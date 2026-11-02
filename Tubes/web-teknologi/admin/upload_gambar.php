<?php
require_once __DIR__ . '/../inc/inc_fungsi.php';
admin_saja();

if (empty($_FILES['file']['name'])) {
    http_response_code(400);
    exit('File tidak ditemukan.');
}

try {
    $nama = simpan_gambar($_FILES['file']);
} catch (RuntimeException $e) {
    http_response_code(400);
    exit($e->getMessage());
}

header('Content-Type: text/plain; charset=utf-8');
echo '../gambar/' . $nama;
