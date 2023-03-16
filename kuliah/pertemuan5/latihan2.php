<?php 
$binatang = ['🐵','🐺','🐱','🦁','🐷'];
$makanan = ['🍕','🍔','🍟','🌭','🍿'];
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latihan 2</title>
</head>
<body>
    <h2>Daftar Bainatang</h2>
    <ul>
        <?php for($i = 0; $i < 5; $i++) { ?>
        <li><?= $binatang[$i]; ?></li>
        <?php } ?>
    </ul>
    <h2>Daftar Makanan</h2>
    <ul>
        <?php for($i = 0; $i < 5; $i++) { ?>
        <li><?= $makanan[$i]; ?></li>
        <?php } ?>
    </ul>

    <br>

    <h2>Daftar Bainatang</h2>
    <ol>
        <?php foreach($binatang as $bntng) { ?>
        <li><?= $bntng; ?></li>
        <?php } ?>
        </ol>

    <br>

    <h2>Daftar Makanan</h2>
    <ol>
        <?php foreach($makanan as $mkn) { ?>
        <li><?= $mkn; ?></li>
        <?php } ?>
    </ol>
    
</body>
</html>