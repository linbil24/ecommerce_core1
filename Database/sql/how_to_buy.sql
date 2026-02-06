-- Database: `core1_marketph`
USE `core1_marketph`;

CREATE TABLE IF NOT EXISTS `buying_steps` (
    `step_id` INT(11) NOT NULL AUTO_INCREMENT,
    `step_order` INT(11) NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `description` TEXT NOT NULL,
    `icon_class` VARCHAR(50) DEFAULT 'fas fa-info-circle',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`step_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default steps
INSERT INTO `buying_steps` (`step_order`, `title`, `description`, `icon_class`) VALUES
(1, 'Search & Select', 'Browse our wide range of products using the search bar or categories. Click on the product you like to view details.', 'fas fa-search'),
(2, 'Add to Cart', 'Select your preferred variation (color, size) and quantity, then click "Add to Cart" or "Buy Now".', 'fas fa-cart-plus'),
(3, 'View Cart & Checkout', 'Review your selected items in the cart. Click "Checkout" to proceed to payment and shipping details.', 'fas fa-shopping-bag'),
(4, 'Place Order', 'Enter your delivery address, choose a payment method, and confirm your order. You will receive an email confirmation.', 'fas fa-check-circle'),
(5, 'Track & Receive', 'Track your order status locally in "My Purchases". Wait for our courier to deliver your package to your doorstep.', 'fas fa-box-open');
