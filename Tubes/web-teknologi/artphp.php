<?php
require_once __DIR__ . '/inc/inc_layout.php';

$id   = (int) ($_GET['id'] ?? 0);
$data = $id ? db_one('SELECT * FROM highlight WHERE id = ?', [$id]) : null;

if (!$data) {
    http_response_code(404);
    layout_head('Artikel tidak ditemukan');
    echo '<div class="container py-5"><p>Artikel tidak ditemukan.</p><a href="index.php">&laquo; Kembali ke beranda</a></div>';
    layout_foot();
    exit;
}

layout_head($data['judul']);
?>
<article class="container py-4">
    <img src="gambar/<?= e($data['gambar']) ?>" class="img-fluid w-100" style="height: 400px; object-fit: cover;"
        alt="<?= e($data['judul']) ?>" />
    <hr>
    <h2><?= e($data['judul']) ?></h2>
    <p class="lead text-muted"><?= e($data['kategori']) ?> | <?= e($data['tgl_upload']) ?></p>
    <div style="text-align: justify;">
        <?= $data['isi'] /* HTML dari Summernote; hanya admin yang bisa menulis, sengaja tidak di-escape */ ?>
    </div>
</article>
<?php layout_foot(); ?>
