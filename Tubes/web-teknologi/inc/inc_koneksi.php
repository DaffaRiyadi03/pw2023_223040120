<?php
/*
 * Konfigurasi database. Port MySQL Laragon default 3306.
 * Bisa dioverride lewat environment variable bila beda mesin.
 */
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', (int) (getenv('DB_PORT') ?: 3306));
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'webteknologi');

function db(): mysqli
{
    static $koneksi = null;
    if ($koneksi === null) {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
            mysqli_set_charset($koneksi, 'utf8mb4');
        } catch (mysqli_sql_exception $e) {
            http_response_code(500);
            exit('Koneksi database gagal: ' . $e->getMessage()
                . ' (cek DB_HOST/DB_PORT/DB_NAME di inc/inc_koneksi.php)');
        }
    }
    return $koneksi;
}
