<?php 
    include ("../inc/inc_koneksi.php");
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

    <title>SearchTech</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bolder" href="#"><span>D.R</span> Tech</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse position-absolute top-50 start-50 translate-middle mt-0"
                id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link fw-bolder" href="index.html">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bolder" href="populer.html">Populer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bolder" href="terbaru.html">Terbaru</a>
                    </li>
                </ul>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="login.html"><button class="btn btn-primary me-md-2" type="button">Masuk</button></a>

            </div>
        </div>
    </nav>
    <!-- Akhir Navbar -->
    <br>