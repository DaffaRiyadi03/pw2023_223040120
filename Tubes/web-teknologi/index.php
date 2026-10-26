<?php
require_once __DIR__ . '/inc/inc_layout.php';

$keywords = preg_split('/\s+/', trim($_GET['q'] ?? ''), -1, PREG_SPLIT_NO_EMPTY);
$kategori = trim($_GET['kategori'] ?? '');
$artikel  = cari_artikel($keywords, $kategori);
$kategoriList = db_all('SELECT DISTINCT kategori FROM highlight ORDER BY kategori');

layout_head('D.R Tech');
?>
<section class="jumbotron text-center">
    <h1 class="display-4 ms-auto">Hello, world!</h1>
    <p class="lead">Jelajahi artikel mengenai teknologi disini!!</p>
    <hr class="my-1" />
    <form class="d-flex" id="form-cari" action="index.php" method="get">
        <input id="q" name="q" class="form-control me-2" type="search" placeholder="Search"
            value="<?= e($_GET['q'] ?? '') ?>" aria-label="Search" />
        <select name="kategori" class="form-select me-2" style="max-width: 200px;" aria-label="Kategori">
            <option value="">Semua Kategori</option>
            <?php foreach ($kategoriList as $k): ?>
            <option value="<?= e($k['kategori']) ?>" <?= $k['kategori'] === $kategori ? 'selected' : '' ?>>
                <?= e($k['kategori']) ?>
            </option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-primary" type="submit">Search</button>
    </form>
</section>

<section id="projects" class="container py-4">
    <h2>Highlight</h2>
    <div id="daftar-artikel"><?= render_kartu_list($artikel) ?></div>
</section>

<script>
const form = document.getElementById('form-cari');
const target = document.getElementById('daftar-artikel');
let timer;

form.addEventListener('submit', e => e.preventDefault());
form.addEventListener('input', () => {
    clearTimeout(timer);
    timer = setTimeout(async () => {
        const params = new URLSearchParams(new FormData(form));
        target.innerHTML = await (await fetch('ajax/ajax_cari.php?' + params)).text();
    }, 250);
});
</script>
<?php layout_foot(); ?>
