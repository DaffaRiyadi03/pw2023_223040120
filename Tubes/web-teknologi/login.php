<?php
require_once __DIR__ . '/inc/inc_fungsi.php';
sesi();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $row = db_one('SELECT * FROM user WHERE username = ?', [trim($_POST['username'] ?? '')]);
    if ($row && password_verify($_POST['password'] ?? '', $row['password'])) {
        session_regenerate_id(true);
        $_SESSION = [
            'user_id'  => $row['id'],
            'username' => $row['username'],
            'role'     => $row['role'],
        ];
        header('Location: ' . ($row['role'] === 'admin' ? 'admin/halaman.php' : 'index.php'));
        exit;
    }
    $error = 'Username / password salah!';
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login-style.css">
</head>

<body>
    <div class="container">
        <input type="checkbox" id="check">
        <div class="login form">
            <header>Masuk</header>
            <form action="" method="post">
                <?= csrf_field() ?>
                <?php if ($error): ?>
                <p style="color:red;"><?= e($error) ?></p>
                <?php elseif (isset($_GET['daftar'])): ?>
                <p style="color:green;">Akun berhasil dibuat, silakan masuk.</p>
                <?php endif; ?>
                <input type="text" name="username" placeholder="Masukkan username" required>
                <input type="password" name="password" placeholder="Masukkan password" required>
                <input type="submit" class="button" name="login" value="Masuk">
            </form>
            <div class="signup">
                <span class="signup">Belum punya akun? <a href="registrasi.php">daftar</a></span>
            </div>
        </div>
    </div>
</body>

</html>
