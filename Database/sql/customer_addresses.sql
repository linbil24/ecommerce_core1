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
-- Database: `core1`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `address_line1` varchar(200) NOT NULL,
  `address_line2` varchar(200) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(50) DEFAULT 'Philippines',
  `status` enum('Verified','Pending Validation','Requires Review') DEFAULT 'Pending Validation',
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_addresses`
--

INSERT INTO `customer_addresses` (`id`, `customer_id`, `address_line1`, `address_line2`, `city`, `province`, `postal_code`, `country`, `status`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 1, '123 Sampaguita St', NULL, 'Quezon City', 'Metro Manila', '1100', 'Philippines', 'Verified', 1, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(2, 2, '456 Maharlika Ave', NULL, 'Cebu City', 'Cebu', '6000', 'Philippines', 'Requires Review', 1, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(3, 3, '789 Kalayaan Rd', NULL, 'Davao City', 'Davao', '8000', 'Philippines', 'Pending Validation', 1, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(4, 4, '321 Rizal Street', NULL, 'Makati City', 'Metro Manila', '1200', 'Philippines', 'Verified', 1, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(5, 5, '654 Bonifacio Ave', NULL, 'Manila', 'Metro Manila', '1000', 'Philippines', 'Verified', 1, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(6, 6, '987 Luna Street', NULL, 'Pasig City', 'Metro Manila', '1600', 'Philippines', 'Verified', 1, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(7, 7, '147 Magallanes St', NULL, 'Iloilo City', 'Iloilo', '5000', 'Philippines', 'Pending Validation', 1, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(8, 8, '258 Garcia Street', NULL, 'Baguio City', 'Benguet', '2600', 'Philippines', 'Verified', 1, '2025-12-26 02:52:32', '2025-12-26 02:52:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD CONSTRAINT `customer_addresses_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
