<?php
session_start();
include("../Database/config.php");

header('Content-Type: application/json');

$sql = "SELECT m.user_id, m.store_name, u.fullname as customer_name, 
        (SELECT message FROM store_chat_messages WHERE user_id = m.user_id AND store_name = m.store_name ORDER BY created_at DESC LIMIT 1) as last_message,
        (SELECT created_at FROM store_chat_messages WHERE user_id = m.user_id AND store_name = m.store_name ORDER BY created_at DESC LIMIT 1) as last_time,
        (SELECT COUNT(*) FROM store_chat_messages WHERE user_id = m.user_id AND store_name = m.store_name AND is_read = 0 AND sender_type = 'customer') as unread_count
        FROM store_chat_messages m
        JOIN users u ON m.user_id = u.id
        GROUP BY m.user_id, m.store_name
        ORDER BY last_time DESC";

$result = mysqli_query($conn, $sql);
$chats = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $chats[] = $row;
    }
}

echo json_encode(['success' => true, 'chats' => $chats]);
?>
