<?php 
session_start();
include_once("inc/inc_koneksi.php");
include_once("inc/inc_fungsi.php");

$queryHighlight = mysqli_query($koneksi, "SELECT * FROM highlight");
// Query untuk mendapatkan nilai-nilai kategori dari tabel highlight
$queryKategori = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM highlight");



$kategoriOptions = "";
while ($row = mysqli_fetch_assoc($queryKategori)) {
  $kategori = $row['kategori'];
  $kategoriOptions .= "<li><a class='dropdown-item' href='#' data-kategori='$kategori'>$kategori</a></li>";
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

    <title>D.R-Tech</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bolder" href="index.php"><span>D.R</span> Tech</a>
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
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <?php
            
            if (isset($_SESSION['username'])) {
                // Jika pengguna sudah login, tampilkan tombol Logout
                echo '<a href="logout.php"><button class="btn btn-danger me-md-2" type="button">Logout</button></a>';
            } else {
                // Jika pengguna belum login, tampilkan tombol Masuk
                echo '<a href="login.php"><button class="btn btn-primary me-md-2" type="button">Masuk</button></a>';
            }
            ?>
            </div>
        </div>
    </nav>

    <!-- Akhir Navbar -->

    <!-- Jumbotron -->
    <section class="jumbotron text-center">
        <h1 class="display-4 ms-auto">Hello, world!</h1>
        <p class="lead">Jelajahi artikel mengenai teknologi disini!!</p>
        <hr class="my-1" />
        <form class="d-flex" id="search-form">
            <input id="search" name="keywords" class="form-control me-2" type="search" placeholder="Search"
                aria-label="Search" />
            <div class="btn-group" style="padding-right: 10px;">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="kategoriDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Kategori
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="kategoriDropdown">
                        <?php echo $kategoriOptions; ?>
                    </ul>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
    </section>

    <!-- Akhir Jumbotron -->

    <br>

    <hr>

    <br>

    <!-- Projects -->
    <section id="projects">

        <div class="container">
            <div class="row">
                <div class="col">
                </div>
            </div>
            <div class="container-card">
                <div class="row">
                    <div class="col-sm-12">
                        <h2>Highlight</h2>
                        <div class="row">
                            <?php while ($data = mysqli_fetch_array($queryHighlight)) { ?>
                            <div class="row-3">
                                <div class="card mb-3" style="max-width: auto; ">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="gambar/<?php echo $data['gambar'] ?>" class="img-thumbnail"
                                                alt="...">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body" style="text-align: justify;">
                                                <h5 class="card-title">
                                                    <a href="artphp.php?judul=<?php echo urlencode($data['judul']) ?>"
                                                        style="text-decoration: none; color: black;"><?php echo $data['judul'] ?></a>
                                                </h5>
                                                <p class="mb-1 text-muted"><?php echo $data['kategori'] ?></p>
                                                <p class="card-text" style="">
                                                    <?php
    $isi = $data['isi'];
    $batasanKarakter = 500; // Jumlah karakter maksimum yang ingin ditampilkan

    if (strlen($isi) > $batasanKarakter) {
        $potonganTeks = substr($isi, 0, $batasanKarakter) . '...';
        echo $potonganTeks;
    } else {
        echo $isi;
    }
    ?>
                                                </p>
                                                <p class="card-text"><small
                                                        class="text-muted"><?php echo $data['tgl_upload'] ?></small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

    </section>
    <!-- Akhir Projects -->

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: white;">
            © 2023 Copyright:
            <a class="text-dark" href="#">Muhammad Daffa Riyadi</a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- AkhirFooter -->

    <!-- Option 1: Bootstrap Bundle with Popper -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        var projects = $("#projects"); // Simpan elemen projects dalam variabel

        $("#search").keyup(function() {
            var keywords = $(this).val().split(" "); // Mengelompokkan kata kunci menjadi array

            if (keywords.length > 0) {
                $.ajax({
                    url: "./ajax/ajax_cari.php",
                    data: {
                        keywords: keywords,
                    },
                    type: "GET",
                    success: function(response) {
                        projects.html(response);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });

        $(".dropdown-menu .dropdown-item").click(function(e) {
            e.preventDefault(); // Mencegah tindakan default pada tautan dropdown
            var kategori = $(this).data('kategori');
            filterBykategori(kategori);
        });

        function filterBykategori(kategori) {
            $.ajax({
                url: "./ajax/kategoriajax.php",
                data: {
                    kategori: kategori,
                },
                type: "GET",
                success: function(response) {
                    projects.html(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });
    </script>
</body>

</html>