-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11 Agu 2018 pada 17.23
-- Versi Server: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `backend_pid`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `access_log`
--

CREATE TABLE `access_log` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(200) NOT NULL,
  `platform` varchar(200) NOT NULL,
  `browser` varchar(200) NOT NULL,
  `date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `slug` text NOT NULL,
  `name` text NOT NULL,
  `created_at` varchar(40) NOT NULL,
  `update_at` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`id`, `slug`, `name`, `created_at`, `update_at`) VALUES
(11, 'franchise', 'Franchise', '20-06-2018 09:51 PM', '20-06-2018 09:51 PM'),
(12, 'motivasi', 'Motivasi', '20-06-2018 09:51 PM', '20-06-2018 09:51 PM'),
(13, 'bisnis', 'Bisnis', '21-06-2018 02:18 PM', '21-06-2018 02:18 PM');

-- --------------------------------------------------------

--
-- Struktur dari tabel `city_news`
--

CREATE TABLE `city_news` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `city_slug` varchar(200) NOT NULL,
  `pgp_name` text NOT NULL,
  `slug` text NOT NULL,
  `created_at` varchar(40) NOT NULL,
  `update_at` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `images_news`
--

CREATE TABLE `images_news` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` enum('I','S') NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumbnail` varchar(11) DEFAULT NULL,
  `created_at` varchar(45) NOT NULL,
  `update_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `images_news`
--

INSERT INTO `images_news` (`id`, `news_id`, `name`, `type`, `title`, `thumbnail`, `created_at`, `update_at`) VALUES
(10, 10, 'pid.png', 'I', '', 'yes', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(12, 11, '4.jpeg', 'I', '', 'yes', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(13, 41, '2.jpeg', 'I', '', 'yes', '21-06-2018 04:01 PM', '21-06-2018 04:01 PM'),
(14, 41, '18556178_1691153400914686_490401.jpg', 'I', '', NULL, '27-06-2018 09:32 PM', '27-06-2018 09:32 PM'),
(15, 41, 'rizki01.png', 'I', '', NULL, '27-06-2018 09:32 PM', '27-06-2018 09:32 PM');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mail_log`
--

CREATE TABLE `mail_log` (
  `id` int(11) NOT NULL,
  `code` varchar(200) NOT NULL,
  `event` enum('FP') NOT NULL COMMENT '''FP; Forget Password',
  `destination` varchar(200) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `status` enum('N','E') NOT NULL COMMENT '''N : New'', ''E : Expired''',
  `user_type` enum('A','U') NOT NULL COMMENT 'A : Admin, U : User',
  `user_id` int(11) NOT NULL,
  `created_at` varchar(40) NOT NULL,
  `update_at` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mail_log`
--

INSERT INTO `mail_log` (`id`, `code`, `event`, `destination`, `subject`, `message`, `status`, `user_type`, `user_id`, `created_at`, `update_at`) VALUES
(1, 'bTv7TCDhxH', '', 'postingidproperty@gmail.com', 'Posting ID Group - Reset Password', 'Anda telah melakukan permintaan untuk me-reset password, gunakan text ini untuk password sementara : <b>YYeYx6AG2y<b> di halaman <a href=\"http://localhost/main/manage\">http://localhost/main/manage</a>', 'N', 'A', 0, '28-06-2018 08:40 PM', '28-06-2018 08:40 PM'),
(2, 'MgBz1Cz2pR', '', 'postingidproperty@gmail.com', 'Posting ID Group - Reset Password', 'Anda telah melakukan permintaan untuk me-reset password, gunakan text ini untuk password sementara : <b>aoik4gkrXg<b> di halaman <a href=\"http://localhost/main/manage\">http://localhost/main/manage</a>', 'N', 'A', 0, '28-06-2018 08:40 PM', '28-06-2018 08:40 PM'),
(3, 'sAIBe8VWVM', '', 'toriqpriad@gmail.com', 'Posting ID Group - Reset Password', 'Anda telah melakukan permintaan untuk me-reset password, gunakan text ini untuk password sementara : <b>VqOpr7oHor<b> di halaman <a href=\"http://localhost/main/manage\">http://localhost/main/manage</a>', 'N', 'A', 0, '28-06-2018 08:42 PM', '28-06-2018 08:42 PM'),
(4, 'OhRal5Bdu9', '', 'toriqpriad@gmail.com', 'Posting ID Group - Reset Password', 'Anda telah melakukan permintaan untuk me-reset password, gunakan text ini untuk password sementara : <b>p3uJ41p6ZM<b> di halaman <a href=\"http://localhost/main/manage\">http://localhost/main/manage</a>', 'N', 'A', 0, '28-06-2018 08:44 PM', '28-06-2018 08:44 PM'),
(5, '8jcRfwjgF4', '', 'toriqpriad@gmail.com', 'Posting ID Group - Reset Password', 'Anda telah melakukan permintaan untuk me-reset password, gunakan text ini untuk password sementara : <b>vMb6Rv819p</b> di halaman <a href=\"http://localhost/main/manage\">http://localhost/main/manage</a>', 'N', 'A', 0, '28-06-2018 08:44 PM', '28-06-2018 08:44 PM'),
(6, '0Jfrp3Y9le', '', 'toriqpriad@gmail.com', 'Posting ID Group - Reset Password', 'Anda telah melakukan permintaan untuk me-reset password, gunakan text di bawah ini sebagai password sementara untuk login di halaman di halaman <a href=\"http://localhost/main/manage\">http://localhost/main/manage</a> : <br> Password Sementara Anda : <b>5Wft86oiTH</b>', 'N', 'A', 0, '28-06-2018 08:47 PM', '28-06-2018 08:47 PM');

-- --------------------------------------------------------

--
-- Struktur dari tabel `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `slug` text NOT NULL,
  `default_slug` text NOT NULL,
  `description` text NOT NULL,
  `youtube_id` varchar(200) NOT NULL,
  `thumbnail` varchar(200) NOT NULL,
  `created_at` varchar(40) NOT NULL,
  `update_at` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `news`
--

INSERT INTO `news` (`id`, `category_id`, `title`, `slug`, `default_slug`, `description`, `youtube_id`, `thumbnail`, `created_at`, `update_at`) VALUES
(10, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(11, 11, 'Franchising', 'franchising.html', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(12, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(13, 11, 'Franchising', 'franchising.html', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(14, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(15, 11, 'Franchising', 'franchising.html', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(16, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(17, 11, 'Franchising', 'franchising.html', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(18, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(19, 11, 'Franchising', 'franchising.html', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(20, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(21, 11, 'Franchising', 'franchising.html\r\n', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(22, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(23, 11, 'Franchising', 'franchising.html', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(24, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(25, 11, 'Franchising', 'franchising.html', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(26, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(27, 11, 'Franchising', 'franchising.html', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(28, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(29, 11, 'Franchising', 'franchising.html', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(30, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(31, 11, 'Franchising', 'franchising.html', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(32, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(33, 11, 'Franchising', 'franchising.html', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(35, 11, 'Franchising', 'franchising.html', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(36, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(37, 11, 'Franchising', 'franchising.html\r\n', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(38, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(39, 11, 'Franchising', 'franchising.html', '', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. FMenurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '21-06-2018 02:21 PM'),
(40, 13, 'Perkenalkan Posting ID Group', 'perkenalkan-posting-id-group.html', '', '<p>Positive Thinking Indonesia ( PostingID ) Institute - merupakan Group Bisnis yang didirikan oleh Sam Iponk Diponegoro dan Kang Apik, sesuai namanya kami bergerak dan berfokus untuk menyebarkan energi positif di Indonesia melalui spirit Entrepreneur di segenap lapisan masyarakat, baik tua dan muda.</p>\r\n', '', '', '21-06-2018 02:19 PM', '21-06-2018 02:19 PM'),
(41, 11, 'Franchiseholic Indonesia JOS', 'franchiseholic-indonesia-jos.html', 'franchiseholic-indonesia-jos', '<p>Waralaba secara umum didefinisikan sebagai hak-hak untuk menjual suatu produk atau jasa maupun layanan. Menurut&nbsp;<strong>Hukum Pemerintah Indonesia</strong>: waralaba adalah perikatan yang salah satu pihaknya diberikan hak memanfaatkan dan atau menggunakan hak dari kekayaan intelektual (HAKI) atau pertemuan dari ciri khas usaha yang dimiliki pihak lain dengan suatu imbalan berdasarkan persyaratan yang ditetapkan oleh pihak lain tersebut dalam rangka penyediaan dan atau penjualan barang dan jasa.</p>\r\n', '', '', '21-06-2018 02:21 PM', '28-06-2018 03:32 PM');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` int(11) NOT NULL,
  `description` text NOT NULL,
  `link` text NOT NULL,
  `created_at` varchar(40) NOT NULL,
  `update_at` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `moto` varchar(200) DEFAULT NULL,
  `description` text,
  `address` text NOT NULL,
  `contact` varchar(40) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `video_id_channel` text NOT NULL,
  `video_api_key` text NOT NULL,
  `logo` text,
  `map_embed` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `last_login` varchar(50) NOT NULL,
  `update_at` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `setting`
--

INSERT INTO `setting` (`id`, `name`, `moto`, `description`, `address`, `contact`, `whatsapp`, `video_id_channel`, `video_api_key`, `logo`, `map_embed`, `email`, `password`, `last_login`, `update_at`) VALUES
(0, '', '', '', '', '081717762297', '1717762297', 'UCeT8GWHN7Cjft7FhMSgOrww', 'AIzaSyAqyAq6pS0O0O9f_7zlpRbwt7_1avUVyxw', 'Zfy9BG.png', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d987.9279611631393!2d112.65309379430728!3d-7.925136095845285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd629859f811c83%3A0xdd1b38db6f18b5e1!2sGrosir+Parfum+Malang!5e0!3m2!1sid!2sid!4v1524050420983\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 'admin@gmail.com', '0ad63e93bd793966990899f058b12da84af35e4912ceded279186a84d92f8ad4', '', '28-06-2018 07:57 PM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_log`
--
ALTER TABLE `access_log`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city_news`
--
ALTER TABLE `city_news`
ADD PRIMARY KEY (`id`),
ADD KEY `city_id` (`city_name`),
ADD KEY `property_id` (`news_id`);

--
-- Indexes for table `images_news`
--
ALTER TABLE `images_news`
ADD PRIMARY KEY (`id`),
ADD KEY `property_id` (`news_id`);

--
-- Indexes for table `mail_log`
--
ALTER TABLE `mail_log`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
ADD PRIMARY KEY (`id`),
ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_log`
--
ALTER TABLE `access_log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `city_news`
--
ALTER TABLE `city_news`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images_news`
--
ALTER TABLE `images_news`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `mail_log`
--
ALTER TABLE `mail_log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `city_news`
--
ALTER TABLE `city_news`
ADD CONSTRAINT `city_news_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `images_news`
--
ALTER TABLE `images_news`
ADD CONSTRAINT `images_news_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `news`
--
ALTER TABLE `news`
ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
