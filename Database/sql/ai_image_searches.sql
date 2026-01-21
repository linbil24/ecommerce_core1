-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jan 17, 2026 at 06:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `core1_marketph`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_image_searches`
--

CREATE TABLE `ai_image_searches` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `detected_labels` text DEFAULT NULL,
  `search_result_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ai_image_searches`
--

INSERT INTO `ai_image_searches` (`id`, `user_id`, `image_path`, `detected_labels`, `search_result_count`, `created_at`) VALUES
(1, 1, '../uploads/ai_searches/search_694e8397d1dbd.jpg', 'iPhone 15 Pro Max', 1, '2025-12-26 12:46:16'),
(2, 1, '../uploads/ai_searches/search_694e839fa9873.jpg', 'iPhone 15 Pro Max', 1, '2025-12-26 12:46:23'),
(3, 1, '../uploads/ai_searches/search_694e84d5abe8d.jpg', 'H&M Loose Fit Hoodie', 1, '2025-12-26 12:51:34'),
(4, 1, '../uploads/ai_searches/search_694e87063dd62.jpg', 'H&M Loose Fit Hoodie', 1, '2025-12-26 13:00:55'),
(5, 1, '../uploads/ai_searches/search_694e8a4c458da.jpg', NULL, 1, '2025-12-26 13:14:52'),
(6, 1, '../uploads/ai_searches/search_694e8a5d79948.jpg', NULL, 1, '2025-12-26 13:15:09'),
(7, 1, '../uploads/ai_searches/search_694e8b1a65f0b.jpg', NULL, 1, '2025-12-26 13:18:18'),
(8, 1, '../uploads/ai_searches/search_694e8c4b94eeb.jpg', NULL, 1, '2025-12-26 13:23:23'),
(9, 1, '../uploads/ai_searches/search_694e8d0e777f8.jpg', NULL, 1, '2025-12-26 13:26:38'),
(10, 1, '../uploads/ai_searches/search_694e8e2fa6eb4.jpg', NULL, 1, '2025-12-26 13:31:27'),
(11, 1, '../uploads/ai_searches/search_694f35d2a582d.jpg', NULL, 1, '2025-12-27 01:26:42'),
(12, 1, '../uploads/ai_searches/search_694f35fc58672.jpg', NULL, 1, '2025-12-27 01:27:24'),
(13, 1, '../uploads/ai_searches/search_695dcfa6acbbc.jpg', NULL, 1, '2026-01-07 03:14:47'),
(14, 1, '../uploads/ai_searches/search_6960d1b3616ec.jpg', NULL, 1, '2026-01-09 10:00:19'),
(15, 1, '../uploads/ai_searches/search_69612efb61769.jpg', NULL, 1, '2026-01-09 16:38:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_image_searches`
--
ALTER TABLE `ai_image_searches`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ai_image_searches`
--
ALTER TABLE `ai_image_searches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
