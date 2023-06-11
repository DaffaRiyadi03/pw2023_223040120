<?php
include_once("../inc/inc_koneksi.php");
include_once("../inc/inc_fungsi.php");

if (isset($_GET['keywords'])) {
    $keywords = $_GET['keywords'];
    $query = "SELECT * FROM highlight WHERE ";
    foreach ($keywords as $key => $keyword) {
        if ($key > 0) {
            $query .= " OR ";
        }
        $query .= "judul LIKE '%$keyword%' OR
                   kategori LIKE '%$keyword%' OR
                   isi LIKE '%$keyword%' OR                   
                   tgl_upload LIKE '%$keyword%'";
    }

    $highlight = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($highlight) > 0) { // Check if any results are found
        ?>
<section id="projects">
    <div class="container">
        <div class="row">
            <div class="col"></div>
        </div>
        <div class="container-card">
            <div class="row">
                <div class="col-sm-12">
                    <h2>Highlight</h2>
                    <div class="row">
                        <?php while ($data = mysqli_fetch_array($highlight)) { ?>
                        <div class="row-3">
                            <div class="card mb-3" style="max-width: auto; max-height: 300px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="gambar/<?php echo $data['gambar'] ?>" class="img-thumbnail" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body" style="text-align: justify;">
                                            <h5 class="card-title">
                                                <a href="artphp.php?judul=<?php echo urlencode($data['judul']) ?>"
                                                    style="text-decoration: none; color: black;"><?php echo $data['judul'] ?></a>
                                            </h5>
                                            <p class="mb-1 text-muted"><?php echo $data['kategori'] ?></p>
                                            <p class="card-text"><?php echo $data['isi'] ?></p>
                                            <p class="card-text"><small
                                                    class="text-muted"><?php echo $data['tgl_upload'] ?></small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    } else {
        echo "Kata kunci tidak ditemukan.";
    }
} else {
    echo "Kata kunci tidak ditemukan.";
}
?>