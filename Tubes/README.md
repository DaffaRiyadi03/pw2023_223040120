# D.R Tech — Portal Artikel Teknologi

Tugas besar Pemrograman Web. PHP native + MySQL (mysqli), Bootstrap 5.

## Struktur

```
webteknologi.sql          dump database (sudah termasuk CREATE DATABASE)
web-teknologi/
  index.php               beranda: daftar artikel + pencarian & filter kategori
  artphp.php              detail artikel (?id=)
  login.php  registrasi.php  logout.php
  inc/inc_koneksi.php     konfigurasi + koneksi database
  inc/inc_fungsi.php      helper: query prepared, auth, CSRF, render kartu
  inc/inc_layout.php      navbar + footer bersama
  admin/                  CRUD artikel (khusus role admin)
  ajax/ajax_cari.php      endpoint live search
  gambar/                 gambar artikel
```

## Menjalankan

1. Start MySQL di Laragon (port default 3306).
2. Import `webteknologi.sql` lewat phpMyAdmin, atau:
   `mysql -u root < webteknologi.sql`
3. Sesuaikan `inc/inc_koneksi.php` bila user/password/port MySQL berbeda.
   Bisa juga lewat environment variable: `DB_HOST`, `DB_PORT`, `DB_USER`, `DB_PASS`, `DB_NAME`.
4. Buka `http://localhost/Tubes/web-teknologi/index.php` (atau sesuai document root Laragon).

## Akun admin

Username `admin`. Password mengikuti dump. Kalau lupa, reset lewat terminal:

```bash
php -r "echo password_hash('passwordbaru', PASSWORD_DEFAULT), PHP_EOL;"
```

lalu:

```sql
UPDATE user SET password = '<hash di atas>' WHERE username = 'admin';
```

Akun baru dari halaman daftar selalu ber-role `user` dan tidak bisa membuka `/admin`.

## Catatan

- Semua query memakai prepared statement; output di-escape dengan `e()`.
- Form ubah/hapus memakai CSRF token.
- Upload gambar dibatasi JPG/PNG/WEBP/GIF, maks 5 MB, dicek dengan `getimagesize`.
- Isi artikel disimpan sebagai HTML dari Summernote dan ditampilkan apa adanya (hanya admin yang bisa menulis).
