<?php
require('functions.php');

$title = 'Form Tambah Data';

//insert data jika tombol diklik


if(isset($_POST['tambah'])) {
    //tampilkan pesan jika data berhasil ditambahkan
    if (tambah($_POST) > 0) {
    echo "<script>
        alert('data berhasil ditambahkan!');
        document.location.href = 'index.php';
        </script>";
    }
}

require('views/tambah.view.php');