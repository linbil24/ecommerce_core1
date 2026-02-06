<?php
session_start();
include("../Database/config.php");

header('Content-Type: application/json');

$user_id = $_GET['user_id'] ?? '';
$store_name = $_GET['store_name'] ?? '';

if (empty($user_id) || empty($store_name)) {
    echo json_encode(['success' => false, 'messages' => []]);
    exit();
}

// Mark messages as read
$update_sql = "UPDATE store_chat_messages SET is_read = 1 
               WHERE user_id = '$user_id' AND store_name = '" . mysqli_real_escape_string($conn, $store_name) . "' 
               AND sender_type = 'customer'";
mysqli_query($conn, $update_sql);

$sql = "SELECT message, sender_type, created_at 
        FROM store_chat_messages 
        WHERE user_id = '$user_id' AND store_name = '" . mysqli_real_escape_string($conn, $store_name) . "' 
        ORDER BY created_at ASC";

$result = mysqli_query($conn, $sql);
$messages = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
}

echo json_encode(['success' => true, 'messages' => $messages]);
?>