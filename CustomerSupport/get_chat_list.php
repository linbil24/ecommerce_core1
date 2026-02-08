<?php
// CustomerSupport/get_chat_list.php
session_start();
require_once __DIR__ . '/connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['support_logged_in']) || $_SESSION['support_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

try {
    $pdo = get_db_connection();
    
    // Use LEFT JOIN to ensure chat shows even if user is deleted (though user_id needed)
    // Modified to handle potential NULLs gracefully
    $sql = "SELECT m.user_id, m.store_name, u.fullname as customer_name, 
            (SELECT message FROM store_chat_messages WHERE user_id = m.user_id AND store_name = m.store_name ORDER BY created_at DESC LIMIT 1) as last_message,
            (SELECT created_at FROM store_chat_messages WHERE user_id = m.user_id AND store_name = m.store_name ORDER BY created_at DESC LIMIT 1) as last_time,
            (SELECT COUNT(*) FROM store_chat_messages WHERE user_id = m.user_id AND store_name = m.store_name AND is_read = 0 AND sender_type = 'customer') as unread_count
            FROM store_chat_messages m
            LEFT JOIN users u ON m.user_id = u.id
            GROUP BY m.user_id, m.store_name
            ORDER BY last_time DESC";

    $stmt = $pdo->query($sql);
    $chats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'chats' => $chats]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
