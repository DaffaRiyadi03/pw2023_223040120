<?php
require_once __DIR__ . '/../inc/inc_fungsi.php';
wajib_admin('../login.php');

// Semua logika (termasuk header redirect) dijalankan sebelum ada output HTML.
$id      = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$gambar = $judul = $kategori = $isi = '';
$error = '';
$sukses = isset($_GET['ok']) ? 'Sukses menyimpan data' : '';
$tidak_ada = false;

if ($id) {
    $row = db_one('SELECT * FROM highlight WHERE id = ?', [$id]);
    if (!$row) {
        http_response_code(404);
        $tidak_ada = true;
        $error = 'Data tidak ditemukan';
    } else {
        ['gambar' => $gambar, 'judul' => $judul, 'kategori' => $kategori, 'isi' => $isi] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$tidak_ada) {
    csrf_check();
    $judul    = trim((string) ($_POST['judul'] ?? ''));
    $kategori = trim((string) ($_POST['kategori'] ?? ''));
    // Editor ada di /admin, jadi Summernote menulis src="../gambar/...". Halaman publik
    // ada di root, jadi simpan versi root-relatif supaya gambarnya tidak 404.
    $isi      = str_replace('../gambar/', 'gambar/', (string) ($_POST['isi'] ?? ''));
    $gambar_lama = basename((string) ($_POST['gambar_lama'] ?? ''));
    $gambar   = $gambar_lama; // default: pertahankan gambar lama

    if ($judul === '' || $isi === '') {
        $error = 'Silahkan masukan judul dan isi.';
    }

    $file = $_FILES['gambar'] ?? null;
    if (!$error && $file && $file['error'] === UPLOAD_ERR_OK) {
        try {
            $gambar = simpan_gambar($file);
        } catch (RuntimeException $e) {
            $error = $e->getMessage();
        }
    }

    if (!$error) {
        if ($id) {
            // tgl_upload sengaja tidak diubah: tanggal terbit asli dipertahankan.
            db_query(
                'UPDATE highlight SET gambar = ?, judul = ?, kategori = ?, isi = ?, isi_teks = ? WHERE id = ?',
                [$gambar, $judul, $kategori, $isi, teks_polos($isi), $id]
            );
        } else {
            db_query(
                'INSERT INTO highlight (gambar, judul, kategori, isi, isi_teks, tgl_upload)
                 VALUES (?, ?, ?, ?, ?, CURDATE())',
                [$gambar, $judul, $kategori, $isi, teks_polos($isi)]
            );
            $id = mysqli_insert_id(db());
        }
        if ($gambar !== $gambar_lama) {
            hapus_gambar($gambar_lama); // cover lama tidak dipakai lagi
        }
        header('Location: halaman_input.php?id=' . $id . '&ok=1');
        exit;
    }
}

$kategoriList = db_all('SELECT DISTINCT kategori FROM highlight ORDER BY kategori');

// Editor ada di /admin, jadi tampilkan path relatif editor; saat simpan dinormalisasi
// balik ke 'gambar/...' supaya valid juga di halaman publik.
$isi = str_replace('src="gambar/', 'src="../gambar/', $isi);

require __DIR__ . '/inc_header.php';
?>
<div class="page-head">
    <div>
        <p class="kicker"><?= $tidak_ada ? 'Tidak ditemukan' : ($id ? 'Sunting artikel' : 'Artikel baru') ?></p>
        <h1><?= $tidak_ada ? 'Artikel tidak ditemukan' : ($id ? 'Sunting artikel' : 'Artikel baru') ?></h1>
        <p><?= $tidak_ada ? 'Artikel yang kamu maksud mungkin sudah dihapus.' : ($id ? 'Perbarui judul, kategori, isi, atau gambar sampul.' : 'Tulis artikel baru untuk portal D.R Tech.') ?>
        </p>
    </div>
    <a class="btn-ghost btn-xs" href="halaman.php">&larr; Kembali</a>
</div>

<?php if ($error): ?>
<div class="alert-line err" role="alert"><?= e($error) ?></div>
<?php endif; ?>
<?php if ($sukses): ?>
<div class="alert-line ok" role="status"><?= e($sukses) ?></div>
<?php endif; ?>

<?php if (!$tidak_ada): ?>
<form class="card-panel form-card" action="" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $id ?>">
    <input type="hidden" name="gambar_lama" value="<?= e($gambar) ?>">

    <div class="form-inner">
        <div class="form-grid">
            <div class="field">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" value="<?= e($judul) ?>" name="judul"
                    placeholder="Judul yang jelas dan spesifik" required>
            </div>
            <div class="field">
                <label for="kategori">Kategori</label>
                <input type="text" class="form-control" id="kategori" value="<?= e($kategori) ?>" name="kategori"
                    list="daftar-kategori" placeholder="mis. Website, AI, Hardware">
                <datalist id="daftar-kategori">
                    <?php foreach ($kategoriList as $k): ?>
                    <option value="<?= e($k['kategori']) ?>">
                    <?php endforeach; ?>
                </datalist>
                <p class="note">Pilih atau tulis baru</p>
            </div>
        </div>

        <div class="field">
            <label for="summernote">Isi artikel</label>
            <textarea name="isi" class="form-control" id="summernote"><?= e($isi) ?></textarea>
        </div>

        <div class="field">
            <label for="gambar">Gambar sampul</label>
            <div class="upload-row">
                <?php if ($gambar): ?>
                <img class="thumb-lg" src="../gambar/<?= e($gambar) ?>" alt="Gambar saat ini">
                <?php endif; ?>
                <input class="form-control" name="gambar" type="file" id="gambar" accept="image/*">
            </div>
            <p class="note">JPG, PNG, WEBP, atau GIF · maks 5 MB · kosongkan untuk mempertahankan gambar lama</p>
        </div>
    </div>

    <div class="form-actions">
        <a class="btn-ghost" href="halaman.php">Batal</a>
        <button type="submit" name="simpan" class="btn-accent">Simpan artikel</button>
    </div>
</form>
<?php endif; ?>

<?php include 'inc_footer.php'; ?>
