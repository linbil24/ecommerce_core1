<?php
// CustomerSupport/get_admin_chat_messages.php
session_start();
require_once __DIR__ . '/connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['support_logged_in']) || $_SESSION['support_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$user_id = $_GET['user_id'] ?? '';
$store_name = $_GET['store_name'] ?? '';

if (empty($user_id) || empty($store_name)) {
    echo json_encode(['success' => false, 'messages' => []]);
    exit();
}

try {
    $pdo = get_db_connection();

    // Mark messages from customer as read
    $updateStmt = $pdo->prepare("UPDATE store_chat_messages SET is_read = 1 
                   WHERE user_id = ? AND store_name = ? 
                   AND sender_type = 'customer'");
    $updateStmt->execute([$user_id, $store_name]);

    // Fetch messages sorted by time asc
    $stmt = $pdo->prepare("SELECT message, sender_type, created_at 
            FROM store_chat_messages 
            WHERE user_id = ? AND store_name = ? 
            ORDER BY created_at ASC");
    $stmt->execute([$user_id, $store_name]);
    
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'messages' => $messages]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
