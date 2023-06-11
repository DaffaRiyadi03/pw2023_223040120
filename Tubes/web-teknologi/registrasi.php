<?php
require "inc/inc_fungsi.php";
require "inc/inc_koneksi.php";

if (isset($_POST["register"])) {
    if (register($_POST) > 0) {
        echo "<script>
            alert('User baru berhasil ditambahkan!');
        </script>";
        
    } else {
        echo mysqli_error($koneksi);
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login & Registration Form</title>

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
        <div class="login form">
            <header>Masuk</header>
            <form action="" method="post">

                <input type="text" name="username" placeholder="Masukkan username" required>
                <input type="password" name="password" placeholder="Masukkan password" required>
                <input type="password" name="password1" placeholder="Konfirmasi password" required>

                <input type="submit" name="register" class="button" value="Daftar">
                <!-- Changed type to "submit" to submit the form -->
            </form>
            <div class="signup">
                <span class="signup">Sudah memiliki akun? <a href="login.php">Masuk</a></span>
            </div>
            </span>
        </div>
    </div>
    <!-- End of Login Form -->

</body>

</html>