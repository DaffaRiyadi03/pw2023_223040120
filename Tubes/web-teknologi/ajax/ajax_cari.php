<?php
require_once __DIR__ . '/../inc/inc_fungsi.php';

header('Content-Type: text/html; charset=utf-8');

$keywords = $_GET['keywords'] ?? [];
$kategori = trim($_GET['kategori'] ?? '');

echo render_kartu_list(cari_artikel($keywords, $kategori));
