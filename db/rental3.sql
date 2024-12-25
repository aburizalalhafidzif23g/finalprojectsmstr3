-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 17, 2024 at 04:44 PM
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
(23, 'tb 4535 l', 'bmw', '2010', 150000, 'AKTIF', '../uploads/gambar2.jpg', 'mobil keluaran eropa', '2024-12-07 14:58:05'),
(24, 'T 1111 LI', 'agya', '2011', 100000, 'AKTIF', '../uploads/gambar8.jpeg', 'mobil agya keluaran terbaru, dan fasilitasi audio yang bagus serta tampilan elelegan,\r\ncocok buat liburan pengantin baru', '2024-12-08 10:05:18'),
(25, 'T 4741 BM', 'Kijang Inova', '2017', 120000, 'AKTIF', '../uploads/gambar7.png', 'Mobil cocok untuk mudik 1 keluarga, di lengkapi pasilitas menarik, dan Atap bisa di buka', '2024-12-08 10:07:27'),
(26, 'T 3902 BL', 'Ertiga', '2018', 120000, 'AKTIF', '../uploads/gambar6.jpeg', 'Mobil Baru, Cocok untuk Liburan Keluarga', '2024-12-08 10:08:53'),
(27, 'T 2121 LOL', 'Ertiga', '2024', 120000, 'AKTIF', '../uploads/gambar4.jpeg', 'Mobil Keluaran terbaru Dengan transmisi semi otomatis', '2024-12-08 10:13:12'),
(28, 'B 33242 HU', 'CARY', '2011', 100000, 'AKTIF', '../uploads/gambar9.jpeg', 'MOBIL BARU', '2024-12-08 12:11:00'),
(29, 'T 235979 bl', 'BMW', '2012', 150000, 'AKTIF', '../uploads/gambar6.jpeg', 'mobil baru', '2024-12-16 20:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL,
  `id_mobil` int DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `status_pembayaran` varchar(50) DEFAULT NULL,
  `tanggal_pembayaran` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_mobil`, `total_harga`, `metode_pembayaran`, `status_pembayaran`, `tanggal_pembayaran`) VALUES
(1, 23, '150000.00', 'transfer', 'pending', NULL),
(2, 23, '150000.00', 'transfer', 'pending', NULL),
(3, 23, '150000.00', 'transfer', 'pending', NULL),
(4, 23, '150000.00', 'cash', 'success', NULL);

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
  `id_mobil` int NOT NULL,
  `id_user` int NOT NULL,
  `nama_sewa` varchar(90) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ktp` varchar(25) NOT NULL,
  `jenkel_sewa` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `alamat` varchar(90) NOT NULL,
  `tlp_sewa` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tujuan` varchar(90) NOT NULL,
  `tgl_sewa` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `lama` int NOT NULL,
  `harga_total` double NOT NULL,
  `kode_booking` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sewa`
--

INSERT INTO `sewa` (`id_sewa`, `id_mobil`, `id_user`, `nama_sewa`, `ktp`, `jenkel_sewa`, `alamat`, `tlp_sewa`, `tujuan`, `tgl_sewa`, `tgl_kembali`, `lama`, `harga_total`, `kode_booking`) VALUES
(21, 25, 6, 'mia', '0101010', 'Perempuan', 'legok hangser', '0851234567', 'karawang', '2024-12-10', '2024-12-11', 1, 120000, NULL),
(22, 26, 6, 'efil', '989896254658', 'Perempuan', 'johar', '986545789', 'cikampek', '2024-12-11', '2024-12-12', 1, 120000, NULL),
(23, 23, 6, 'galih', '123456789', 'Laki-Laki', 'gempol', '085433256255', 'bekasi', '2024-12-12', '2024-12-14', 2, 300000, NULL),
(24, 23, 10, 'selena', '54278698786745634', 'Perempuan', 'telagasari', '0099986369', 'Bandung', '2024-12-12', '2024-12-16', 4, 600000, NULL),
(25, 23, 10, 'leni', '86643578', 'Perempuan', 'legok hangser', '0851234567', 'bekasi', '2024-12-12', '2024-12-14', 2, 300000, NULL),
(28, 24, 10, 'Aisyah', '010102910281028', 'Perempuan', 'tunggak jati', '089098765', 'magelang', '2024-12-17', '2024-12-19', 2, 200000, NULL),
(40, 24, 10, 'hikal', '123321', 'Laki-Laki', 'gempol', '085433256255', 'bekasi', '2024-12-17', '2024-12-18', 1, 100000, NULL),
(41, 24, 10, 'hikal', '123321', 'Laki-Laki', 'gempol', '085433256255', 'bekasi', '2024-12-17', '2024-12-19', 2, 200000, NULL);

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
(10, 'aisyah', '08544444444', 'aisyah', 'aisyah@gmail.com', '$2y$10$JvGSwqKQN2TpxttWDyqPtect/xd4JgLesFSssZeNKTQEXk0hW5eAO', '6753ff5f19434.png', '2024-12-07 07:55:11');

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
  ADD KEY `id_mobil` (`id_mobil`);

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
  MODIFY `id_mobil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pendapatan`
--
ALTER TABLE `pendapatan`
  MODIFY `id_sewa` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sewa`
--
ALTER TABLE `sewa`
  MODIFY `id_sewa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_mobil`) REFERENCES `mobil` (`id_mobil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
