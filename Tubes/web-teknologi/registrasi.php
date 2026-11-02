<?php
require_once __DIR__ . '/inc/inc_fungsi.php';
sesi();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $hasil = register($_POST);
    if ($hasil === true) {
        header('Location: login.php?daftar=1');
        exit;
    }
    $error = $hasil;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — D.R Tech</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="auth">
    <div class="auth-shell">
        <aside class="auth-aside">
            <a class="brand" href="index.php"><span class="brand-mark" aria-hidden="true"></span><span
                    class="wordmark">D.R Tech</span></a>
            <div>
                <h2>Mulai perjalananmu di dunia teknologi.</h2>
                <p class="auth-lead">Satu akun untuk membaca semua artikel dan menyimpan referensi belajar.</p>
                <ul class="auth-list">
                    <li>Kurasi artikel pilihan</li>
                    <li>Antarmuka ringan &amp; fokus</li>
                    <li>Gratis selamanya</li>
                </ul>
            </div>
            <p class="auth-note">D.R Tech · Portal artikel teknologi</p>
        </aside>

        <main class="auth-main">
            <p class="kicker">Akun baru</p>
            <h1>Daftar akun</h1>
            <p class="auth-sub">Cukup 30 detik, langsung bisa baca.</p>

            <?php if ($error): ?>
            <div class="alert-line err" role="alert"><?= e($error) ?></div>
            <?php endif; ?>

            <form action="" method="post">
                <?= csrf_field() ?>
                <div class="field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="mis. daffa" required autofocus
                        pattern="[a-zA-Z0-9._-]{3,32}" title="3–32 karakter: huruf, angka, titik, garis bawah, strip">
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required
                        minlength="8">
                </div>
                <div class="field">
                    <label for="password1">Konfirmasi password</label>
                    <input type="password" id="password1" name="password1" placeholder="Ulangi password" required>
                </div>
                <button type="submit" name="register" class="btn-accent auth-submit">Buat akun</button>
            </form>

            <div class="auth-alts">
                <p class="auth-alt">Sudah memiliki akun? <a href="login.php">Masuk</a></p>
                <p class="auth-alt"><a href="index.php">&larr; Kembali ke beranda</a></p>
            </div>
        </main>
    </div>
</body>

</html>
