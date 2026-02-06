<?php
session_start();
include("../Database/config.php");

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to follow stores']);
    exit();
}

$user_id = $_SESSION['user_id'];
$store_name = $_POST['store_name'] ?? '';
$action = $_POST['action'] ?? 'follow'; // 'follow' or 'unfollow'

if (empty($store_name)) {
    echo json_encode(['success' => false, 'message' => 'Store name is required']);
    exit();
}

// Create table if not exists
$create_table = "CREATE TABLE IF NOT EXISTS store_followers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    store_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_follow (user_id, store_name)
)";
mysqli_query($conn, $create_table);

if ($action === 'follow') {
    $sql = "INSERT IGNORE INTO store_followers (user_id, store_name) VALUES ('$user_id', '" . mysqli_real_escape_string($conn, $store_name) . "')";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Store followed successfully!', 'action' => 'followed']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to follow store']);
    }
} else {
    $sql = "DELETE FROM store_followers WHERE user_id = '$user_id' AND store_name = '" . mysqli_real_escape_string($conn, $store_name) . "'";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Store unfollowed', 'action' => 'unfollowed']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to unfollow store']);
    }
}
?>