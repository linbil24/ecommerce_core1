-- Database: `core1_marketph`
USE `core1_marketph`;

CREATE TABLE IF NOT EXISTS `return_refund_requests` (
    `request_id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `order_id` VARCHAR(50) NOT NULL,
    `product_name` VARCHAR(255) NOT NULL,
    `reason` ENUM('Damaged', 'Wrong Item', 'Incomplete', 'Changed Mind', 'Other') NOT NULL,
    `details` TEXT NOT NULL,
    `image_proof` VARCHAR(255) DEFAULT NULL,
    `status` ENUM('Pending', 'Approved', 'Rejected', 'Refunded') DEFAULT 'Pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`request_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
