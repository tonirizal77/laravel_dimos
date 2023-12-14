-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2021 at 03:41 PM
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
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telpon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kota_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `nama`, `alamat`, `telpon`, `kota_id`, `kota`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Abadi', 'Padang Panjang', '085274520578', NULL, 'Padang Panjang', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(2, 'Abdul', 'Durian Gadang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(3, 'Af - Era', 'Sikasok - Seberang Parit', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(4, 'Afdal - Anis', 'Tj.Mungo - Situjuh', '085355102517', NULL, 'Kab.50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(5, 'Agus', 'Sikasok - Seberang Parit', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(6, 'Ajuang', 'Piladang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(7, 'Al - Armi', 'Tj.Mungo - Situjuh', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(8, 'Bawang Berlian', 'Surabaya', '', NULL, 'Surabaya', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(9, 'Bayan', 'Simp.BR - Piladang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(10, 'Ben', 'Koto Nan Gadang - Tambago', '085763189066', NULL, 'Payakumbuh', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(11, 'Cici', 'Padang Karambia', '', NULL, 'Payakumbuh', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(12, 'Deni', 'Simpang BR', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(13, 'Desi - Ujang', 'Guguak Nunang - Piladang', '0852-75122023', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(14, 'Doni', 'Tj.Mungo', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(15, 'Edi', 'Tangah Padang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(16, 'Edi p', 'Guguak Nunang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(17, 'El - Amir', 'Durian Gadang', '0813-74888137', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(18, 'Ema', 'Guguak Nunang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(19, 'Ema', 'Guguak Nunang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(20, 'Eni', 'Tangah Padang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(21, 'Eri Nunies', 'Guguak Nunang - Piladang', '0821-71080101', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(22, 'Fauzan', 'Tangah Padang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(23, 'Fifi', 'Tg.Padang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(24, 'Jen', 'Halaban', '', NULL, 'Lareh Sago Halaban', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(25, 'Jum', 'BA 8278 KL      [ Halaban )', '', NULL, 'Lareh Sago Halaban', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(26, 'Jun', 'Durian Gadang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(27, 'Leni - Kotik', 'Guguak Bulek', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(28, 'Lili - Pir', 'Jorong Piladang', '0823-88376696', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:27', '2021-07-16 23:52:27'),
(29, 'Linda', 'Tangah Padang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(30, 'Linda - Tuah', 'Sikasok - Seberang Parit', '0823-91518953', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(31, 'Lusi', 'Guguak Nunang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(32, 'Ma \'Un', 'Sikasok - Seberang Parit', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(33, 'Mak Nen', 'Halaban', '', NULL, 'Lareh Sago Halaban', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(34, 'Mareli', 'Tj.Mungo - Situjuh', '0821-73093199', NULL, 'Kab. 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(35, 'Mira', 'Piladang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(36, 'Muan', 'Piladang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(37, 'Mun - Nina', 'Tj.Mungo - Situjuh', '0853-75020606', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(38, 'Nia', 'Seb.Parit', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(39, 'Nina - Anto', 'Sikasok - Seberang Parit', '0823-90196946', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(40, 'Nita Gapuak', 'Sikasok - Seberang Parik', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(41, 'Pak Nyon', 'Halaban', '', NULL, 'Lareh Sago Halaban', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(42, 'Pak Sur', 'Halaban', '', NULL, 'Lareh Sago Halaban', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(43, 'Peni', 'Tj.Mungo - Situjuh', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(44, 'Peri - Ita', 'Tj.Mungo - Situjuh', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(45, 'Pit - Malin', 'Sungai Cubadak', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(46, 'Pul', 'Situjuh', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(47, 'Ral', 'Guguak Malintang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(48, 'Ramadhan', 'Suayan', '', NULL, 'Kab 50 kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(49, 'San', 'Bonai', '', NULL, 'Payakumbuh', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(50, 'Santi', 'Piladang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(51, 'Santi / Wati', 'Pakudoan', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(52, 'Suci - Asnal', 'Guguak Bulek', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(53, 'Syaf', 'Sikasok - Seberang Parit', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(54, 'Tati', 'Piladang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(55, 'Tek Lis', 'Sikasok - Seberang Parit', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(56, 'Tek Yal', 'Guguak Bulek', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(57, 'Tika', 'Tj.Mungo - Situjuh', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(58, 'Uncu - Lilik', 'Ibuh', '', NULL, 'Payakumbuh', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(59, 'Upik', 'Tg.Padang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(60, 'Wati', 'Palasan - Seb. Parit', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(61, 'Yanti - Andi', 'Guguak Bulek', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(62, 'Yanto', 'Simp.BR', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(63, 'Yas', 'Guguak Nunang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(64, 'Yas', 'Tangah Padang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:28', '2021-07-16 23:52:28'),
(65, 'Yenti', 'Tangah Padang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:29', '2021-07-16 23:52:29'),
(66, 'Zul', 'Guguak Nunang', '', NULL, 'Kab 50 Kota', 1, '2021-07-16 23:52:29', '2021-07-16 23:52:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
