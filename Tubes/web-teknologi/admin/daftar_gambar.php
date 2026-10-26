<?php
require_once __DIR__ . '/../inc/inc_fungsi.php';
admin_saja();

$files = array_filter(glob(__DIR__ . '/../gambar/*'), 'is_file');

header('Content-Type: application/json');
echo json_encode(array_values(array_map('basename', $files)));
