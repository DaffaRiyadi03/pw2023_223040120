<?php
require_once __DIR__ . '/inc_koneksi.php';

/* ---------- helper umum ---------- */

function e($s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

function sesi(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
        session_start();
    }
}

/* ---------- database ---------- */

function db_query(string $sql, array $params = []): mysqli_stmt
{
    $stmt = mysqli_prepare(db(), $sql);
    if ($params) {
        mysqli_stmt_bind_param($stmt, str_repeat('s', count($params)), ...$params);
    }
    mysqli_stmt_execute($stmt);
    return $stmt;
}

function db_all(string $sql, array $params = []): array
{
    return mysqli_fetch_all(mysqli_stmt_get_result(db_query($sql, $params)), MYSQLI_ASSOC);
}

function db_one(string $sql, array $params = []): ?array
{
    return db_all($sql, $params)[0] ?? null;
}

/** Escape wildcard LIKE agar input user dicari apa adanya. */
function like(string $s): string
{
    return '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $s) . '%';
}

/* ---------- auth ---------- */

function csrf_token(): string
{
    sesi();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_check(): void
{
    sesi();
    $token = is_string($_POST['csrf'] ?? null) ? $_POST['csrf'] : '';
    if (!hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(400);
        exit('Sesi kedaluwarsa. Silakan ulangi.');
    }
}

/** Guard halaman admin: redirect ke login bila bukan admin. */
function wajib_admin(string $loginUrl): void
{
    sesi();
    if (($_SESSION['role'] ?? '') !== 'admin') {
        header('Location: ' . $loginUrl);
        exit;
    }
}

/** Guard endpoint (ajax/upload): 403 bila bukan admin. */
function admin_saja(): void
{
    sesi();
    if (($_SESSION['role'] ?? '') !== 'admin') {
        http_response_code(403);
        exit('Akses ditolak.');
    }
}

/** @return true|string true bila sukses, pesan error bila gagal. */
function register(array $data)
{
    $username  = strtolower(trim((string) ($data['username'] ?? '')));
    $password  = (string) ($data['password'] ?? '');
    $password1 = (string) ($data['password1'] ?? '');

    if ($username === '' || $password === '') {
        return 'Username dan password wajib diisi.';
    }
    if (!preg_match('/^[a-z0-9._-]{3,32}$/', $username)) {
        return 'Username 3–32 karakter: huruf, angka, titik, garis bawah, atau strip.';
    }
    if (strlen($password) < 8) {
        return 'Password minimal 8 karakter.';
    }
    if ($password !== $password1) {
        return 'Konfirmasi password tidak sesuai!';
    }

    // role selalu 'user'; jangan pernah percaya input role dari form.
    try {
        db_query(
            'INSERT INTO user (username, password, role) VALUES (?, ?, ?)',
            [$username, password_hash($password, PASSWORD_DEFAULT), 'user']
        );
    } catch (mysqli_sql_exception $e) {
        // 1062 / 23000 = duplicate key (index UNIQUE di kolom username).
        if ($e->getCode() === 1062 || $e->getCode() === '23000') {
            return 'Username sudah terdaftar!';
        }
        throw $e;
    }
    return true;
}

/* ---------- artikel ---------- */

/** Cari artikel. $keywords string|array, dicocokkan AND antar kata. */
function cari_artikel($keywords, string $kategori = ''): array
{
    $where  = [];
    $params = [];

    foreach ((array) $keywords as $k) {
        $k = trim((string) $k);
        if ($k === '') {
            continue;
        }
        // isi_teks = versi teks polos, supaya tag HTML tidak ikut cocok.
        // COALESCE: baris lama yang belum di-backfill tetap bisa dicari.
        $where[] = '(judul LIKE ? OR kategori LIKE ? OR COALESCE(isi_teks, isi) LIKE ?)';
        $like    = like($k);
        $params[] = $like;
        $params[] = $like;
        $params[] = $like;
    }
    if ($kategori !== '') {
        $where[]  = 'kategori = ?';
        $params[] = $kategori;
    }

    // ponytail: tanpa paginasi; tambah LIMIT/OFFSET kalau artikel sudah ratusan.
    $sql = 'SELECT * FROM highlight'
        . ($where ? ' WHERE ' . implode(' AND ', $where) : '')
        . ' ORDER BY id DESC LIMIT 60';

    return db_all($sql, $params);
}

/** Teks polos dari HTML summernote (tag & entity dibuang, spasi dirapatkan). */
function teks_polos(string $html): string
{
    $teks = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return trim(preg_replace('/\s+/u', ' ', $teks));
}

/** Ringkasan teks polos (tag tidak terpotong). */
function ringkas(string $html, int $panjang = 240): string
{
    $teks = teks_polos($html);
    return mb_strlen($teks) > $panjang ? mb_substr($teks, 0, $panjang) . '…' : $teks;
}

/** Tanggal ringkas ala Indonesia, mis. 11 Jun 2023. */
function tanggal_id(?string $tgl): string
{
    $ts = strtotime((string) $tgl);
    if (!$ts) {
        return '';
    }
    $bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    return date('j', $ts) . ' ' . $bulan[(int) date('n', $ts)] . ' ' . date('Y', $ts);
}

/** Estimasi waktu baca (200 kata/menit, minimal 1 menit). */
function menit_baca(string $html): int
{
    return max(1, (int) ceil(str_word_count(teks_polos($html)) / 200));
}

/* ---------- gambar ---------- */

/**
 * Validasi + simpan file upload ke folder gambar/.
 * @return string nama file (tanpa path)
 * @throws RuntimeException pesan siap tampil ke user
 */
function simpan_gambar(array $file): string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload gagal, kode error: ' . (int) ($file['error'] ?? 0));
    }
    $ext = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
        throw new RuntimeException('Format gambar harus JPG/PNG/WEBP/GIF.');
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        throw new RuntimeException('Ukuran gambar maksimal 5 MB.');
    }
    if (!@getimagesize($file['tmp_name'])) {
        throw new RuntimeException('File yang diunggah bukan gambar.');
    }

    $nama = bin2hex(random_bytes(8)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], __DIR__ . '/../gambar/' . $nama)) {
        throw new RuntimeException('Gagal menyimpan gambar.');
    }
    return $nama;
}

/** Hapus file gambar (aman untuk nama kosong / path aneh). */
function hapus_gambar(string $nama): void
{
    $nama = basename($nama);
    if ($nama === '') {
        return;
    }
    // Jangan hapus file yang masih dipakai artikel lain (cover atau isi).
    $dipakai = db_one(
        'SELECT 1 FROM highlight WHERE gambar = ? OR isi LIKE ? LIMIT 1',
        [$nama, '%gambar/' . $nama . '%']
    );
    if (!$dipakai && is_file(__DIR__ . '/../gambar/' . $nama)) {
        @unlink(__DIR__ . '/../gambar/' . $nama);
    }
}

/** Render grid kartu artikel (dipakai index.php & ajax). */
function render_kartu_list(array $rows): string
{
    if (!$rows) {
        return '<div class="empty"><strong>Belum ada artikel yang cocok.</strong>'
            . 'Coba kata kunci lain atau <a href="index.php">lihat semua artikel</a>.</div>';
    }

    $out = '<div class="artikel-grid">';
    foreach ($rows as $d) {
        $url = 'artphp.php?id=' . (int) $d['id'];
        $img = !empty($d['gambar'])
            ? '<img src="gambar/' . e($d['gambar']) . '" alt="' . e($d['judul']) . '" loading="lazy">'
            : '';
        $teks = (string) ($d['isi_teks'] ?? $d['isi']);

        $out .= '<article class="artikel-card">'
            . '<a class="artikel-thumb" href="' . $url . '">' . $img . '</a>'
            . '<div class="artikel-body">'
            . '<span class="kicker">' . e($d['kategori']) . '</span>'
            . '<h3 class="artikel-title"><a href="' . $url . '">' . e($d['judul']) . '</a></h3>'
            . '<p class="artikel-excerpt">' . e(ringkas($teks)) . '</p>'
            . '<div class="artikel-meta">'
            . '<span>' . e(tanggal_id($d['tgl_upload'])) . '</span>'
            . '<span class="dot"></span>'
            . '<span>' . menit_baca($teks) . ' menit</span>'
            . '</div></div></article>';
    }
    return $out . '</div>';
}
