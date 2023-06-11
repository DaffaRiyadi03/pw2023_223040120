<?php
function register($data)
{
    global $koneksi;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password1 = mysqli_real_escape_string($koneksi, $data["password1"]);

    // Memeriksa apakah kunci 'role' ada dalam array $data
    if (isset($data['role'])) {
        $role = $data['role'];
    } else {
        $role = 0; // Nilai peran default jika kunci 'role' tidak ada dalam array
    }

    // Memeriksa duplikasi username
    $result = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$username'");

    if (mysqli_num_rows($result) > 0) {
        return "Username sudah terdaftar!";
    }

    // Memeriksa apakah password dan konfirmasi password cocok
    if ($password !== $password1) {
        return "Konfirmasi password tidak sesuai!";
    }

    // Melakukan enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Menambahkan pengguna baru ke database
    $query = "INSERT INTO user (username, password, role) VALUES ('$username', '$password', '$role')";
    if (mysqli_query($koneksi, $query)) {
        return true; // Registrasi berhasil
    } else {
        return mysqli_error($koneksi); // Mengembalikan pesan error dari database
    }
}
?>