<?php
require_once __DIR__ . '/../inc/inc_fungsi.php';
admin_saja();

if (empty($_FILES['file']['name'])) {
    http_response_code(400);
    exit('File tidak ditemukan.');
}
$file = $_FILES['file'];
if ($file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    exit('Upload gagal, kode error: ' . $file['error']);
}

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
    http_response_code(400);
    exit('Format gambar harus JPG/PNG/WEBP/GIF.');
}
if ($file['size'] > 5 * 1024 * 1024) {
    http_response_code(400);
    exit('Ukuran gambar maksimal 5 MB.');
}
if (!@getimagesize($file['tmp_name'])) {
    http_response_code(400);
    exit('File yang diunggah bukan gambar.');
}

$nama = bin2hex(random_bytes(8)) . '.' . $ext;
if (!move_uploaded_file($file['tmp_name'], __DIR__ . '/../gambar/' . $nama)) {
    http_response_code(500);
    exit('Gagal menyimpan gambar.');
}

header('Content-Type: text/plain; charset=utf-8');
echo '../gambar/' . $nama;
