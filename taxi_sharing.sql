-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 02 Jun 2022 pada 04.49
-- Versi server: 5.7.33
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taxi_sharing`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `nama_lengkap` text NOT NULL,
  `email` text NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto` text,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `username`, `password`, `nama_lengkap`, `email`, `no_hp`, `foto`, `status`, `create_datetime`, `update_datetime`, `last_login`) VALUES
(1, 'admin', '$2y$10$CkgK/RMBttAkELktMHLI1.uCU307Y/tIqUYCMF1i2MM9wSXzmXBB2', 'Administrator Greg', 'admin@taxysharing.com', '085750597580', '1643619547_9c61f58d81c7ead0be93.png', '1', '2021-07-31 11:03:14', '2021-07-31 11:03:14', '2021-07-31 11:03:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bandara`
--

CREATE TABLE `tb_bandara` (
  `id_bandara` int(11) NOT NULL,
  `nama_bandara` text NOT NULL,
  `alamat` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `status` enum('0','1') NOT NULL,
  `create_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_datetime` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `tb_bandara`
--

INSERT INTO `tb_bandara` (`id_bandara`, `nama_bandara`, `alamat`, `latitude`, `longitude`, `status`, `create_datetime`, `update_datetime`) VALUES
(1, 'Bandar Udara Internasional Supadio Pontianak', 'Jalan Arteri Supadio Km. 17, Limbung, Sungai Raya, Limbung, Kec. Sungai Raya, Kabupaten Kubu Raya, Kalimantan Barat 78381', '-0.1467269', '109.4043702', '1', '2022-01-28 14:44:00', '2022-02-07 01:30:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_customer`
--

CREATE TABLE `tb_customer` (
  `id_customer` int(11) NOT NULL,
  `google_id` varchar(100) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nama_lengkap` text NOT NULL,
  `email` text NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto` text NOT NULL,
  `latitude` text,
  `longitude` text,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `token_reset_password` text,
  `last_login` datetime DEFAULT NULL,
  `create_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_datetime` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_customer`
--

INSERT INTO `tb_customer` (`id_customer`, `google_id`, `username`, `password`, `nama_lengkap`, `email`, `no_hp`, `foto`, `latitude`, `longitude`, `status`, `token_reset_password`, `last_login`, `create_datetime`, `update_datetime`) VALUES
(1, NULL, 'ronal', '$2y$10$EOegcohaJxATN4XxFC8Vk.fJ2Tb.jPjWxTIGL379CCJieDoVuNXcW', 'Ronaldo Pei Piro', 'ronaldopeipiro11@gmail.com', '085750597580', '1643988369_18b6497c0dc5a43f20c1.png', '-0.0373644', '109.3315771', '1', '', NULL, '2021-09-29 06:50:04', '2022-02-09 02:12:24'),
(2, NULL, 'rendi', '$2y$10$9FmVLGI912CcGWzbxwDblehypnI9QJbp7bBhLXFHSUmczv2olBF1y', 'Rendy', 'rendi@gmail.com', '0892392839289', '1643969672_3bfbe9adabc2454b9a47.png', '-0.044031', '109.3426422', '1', NULL, NULL, '2022-02-01 08:22:27', '2022-02-04 17:14:32'),
(6, '100188469418052439975', 'ronaldopeipiro11@gmail.com', NULL, 'Ronaldo Pei Piro', 'ronaldopeipiro11@gmail.com', '085161671197', '1643720000_1d2d83c5dd49c6fa9547.png', '-0.0373515', '109.3315721', '1', NULL, '2022-02-01 19:45:36', '2022-02-01 19:45:37', '2022-03-06 00:30:24'),
(7, '109122807979405606847', 'ronaldopeipiro@student.untan.ac.id', NULL, 'Ronaldo Pei Piro', 'ronaldopeipiro@student.untan.ac.id', NULL, 'https://lh3.googleusercontent.com/a-/AOh14GhdVJ1fa6Qz8OfTVe5QXdxRyi2SHQeOOuj_WlghVg=s96-c', '-0.037429160608841064', '109.33141741302963', '1', NULL, '2022-02-02 13:09:46', '2022-02-02 13:09:52', '2022-02-08 16:46:25'),
(8, '112683968497211221968', 'ffdf487@gmail.com', NULL, 'Ronaldo Pei Piro', 'ffdf487@gmail.com', NULL, 'https://lh3.googleusercontent.com/a-/AOh14GjxSwcEbjzejgNVIIJoTNQhPH-d_U5Y0WaWtIOvEA=s96-c', '-0.0415705', '109.3426422', '1', NULL, '2022-02-02 20:35:26', '2022-02-02 20:35:29', '2022-02-08 16:46:00'),
(9, '114506006396026335310', 'ronaldopeipiro@gmail.com', NULL, 'Ronaldo Pei Piro', 'ronaldopeipiro@gmail.com', NULL, 'https://lh3.googleusercontent.com/a-/AOh14Gi5Lezcj4QYzdFfPlls23a3xG-LYwLcn2EzSo88ig=s96-c', '-0.0263303', '109.3425039', '1', NULL, '2022-03-01 21:00:33', '2022-03-01 21:00:37', '2022-03-11 01:37:13'),
(10, '107499557051092078219', 'airporttaxisharing@gmail.com', NULL, 'Airport Taxi Sharing', 'airporttaxisharing@gmail.com', NULL, 'https://lh3.googleusercontent.com/a-/AOh14Gj0oa2i3NopLCcYDSQ1Av68XYloVQNKaXq3zE0I=s96-c', '-0.0425984', '109.3337088', '1', NULL, '2022-04-04 14:56:01', '2022-04-04 14:56:03', '2022-04-11 15:45:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_driver`
--

CREATE TABLE `tb_driver` (
  `id_driver` int(10) NOT NULL,
  `no_anggota` varchar(20) NOT NULL,
  `nopol` varchar(10) NOT NULL,
  `username` text NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nama_lengkap` text NOT NULL,
  `email` text NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto` text,
  `status_akun` enum('0','1','2') NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  `latitude` text,
  `longitude` text,
  `token_reset_password` text,
  `endpoint` text,
  `last_login` datetime DEFAULT NULL,
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_driver`
--

INSERT INTO `tb_driver` (`id_driver`, `no_anggota`, `nopol`, `username`, `password`, `nama_lengkap`, `email`, `no_hp`, `foto`, `status_akun`, `aktif`, `latitude`, `longitude`, `token_reset_password`, `endpoint`, `last_login`, `create_datetime`, `update_datetime`) VALUES
(1, '2020202020202', 'KB 1111 YY', 'ronal', '$2y$10$qe/TF29XGjbUML2CuVQEluqtF2CMX6/W1KFX4frIf8WonUnmMXNHu', 'Ronaldo Pei Piro', 'ronaldopeipiro11@gmail.com', '085750597580', '1643984300_85a3cf606080ebefba27.jpg', '1', 'Y', '-0.0373783', '109.3315642', 'ujw3TG6rv1ttB3r2kuIccwgKK4bCewpDwlIlPdjTRfC2aPwT1y6H8emCc9a8aGzyTZ2fDwzokKPFqbFk35cskAmd0vq1VZQ49', NULL, NULL, '2021-09-29 03:46:07', NULL),
(2, '028928392839', 'KB 1223 BB', 'gedc', '$2y$10$jXJubOso1JowAQ/GLCduy.Em8mpJGtZ/lVj8jjUONCAP3X5qw5Sku', 'Gregorius Edward Dicky Chandra', 'edwargre@gmail.com', '089999992810', '1643970058_890504a7767a3027a9b3.png', '1', 'Y', '-0.0088101', '109.3188503', NULL, NULL, NULL, '2021-09-29 04:09:26', NULL),
(3, '101020203030', 'KB 3767 BV', 'azy', '$2y$10$G7XLUucduECe68/PlIscTeuibm3IhkydjKwJSbd4.b.WdtLfU83YS', 'Ari Risky', 'azy@gmail.com', '085959595959', NULL, '1', 'Y', '-0.0373792', '109.3315505', NULL, NULL, NULL, '2022-01-24 11:05:46', NULL),
(4, '928392839823989', 'KB 1020 LL', 'rendi', '$2y$10$Ix9LgxJDcuwkX6nSFWBHauCTWJzmFQ298W0WkRAd3xj052yVIxwOa', 'Rendi Biwantoro', 'ffdf487@gmail.com', '085750597580', NULL, '1', 'N', NULL, NULL, NULL, NULL, NULL, '2022-02-04 18:14:05', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_order`
--

CREATE TABLE `tb_order` (
  `id_order` int(10) NOT NULL,
  `kode_order` varchar(10) NOT NULL,
  `id_pengantaran` int(10) NOT NULL,
  `id_customer` int(10) NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `jarak_customer_to_bandara` varchar(10) NOT NULL,
  `tarif_perkm` varchar(20) NOT NULL,
  `biaya` varchar(20) NOT NULL,
  `status` enum('0','1','2','3','4','5','6') NOT NULL DEFAULT '0' COMMENT '0 = proses, \r\n1 = order diterima driver,\r\n2 = jemput penumpang, \r\n3 = menuju bandara, \r\n4 = selesai,\r\n5 = order dibatalkan oleh customer,\r\n6 = order dibatalkan oleh driver',
  `create_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_datetime` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_order`
--

INSERT INTO `tb_order` (`id_order`, `kode_order`, `id_pengantaran`, `id_customer`, `latitude`, `longitude`, `jarak_customer_to_bandara`, `tarif_perkm`, `biaya`, `status`, `create_datetime`, `update_datetime`) VALUES
(13, 'yEJDg2uCut', 2, 6, '-0.0415705', '109.3426422', '15.9', '4200', '66780', '4', '2022-02-02 21:05:05', '2022-02-04 16:37:25'),
(14, 'zAPUMOL6Y3', 1, 1, '-0.03742456455100065', '109.33140801087339', '16.2', '4200', '68040', '4', '2022-02-02 21:50:22', '2022-02-04 21:17:14'),
(15, 'LEXDXENre9', 5, 6, '-0.0373823', '109.3315387', '16.2', '4200', '68040', '5', '2022-02-04 19:14:14', '2022-02-04 21:33:28'),
(16, 'cfGKLl2PYB', 8, 1, '-0.044031', '109.3426422', '15.0', '4200', '63000', '6', '2022-02-04 21:23:53', '2022-02-04 21:34:49'),
(17, 'kwioAk4JQ0', 8, 6, '-0.044031', '109.3426422', '15.0', '4200', '63000', '4', '2022-02-04 21:33:50', '2022-02-19 16:20:58'),
(18, '3kE2IlVGxU', 9, 6, '-0.044031', '109.3426422', '15.0', '4200', '63000', '5', '2022-02-07 02:29:07', '2022-02-07 02:29:59'),
(19, 'oSiaIht5Bz', 9, 1, '-0.044031', '109.3426422', '15.0', '4200', '63000', '4', '2022-02-08 15:35:56', '2022-02-09 01:47:06'),
(20, 'SFuvx55vYe', 11, 1, '-0.0373644', '109.3315771', '16.2', '4200', '68040', '4', '2022-02-09 02:12:41', '2022-02-09 02:13:28'),
(21, 'AjJiTymJNZ', 5, 9, '-0.03624', '109.3456255', '15.9', '4200', '66780', '5', '2022-03-02 01:32:17', '2022-03-03 23:26:07'),
(22, 'Mr8kc0lqVJ', 5, 10, '-0.0373469', '109.3316213', '16.2', '4200', '68040', '0', '2022-04-11 15:45:02', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengantaran`
--

CREATE TABLE `tb_pengantaran` (
  `id_pengantaran` int(10) NOT NULL,
  `id_bandara` int(11) NOT NULL,
  `id_driver` int(10) NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `radius_jemput` int(11) NOT NULL,
  `status_pengantaran` enum('0','1','2') NOT NULL COMMENT '0 = Proses, 1 = Selesai, 2 = Tidak selesai',
  `create_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_datetime` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pengantaran`
--

INSERT INTO `tb_pengantaran` (`id_pengantaran`, `id_bandara`, `id_driver`, `latitude`, `longitude`, `radius_jemput`, `status_pengantaran`, `create_datetime`, `update_datetime`) VALUES
(1, 1, 1, '-0.0402352', '109.3283336', 300, '1', '2022-01-15 00:57:35', '2022-02-03 20:40:39'),
(2, 1, 2, '-0.0489424', '109.3577023', 200, '1', '2022-01-24 17:50:23', '2022-02-04 16:36:46'),
(5, 1, 3, '-0.0276842', '109.3299919', 8000, '0', '2022-01-31 00:40:31', '2022-01-31 00:42:32'),
(7, 1, 1, '0.0019054', '109.2859659', 270, '2', '2022-02-03 21:24:07', '2022-02-03 22:42:49'),
(8, 1, 1, '-0.046018533905111424', '109.35392127168886', 290, '1', '2022-02-03 22:55:58', '2022-02-04 21:41:27'),
(9, 1, 2, '-0.0495795', '109.3574226', 1010, '1', '2022-02-04 17:22:49', '2022-02-09 01:35:22'),
(10, 1, 1, '-0.06712376801635674', '109.34477440909272', 4260, '1', '2022-02-08 01:13:48', '2022-02-19 21:41:34'),
(11, 1, 2, '-0.042980277343477334', '109.34787934180298', 1880, '1', '2022-02-09 02:12:05', '2022-02-09 02:13:09'),
(12, 1, 2, '0.9060204000000001', '108.9872049', 380, '0', '2022-03-08 23:13:45', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_push_notif`
--

CREATE TABLE `tb_push_notif` (
  `id_push_notif` bigint(10) NOT NULL,
  `id_user` bigint(10) NOT NULL,
  `tipe_user` enum('customer','driver') NOT NULL,
  `endpoint` text NOT NULL,
  `p256dh` text NOT NULL,
  `auth` text NOT NULL,
  `create_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_push_notif`
--

INSERT INTO `tb_push_notif` (`id_push_notif`, `id_user`, `tipe_user`, `endpoint`, `p256dh`, `auth`, `create_datetime`) VALUES
(1, 10, 'customer', 'https://fcm.googleapis.com/fcm/send/eRRnGY0ndgs:APA91bH5V2kLrDhGfWZxdQhb8FhK95APSx_rbh7gziSt5XwZysTfcmHnyL6v-xua0q1P37zW4Q7sas73hPFBFWsKEylbPgAgzQdoiaThB74X8g31xYsL9j68ZoVDiXSUd8Yp31Ldzm0p', 'BN53+i1qhDXCE1NlPz9k4RIkbzXOi/Jv3cP3m/hcO/Cm+XBo23hhHxT3/BPUvqthiYe5VP//NF5FR0jM/Ja36Wc=', 'Js8T0y/is8jr9plMXQ4Lpw==', '2022-05-10 11:39:41'),
(2, 2, 'driver', 'https://fcm.googleapis.com/fcm/send/dyF8yTVWGv4:APA91bENh23C3Y71mQZ56NVZYckyy1wrEtRhL6RgoUV8V_zEVtPxycQNR_SP2cPivUz-pQpHroM6pV777TvADkInEtIVITaJmST1WAXXG51JHWY4XAX-hQzOOhawFU1V26pUMeRurxsp', 'BCJgzl91aoXD2yFMhg40ntlPS/son2nm7LbQ9/ii5O28EJ74P+Je8nj9b7avX5lfQHGOamWW6kp74bSiYb1jJaw=', 'JyFyVUvKdYK0CpLARtLRmg==', '2022-06-02 10:36:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tarif`
--

CREATE TABLE `tb_tarif` (
  `id_tarif` int(11) NOT NULL,
  `tarif_perkm` varchar(20) NOT NULL,
  `id_admin` int(10) NOT NULL,
  `update_datetime` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_tarif`
--

INSERT INTO `tb_tarif` (`id_tarif`, `tarif_perkm`, `id_admin`, `update_datetime`) VALUES
(1, '4200', 1, '2022-02-01 14:48:38');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `tb_bandara`
--
ALTER TABLE `tb_bandara`
  ADD PRIMARY KEY (`id_bandara`);

--
-- Indeks untuk tabel `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`id_customer`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- Indeks untuk tabel `tb_driver`
--
ALTER TABLE `tb_driver`
  ADD PRIMARY KEY (`id_driver`),
  ADD UNIQUE KEY `nopol` (`nopol`),
  ADD UNIQUE KEY `no_anggota` (`no_anggota`);

--
-- Indeks untuk tabel `tb_order`
--
ALTER TABLE `tb_order`
  ADD PRIMARY KEY (`id_order`);

--
-- Indeks untuk tabel `tb_pengantaran`
--
ALTER TABLE `tb_pengantaran`
  ADD PRIMARY KEY (`id_pengantaran`);

--
-- Indeks untuk tabel `tb_push_notif`
--
ALTER TABLE `tb_push_notif`
  ADD PRIMARY KEY (`id_push_notif`);

--
-- Indeks untuk tabel `tb_tarif`
--
ALTER TABLE `tb_tarif`
  ADD PRIMARY KEY (`id_tarif`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_bandara`
--
ALTER TABLE `tb_bandara`
  MODIFY `id_bandara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_customer`
--
ALTER TABLE `tb_customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_driver`
--
ALTER TABLE `tb_driver`
  MODIFY `id_driver` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `id_order` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `tb_pengantaran`
--
ALTER TABLE `tb_pengantaran`
  MODIFY `id_pengantaran` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tb_push_notif`
--
ALTER TABLE `tb_push_notif`
  MODIFY `id_push_notif` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_tarif`
--
ALTER TABLE `tb_tarif`
  MODIFY `id_tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
