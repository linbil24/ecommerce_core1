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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `category_id` int(11) NOT NULL,
  `status` enum('Active','Inactive','Low Stock','Critical Stock') DEFAULT 'Active',
  `image_url` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `price`, `stock`, `category_id`, `status`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'Laptop Pro 2025', 'laptop-pro-2025', 'High-performance laptop for professionals with latest processor', 1200.00, 50, 1, 'Active', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(2, 'Organic Coffee Beans (KG)', 'organic-coffee-beans', 'Single-origin, ethically sourced Arabica beans', 25.50, 12, 2, 'Low Stock', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(3, 'Noise-Cancelling Headphones', 'noise-cancelling-headphones', 'Industry-leading sound quality and comfort', 180.00, 210, 1, 'Active', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(4, 'Ergonomic Desk Mat (Grey)', 'ergonomic-desk-mat', 'Extra large desk mat with anti-slip base', 35.00, 5, 3, 'Critical Stock', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(5, 'Wireless Mouse', 'wireless-mouse', 'Ergonomic wireless mouse with long battery life', 29.99, 85, 1, 'Active', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(6, 'Green Tea (KG)', 'green-tea', 'Premium organic green tea leaves', 18.00, 60, 2, 'Active', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(7, 'Black Tea (KG)', 'black-tea', 'Rich and flavorful black tea', 15.00, 45, 2, 'Active', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(8, 'Premium Notebook Set', 'premium-notebook-set', 'Set of 3 high-quality notebooks', 22.50, 30, 3, 'Active', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(9, 'Standing Desk', 'standing-desk', 'Adjustable height standing desk', 450.00, 12, 3, 'Active', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32'),
(10, 'Smart Watch', 'smart-watch', 'Feature-rich smartwatch with health tracking', 299.99, 25, 1, 'Active', NULL, '2025-12-26 02:52:32', '2025-12-26 02:52:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
