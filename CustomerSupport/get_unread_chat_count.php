<?php
// CustomerSupport/get_unread_chat_count.php
session_start();
require_once __DIR__ . '/connection.php';
header('Content-Type: application/json');

if (!isset($_SESSION['support_logged_in']) || $_SESSION['support_logged_in'] !== true) {
    echo json_encode(['success' => false, 'unread_count' => 0]);
    exit();
}

try {
    $pdo = get_db_connection();
    // Count total unread messages from customers
    $stmt = $pdo->query("SELECT COUNT(*) FROM store_chat_messages WHERE is_read = 0 AND sender_type = 'customer'");
    $count = $stmt->fetchColumn();
    echo json_encode(['success' => true, 'unread_count' => $count]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'unread_count' => 0]);
}
?>
