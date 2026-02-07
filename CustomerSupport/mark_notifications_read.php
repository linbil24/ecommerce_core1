<?php
// CustomerSupport/mark_notifications_read.php
session_start();
require_once('../Database/config.php');

header('Content-Type: application/json');

if (!isset($_SESSION['support_logged_in']) || $_SESSION['support_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Mark all chat messages as read
$sql = "UPDATE store_chat_messages SET is_read = 1 WHERE sender_type = 'customer' AND is_read = 0";
mysqli_query($conn, $sql);

// Mark all support tickets as read
$sql2 = "UPDATE support_tickets SET is_read = 1 WHERE is_read = 0";
mysqli_query($conn, $sql2);

echo json_encode(['success' => true, 'message' => 'All notifications marked as read']);
?>
