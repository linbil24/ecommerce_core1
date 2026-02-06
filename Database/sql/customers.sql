-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 27, 2025 at 02:50 AM
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
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `status` enum('Active','Inactive','Banned') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `email`, `phone_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Erica Fernandez', 'erica.fernandez@example.com', '09123456789', 'Active', '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(2, 'Jose Perez', 'jose.perez@example.com', '09123456790', 'Active', '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(3, 'Anna Martinez', 'anna.martinez@example.com', '09123456791', 'Active', '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(4, 'Ramon Torres', 'ramon.torres@example.com', '09123456792', 'Active', '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(5, 'Juan Dela Cruz', 'juan.delacruz@example.com', '09123456793', 'Active', '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(6, 'Maria Santos', 'maria.santos@example.com', '09123456794', 'Active', '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(7, 'Pedro Esguerra', 'pedro.esguerra@example.com', '09123456795', 'Active', '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(8, 'Sarah Gomez', 'sarah.gomez@example.com', '09123456796', 'Active', '2025-12-26 02:52:32', '2025-12-26 02:52:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
