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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
  `payment_status` enum('Pending','Paid','Failed','Refunded') DEFAULT 'Pending',
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `shipped_date` datetime DEFAULT NULL,
  `delivered_date` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `address_id`, `total_amount`, `status`, `payment_status`, `order_date`, `shipped_date`, `delivered_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'ORD-2025-5001', 1, 1, 202.50, 'Pending', 'Pending', '2025-01-27 10:30:00', NULL, NULL, NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(2, 'ORD-2025-5002', 2, 2, 1200.00, 'Processing', 'Paid', '2025-01-27 11:15:00', NULL, NULL, NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(3, 'ORD-2025-5003', 3, 3, 68.00, 'Shipped', 'Paid', '2025-01-26 14:20:00', '2025-01-27 08:00:00', NULL, NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(4, 'ORD-2025-5004', 4, 4, 450.00, 'Cancelled', 'Refunded', '2025-01-25 09:45:00', NULL, NULL, 'Customer cancelled order', '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(5, 'ORD-2025-5005', 5, 5, 211.50, 'Processing', 'Paid', '2025-01-28 08:30:00', NULL, NULL, NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(6, 'ORD-2025-5006', 6, 6, 299.99, 'Shipped', 'Paid', '2025-01-27 16:45:00', '2025-01-28 10:00:00', NULL, NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `address_id` (`address_id`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `customer_addresses` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
