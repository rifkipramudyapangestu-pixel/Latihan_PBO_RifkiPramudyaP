-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 12, 2026 at 03:06 AM
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
-- Database: `db_latihan_pbo_trpl1a_rifki pramudya pangestu`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_tiket`
--

CREATE TABLE `tabel_tiket` (
  `id_tabel` int NOT NULL,
  `nama_film` varchar(255) NOT NULL,
  `jadwal_tayang` datetime NOT NULL,
  `jumlah_kursi` int NOT NULL,
  `harga_dasar_tiket` decimal(10,2) NOT NULL,
  `jenis_studio` enum('Reguler','IMAX','Velvet') NOT NULL,
  `tipe_audio` varchar(50) DEFAULT NULL,
  `lokasi_baris` varchar(5) DEFAULT NULL,
  `kacamata_3D_id` varchar(50) DEFAULT NULL,
  `efek_gerak_fitur` varchar(100) DEFAULT NULL,
  `bantal_selimut_pack` varchar(50) DEFAULT NULL,
  `layanan_butler` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_tiket`
--

INSERT INTO `tabel_tiket` (`id_tabel`, `nama_film`, `jadwal_tayang`, `jumlah_kursi`, `harga_dasar_tiket`, `jenis_studio`, `tipe_audio`, `lokasi_baris`, `kacamata_3D_id`, `efek_gerak_fitur`, `bantal_selimut_pack`, `layanan_butler`) VALUES
(1, 'Dune: Part Two', '2026-06-15 13:00:00', 50, '45000.00', 'Reguler', 'Dolby 7.1', 'Row G', NULL, NULL, NULL, NULL),
(2, 'Dune: Part Two', '2026-06-15 16:00:00', 48, '45000.00', 'Reguler', 'Dolby 7.1', 'Row F', NULL, NULL, NULL, NULL),
(3, 'Agak Laen 2', '2026-06-16 12:00:00', 60, '40000.00', 'Reguler', 'Dolby 5.1', 'Row E', NULL, NULL, NULL, NULL),
(4, 'Agak Laen 2', '2026-06-16 14:30:00', 55, '40000.00', 'Reguler', 'Dolby 5.1', 'Row D', NULL, NULL, NULL, NULL),
(5, 'Interstellar', '2026-06-18 20:00:00', 40, '50000.00', 'Reguler', 'Dolby Atmos', 'Row C', NULL, NULL, NULL, NULL),
(6, 'Siksa Kubur', '2026-06-19 13:00:00', 65, '35000.00', 'Reguler', 'Dolby 5.1', 'Row L', NULL, NULL, NULL, NULL),
(7, 'Siksa Kubur', '2026-06-19 15:30:00', 62, '35000.00', 'Reguler', 'Dolby 5.1', 'Row M', NULL, NULL, NULL, NULL),
(8, 'Detective Conan Movie', '2026-06-21 11:30:00', 70, '45000.00', 'Reguler', 'Dolby 7.1', 'Row H', NULL, NULL, NULL, NULL),
(9, 'Detective Conan Movie', '2026-06-21 14:00:00', 68, '45000.00', 'Reguler', 'Dolby 7.1', 'Row G', NULL, NULL, NULL, NULL),
(10, 'Dune: Part Two', '2026-06-15 14:00:00', 120, '75000.00', 'IMAX', 'IMAX 12-Channel', 'Row K', '3D-IMAX-001', 'None', NULL, NULL),
(11, 'The Avengers', '2026-06-17 11:00:00', 100, '80000.00', 'IMAX', 'IMAX 6-Track', 'Row J', '3D-IMAX-042', 'Vibration Seat', NULL, NULL),
(12, 'The Avengers', '2026-06-17 15:00:00', 95, '80000.00', 'IMAX', 'IMAX 6-Track', 'Row H', '3D-IMAX-089', 'Vibration Seat', NULL, NULL),
(13, 'Avatar: The Way of Water', '2026-06-20 10:00:00', 140, '90000.00', 'IMAX', 'IMAX 12-Channel', 'Row M', '3D-AV-992', 'Water & Wind FX', NULL, NULL),
(14, 'Avatar: The Way of Water', '2026-06-20 14:00:00', 135, '90000.00', 'IMAX', 'IMAX 12-Channel', 'Row L', '3D-AV-105', 'Water & Wind FX', NULL, NULL),
(15, 'Inception', '2026-06-22 16:00:00', 80, '75000.00', 'IMAX', 'IMAX 6-Track', 'Row I', '3D-INC-404', 'None', NULL, NULL),
(16, 'Dune: Part Two', '2026-06-15 19:30:00', 20, '150000.00', 'Velvet', 'Dolby Atmos', 'Row A', NULL, NULL, 'Premium Pack A', 'Welcome Drink & Snacks'),
(17, 'Agak Laen 2', '2026-06-16 19:00:00', 15, '130000.00', 'Velvet', 'Dolby 7.1', 'Row B', NULL, NULL, 'Standard Pack', 'Welcome Drink Only'),
(18, 'Interstellar', '2026-06-18 21:00:00', 10, '160000.00', 'Velvet', 'Dolby Atmos', 'Row C', NULL, NULL, 'Luxury Pack B', 'Full Course Meal'),
(19, 'Avatar: The Way of Water', '2026-06-20 18:30:00', 22, '180000.00', 'Velvet', 'Dolby Atmos', 'Row B', NULL, NULL, 'Premium Pack Gold', 'VIP Butler Service'),
(20, 'Inception', '2026-06-22 20:00:00', 12, '150000.00', 'Velvet', 'Dolby Atmos', 'Row A', NULL, NULL, 'Standard Pack', 'Welcome Drink & Snacks');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_tiket`
--
ALTER TABLE `tabel_tiket`
  ADD PRIMARY KEY (`id_tabel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_tiket`
--
ALTER TABLE `tabel_tiket`
  MODIFY `id_tabel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
