<?php 
require('functions.php');
$tittle = 'Home';
$students = [
    [
      "nama" => "Muhammad Daffa Riyadi",
      "npm" => "223040120",
      "email" => "daffariyadi2003@gmail.com"    
    ],
    [
      "nama" => "Rizal Fahla",
      "npm" => "223040120",
      "email" => "fahla43@gmail.com" 
    ]
];


// echo $_SERVER['REQUEST_URI']; 
// /pw2023_223040120/kuliah/pertemuan9/index.php

require('views/index.view.php');

?>