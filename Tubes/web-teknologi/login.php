<?php
require_once __DIR__ . '/inc/inc_fungsi.php';
sesi();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $gagal = $_SESSION['login_gagal'] ?? ['n' => 0, 't' => 0];

    // ponytail: throttle per-sesi; pindah ke tabel/redis kalau perlu lintas device.
    if ($gagal['n'] >= 5 && time() - $gagal['t'] < 60) {
        $error = 'Terlalu banyak percobaan gagal. Coba lagi dalam 1 menit.';
    } else {
        $row = db_one(
            'SELECT * FROM user WHERE username = ?',
            [strtolower(trim((string) ($_POST['username'] ?? '')))]
        );
        if ($row && password_verify((string) ($_POST['password'] ?? ''), $row['password'])) {
            session_regenerate_id(true);
            $_SESSION = [
                'user_id'  => $row['id'],
                'username' => $row['username'],
                'role'     => $row['role'],
            ];
            header('Location: ' . ($row['role'] === 'admin' ? 'admin/halaman.php' : 'index.php'));
            exit;
        }
        $dalam = time() - $gagal['t'] < 60;
        $_SESSION['login_gagal'] = ['n' => $dalam ? $gagal['n'] + 1 : 1, 't' => time()];
        $error = 'Username / password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — D.R Tech</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="auth">
    <div class="auth-shell">
        <aside class="auth-aside">
            <a class="brand" href="index.php"><span class="brand-mark" aria-hidden="true"></span><span
                    class="wordmark">D.R Tech</span></a>
            <div>
                <h2>Tempatnya belajar teknologi, tanpa ribet.</h2>
                <p class="auth-lead">Masuk untuk melanjutkan membaca dan mengelola artikel favoritmu.</p>
                <ul class="auth-list">
                    <li>Artikel pemrograman &amp; web</li>
                    <li>Pencarian cepat dan rapi</li>
                    <li>Gratis, tanpa iklan</li>
                </ul>
            </div>
            <p class="auth-note">D.R Tech · Portal artikel teknologi</p>
        </aside>

        <main class="auth-main">
            <p class="kicker">Selamat datang</p>
            <h1>Masuk</h1>
            <p class="auth-sub">Senang melihatmu kembali.</p>

            <?php if ($error): ?>
            <div class="alert-line err" role="alert"><?= e($error) ?></div>
            <?php elseif (isset($_GET['daftar'])): ?>
            <div class="alert-line ok" role="status">Akun berhasil dibuat, silakan masuk.</div>
            <?php endif; ?>

            <form action="" method="post">
                <?= csrf_field() ?>
                <div class="field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="mis. daffa" required autofocus>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" name="login" class="btn-accent auth-submit">Masuk</button>
            </form>

            <div class="auth-alts">
                <p class="auth-alt">Belum punya akun? <a href="registrasi.php">Daftar sekarang</a></p>
                <p class="auth-alt"><a href="index.php">&larr; Kembali ke beranda</a></p>
            </div>
        </main>
    </div>
</body>

</html>
