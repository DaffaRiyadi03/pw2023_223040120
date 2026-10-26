<?php require 'inc_header.php'; ?>
<?php
$katakunci = trim($_GET['katakunci'] ?? '');
$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'hapus') {
    csrf_check();
    db_query('DELETE FROM highlight WHERE id = ?', [(int) ($_POST['id'] ?? 0)]);
    $pesan = 'Berhasil hapus data';
}

$where  = '';
$params = [];
if ($katakunci !== '') {
    $where  = ' WHERE (judul LIKE ? OR kategori LIKE ? OR isi LIKE ?)';
    $params = array_fill(0, 3, '%' . $katakunci . '%');
}

$per_halaman = 10;
$total  = (int) db_one('SELECT COUNT(*) AS n FROM highlight' . $where, $params)['n'];
$pages  = max(1, (int) ceil($total / $per_halaman));
$page   = min(max(1, (int) ($_GET['page'] ?? 1)), $pages);
$mulai  = ($page - 1) * $per_halaman;

$rows = db_all(
    'SELECT * FROM highlight' . $where . ' ORDER BY id DESC LIMIT ' . (int) $mulai . ',' . (int) $per_halaman,
    $params
);
$nomor = $mulai + 1;
?>
<h1>Halaman Admin</h1>
<p>
    <a href="halaman_input.php"><input type="button" class="btn btn-primary" value="Buat Halaman Baru" /></a>
</p>
<?php if ($pesan): ?>
<div class="alert alert-primary" role="alert"><?= e($pesan) ?></div>
<?php endif; ?>
<form class="row g-3" method="get">
    <div class="col-auto">
        <input type="text" class="form-control" placeholder="Masukan Kata Kunci" name="katakunci"
            value="<?= e($katakunci) ?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Cari Tulisan" class="btn btn-secondary" />
    </div>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th class="col-1">#</th>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Isi</th>
            <th class="col-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $r1): ?>
        <tr>
            <td><?= $nomor++ ?></td>
            <td><?= e($r1['gambar']) ?></td>
            <td><?= e($r1['judul']) ?></td>
            <td><?= e($r1['kategori']) ?></td>
            <td><?= e(ringkas($r1['isi'], 120)) ?></td>
            <td>
                <a href="halaman_input.php?id=<?= (int) $r1['id'] ?>">
                    <span class="badge bg-warning text-dark">Edit</span>
                </a>
                <form method="post" class="d-inline"
                    onsubmit="return confirm('Apakah anda ingin menghapus data ini?')">
                    <?= csrf_field() ?>
                    <input type="hidden" name="aksi" value="hapus">
                    <input type="hidden" name="id" value="<?= (int) $r1['id'] ?>">
                    <button type="submit" class="badge bg-danger border-0">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (!$rows): ?>
        <tr>
            <td colspan="6" class="text-center">Data tidak ditemukan.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<nav aria-label="Navigasi halaman">
    <ul class="pagination">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
            <a class="page-link"
                href="halaman.php?katakunci=<?= urlencode($katakunci) ?>&page=<?= $i ?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>
    </ul>
</nav>

<?php include 'inc_footer.php'; ?>
