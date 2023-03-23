<?php 
$mahasiswa = [
    ['nama' => 'Muhammad Daffa Riyadi',
    'npm' => '223040120',
    'email' => 'Daffa.223040120@mail.unpas.ac.id',
    'jurusan' => 'Teknik Informatika',
    'foto' => 'daffarb.png'
    ],
    ['nama' => 'Aurelia Melati Suci',
    'npm' => '223040045',
    'email' => 'aurelia.223040045@mail.unpas.ac.id',
    'jurusan' => 'Teknik Informatika',
    'foto' => 'aurel.jpeg"'
    ],
    ['nama' => 'Rivaldy Novyan Dwi Putra',
    'npm' => '223040110',
    'email' => 'rivaldy.223040110@mail.unpas.ac.id',
    'jurusan' => 'Teknik Informatika',
    'foto' => 'rivaldy.jpeg"'
    ],
    ['nama' => 'Moch Zuhdi Maulana Nabilah',
    'npm' => '223040101',
    'email' => 'zuhdi.223040101@mail.unpas.ac.id',
    'jurusan' => 'Teknik Informatika',
    'foto' => 'zuhdi.jpeg'
    ],
    ['nama' => 'Muhammad Marsa Nurjaman',
    'npm' => '223040083',
    'email' => 'marsa.223040083@mail.unpas.ac.id',
    'jurusan' => 'Teknik Informatika',
    'foto' => 'marsa.jpeg"'
    ],
    ['nama' => 'Muhammad Daffa Mussyaffa',
    'npm' => '223040048',
    'email' => 'daffa.223040048@mail.unpas.ac.id',
    'jurusan' => 'Teknik Informatika',
    'foto' => 'daffa.jpeg"'
    ],
    ['nama' => 'Kaka Praditha Putra',
    'npm' => '223040087',
    'email' => 'kaka.223040087@mail.unpas.ac.id',
    'jurusan' => 'Teknik Informatika',
    'foto' => 'kaka.png'
    ],
    ['nama' => 'Rizal Fahla',
    'npm' => '223040125',
    'email' => 'rizal.223040125@mail.unpas.ac.id',
    'jurusan' => 'Teknik Informatika',
    'foto' => 'rizal.jpeg'
    ],
    ['nama' => 'Chandra Ardiansyah',
    'npm' => '223040',
    'email' => 'chandra.223040110@mail.unpas.ac.id',
    'jurusan' => 'Teknik Informatika',
    'foto' => 'chandra.png'
    ],
    ['nama' => 'Dzikri Setiawan',
    'npm' => '223040072',
    'email' => 'dzikri.223040072@mail.unpas.ac.id',
    'jurusan' => 'Teknik Informatika',
    'foto' => 'dzikri.jpeg'
    ],
]
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas 5a</title>
</head>
<body>
    <h2>Daftar mahasiswa</h2>
    <?php foreach($mahasiswa as $mhs) {?>
    <br>
    <ul>
        <li style ="list-style:none;">
            <img src="img/<?= $mhs['foto']; ?>" width = "150" height = "150" border = "3px solid black" >
        </li>
        <li>Nama : <?= $mhs['nama']; ?></li>
        <li>NPM : <?= $mhs['npm']; ?></li>
        <li>Email : <?= $mhs['email']; ?></li>
        <li>Jurusan : <?= $mhs['jurusan']; ?></li>
    </ul>
    <?php } ?>
</body>
</html>