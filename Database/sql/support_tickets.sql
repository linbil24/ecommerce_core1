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
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` int(11) NOT NULL,
  `ticket_number` varchar(50) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Open','In Progress','Resolved','Closed') DEFAULT 'Open',
  `priority` enum('Low','Medium','High','Urgent') DEFAULT 'Medium',
  `assigned_to` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `ticket_number`, `customer_id`, `subject`, `message`, `status`, `priority`, `assigned_to`, `created_at`, `updated_at`) VALUES
(1, 'TKT-2025-001', 1, 'Order Delivery Delay', 'My order ORD-2025-5001 was supposed to arrive yesterday but it hasn\'t been delivered yet.', 'Open', 'Medium', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(2, 'TKT-2025-002', 3, 'Product Quality Issue', 'The green tea I received seems to be of lower quality than expected.', 'In Progress', 'High', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(3, 'TKT-2025-003', 5, 'Payment Refund Request', 'I need to cancel my order and get a refund. Order number: ORD-2025-5005', 'Open', 'Low', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(4, 'TKT-2025-004', 7, 'Account Access Problem', 'I cannot log in to my account. Please help reset my password.', 'Resolved', 'Medium', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_number` (`ticket_number`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `support_tickets_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
