<?php
require_once __DIR__ . '/inc/inc_layout.php';

$q        = trim($_GET['q'] ?? '');
$keywords = preg_split('/\s+/', $q, -1, PREG_SPLIT_NO_EMPTY);
$kategori = trim($_GET['kategori'] ?? '');
$artikel  = cari_artikel($keywords, $kategori);
$kategoriList = db_all('SELECT DISTINCT kategori FROM highlight ORDER BY kategori');

// Artikel terbaru dipakai sebagai pilihan editor; grid menampilkan sisanya.
$utama  = $q === '' ? ($artikel[0] ?? null) : null;
$daftar = $utama ? array_slice($artikel, 1) : $artikel;

layout_head('D.R Tech — Portal Artikel Teknologi');
?>
<section class="wrap hero" id="cari">
    <div class="hero-grid">
        <div class="hero-copy">
            <p class="eyebrow">Portal artikel · Edisi <?= date('Y') ?></p>
            <h1>Teknologi, dijelaskan dengan tenang.</h1>
            <p class="lead">Esai dan panduan ringkas soal pemrograman, web, dan perangkat — ditulis untuk dibaca,
                bukan discroll.</p>
            <form class="search-panel" id="form-cari" action="index.php" method="get" role="search">
                <svg class="search-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="7"></circle>
                    <path d="m20 20-3.5-3.5"></path>
                </svg>
                <input id="q" name="q" class="search-input" type="search" placeholder="Cari artikel, mis. PHP atau AI…"
                    value="<?= e($q) ?>" aria-label="Cari artikel">
                <input type="hidden" name="kategori" value="<?= e($kategori) ?>">
                <button class="btn-accent" type="submit">Cari</button>
            </form>
            <?php if ($kategoriList): ?>
            <div class="popular">
                <span class="label">Populer</span>
                <?php foreach (array_slice($kategoriList, 0, 3) as $k): ?>
                <a class="tag" href="index.php?kategori=<?= urlencode($k['kategori']) ?>"><?= e($k['kategori']) ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <?php if ($utama): ?>
        <aside class="featured">
            <a class="featured-cover" href="artphp.php?id=<?= (int) $utama['id'] ?>">
                <?php if ($utama['gambar'] !== ''): ?>
                <img src="gambar/<?= e($utama['gambar']) ?>" alt="<?= e($utama['judul']) ?>">
                <?php endif; ?>
            </a>
            <div class="featured-body">
                <div class="featured-meta">
                    <span class="kicker">Pilihan editor</span>
                    <span class="kicker is-muted"><?= menit_baca((string) ($utama['isi_teks'] ?? $utama['isi'])) ?>
                        menit</span>
                </div>
                <h2 class="featured-title"><a
                        href="artphp.php?id=<?= (int) $utama['id'] ?>"><?= e($utama['judul']) ?></a></h2>
                <p class="featured-excerpt"><?= e(ringkas((string) ($utama['isi_teks'] ?? $utama['isi']), 150)) ?></p>
            </div>
        </aside>
        <?php endif; ?>
    </div>
</section>

<?php if ($kategoriList): ?>
<div class="wrap tabs-wrap" id="kategori">
    <div class="rule"></div>
    <nav class="tabs" aria-label="Filter kategori">
        <a class="tab <?= $kategori === '' ? 'is-active' : '' ?>" href="index.php">Semua</a>
        <?php foreach ($kategoriList as $k): ?>
        <a class="tab <?= $k['kategori'] === $kategori ? 'is-active' : '' ?>"
            href="index.php?kategori=<?= urlencode($k['kategori']) ?>"><?= e($k['kategori']) ?></a>
        <?php endforeach; ?>
    </nav>
</div>
<?php endif; ?>

<section class="wrap section" id="artikel">
    <div class="section-head">
        <div>
            <p class="kicker">Terbaru</p>
            <h2><?= $kategori !== '' ? 'Kategori ' . e($kategori) : ($q !== '' ? 'Hasil pencarian' : 'Artikel lainnya') ?>
            </h2>
            <p class="sub"><?= $q !== '' ? 'Kata kunci: “' . e($q) . '”' : 'Pilihan tulisan terbaru seputar dunia teknologi.' ?>
            </p>
        </div>
        <a class="link-arrow" href="index.php">Lihat semua &rarr;</a>
    </div>
    <div id="daftar-artikel"><?= $daftar ? render_kartu_list($daftar) : '<p class="sub">Belum ada tulisan lain. Artikel terbaru tampil di atas.</p>' ?></div>
</section>

<section class="wrap subscribe-wrap">
    <div class="subscribe">
        <div>
            <h3>Satu email, satu esai tiap pekan.</h3>
            <p>Ringkasan tulisan terbaik D.R Tech. Tanpa iklan, bisa berhenti kapan saja.</p>
        </div>
        <?php if (isset($_SESSION['username'])): ?>
        <a class="btn-light" href="#artikel">Jelajahi artikel</a>
        <?php else: ?>
        <a class="btn-light" href="registrasi.php">Daftar gratis</a>
        <?php endif; ?>
    </div>
</section>

<script>
const form = document.getElementById('form-cari');
const target = document.getElementById('daftar-artikel');
let timer;

async function cariArtikel() {
    const params = new URLSearchParams(new FormData(form));
    target.style.opacity = .45;
    target.innerHTML = await (await fetch('ajax/ajax_cari.php?' + params)).text();
    target.style.opacity = 1;
}

form.addEventListener('input', () => {
    clearTimeout(timer);
    timer = setTimeout(cariArtikel, 250);
});
form.addEventListener('change', cariArtikel);
</script>
<?php layout_foot(); ?>
