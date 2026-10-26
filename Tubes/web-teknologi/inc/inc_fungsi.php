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
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
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
    $username  = strtolower(trim($data['username'] ?? ''));
    $password  = $data['password'] ?? '';
    $password1 = $data['password1'] ?? '';

    if ($username === '' || $password === '') {
        return 'Username dan password wajib diisi.';
    }
    if ($password !== $password1) {
        return 'Konfirmasi password tidak sesuai!';
    }
    if (db_one('SELECT id FROM user WHERE username = ?', [$username])) {
        return 'Username sudah terdaftar!';
    }

    // role selalu 'user'; jangan pernah percaya input role dari form.
    db_query(
        'INSERT INTO user (username, password, role) VALUES (?, ?, ?)',
        [$username, password_hash($password, PASSWORD_DEFAULT), 'user']
    );
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
        $where[]  = '(judul LIKE ? OR kategori LIKE ? OR isi LIKE ?)';
        $like     = '%' . $k . '%';
        $params[] = $like;
        $params[] = $like;
        $params[] = $like;
    }
    if ($kategori !== '') {
        $where[]  = 'kategori = ?';
        $params[] = $kategori;
    }

    $sql = 'SELECT * FROM highlight'
        . ($where ? ' WHERE ' . implode(' AND ', $where) : '')
        . ' ORDER BY id DESC';

    return db_all($sql, $params);
}

/** Ringkasan teks polos dari HTML summernote (tag tidak terpotong). */
function ringkas(string $html, int $panjang = 240): string
{
    $teks = trim(preg_replace('/\s+/u', ' ', strip_tags($html)));
    return mb_strlen($teks) > $panjang ? mb_substr($teks, 0, $panjang) . '…' : $teks;
}

/** Render daftar kartu artikel (dipakai index.php & ajax). */
function render_kartu_list(array $rows): string
{
    if (!$rows) {
        return '<div class="alert alert-info" role="alert">Tidak ada artikel yang cocok.</div>';
    }

    $out = '<div class="row">';
    foreach ($rows as $d) {
        $out .= '<div class="col-12"><div class="card mb-3"><div class="row g-0">'
            . '<div class="col-md-4"><img src="gambar/' . e($d['gambar']) . '" class="img-thumbnail" alt="' . e($d['judul']) . '"></div>'
            . '<div class="col-md-8"><div class="card-body" style="text-align:justify;">'
            . '<h5 class="card-title"><a href="artphp.php?id=' . (int) $d['id'] . '" style="text-decoration:none;color:black;">' . e($d['judul']) . '</a></h5>'
            . '<p class="mb-1 text-muted">' . e($d['kategori']) . '</p>'
            . '<p class="card-text">' . e(ringkas($d['isi'])) . '</p>'
            . '<p class="card-text"><small class="text-muted">' . e($d['tgl_upload']) . '</small></p>'
            . '</div></div></div></div></div>';
    }
    return $out . '</div>';
}
