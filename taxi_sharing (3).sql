-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 03, 2022 at 06:02 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

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
-- Table structure for table `tb_admin`
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
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `username`, `password`, `nama_lengkap`, `email`, `no_hp`, `foto`, `status`, `create_datetime`, `update_datetime`, `last_login`) VALUES
(1, 'admin', '$2y$10$CkgK/RMBttAkELktMHLI1.uCU307Y/tIqUYCMF1i2MM9wSXzmXBB2', 'Administrator Greg', 'admin@taxysharing.com', '085750597580', '1643619547_9c61f58d81c7ead0be93.png', '1', '2021-07-31 11:03:14', '2021-07-31 11:03:14', '2021-07-31 11:03:14');

-- --------------------------------------------------------

--
-- Table structure for table `tb_bandara`
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
-- Dumping data for table `tb_bandara`
--

INSERT INTO `tb_bandara` (`id_bandara`, `nama_bandara`, `alamat`, `latitude`, `longitude`, `status`, `create_datetime`, `update_datetime`) VALUES
(1, 'Bandar Udara Internasional Supadio Pontianak', 'Jalan Arteri Supadio Km. 17, Limbung, Raya R iver, Limbung, Kec. Sungai Raya, Kabupaten Kubu Raya, Kalimantan Barat 78381', '-0.1467269', '109.4043702', '1', '2022-01-28 14:44:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
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
-- Dumping data for table `tb_customer`
--

INSERT INTO `tb_customer` (`id_customer`, `google_id`, `username`, `password`, `nama_lengkap`, `email`, `no_hp`, `foto`, `latitude`, `longitude`, `status`, `token_reset_password`, `last_login`, `create_datetime`, `update_datetime`) VALUES
(1, NULL, 'wiwin', '$2y$10$QpilafkKMnUDSyw3qaQNqOw8uylb2grqaQg5xAq19cEmTScgSvcbi', 'Wiwin Galuh Pr.', 'wiwin@gmail.com', '0892839283928392', '', '-0.037430580160998005', '109.33141425589628', '1', NULL, NULL, '2021-09-29 06:50:04', '2022-02-02 21:50:25'),
(2, NULL, 'rendi', '$2y$10$9FmVLGI912CcGWzbxwDblehypnI9QJbp7bBhLXFHSUmczv2olBF1y', 'Rendy', 'rendi@gmail.com', '0892392839289', '', '-0.044031', '109.3426422', '1', NULL, NULL, '2022-02-01 08:22:27', NULL),
(6, '100188469418052439975', 'ronaldopeipiro11@gmail.com', NULL, 'Ronaldo Pei Piro', 'ronaldopeipiro11@gmail.com', '085161671197', '1643720000_1d2d83c5dd49c6fa9547.png', '-0.0415705', '109.3426422', '1', NULL, '2022-02-01 19:45:36', '2022-02-01 19:45:37', '2022-02-02 21:09:22'),
(7, '109122807979405606847', 'ronaldopeipiro@student.untan.ac.id', NULL, 'Ronaldo Pei Piro', 'ronaldopeipiro@student.untan.ac.id', NULL, 'https://lh3.googleusercontent.com/a-/AOh14GhdVJ1fa6Qz8OfTVe5QXdxRyi2SHQeOOuj_WlghVg=s96-c', '-0.037429160608841064', '109.33141741302963', '1', NULL, '2022-02-02 13:09:46', '2022-02-02 13:09:52', '2022-02-02 21:40:19'),
(8, '112683968497211221968', 'ffdf487@gmail.com', NULL, 'Ronaldo Pei Piro', 'ffdf487@gmail.com', NULL, 'https://lh3.googleusercontent.com/a-/AOh14GjxSwcEbjzejgNVIIJoTNQhPH-d_U5Y0WaWtIOvEA=s96-c', '-0.0415705', '109.3426422', '1', NULL, '2022-02-02 20:35:26', '2022-02-02 20:35:29', '2022-02-02 20:35:33');

-- --------------------------------------------------------

--
-- Table structure for table `tb_driver`
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
  `last_login` datetime DEFAULT NULL,
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_driver`
--

INSERT INTO `tb_driver` (`id_driver`, `no_anggota`, `nopol`, `username`, `password`, `nama_lengkap`, `email`, `no_hp`, `foto`, `status_akun`, `aktif`, `latitude`, `longitude`, `token_reset_password`, `last_login`, `create_datetime`, `update_datetime`) VALUES
(1, '928392839283298', 'KB 1111 YY', 'ronal', '$2y$10$p2qOyqtWBsZ5jHNXoSu1k.CZ2ENYwUvTeSFxQOdz1pWVsmRMljza2', 'Ronaldo Pei Piro', 'ronaldopeipiro11@gmail.com', '085750597580', NULL, '0', 'Y', '-0.0373747', '109.3315803', NULL, NULL, '2021-09-29 03:46:07', NULL),
(2, '028928392839', 'KB 1223 BB', 'gedc', '$2y$10$v7IF/fKQQx6SQ.cXSHhSUe9BdJZTRtgGLeoFwMUAx8ndFPnod6CvW', 'Gregorius Edward', 'gedc@gmail.com', '089999992810', NULL, '0', 'Y', '-0.0373749', '109.3315406', NULL, NULL, '2021-09-29 04:09:26', NULL),
(3, '101020203030', 'KB 3767 BV', 'azy', '$2y$10$G7XLUucduECe68/PlIscTeuibm3IhkydjKwJSbd4.b.WdtLfU83YS', 'Ari Risky', 'azy@gmail.com', '085959595959', NULL, '0', 'Y', '-0.0616549', '109.3426422', NULL, NULL, '2022-01-24 11:05:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_order`
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
-- Dumping data for table `tb_order`
--

INSERT INTO `tb_order` (`id_order`, `kode_order`, `id_pengantaran`, `id_customer`, `latitude`, `longitude`, `jarak_customer_to_bandara`, `tarif_perkm`, `biaya`, `status`, `create_datetime`, `update_datetime`) VALUES
(13, 'yEJDg2uCut', 2, 6, '-0.0415705', '109.3426422', '15.9', '4200', '66780', '0', '2022-02-02 21:05:05', NULL),
(14, 'zAPUMOL6Y3', 1, 1, '-0.03742456455100065', '109.33140801087339', '16.2', '4200', '68040', '0', '2022-02-02 21:50:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengantaran`
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
-- Dumping data for table `tb_pengantaran`
--

INSERT INTO `tb_pengantaran` (`id_pengantaran`, `id_bandara`, `id_driver`, `latitude`, `longitude`, `radius_jemput`, `status_pengantaran`, `create_datetime`, `update_datetime`) VALUES
(1, 1, 1, '-0.0402352', '109.3283336', 300, '0', '2022-01-15 00:57:35', '2022-01-30 15:15:07'),
(2, 1, 2, '-0.0489424', '109.3577023', 200, '0', '2022-01-24 17:50:23', '2022-01-30 15:15:10'),
(5, 1, 3, '-0.0276842', '109.3299919', 8000, '0', '2022-01-31 00:40:31', '2022-01-31 00:42:32');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tarif`
--

CREATE TABLE `tb_tarif` (
  `id_tarif` int(11) NOT NULL,
  `tarif_perkm` varchar(20) NOT NULL,
  `id_admin` int(10) NOT NULL,
  `update_datetime` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_tarif`
--

INSERT INTO `tb_tarif` (`id_tarif`, `tarif_perkm`, `id_admin`, `update_datetime`) VALUES
(1, '4200', 1, '2022-02-01 14:48:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tb_bandara`
--
ALTER TABLE `tb_bandara`
  ADD PRIMARY KEY (`id_bandara`);

--
-- Indexes for table `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`id_customer`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- Indexes for table `tb_driver`
--
ALTER TABLE `tb_driver`
  ADD PRIMARY KEY (`id_driver`),
  ADD UNIQUE KEY `nopol` (`nopol`),
  ADD UNIQUE KEY `no_anggota` (`no_anggota`);

--
-- Indexes for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD PRIMARY KEY (`id_order`);

--
-- Indexes for table `tb_pengantaran`
--
ALTER TABLE `tb_pengantaran`
  ADD PRIMARY KEY (`id_pengantaran`);

--
-- Indexes for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  ADD PRIMARY KEY (`id_tarif`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_bandara`
--
ALTER TABLE `tb_bandara`
  MODIFY `id_bandara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_customer`
--
ALTER TABLE `tb_customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_driver`
--
ALTER TABLE `tb_driver`
  MODIFY `id_driver` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `id_order` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_pengantaran`
--
ALTER TABLE `tb_pengantaran`
  MODIFY `id_pengantaran` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  MODIFY `id_tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
