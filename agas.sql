-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2021 at 08:45 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agas`
--

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `kompetensi_keahlian` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `kompetensi_keahlian`) VALUES
(1, 'Sebelas', 'Rekayara Perangkat Lunak'),
(2, 'Sebelas', 'Rekayasa Perangkat Lunak'),
(3, 'Sebelas', 'Rekayasa Perangkat Lunak'),
(4, 'Sebelas', 'Rekayasa Perangkat Lunak'),
(5, 'Sebelas', 'Rekayasa Perangkat Lunak');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `nisn` int(11) NOT NULL,
  `tahun` varchar(12) CHARACTER SET latin1 NOT NULL,
  `nominal` int(12) NOT NULL,
  `jumlah_bayar` int(12) NOT NULL,
  `sisa_bayar` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`nisn`, `tahun`, `nominal`, `jumlah_bayar`, `sisa_bayar`) VALUES
(1123, '2021', 950000, 379000, 571000),
(1456, '2021', 950000, 493000, 457000),
(3209, '2021', 950000, 375000, 575000),
(3390, '2021', 950000, 570000, 380000);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `nisn` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `bulan_dibayar` varchar(8) NOT NULL,
  `tahun_dibayar` varchar(4) NOT NULL,
  `id_spp` int(11) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  `keterangan` enum('Lunas','Belum Lunas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_petugas`, `nisn`, `tgl_bayar`, `bulan_dibayar`, `tahun_dibayar`, `id_spp`, `jumlah_bayar`, `keterangan`) VALUES
(1, 8, 3390, '2021-03-09', 'Maret', '2021', 1, 570000, 'Belum Lunas'),
(2, 7, 1123, '2021-04-07', 'April', '2021', 3, 379000, 'Belum Lunas'),
(3, 5, 1456, '2021-02-26', 'Februari', '2021', 4, 493000, 'Belum Lunas'),
(4, 6, 3209, '2021-02-28', 'Februari', '2021', 2, 375000, 'Belum Lunas');

--
-- Triggers `pembayaran`
--
DELIMITER $$
CREATE TRIGGER `tambah_pembayaran` AFTER INSERT ON `pembayaran` FOR EACH ROW BEGIN
INSERT INTO laporan SET
nisn = NEW.nisn,
jumlah_bayar = NEW.jumlah_bayar
ON DUPLICATE KEY UPDATE
jumlah_bayar = jumlah_bayar+NEW.jumlah_bayar,
sisa_bayar = nominal-jumlah_bayar;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama_petugas` varchar(35) NOT NULL,
  `level` enum('admin','petugas','siswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `username`, `password`, `nama_petugas`, `level`) VALUES
(1, 'maksum', 'maksum', 'Maksum', 'admin'),
(2, 'yusanto', 'yusanto', 'Fahrur Yusanto', 'petugas'),
(3, 'afif', 'afif', 'Rokhmad Afif', 'siswa'),
(4, 'agas', 'agas', 'Agas Arapi', 'admin'),
(5, 'rihan', 'rihan', 'Rihan Shufi Aditya', 'siswa'),
(6, 'ens', 'ens', 'Enrico Kurniawan', 'siswa'),
(7, 'mungin', 'mungin', 'Miftahul Mungin', 'siswa'),
(8, 'bagas', 'bagas', 'Bagas Cahya Pamungkas', 'siswa');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nisn` int(11) NOT NULL,
  `nis` char(8) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `id_spp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES
(1123, '5796', 'Miftahul Mungin', 3, 'Wonosobo', '085', 3),
(1456, '7789', 'Rihan Shufi Aditya', 4, 'Kaliangkrik', '082', 4),
(2933, '7974', 'Agas Arapi', 5, 'Gatak', '081', 5),
(3209, '4432', 'Enrico Kurniawan', 2, 'Wonoroto', '081', 2),
(3390, '2089', 'Bagas Cahya Pamungkas', 1, 'Kaliangkrik', '082', 1);

-- --------------------------------------------------------

--
-- Table structure for table `spp`
--

CREATE TABLE `spp` (
  `id_spp` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  `nisn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spp`
--

INSERT INTO `spp` (`id_spp`, `tahun`, `nominal`, `nisn`) VALUES
(1, 2021, 950000, 3390),
(2, 2021, 950000, 3209),
(3, 2021, 950000, 1123),
(4, 2021, 950000, 1456);

--
-- Triggers `spp`
--
DELIMITER $$
CREATE TRIGGER `tambah_spp` AFTER INSERT ON `spp` FOR EACH ROW BEGIN
INSERT INTO laporan SET
nominal = NEW.nominal,
tahun = NEW.tahun,
nisn = NEW.nisn
ON DUPLICATE KEY UPDATE
nominal = nominal+NEW.nominal;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`nisn`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nisn`);

--
-- Indexes for table `spp`
--
ALTER TABLE `spp`
  ADD PRIMARY KEY (`id_spp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
