-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 25, 2024 at 03:40 PM
-- Server version: 8.0.40
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental3`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `jenkel_admin` varchar(20) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `jenkel_admin`, `username`, `password`, `level`) VALUES
(1, 'Rizal', 'laki-laki', 'rizal', 'rizal123', 'SUPER'),
(4, 'Alya qatrun', 'Perempuan', 'alya', '123', 'ADMIN'),
(8, 'Elsa', 'Perempuan', 'elsa', '123', 'ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id_mobil` int NOT NULL,
  `no_polisi` varchar(12) NOT NULL,
  `merk` varchar(90) NOT NULL,
  `tahun` varchar(10) NOT NULL,
  `harga` double NOT NULL,
  `s_mobil` varchar(20) NOT NULL,
  `poto` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `no_polisi`, `merk`, `tahun`, `harga`, `s_mobil`, `poto`, `deskripsi`, `created_at`) VALUES
(26, 'T 3902 BL', 'Ertiga', '2018', 120000, 'AKTIF', '../uploads/gambar5.jpeg', 'Mobil Baru, Cocok untuk Liburan Keluarga', '2024-12-08 10:08:53'),
(27, 'T 2121 LOL', 'Fred', '2024', 120000, 'AKTIF', '../uploads/gambar8.jpeg', 'Mobil Keluaran terbaru Dengan transmisi semi otomatis', '2024-12-08 10:13:12'),
(32, 'T 123 BW', 'KLX', '2018', 120000, 'TIDAK AKTIF', '../uploads/gambar9.jpeg', 'mobil  dari akeluaran terbar', '2024-12-19 19:11:30'),
(37, 'B 555 TL', 'xenia', '2024', 150000, 'AKTIF', '../uploads/gambar6.jpeg', 'Mobil Avanza Dengan interior mewah, dan mulus', '2024-12-22 21:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL,
  `id_sewa` int DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `no_rek` varchar(50) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `tanggal_pembayaran` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_sewa`, `nama`, `total_harga`, `metode_pembayaran`, `no_rek`, `bukti_pembayaran`, `tanggal_pembayaran`) VALUES
(34, 118, 'Amirul', '120000.00', 'transfer', '1234', '../uploads/Screenshot_20241221-194726.jpg', '2024-12-22 00:00:00'),
(35, 120, 'Aldi', '240000.00', 'transfer', '1234', '../uploads/20119d24-2d77-45ba-93ab-86e55b16b71e.jpeg', '2024-12-24 00:00:00'),
(36, 121, 'Kurniati', '200000.00', 'cash', '778', '../uploads/Screenshot 2023-12-15 125101.png', '2024-12-22 00:00:00'),
(37, 122, 'Aisyah', '120000.00', 'transfer', '1234', '../uploads/Screenshot 2024-06-26 235238.png', '2024-12-22 00:00:00'),
(38, 123, 'Aisyah', '150000.00', 'cash', '1234', '../uploads/lp1.jpg', '2024-12-23 00:00:00'),
(39, 124, 'Aisyah', '150000.00', 'transfer', '1234', '../uploads/Screenshot 2024-04-21 201017.png', '2024-12-24 00:00:00'),
(40, 125, 'hikal', '200000.00', 'transfer', '123456', '../uploads/2.png', '2024-12-25 00:00:00'),
(41, 126, 'Amirul', '2480000.00', 'transfer', '54321', '../uploads/Screenshot 2024-06-30 165616.png', '2024-12-24 00:00:00'),
(42, 127, 'Amirul', '100000.00', 'cash', '54321', '../uploads/Screenshot 2024-04-21 102238.png', '2024-12-24 00:00:00'),
(43, 128, 'Diki', '120000.00', 'transfer', '1234321', '../uploads/Laporan.png', '2024-12-24 00:00:00'),
(44, 129, 'Arifah', '150000.00', 'transfer', '555555', '../uploads/Proses Penyewaan.png', '2024-12-24 00:00:00'),
(45, 130, 'iki', '500000.00', 'transfer', '09876', '../uploads/RS.png', '2024-12-25 00:00:00'),
(46, 132, 'ilham', '240000.00', 'transfer', '12ilham', '../uploads/WIN_20240509_06_34_49_Pro.jpg', '2024-12-11 00:00:00'),
(47, 133, 'Amirul', '100000.00', 'transfer', '54321', '../uploads/Screenshot 2024-06-12 220425.png', '2024-12-25 00:00:00'),
(48, 134, 'Amirul', '100000.00', 'transfer', '54321', '../uploads/WIN_20240531_00_34_30_Pro.jpg', '2024-12-25 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pendapatan`
--

CREATE TABLE `pendapatan` (
  `id_sewa` int NOT NULL,
  `bulan` int NOT NULL,
  `tahun` int NOT NULL,
  `jumlah` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sewa`
--

CREATE TABLE `sewa` (
  `id_sewa` int NOT NULL,
  `id_mobil` int DEFAULT NULL,
  `id_user` int NOT NULL,
  `nama_sewa` varchar(90) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ktp` varchar(25) NOT NULL,
  `jenkel_sewa` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `alamat` varchar(90) NOT NULL,
  `tlp_sewa` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tujuan` varchar(90) NOT NULL,
  `tgl_sewa` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `lama` int NOT NULL,
  `harga_total` double NOT NULL,
  `konf_pembayaran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sewa`
--

INSERT INTO `sewa` (`id_sewa`, `id_mobil`, `id_user`, `nama_sewa`, `ktp`, `jenkel_sewa`, `alamat`, `tlp_sewa`, `tujuan`, `tgl_sewa`, `tgl_kembali`, `lama`, `harga_total`, `konf_pembayaran`) VALUES
(118, 26, 6, 'Amirul', '2347788661', 'Laki-Laki', 'bumi ayu, jawa tengah ', '08534211', 'Purwakarta ', '2024-12-22', '2024-12-23', 1, 120000, 'Pembayaran diterima'),
(119, 31, 6, 'ilham', '32323232', 'Laki-Laki', 'Jl. HS.Ronggo Waluyo, Puseurjaya, Telukjambe Timur, Karawang, Jawa Barat', '08534736', 'purwakarta', '2024-12-22', '2024-12-23', 1, 150000, 'Belum Bayar'),
(120, 26, 12, 'Aldi', '321098', 'Laki-Laki', 'Telagasari', '098765432112', 'Bogor', '2024-12-23', '2024-12-25', 2, 240000, 'Pembayaran di terima'),
(121, 28, 6, 'Kurniati', '3214141414', 'Perempuan', 'Telukjambe Timur, Karawang, Jawa Barat', '08534736', 'purwakarta', '2024-12-22', '2024-12-24', 2, 200000, 'Pembayaran di terima'),
(122, 27, 6, 'rizal', '123321', 'Laki-Laki', 'tunggak jati', '85712345', 'karawang', '2024-12-22', '2024-12-23', 1, 120000, 'Pembayaran diterima'),
(123, 31, 6, 'rizal', '123321', 'Laki-Laki', 'tunggak jati', '85712345', 'telagasari', '2024-12-23', '2024-12-24', 1, 150000, 'Pembayaran diterima'),
(124, 37, 10, 'mia', '6767676', 'Perempuan', 'tunggak jati', '08987676', 'telagasari', '2024-12-24', '2024-12-25', 1, 150000, 'Sedang di proses'),
(125, 28, 6, 'hikal', '989896254658', 'Laki-Laki', 'johar', '0986545789', 'Bandung', '2024-12-24', '2024-12-26', 2, 200000, 'Pembayaran diterima'),
(126, 32, 11, 'Amirul', '12345', 'Laki-Laki', 'Bumi Ayu, Jawa Timur', '085712435541', 'Bandung', '2024-12-24', '2024-12-28', 4, 480000, 'Pembayaran diterima'),
(127, 28, 11, 'azhar', '12345', 'Laki-Laki', 'johar', '0986545789', 'Bandung', '2024-12-24', '2024-12-25', 1, 100000, 'Pembayaran diterima'),
(128, 27, 6, 'Diki', '32984948394839', 'Laki-Laki', 'kalisari', '011111111166', 'Karawang', '2024-12-24', '2024-12-25', 1, 120000, 'Pembayaran diterima'),
(129, 37, 10, 'Arifah', '321425520987', 'Perempuan', 'ronggowaluyo', '1234567890987', 'pasar', '2024-12-24', '2024-12-25', 1, 150000, 'Pembayaran diterima'),
(130, 32, 6, 'iki', '4567890', 'Laki-Laki', 'Kecamatan Wadas rt.002 rw.001 desa kali', '009988', 'batam', '2024-12-26', '2024-12-31', 5, 600000, 'Pembayaran diterima'),
(131, 26, 11, 'ilham', '3232325545414', 'Laki-Laki', 'Telukjambe Timur, Karawang, Jawa Barat', '0000000', 'purwakarta', '2024-12-25', '2024-12-26', 1, 120000, 'Belum Bayar'),
(132, 26, 11, 'ilham', '3232325545414', 'Laki-Laki', 'Telukjambe Timur, Karawang, Jawa Barat', '0000000', 'purwakarta', '2024-12-25', '2024-12-26', 1, 120000, 'Pembayaran diterima'),
(133, 28, 6, 'azhar', '12345', 'Laki-Laki', 'johar', '0986545789', 'Bandung', '2024-12-25', '2024-12-26', 1, 100000, 'Pembayaran diterima'),
(134, 26, 6, 'hikal', '123321', 'Laki-Laki', 'telagasari', '85712345', 'Bandung', '2024-12-25', '2024-12-26', 1, 120000, 'Sedang Diproses');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `nomor_hp` varchar(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_lengkap`, `nomor_hp`, `username`, `email`, `password`, `foto`, `created_at`) VALUES
(6, 'Hikal Marpratama', '008512345', 'hikal', 'hikal@gmail.com', '$2y$10$ppoSRXG/tNfmCW/bYhWTheD2q7Yq3p2Unlyzl2UUJ4TFI1srfvcDq', '674f6f5d4152d.jpg', '2024-12-03 20:51:41'),
(13, 'fahry', '0004445', 'fahry', 'fahry@gmail.com', '$2y$10$2ByxqgA.9ZDjZ4nsyaiwT.NAiwqLeOw0HGjnhcLxZQhIGrgd0Ic9m', '676c010decbd2.jpg', '2024-12-25 12:56:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id_mobil`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_mobil` (`id_sewa`);

--
-- Indexes for table `pendapatan`
--
ALTER TABLE `pendapatan`
  ADD PRIMARY KEY (`id_sewa`);

--
-- Indexes for table `sewa`
--
ALTER TABLE `sewa`
  ADD PRIMARY KEY (`id_sewa`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `nomor_hp` (`nomor_hp`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_mobil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `pendapatan`
--
ALTER TABLE `pendapatan`
  MODIFY `id_sewa` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sewa`
--
ALTER TABLE `sewa`
  MODIFY `id_sewa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
