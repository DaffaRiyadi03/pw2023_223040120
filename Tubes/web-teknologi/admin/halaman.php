<?php
require_once __DIR__ . '/../inc/inc_fungsi.php';
wajib_admin('../login.php');

$katakunci = trim($_GET['katakunci'] ?? '');
$kategori  = trim($_GET['kategori'] ?? '');
$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'hapus') {
    csrf_check();
    $hapus = (int) ($_POST['id'] ?? 0);
    $lama  = db_one('SELECT gambar FROM highlight WHERE id = ?', [$hapus]);
    db_query('DELETE FROM highlight WHERE id = ?', [$hapus]);
    hapus_gambar((string) ($lama['gambar'] ?? ''));
    $pesan = 'Berhasil hapus data';
}

$where  = [];
$params = [];
if ($katakunci !== '') {
    $where[]  = '(judul LIKE ? OR kategori LIKE ? OR COALESCE(isi_teks, isi) LIKE ?)';
    $params   = array_merge($params, array_fill(0, 3, like($katakunci)));
}
if ($kategori !== '') {
    $where[]  = 'kategori = ?';
    $params[] = $kategori;
}
$whereSql = $where ? ' WHERE ' . implode(' AND ', $where) : '';

$per_halaman = 10;
$total  = (int) db_one('SELECT COUNT(*) AS n FROM highlight' . $whereSql, $params)['n'];
$pages  = max(1, (int) ceil($total / $per_halaman));
$page   = min(max(1, (int) ($_GET['page'] ?? 1)), $pages);
$mulai  = ($page - 1) * $per_halaman;

$rows = db_all(
    'SELECT * FROM highlight' . $whereSql . ' ORDER BY id DESC LIMIT ' . (int) $mulai . ',' . (int) $per_halaman,
    $params
);
$nomor = $mulai + 1;
$kategoriList = db_all('SELECT DISTINCT kategori FROM highlight ORDER BY kategori');
$tautan = 'halaman.php?katakunci=' . urlencode($katakunci) . '&kategori=' . urlencode($kategori);

require __DIR__ . '/inc_header.php';
?>
<div class="page-head">
    <div>
        <p class="kicker">Konten</p>
        <h1>Artikel</h1>
        <p><?= $total ?> artikel tersimpan<?= $katakunci !== '' ? ' · hasil untuk “' . e($katakunci) . '”' : '' ?></p>
    </div>
    <a class="btn-accent" href="halaman_input.php">+ Tulis artikel</a>
</div>

<?php if ($pesan): ?>
<div class="alert-line ok" role="status"><?= e($pesan) ?></div>
<?php endif; ?>

<div class="toolbar" style="margin-bottom:22px">
    <form class="search-panel" method="get" role="search">
        <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" aria-hidden="true">
            <circle cx="11" cy="11" r="7"></circle>
            <path d="m20 20-3.5-3.5"></path>
        </svg>
        <input type="search" class="search-input" placeholder="Cari judul, kategori, atau isi…" name="katakunci"
            value="<?= e($katakunci) ?>" aria-label="Cari artikel">
        <input type="hidden" name="kategori" value="<?= e($kategori) ?>">
        <button type="submit" name="cari" class="btn-accent">Cari</button>
    </form>
    <div class="chips">
        <a class="chip <?= $kategori === '' ? 'is-active' : '' ?>"
            href="halaman.php?katakunci=<?= urlencode($katakunci) ?>">Semua</a>
        <?php foreach ($kategoriList as $k): ?>
        <a class="chip <?= $k['kategori'] === $kategori ? 'is-active' : '' ?>"
            href="<?= $tautan ?>&kategori=<?= urlencode($k['kategori']) ?>"><?= e($k['kategori']) ?></a>
        <?php endforeach; ?>
    </div>
</div>

<div class="card-panel">
    <div class="table-scroll">
        <table class="table-clean">
            <thead>
                <tr>
                    <th style="width:48px">#</th>
                    <th>Artikel</th>
                    <th style="width:150px">Kategori</th>
                    <th style="width:160px">Tanggal</th>
                    <th style="width:150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r1): ?>
                <tr>
                    <td class="cell-date"><?= $nomor++ ?></td>
                    <td>
                        <div class="cell-artikel">
                            <?php if ($r1['gambar']): ?>
                            <img class="thumb" src="../gambar/<?= e($r1['gambar']) ?>" alt="">
                            <?php endif; ?>
                            <div>
                                <a class="cell-title" href="halaman_input.php?id=<?= (int) $r1['id'] ?>">
                                    <?= e($r1['judul']) ?>
                                </a>
                                <p class="cell-excerpt"><?= e(ringkas((string) ($r1['isi_teks'] ?? $r1['isi']), 120)) ?></p>
                            </div>
                        </div>
                    </td>
                    <td><span class="cell-kategori"><?= e($r1['kategori']) ?></span></td>
                    <td class="cell-date"><?= e(tanggal_id($r1['tgl_upload'])) ?></td>
                    <td>
                        <div class="row-actions">
                            <a class="btn-ghost btn-xs" href="halaman_input.php?id=<?= (int) $r1['id'] ?>">Edit</a>
                            <form method="post" class="d-inline"
                                onsubmit="return confirm('Apakah anda ingin menghapus data ini?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="aksi" value="hapus">
                                <input type="hidden" name="id" value="<?= (int) $r1['id'] ?>">
                                <button type="submit" class="btn-danger-soft btn-xs">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (!$rows): ?>
                <tr>
                    <td colspan="5" class="text-center" style="padding:48px 18px;color:var(--muted)">
                        Data tidak ditemukan.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination-clean">
        <span class="pagination-info">Menampilkan
            <?= $rows ? $mulai + 1 : 0 ?>&ndash;<?= $mulai + count($rows) ?> dari <?= $total ?></span>
        <?php if ($pages > 1): ?>
        <nav class="pagination-pages" aria-label="Navigasi halaman">
            <?php for ($i = 1; $i <= $pages; $i++): ?>
            <a class="<?= $i === $page ? 'is-active' : '' ?>" href="<?= $tautan ?>&page=<?= $i ?>"
                <?= $i === $page ? 'aria-current="page"' : '' ?>><?= $i ?></a>
            <?php endfor; ?>
        </nav>
        <?php endif; ?>
    </div>
</div>

<?php include 'inc_footer.php'; ?>
