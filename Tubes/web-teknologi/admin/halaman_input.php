<?php require 'inc_header.php'; ?>
<?php
$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$gambar = $judul = $kategori = $isi = '';
$error = '';
$sukses = isset($_GET['ok']) ? 'Sukses menyimpan data' : '';

if ($id) {
    $row = db_one('SELECT * FROM highlight WHERE id = ?', [$id]);
    if ($row) {
        ['gambar' => $gambar, 'judul' => $judul, 'kategori' => $kategori, 'isi' => $isi] = $row;
    } else {
        $error = 'Data tidak ditemukan';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $judul    = trim($_POST['judul'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $isi      = $_POST['isi'] ?? '';
    $gambar   = $_POST['gambar_lama'] ?? ''; // default: pertahankan gambar lama

    if ($judul === '' || $isi === '') {
        $error = 'Silahkan masukan judul dan isi.';
    }

    $file = $_FILES['gambar'] ?? null;
    if (!$error && $file && $file['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
            $error = 'Format gambar harus JPG/PNG/WEBP/GIF.';
        } elseif ($file['size'] > 5 * 1024 * 1024) {
            $error = 'Ukuran gambar maksimal 5 MB.';
        } elseif (!@getimagesize($file['tmp_name'])) {
            $error = 'File yang diunggah bukan gambar.';
        } else {
            $nama = bin2hex(random_bytes(8)) . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], __DIR__ . '/../gambar/' . $nama)) {
                $gambar = $nama;
            } else {
                $error = 'Gagal menyimpan gambar.';
            }
        }
    }

    if (!$error) {
        if ($id) {
            db_query(
                'UPDATE highlight SET gambar = ?, judul = ?, kategori = ?, isi = ?, tgl_upload = CURDATE() WHERE id = ?',
                [$gambar, $judul, $kategori, $isi, $id]
            );
        } else {
            db_query(
                'INSERT INTO highlight (gambar, judul, kategori, isi, tgl_upload) VALUES (?, ?, ?, ?, CURDATE())',
                [$gambar, $judul, $kategori, $isi]
            );
            $id = mysqli_insert_id(db());
        }
        header('Location: halaman_input.php?id=' . $id . '&ok=1');
        exit;
    }
}

$kategoriList = db_all('SELECT DISTINCT kategori FROM highlight ORDER BY kategori');
?>
<h1>Halaman Admin Input Data</h1>
<div class="mb-3 row">
    <a href="halaman.php">&lt;&lt; Kembali ke halaman admin</a>
</div>
<?php if ($error): ?>
<div class="alert alert-danger" role="alert"><?= e($error) ?></div>
<?php endif; ?>
<?php if ($sukses): ?>
<div class="alert alert-primary" role="alert"><?= e($sukses) ?></div>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $id ?>">
    <input type="hidden" name="gambar_lama" value="<?= e($gambar) ?>">
    <div class="mb-3 row">
        <label for="judul" class="col-sm-2 col-form-label">Judul</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="judul" value="<?= e($judul) ?>" name="judul">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="kategori" value="<?= e($kategori) ?>" name="kategori"
                list="daftar-kategori">
            <datalist id="daftar-kategori">
                <?php foreach ($kategoriList as $k): ?>
                <option value="<?= e($k['kategori']) ?>">
                <?php endforeach; ?>
            </datalist>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="isi" class="col-sm-2 col-form-label">Isi</label>
        <div class="col-sm-10">
            <textarea name="isi" class="form-control" id="summernote"><?= e($isi) ?></textarea>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
        <div class="col-sm-10">
            <?php if ($gambar): ?>
            <img src="../gambar/<?= e($gambar) ?>" style="max-height:100px;max-width:100px" alt="">
            <?php endif; ?>
            <input class="form-control" name="gambar" type="file" id="gambar" accept="image/*">
        </div>
    </div>

    <div class="col-sm-10">
        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
    </div>
</form>

<?php include 'inc_footer.php'; ?>
