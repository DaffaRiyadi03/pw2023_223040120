<?php include("inc_header.php") ?>

<?php
$gambar = "";
$judul = "";
$kategori = "";
$isi = "";
$error = "";
$sukses = "";
$sql1 = ""; // Define $sql1 variable here

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = "";
}

if ($id != "") {
    $sql1 = "SELECT * FROM highlight WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        if (mysqli_num_rows($q1) > 0) {
            $r1 = mysqli_fetch_array($q1);
            $gambar = $r1['gambar'];
            $judul = $r1['judul'];
            $kategori = $r1['kategori'];
            $isi = $r1['isi'];
        } else {
            $error = "Data tidak ditemukan";
        }
    } else {
        $error = "Gagal menjalankan query";
    }
}

if (isset($_POST['simpan'])) {
    $gambar = $_FILES['gambar']['name'];
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori'];
    $isi = $_POST['isi'];

    if ($judul == '' or $isi == '') {
        $error = 'Silahkan masukan semua data yakni judul, kategori, dan isi';
    }

    if (empty($error)) {
        if ($id === "") {
            $sql1 = "INSERT INTO highlight (gambar, judul, kategori, isi, tgl_upload) VALUES ('$gambar', '$judul', '$kategori', '$isi', NOW())";
        } else {
            $sql1 = "UPDATE highlight SET gambar='$gambar',judul='$judul',kategori='$kategori',isi='$isi',tgl_upload=NOW() WHERE id = '$id'";
        }

        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            move_uploaded_file($_FILES['gambar']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/pw2023_223040120/web-teknologi/gambar/' . $gambar);
            $sukses = 'Sukses memasukan data';
        } else {
            $error = 'Gagal menginput data';
        }
    }
}
?>

<h1>Halaman Admin Input Data</h1>
<div class="mb-3 row">
    <a href="halaman.php">&lt;&lt; Kembali ke halaman admin</a>
</div>
<?php
if ($error) {
?>
<div class="alert alert-danger" role="alert">
    <?php echo $error ?>
</div>
<?php
}
?>

<?php
if ($sukses) {
?>
<div class="alert alert-primary" role="alert">
    <?php echo $sukses ?>
</div>
<?php
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3 row">
        <label for="judul" class="col-sm-2 col-form-label">Judul</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="judul" value="<?php echo $judul ?>" name="judul">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="kategori" value="<?php echo $kategori ?>" name="kategori">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="isi" class="col-sm-2 col-form-label">Isi</label>
        <div class="col-sm-10">
            <textarea name="isi" class="form-control" id="summernote"><?php echo $isi ?></textarea>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
        <div class="col-sm-10">
            <?php
            if ($gambar) {
                echo "<img src='/pw2023_223040120/web-teknologi/gambar/$gambar' style='max-height:100px;max-width:100px' >";
            }
            ?>
            <input class="form-control" name="gambar" type="file" id="gambar">
        </div>
    </div>

    <div class="col-sm-10">
        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
    </div>
</form>

<?php include("inc_footer.php") ?>