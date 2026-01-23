<?php

$host = "localhost";
$user = "core1_marketph";
$password = "123";
$db = "core1_marketph";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




// Auto-create support_tickets table if it doesn't exist
$sql_create_tickets = "CREATE TABLE IF NOT EXISTS `support_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Open','In Progress','Resolved','Closed') DEFAULT 'Open',
  `priority` enum('Low','Medium','High','Urgent') DEFAULT 'Medium',
  `assigned_to` int(11) DEFAULT NULL,
  `admin_reply` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `ticket_number` (`ticket_number`),
  KEY `customer_id` (`customer_id`),
  KEY `assigned_to` (`assigned_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$conn->query($sql_create_tickets);
// Auto-update orders table structure
$check_orders = $conn->query("SHOW TABLES LIKE 'orders'");
if ($check_orders->num_rows > 0) {
  // Check and add user_id
  $check_user_id = $conn->query("SHOW COLUMNS FROM orders LIKE 'user_id'");
  if ($check_user_id->num_rows == 0) {
    $conn->query("ALTER TABLE orders ADD COLUMN user_id INT NOT NULL AFTER id");
  }

  // Check and add tracking_number
  $check_tracking = $conn->query("SHOW COLUMNS FROM orders LIKE 'tracking_number'");
  if ($check_tracking->num_rows == 0) {
    $conn->query("ALTER TABLE orders ADD COLUMN tracking_number VARCHAR(50) AFTER user_id");
  }

  // Check and add product_id
  $check_product_id = $conn->query("SHOW COLUMNS FROM orders LIKE 'product_id'");
  if ($check_product_id->num_rows == 0) {
    $conn->query("ALTER TABLE orders ADD COLUMN product_id INT DEFAULT 0 AFTER tracking_number");
  }

  // Check and add product_name
  $check_pname = $conn->query("SHOW COLUMNS FROM orders LIKE 'product_name'");
  if ($check_pname->num_rows == 0) {
    $conn->query("ALTER TABLE orders ADD COLUMN product_name VARCHAR(255) NOT NULL AFTER product_id");
  }

  // Check and add quantity
  $check_qty = $conn->query("SHOW COLUMNS FROM orders LIKE 'quantity'");
  if ($check_qty->num_rows == 0) {
    $conn->query("ALTER TABLE orders ADD COLUMN quantity INT NOT NULL AFTER product_name");
  }

  // Check and add price
  $check_price = $conn->query("SHOW COLUMNS FROM orders LIKE 'price'");
  if ($check_price->num_rows == 0) {
    $conn->query("ALTER TABLE orders ADD COLUMN price DECIMAL(10,2) NOT NULL AFTER quantity");
  }

  // Check and add total_amount
  $check_total = $conn->query("SHOW COLUMNS FROM orders LIKE 'total_amount'");
  if ($check_total->num_rows == 0) {
    $conn->query("ALTER TABLE orders ADD COLUMN total_amount DECIMAL(10,2) NOT NULL AFTER price");
  }

  // Check and add image_url (some versions might have used image_url instead of image)
  $check_image = $conn->query("SHOW COLUMNS FROM orders LIKE 'image_url'");
  if ($check_image->num_rows == 0) {
    $conn->query("ALTER TABLE orders ADD COLUMN image_url VARCHAR(255) AFTER status");
  }

  // Check and add full_name, phone_number, address, city, postal_code, payment_method, status
  $cols_to_check = [
    'full_name' => "VARCHAR(255) NOT NULL",
    'phone_number' => "VARCHAR(50) NOT NULL",
    'address' => "TEXT NOT NULL",
    'city' => "VARCHAR(100) NOT NULL",
    'postal_code' => "VARCHAR(20) NOT NULL",
    'payment_method' => "VARCHAR(50) NOT NULL",
    'status' => "VARCHAR(50) DEFAULT 'Pending'"
  ];

  foreach ($cols_to_check as $col => $def) {
    $c_check = $conn->query("SHOW COLUMNS FROM orders LIKE '$col'");
    if ($c_check->num_rows == 0) {
      $conn->query("ALTER TABLE orders ADD COLUMN $col $def");
    }
  }
}

// Auto-update cart table structure
$check_cart = $conn->query("SHOW TABLES LIKE 'cart'");
if ($check_cart->num_rows > 0) {
  $check_cart_pid = $conn->query("SHOW COLUMNS FROM cart LIKE 'product_id'");
  if ($check_cart_pid->num_rows == 0) {
    $conn->query("ALTER TABLE cart ADD COLUMN product_id INT DEFAULT 0 AFTER user_id");
  }
}
?>