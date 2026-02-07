<?php
session_start();
include("../Database/config.php");

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit();
}

$user_id = $_SESSION['user_id'];
$store_name = $_POST['store_name'] ?? '';
$message = $_POST['message'] ?? '';
$sender_type = $_POST['sender_type'] ?? 'customer';

if (empty($store_name) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Store name and message are required']);
    exit();
}

// Create table if not exists
$create_table = "CREATE TABLE IF NOT EXISTS store_chat_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    store_name VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    sender_type ENUM('customer', 'admin') DEFAULT 'customer',
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_store (store_name),
    INDEX idx_user (user_id)
)";
mysqli_query($conn, $create_table);

$sql = "INSERT INTO store_chat_messages (user_id, store_name, message, sender_type) 
        VALUES ('$user_id', '" . mysqli_real_escape_string($conn, $store_name) . "', '" . mysqli_real_escape_string($conn, $message) . "', '$sender_type')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send message']);
}
?>
