-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2021 at 03:40 PM
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icons` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `icons`, `active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Kerupuk Merah', NULL, 1, NULL, '2021-07-17 00:42:57', '2021-07-17 00:42:57'),
(2, 'Rubik', NULL, 1, NULL, '2021-07-17 00:43:01', '2021-07-17 00:43:01'),
(3, 'Tepung', NULL, 1, NULL, '2021-07-17 00:43:12', '2021-07-17 00:43:12'),
(4, 'K. Bungkus', NULL, 1, NULL, '2021-07-17 00:43:19', '2021-07-17 00:43:19'),
(5, 'K. Timbang', NULL, 1, NULL, '2021-07-17 00:43:28', '2021-07-17 00:43:28'),
(6, 'Bulan', NULL, 1, NULL, '2021-07-17 00:43:34', '2021-07-17 00:43:34'),
(7, 'Sakura', NULL, 1, NULL, '2021-07-17 00:43:39', '2021-07-17 00:43:39'),
(8, 'Halaban', NULL, 1, NULL, '2021-07-17 00:43:57', '2021-07-17 00:43:57'),
(9, 'JB', NULL, 1, NULL, '2021-07-17 00:44:02', '2021-07-17 00:44:02'),
(10, 'BB', NULL, 1, NULL, '2021-07-17 00:44:08', '2021-07-17 00:44:08'),
(11, 'PT', NULL, 1, NULL, '2021-07-17 00:44:11', '2021-07-17 00:44:11'),
(12, 'Tim Jawa', NULL, 1, NULL, '2021-07-17 00:44:18', '2021-07-17 00:44:18'),
(13, 'Kerang / Stick', NULL, 1, NULL, '2021-07-17 00:44:26', '2021-07-17 00:44:26'),
(14, 'Toples', NULL, 1, NULL, '2021-07-17 00:44:44', '2021-07-17 00:44:44'),
(15, 'Kue Kering', NULL, 1, NULL, '2021-07-17 00:44:50', '2021-07-17 00:44:50'),
(16, 'Bedeng', NULL, 1, NULL, '2021-07-17 00:44:55', '2021-07-25 21:05:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
