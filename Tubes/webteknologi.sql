-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jun 10, 2023 at 05:03 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webteknologi`
--

-- --------------------------------------------------------

--
-- Table structure for table `highlight`
--

CREATE TABLE `highlight` (
  `id` int NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `tgl_upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `highlight`
--

INSERT INTO `highlight` (`id`, `gambar`, `judul`, `kategori`, `isi`, `tgl_upload`) VALUES
(1, 'PHP.jpg', 'PHP Adalah Bagian dalam Bahasa Pemrograman, Ketahui Jenis-Jenisnya', 'Website', '<p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">Personal Home Pages atau&nbsp;<a href=\"https://hot.liputan6.com/read/4521117/php-adalah-bahasa-pemrograman-yang-bersifat-open-source-ini-peranan-dan-kelebihannya\" target=\"_blank\" style=\"background-color: transparent; color: rgb(255, 51, 0); text-decoration-line: none;\">PHP</a>&nbsp;adalah&nbsp;bahasa skrip&nbsp;yang dapat ditanamkan atau disisipkan ke dalam&nbsp;HTML. PHP adalah bagian yang dapat membuat website Anda menjadi lebih dinamis. Tidak hanya itu, PHP adalah salah satu bahasa pemrograman yang dapat berinteraksi langsung dengan database.</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\"><a href=\"https://hot.liputan6.com/read/4521117/php-adalah-bahasa-pemrograman-yang-bersifat-open-source-ini-peranan-dan-kelebihannya\" target=\"_blank\" style=\"background-color: transparent; color: rgb(255, 51, 0); text-decoration-line: none;\">PHP adalah</a>&nbsp;singkatan rekursif untuk \"PHP: Hypertext Preprocessor\", yaitu&nbsp;<a href=\"https://hot.liputan6.com/read/4521117/php-adalah-bahasa-pemrograman-yang-bersifat-open-source-ini-peranan-dan-kelebihannya\" target=\"_blank\" style=\"background-color: transparent; color: rgb(255, 51, 0); text-decoration-line: none;\">bahasa pemrograman</a>&nbsp;yang digunakan secara luas untuk penanganan pembuatan dan pengembangan sebuah situs web dan bisa digunakan bersamaan dengan HTML. PHP adalah bagian dari bahasa skrip, seperti JavaScript dan Phyton.</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\"><a href=\"https://hot.liputan6.com/read/4521117/php-adalah-bahasa-pemrograman-yang-bersifat-open-source-ini-peranan-dan-kelebihannya\" target=\"_blank\" style=\"background-color: transparent; color: rgb(255, 51, 0); text-decoration-line: none; outline: 0px;\">PHP</a>&nbsp;juga banyak diaplikasikan untuk pembuatan program-program seperti misalnya sistem informasi klinik, rumah sakit, akademik, keuangan, manajemen aset, manajemen bengkel dan lain-lain.Penerapan PHP saat ini juga banyak ditemukan pada proyek-proyek pemerintah seperti e-budgetting, e-procurement, e-goverment dan e-e lainnya.</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">Untuk lebih rinci, berikut ini penjelasan mengenai pengertian&nbsp;<a href=\"https://hot.liputan6.com/read/4521117/php-adalah-bahasa-pemrograman-yang-bersifat-open-source-ini-peranan-dan-kelebihannya\" target=\"_blank\" style=\"background-color: transparent; color: rgb(255, 51, 0); text-decoration-line: none;\">PHP</a>&nbsp;Beserta fungsi dan cara kerjanya yang telah dirangkum oleh Liputan6.com dari berbagai sumber, Rabu (13/10/2021)</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">Hypertext Preprocessor atau PHP adalah suatu bahasa pemrograman yang digunakan untuk membuat web dinamis, meskipun bisa juga digunakan untuk membuat program lain. Tentunya bahasa pemrograman PHP berbeda dengan HTML, pada PHP Script atau kode yang dibuat tidak dapat ditampilkan pada halaman atau muka website begitu saja, tapi harus diproses terlebih dahulu oleh web server lalu ditampilkan dalam bentuk halaman website di web browser, Script PHP juga dapat disisipkan pada HTML dan Script PHP selalu diawali dengan&lt;php dan diakhiri dengan?&gt;.</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">Manajemen database yang biasanya digunakan untuk pemerograman PHP misalnya seperti MySQL, tapi ada juga yang menggunakan Oracle, Microsoft Acces dan lain-lain. PHP disebut juga sebagai bahasa pemerograman script server side, karena PHP di proses pada komputer server.</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">Jenis server yang sering digunakan bersama dengan PHP antara lain Apache, Nginx, dan LiteSpeed. PHP adalah bahasa pemograman yang bersifat open source. Artinya, para pengguna bebas untuk memodifikasi dan mengembangkannya sesuai dengan kebutuhan masing-masing.&nbsp;</p><h2 class=\"article-content-body__item-title\" data-component-name=\"desktop:read-page:article-content-body:section:pagetitle\" style=\"color: rgb(57, 57, 57); margin-top: 40px; margin-bottom: 18px; font-size: 24px; font-weight: 700; line-height: 1.4; font-family: Inter, arial, helvetica, sans-serif;\">Jenis-jenis PHP</h2><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">Berikut ini ada beberapa jenis-jenis PHP yang wajib Anda ketahui sebagai pemula, diantaranya:</p><h2 style=\"color: rgb(0, 0, 0); font-family: Inter, arial, helvetica, sans-serif;\">1. Integer</h2><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">Merupakan tipe data PHP berupa bilangan bulat, tipe data ini sering sekali digunakan pada pemerograman PHP khususnya yang berkaitannya dengan bilangan bulat. digunakan sebagai variabel atau digunakan dalam ekspresi seperti :</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">$int_var = 12345;</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">$another_int = -12345 + 12345;</p><h2 style=\"color: rgb(0, 0, 0); font-family: Inter, arial, helvetica, sans-serif;\">2. Float</h2><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">Dapat dikatakn juga bilangan berkoma (,) tapi dalam pemerograman tidak menggunakan koma melainkan titik (.).</p><h2 style=\"color: rgb(0, 0, 0); font-family: Inter, arial, helvetica, sans-serif;\">3. String</h2><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">Merupakan tipe data berupa karakter, didalamnya bisa berupa teks atau kata. Adalah kumpulan karakter, seperti dibawah :</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">$string_1 = “This is a string in double quotes”;</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">$string_2 = “This is a somewhat longer, singly quoted string”;</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">$string_39 = “This is a string has thirty-nine characters”;</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">$string_0 = “ “; //This is a string with zero characters</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">String dapat ditutup dalam tanda petik tunggal maupun petik ganda. Petik tunggal seperti literalnya sedang petik ganda menggantikan variabel dengan nilainya seperti menginterpretasikan karakter khusus.</p><h2 style=\"color: rgb(0, 0, 0); font-family: Inter, arial, helvetica, sans-serif;\">4. Boolean</h2><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">Adalah nilai true atau false, digunakan sebagai kontrol seperti untuk test sebuah statement if. Nilai “truth” boolean dapat dikombinasikan menggunakan operator logika untuk membuat lebih lengkap ekspresi boolean. PHP menyediakan sepasang konstanta khususnya untuk digunakan sebagai Boolean :&nbsp;TRUE&nbsp;dan&nbsp;FALSE. Aturan untuk menentukan “truth” dari nilai yang tidak ada pada tipe boolean:</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">a. Jika nilai adalah angka,&nbsp;false&nbsp;jika sama dengan nol dan selain itu&nbsp;true.</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">b. Jika nilai adalah&nbsp;string,&nbsp;false&nbsp;jika string mengandung karakter kosong atau&nbsp;string&nbsp;“0” selain itu&nbsp;true.</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">c. Jika nilai adalah gabungan tipe data (array&nbsp;atau&nbsp;object)&nbsp;false&nbsp;jika tidak berisi nilai selain itu&nbsp;true.</p><h2 style=\"color: rgb(0, 0, 0); font-family: Inter, arial, helvetica, sans-serif;\">5. Array</h2><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">Tipe array pada PHP memudahkan programmer cara untuk mengelompokkan nilai-nilai yang berbeda dan mengindeksnya dengan numerik (dan juga dengan nama). Elemen array dituliskan dengan indeks dalam tanda kurung (the[1], [2],[3]..) dan elemn dari tipe yang berbeda dapat ditunjuk dengan array yang sama.</p><h2 style=\"color: rgb(0, 0, 0); font-family: Inter, arial, helvetica, sans-serif;\">6. Objek</h2><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">Object&nbsp;adalah sebuah tipe data yang dapat berupa sebuah bilangan, variabel atau bahkan sebuah fungsi.&nbsp;Object&nbsp;dibuat dengan tujuan untuk membantu programmer yang terbiasa dengan&nbsp;Object Oriented Programming, meski fasilitas OOP yang disediakan oleh PHP masih sangat kurang. Berikut sebuah contoh penggunaan tipe data&nbsp;object, yaitu:&nbsp;</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">&lt;? // object.php</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">class Test</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">{ var $str = “Variabel Class”;</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">function set_var($str)</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">{ $this-&gt;str = $str; }</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">}</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">$class = new Test;</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">echo$class-&gt;str;</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">$class-&gt;set_var (“Variabel Object”);</p><p style=\"overflow-wrap: break-word; color: rgb(68, 68, 68); font-family: Inter, arial, helvetica, sans-serif; font-size: 15px;\">echo(“&lt;br&gt;$class-&gt;str”); ?&gt;</p>', '2023-06-11');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`) VALUES
(3, 'admin', '$2y$10$jnCr.2OOL/3GonsUWNo/XOK3RK6zLjDhDk3/2GMJdANb1l.8Dsz6.', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `highlight`
--
ALTER TABLE `highlight`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `highlight`
--
ALTER TABLE `highlight`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
