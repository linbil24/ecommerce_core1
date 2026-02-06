-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 27, 2025 at 02:51 AM
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
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `transaction_number` varchar(50) NOT NULL,
  `payment_method` enum('Cash','Credit Card','Debit Card','Bank Transfer','E-Wallet') DEFAULT 'Cash',
  `amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','Completed','Failed','Refunded') DEFAULT 'Pending',
  `transaction_date` datetime NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `transaction_number`, `payment_method`, `amount`, `status`, `transaction_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'TXN-2025-1001', 'Credit Card', 202.50, 'Pending', '2025-01-27 10:30:00', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(2, 2, 'TXN-2025-1002', 'Bank Transfer', 1200.00, 'Completed', '2025-01-27 11:20:00', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(3, 3, 'TXN-2025-1003', 'E-Wallet', 68.00, 'Completed', '2025-01-26 14:25:00', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(4, 4, 'TXN-2025-1004', 'Credit Card', 450.00, 'Refunded', '2025-01-25 09:50:00', 'Refund processed due to cancellation', '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(5, 5, 'TXN-2025-1005', 'Debit Card', 211.50, 'Completed', '2025-01-28 08:35:00', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(6, 6, 'TXN-2025-1006', 'E-Wallet', 299.99, 'Completed', '2025-01-27 16:50:00', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_number` (`transaction_number`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
