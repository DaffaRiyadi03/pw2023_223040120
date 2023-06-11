<?php
include_once("../inc/inc_koneksi.php");
include_once("../inc/inc_fungsi.php");
if (isset($_GET['kategori'])) {
    $kategori = $_GET['kategori'];
    
    // Query untuk mengambil data berdasarkan kategori
    $query = "SELECT * FROM highlight WHERE kategori = '$kategori'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_array($result)) {
            // Tampilkan data sesuai format yang diinginkan
            echo 
           ' <div class="row-3">
                <div class="card mb-3" style="max-width: auto; ">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="gambar/'.$data['gambar'].'" class="img-thumbnail" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body" style="text-align: justify;">
                                <h5 class="card-title">
                                    <a href="artphp.php?judul='.urlencode($data['judul']).'" style="text-decoration: none; color: black;">'.$data['judul'].'</a>
                                </h5>
                                <p class="mb-1 text-muted">'.$data['kategori'].'</p>
                                <p class="card-text">'.$data['isi'].'</p>
                                <p class="card-text"><small class="text-muted">'.$data['tgl_upload'].'</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
    } else {
        // Tampilkan pesan jika tidak ada data yang sesuai dengan kategori
        echo '<div class="alert alert-info" role="alert">Tidak ada hasil yang sesuai dengan kategori yang dipilih.</div>';
    }
    
    // Hentikan eksekusi skrip setelah mengirimkan respons
    die();
} else {
    // Tampilkan pesan jika parameter kategori tidak ada
    echo '<div class="alert alert-danger" role="alert">Parameter kategori tidak ditemukan.</div>';
    // Hentikan eksekusi skrip setelah mengirimkan respons
    die();
}
?>