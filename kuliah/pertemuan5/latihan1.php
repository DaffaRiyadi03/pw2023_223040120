<?php

//ARRAY
//Membuat Aarray

$hari = array('senin' , 'selasa' , 'rabu' , 'kamis');
$bulan = ['januari' , 'februari' , 'maret'];
$myArray = ['Daffa','39',false];
$binatang = ['🐵','🐺','🐱','🦁','🐷'];

//Manampilkan Array
// Mencetak 1 elemen Array menggunakan index

echo $binatang[4];
echo '<hr>';

// Mencetak seluruh isi Array
// var-dump,print-r

var_dump($hari);
echo '<hr>';

print_r($bulan);
echo '<hr>';

// Manipulasi isi Array
// isi elemen menggunakan indexnya

$hari[4] = 'jumat';
print_r($hari);
echo '<hr>';

//menambahkan elemen kosng di akhir array menggunakan index kosong [}

$hari[] = 'sabtu';
print_r($hari);
echo '<hr>';


// Menambahkan elemne baru di akhir array menggunakan array-push()
array_push($bulan, 'april', 'mei', 'juni', 'juli');
print_r($bulan);
echo '<hr>';

// Menambhakan elemen baru di awal array menggunakan array_unshift
array_unshift($bulan, 'desember');
print_r($bulan);
echo '<hr>';

// Menghapus elemen di awal array menggunakan array_pop
array_pop($binatang);
print_r($binatang);
echo '<hr>';

//menghapus elemen di awal array menggunakan array_shift
array_shift($hari);
print_r($hari);



?>