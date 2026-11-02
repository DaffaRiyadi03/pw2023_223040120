<?php
require_once __DIR__ . '/inc_fungsi.php';

/* ---------- layout bersama (navbar + footer) ---------- */

function layout_head(string $judul): void
{
    sesi();
    $halaman = basename($_SERVER['PHP_SELF'] ?? '');
    $isAdmin = ($_SESSION['role'] ?? '') === 'admin';
    ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="D.R Tech — portal artikel teknologi: pemrograman, web, dan perangkat.">
    <title><?= e($judul) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg site-nav">
        <div class="wrap">
            <a class="brand" href="index.php"><span class="brand-mark" aria-hidden="true"></span><span
                    class="wordmark">D.R Tech</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navUtama"
                aria-controls="navUtama" aria-expanded="false" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navUtama">
                <ul class="navbar-nav nav-links">
                    <li class="nav-item">
                        <a class="nav-link <?= $halaman === 'index.php' ? 'active' : '' ?>" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $halaman === 'artphp.php' ? 'active' : '' ?>"
                            href="index.php#artikel">Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#kategori">Kategori</a>
                    </li>
                    <?php if ($isAdmin): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/halaman.php">Admin</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <div class="nav-actions">
                    <a class="nav-icon" href="index.php#cari" aria-label="Cari artikel">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="m20 20-3.5-3.5"></path>
                        </svg>
                    </a>
                    <span class="rule-v" aria-hidden="true"></span>
                    <?php if (isset($_SESSION['username'])): ?>
                    <span class="user-chip"><?= e($_SESSION['username']) ?></span>
                    <form method="post" action="logout.php" class="nav-logout">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-logout">Keluar</button>
                    </form>
                    <?php else: ?>
                    <a href="login.php" class="btn-logout">Masuk</a>
                    <a href="registrasi.php" class="btn-accent">Daftar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <main>
<?php
}

function layout_foot(): void
{
    ?>
    </main>
    <footer class="site-footer">
        <div class="wrap">
            <a class="brand" href="index.php"><span class="brand-mark" aria-hidden="true"></span><span
                    class="wordmark">D.R Tech</span></a>
            <nav class="footer-links" aria-label="Tautan footer">
                <a href="index.php">Beranda</a>
                <a href="index.php#artikel">Artikel</a>
                <a href="index.php#kategori">Kategori</a>
                <?php if (!isset($_SESSION['username'])): ?>
                <a href="login.php">Masuk</a>
                <?php endif; ?>
            </nav>
            <span class="footer-note">&copy; <?= date('Y') ?> Muhammad Daffa Riyadi</span>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
<?php
}
