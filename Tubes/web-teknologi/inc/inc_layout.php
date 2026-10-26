<?php
require_once __DIR__ . '/inc_fungsi.php';

/* ---------- layout bersama (navbar + footer) ---------- */

function layout_head(string $judul): void
{
    sesi();
    ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judul) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bolder" href="index.php"><span>D.R</span> Tech</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link fw-bolder" href="index.php">Beranda</a></li>
                    <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link fw-bolder" href="admin/halaman.php">Admin</a></li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <?php if (isset($_SESSION['username'])): ?>
                    <span class="text-muted small"><?= e($_SESSION['username']) ?></span>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                    <?php else: ?>
                    <a href="login.php" class="btn btn-primary">Masuk</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
<?php
}

function layout_foot(): void
{
    ?>
<footer class="bg-light text-center mt-5">
    <div class="text-center p-3">&copy; <?= date('Y') ?> Muhammad Daffa Riyadi</div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
</body>

</html>
<?php
}
