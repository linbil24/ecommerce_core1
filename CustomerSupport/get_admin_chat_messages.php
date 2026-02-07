<?php
// CustomerSupport/get_admin_chat_messages.php
session_start();
require_once('../Database/config.php');

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

$user_id_esc = mysqli_real_escape_string($conn, $user_id);
$store_name_esc = mysqli_real_escape_string($conn, $store_name);

// Mark as read
$update_sql = "UPDATE store_chat_messages SET is_read = 1 
               WHERE user_id = '$user_id_esc' AND store_name = '$store_name_esc' 
               AND sender_type = 'customer'";
mysqli_query($conn, $update_sql);

$sql = "SELECT message, sender_type, created_at 
        FROM store_chat_messages 
        WHERE user_id = '$user_id_esc' AND store_name = '$store_name_esc' 
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
