<?php
// CustomerSupport/send_chat_reply.php
session_start();
require_once __DIR__ . '/connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['support_logged_in']) || $_SESSION['support_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$user_id = $_POST['user_id'] ?? '';
$store_name = $_POST['store_name'] ?? '';
$message = $_POST['message'] ?? '';

if (empty($user_id) || empty($store_name) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit();
}

try {
    $pdo = get_db_connection();

    // Insert new message
    $stmt = $pdo->prepare("INSERT INTO store_chat_messages (user_id, store_name, message, sender_type, created_at, is_read) 
            VALUES (?, ?, ?, 'admin', NOW(), 0)");
    
    if ($stmt->execute([$user_id, $store_name, $message])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
