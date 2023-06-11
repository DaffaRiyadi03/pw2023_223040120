<?php
session_start();
require 'inc/inc_koneksi.php';
require 'inc/inc_fungsi.php';

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");

    // cek username
    if (mysqli_num_rows($result) === 1) {
        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // Set session to store user login information
            $_SESSION['submit'] = true;
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["role"] = $row["role"];

            if ($row["role"] == 'admin') {
                // If role is admin (1), redirect to admin page
                header("Location: admin/halaman.php");
                exit;
            } else {
                // If role is user (0), redirect to user page
                header("Location: index.php");
                exit;
            }
        }
    }

    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Masuk</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;700&display=swap" rel="stylesheet">

    <!-- Custom CSS File -->
    <link rel="stylesheet" href="css/login-style.css">

</head>

<body>
    <!-- Login Form -->
    <div class="container">
        <input type="checkbox" id="check">
        <div class="login form">
            <header>Masuk</header>
            <form action="" method="post">
                <?php 
                if (isset($error)):
                ?>
                <p style="color:red;">Username / password salah!</p>
                <?php endif; ?>
                <!-- Added method="POST" to send form data -->
                <input type="text" name="username" placeholder="Masukkan username">
                <input type="password" name="password" placeholder="Masukkan password">
                <input type="submit" class="button" name="login" value="Masuk">
                <!-- Changed type to "submit" and added name="login" -->
            </form>
            <div class="signup">
                <span class="signup">Belum punya akun?
                    <a href="registrasi.php ">
                        daftar
                    </a>

                </span>
            </div>
        </div>
        <!-- End of Login Form -->

</body>

</html>