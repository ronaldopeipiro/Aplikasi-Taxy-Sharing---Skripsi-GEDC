-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 13, 2022 at 02:12 PM
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
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `username`, `password`, `nama_lengkap`, `email`, `no_hp`, `foto`, `create_datetime`, `update_datetime`, `last_login`) VALUES
(1, 'admin', '$2y$10$rsfdXbm9dLAIu4uI27w77OYRLma.zD/idK/AVsdlhj5iQS2Wx9Lz.', 'Administrator ', 'admin@taxy_sharing.com', '085750597580', NULL, '2021-07-31 11:03:14', '2021-07-31 11:03:14', '2021-07-31 11:03:14');

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
  `jenis_kelamin` enum('Pria','Wanita') DEFAULT NULL,
  `email` text NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto` text NOT NULL,
  `latitude` text,
  `longitude` text,
  `status` enum('0','1') NOT NULL,
  `token_reset_password` text,
  `last_login` datetime DEFAULT NULL,
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_customer`
--

INSERT INTO `tb_customer` (`id_customer`, `google_id`, `username`, `password`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `foto`, `latitude`, `longitude`, `status`, `token_reset_password`, `last_login`, `create_datetime`, `update_datetime`) VALUES
(1, NULL, 'wiwin', '$2y$10$QpilafkKMnUDSyw3qaQNqOw8uylb2grqaQg5xAq19cEmTScgSvcbi', 'Wiwin Galuh Pr.', NULL, 'wiwin@gmail.com', '0892839283928392', '', NULL, NULL, '1', NULL, NULL, '2021-09-29 06:50:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_driver`
--

CREATE TABLE `tb_driver` (
  `id_driver` int(10) NOT NULL,
  `no_anggota` varchar(20) NOT NULL,
  `nopol` varchar(10) NOT NULL,
  `google_id` varchar(100) DEFAULT NULL,
  `username` text NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nama_lengkap` text NOT NULL,
  `jenis_kelamin` enum('Pria','Wanita') DEFAULT NULL,
  `email` text NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto` text,
  `status_akun` enum('0','1','2') NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
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

INSERT INTO `tb_driver` (`id_driver`, `no_anggota`, `nopol`, `google_id`, `username`, `password`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `foto`, `status_akun`, `aktif`, `latitude`, `longitude`, `token_reset_password`, `last_login`, `create_datetime`, `update_datetime`) VALUES
(1, '928392839283298', 'KB 1111 YY', NULL, 'ronal', '$2y$10$p2qOyqtWBsZ5jHNXoSu1k.CZ2ENYwUvTeSFxQOdz1pWVsmRMljza2', 'Ronaldo Pei Piro', NULL, 'ronaldopeipiro11@gmail.com', '085750597580', NULL, '0', 'N', NULL, NULL, NULL, NULL, '2021-09-29 03:46:07', NULL),
(2, '028928392839', 'KB 1223 BB', NULL, 'gedc', '$2y$10$v7IF/fKQQx6SQ.cXSHhSUe9BdJZTRtgGLeoFwMUAx8ndFPnod6CvW', 'Gregorius Edward', NULL, 'gedc@gmail.com', '089999992810', NULL, '0', 'N', NULL, NULL, NULL, NULL, '2021-09-29 04:09:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_order`
--

CREATE TABLE `tb_order` (
  `id_order` int(10) NOT NULL,
  `id_pengantaran` int(10) NOT NULL,
  `id_pengguna` int(10) NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `jarak_jemput` varchar(10) NOT NULL,
  `jarak_bandara` varchar(10) NOT NULL,
  `tarif_perkm` varchar(20) NOT NULL,
  `biaya` varchar(20) NOT NULL,
  `status` enum('0','1','2','3') NOT NULL,
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengantaran`
--

CREATE TABLE `tb_pengantaran` (
  `id_pengantaran` int(10) NOT NULL,
  `id_driver` int(10) NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `radius_jemput` int(11) NOT NULL,
  `status_pengantaran` enum('0','1') NOT NULL,
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tarif`
--

CREATE TABLE `tb_tarif` (
  `id_tarif` int(11) NOT NULL,
  `tarif_perkm` varchar(20) NOT NULL,
  `id_admin` int(10) NOT NULL,
  `update_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_tarif`
--

INSERT INTO `tb_tarif` (`id_tarif`, `tarif_perkm`, `id_admin`, `update_datetime`) VALUES
(1, '4000', 1, '2021-07-31 10:59:44');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tujuan`
--

CREATE TABLE `tb_tujuan` (
  `id_tujuan` int(11) NOT NULL,
  `nama_bandara` text NOT NULL,
  `alamat` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_tujuan`
--

INSERT INTO `tb_tujuan` (`id_tujuan`, `nama_bandara`, `alamat`, `latitude`, `longitude`, `status`) VALUES
(1, 'Bandar Udara Internasional Supadio Pontianak', 'Jalan Arteri Supadio Km. 17, Limbung, Raya R iver, Limbung, Kec. Sungai Raya, Kabupaten Kubu Raya, Kalimantan Barat 78381', '-0.1467269', '109.4043702', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

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
  ADD UNIQUE KEY `no_anggota` (`no_anggota`),
  ADD UNIQUE KEY `google_id` (`google_id`);

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
-- Indexes for table `tb_tujuan`
--
ALTER TABLE `tb_tujuan`
  ADD PRIMARY KEY (`id_tujuan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_customer`
--
ALTER TABLE `tb_customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_driver`
--
ALTER TABLE `tb_driver`
  MODIFY `id_driver` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `id_order` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_pengantaran`
--
ALTER TABLE `tb_pengantaran`
  MODIFY `id_pengantaran` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  MODIFY `id_tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_tujuan`
--
ALTER TABLE `tb_tujuan`
  MODIFY `id_tujuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
