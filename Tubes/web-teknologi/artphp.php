<?php
require_once __DIR__ . '/inc/inc_layout.php';

$id   = (int) ($_GET['id'] ?? 0);
$data = $id ? db_one('SELECT * FROM highlight WHERE id = ?', [$id]) : null;

if (!$data) {
    http_response_code(404);
    $saran = db_all('SELECT id, judul, kategori, gambar FROM highlight ORDER BY id DESC LIMIT 3');
    layout_head('Artikel tidak ditemukan');
    ?>
<section class="wrap error-page">
    <p class="kicker">Error 404</p>
    <h1>Halaman ini tidak ada.</h1>
    <p class="error-sub">Tautan mungkin sudah dipindahkan atau artikelnya dihapus. Coba mulai dari beranda, atau baca
        salah satu tulisan di bawah.</p>
    <div class="error-actions">
        <a class="btn-accent" href="index.php">Kembali ke beranda</a>
        <a class="btn-ghost" href="index.php#cari">Cari artikel</a>
    </div>
</section>

<?php if ($saran): ?>
<section class="wrap suggestions">
    <div class="rule"></div>
    <p class="kicker">Mungkin kamu suka</p>
    <div class="sug-row">
        <?php foreach ($saran as $s): ?>
        <a class="sug-item" href="artphp.php?id=<?= (int) $s['id'] ?>">
            <span class="sug-cover">
                <?php if (!empty($s['gambar'])): ?>
                <img src="gambar/<?= e($s['gambar']) ?>" alt="<?= e($s['judul']) ?>" loading="lazy">
                <?php endif; ?>
            </span>
            <span class="kicker"><?= e($s['kategori']) ?></span>
            <span class="sug-title"><?= e($s['judul']) ?></span>
        </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
<?php
    layout_foot();
    exit;
}

$lain = db_all(
    'SELECT id, judul, kategori FROM highlight WHERE id <> ? ORDER BY id DESC LIMIT 3',
    [$id]
);

layout_head($data['judul']);
?>
<article class="wrap article-head">
    <a class="back-link" href="index.php">&larr; Semua artikel</a>
    <div class="kicker-row">
        <span class="kicker"><?= e($data['kategori']) ?></span>
        <span class="rule-v" aria-hidden="true"></span>
        <span class="kicker is-muted"><?= menit_baca($data['isi']) ?> menit baca</span>
    </div>
    <h1 class="article-title"><?= e($data['judul']) ?></h1>
    <p class="dek"><?= e(ringkas($data['isi'], 220)) ?></p>
    <div class="byline">
        <span class="avatar" aria-hidden="true">D</span>
        <div class="who">
            <span class="author">Muhammad Daffa Riyadi</span>
            <span class="date"><?= e(tanggal_id($data['tgl_upload'])) ?></span>
        </div>
    </div>
</article>

<?php if ($data['gambar']): ?>
<div class="wrap article-cover">
    <img src="gambar/<?= e($data['gambar']) ?>" alt="<?= e($data['judul']) ?>">
</div>
<?php endif; ?>

<div class="wrap article-layout">
    <div class="prose">
        <?= $data['isi'] /* HTML dari Summernote; hanya admin yang bisa menulis, sengaja tidak di-escape */ ?>
        <div class="prose-tags">
            <span class="tag"><?= e($data['kategori']) ?></span>
        </div>
        <div class="article-foot">
            <a class="btn-ghost" href="index.php">&larr; Kembali ke beranda</a>
        </div>
    </div>

    <?php if ($lain): ?>
    <aside class="rail">
        <div class="rule"></div>
        <p class="kicker">Baca juga</p>
        <?php foreach ($lain as $l): ?>
        <a class="rail-item" href="artphp.php?id=<?= (int) $l['id'] ?>">
            <span class="kicker"><?= e($l['kategori']) ?></span>
            <span class="rail-title"><?= e($l['judul']) ?></span>
        </a>
        <?php endforeach; ?>
    </aside>
    <?php endif; ?>
</div>
<?php layout_foot(); ?>
