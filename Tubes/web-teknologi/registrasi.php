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
    <title>Daftar Akun</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login-style.css">
</head>

<body>
    <div class="container">
        <div class="login form">
            <header>Daftar</header>
            <form action="" method="post">
                <?= csrf_field() ?>
                <?php if ($error): ?>
                <p style="color:red;"><?= e($error) ?></p>
                <?php endif; ?>
                <input type="text" name="username" placeholder="Masukkan username" required>
                <input type="password" name="password" placeholder="Masukkan password" required>
                <input type="password" name="password1" placeholder="Konfirmasi password" required>
                <input type="submit" name="register" class="button" value="Daftar">
            </form>
            <div class="signup">
                <span class="signup">Sudah memiliki akun? <a href="login.php">Masuk</a></span>
            </div>
        </div>
    </div>
</body>

</html>
