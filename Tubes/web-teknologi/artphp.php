<?php 
session_start();

if(!isset($_SESSION["submit"])) {
header("Location: login.php");
exit;

}

include_once("inc/inc_koneksi.php");
include_once("inc/inc_fungsi.php");

if(isset($_GET['judul'])){
  $judul = htmlspecialchars($_GET['judul']);
  $queryHighlight = mysqli_query($koneksi, "SELECT * FROM highlight WHERE judul='$judul'");
  $data = mysqli_fetch_array($queryHighlight);
} else {
  // Tambahkan penanganan jika parameter judul tidak tersedia dalam URL
  echo "Judul tidak tersedia.";
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- My CSS -->
    <link rel="stylesheet" href="css/style.css" />

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.php"><span>D.R</span> Tech</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse position-absolute top-50 start-50 translate-middle mt-0"
                id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link fw-bolder" href="index.php"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bolder" href="populer.php"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bolder" href="terbaru.php"></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Akhir Navbar -->
    <br />

    <!-- Isi Artikel -->
    <div class="container text-center">
        <div class="row">
            <div class="col">
                <div class="container">
                    <img src="gambar/<?php echo $data['gambar'] ?>" class="img-fluid" alt="..."
                        style="width: 100%; height: 400px; align-self: center;" />
                </div>
            </div>
        </div>
        <br>
        <hr>
        <br>

        <div class="container text-center">
            <div class="judul" style="text-align: start;">
                <h2><?php echo $data['judul'] ?></h2>
                <p class="lead"><?php echo $data['kategori'] ?> | <?php echo $data['tgl_upload'] ?></p>
            </div>
            <br>
            <p style="text-align: justify;">
                <?php echo $data['isi'] ?>
            </p>

        </div>
    </div>

    <!-- Akhir Artikel -->

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start">
        <div class="text-center p-3" style="background-color: white;">
            © 2023 Muhammad Daffa Riyadi
        </div>
    </footer>
    <!-- Akhir Footer -->

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pzjw4cvC2U4Oo5QRI8CmsOyhC9cFuOHqzHHPgNLz5+RyJcwAIOwBfLrzKaMrDH7z" crossorigin="anonymous">
    </script>

</body>

</html>