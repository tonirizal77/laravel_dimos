-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2021 at 03:38 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dimos_apps`
--

-- --------------------------------------------------------

--
-- Table structure for table `satuans`
--

CREATE TABLE `satuans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'CTN.BOX.PCS',
  `konversi` tinyint(1) NOT NULL DEFAULT 0,
  `nilai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '100.50.1',
  `kode` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'B.S.K',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satuans`
--

INSERT INTO `satuans` (`id`, `tipe`, `konversi`, `nilai`, `kode`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'BALL', 0, '1', 'B', NULL, '2021-07-16 22:00:36', '2021-07-16 22:00:36'),
(2, 'CTN', 0, '1', 'B', NULL, '2021-07-16 22:00:36', '2021-07-16 22:00:36'),
(3, 'DUS', 0, '1', 'B', NULL, '2021-07-16 22:00:36', '2021-07-16 22:00:36'),
(4, 'KRG', 0, '1', 'B', NULL, '2021-07-16 22:00:36', '2021-07-16 22:00:36'),
(5, 'BOX', 0, '1', 'S', NULL, '2021-07-16 22:00:36', '2021-07-16 22:00:36'),
(6, 'IKAT', 0, '1', 'S', NULL, '2021-07-16 22:00:36', '2021-07-16 22:00:36'),
(7, 'JRGN', 0, '1', 'S', NULL, '2021-07-16 22:00:36', '2021-07-16 22:00:36'),
(8, 'PACK', 0, '1', 'S', NULL, '2021-07-16 22:00:36', '2021-07-16 22:00:36'),
(9, 'PAIRS', 0, '1', 'S', NULL, '2021-07-16 22:00:36', '2021-07-16 22:00:36'),
(10, 'PAIL', 0, '1', 'S', NULL, '2021-07-16 22:00:36', '2021-07-16 22:00:36'),
(11, 'KRAT', 0, '1', 'S', NULL, '2021-07-16 22:00:36', '2021-07-16 22:00:36'),
(12, 'KTK', 0, '1', 'S', NULL, '2021-07-16 22:00:36', '2021-07-16 22:00:36'),
(13, 'RTG', 0, '1', 'S', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(14, 'SLOP', 0, '1', 'S', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(15, 'TIM', 0, '1', 'S', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(16, 'PCS', 0, '1', 'K', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(17, 'BKS', 0, '1', 'K', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(18, 'BLEK', 0, '1', 'K', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(19, 'KG', 0, '1', 'K', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(20, 'KLG', 0, '1', 'K', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(21, 'LBR', 0, '1', 'K', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(22, 'CTN.BOX.PCS', 1, '100.50.1', 'B.S.K', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(23, 'CTN.PACK.PCS', 1, '100.10.1', 'B.S.K', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(24, 'CTN.PAIRS.PCS', 1, '50.2.1', 'B.S.K', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(25, 'CTN.BOX', 1, '100.50', 'B.S', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(26, 'BOX.PCS', 1, '50.1', 'S.K', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(27, 'CTN.PCS', 1, '25.1', 'B.K', NULL, '2021-07-16 22:00:37', '2021-07-16 22:00:37'),
(28, 'BALL.TIM.KG', 1, '10.5.1', 'B.S.K', NULL, '2021-07-17 01:10:11', '2021-07-17 01:10:11'),
(29, 'KRG.TIM.KG', 1, '25.5.1', 'B.S.K', NULL, '2021-07-18 06:02:11', '2021-07-18 06:02:11'),
(30, 'BALL.KG', 1, '5.1', 'B.K', NULL, '2021-07-24 04:38:42', '2021-07-24 04:38:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `satuans`
--
ALTER TABLE `satuans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `satuans_tipe_unique` (`tipe`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `satuans`
--
ALTER TABLE `satuans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
