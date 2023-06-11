<?php  
$host = "localhost:81";
$user = "root";
$pass = "";
$db   = "webteknologi";

$koneksi = mysqli_connect($host,$user,$pass,$db);
if (!$koneksi) {
    die("gagal koneksi");
} else {
    echo "";
}