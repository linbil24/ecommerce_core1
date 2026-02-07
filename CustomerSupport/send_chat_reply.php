<?php
// CustomerSupport/send_chat_reply.php
session_start();
require_once('../Database/config.php');

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

$user_id_esc = mysqli_real_escape_string($conn, $user_id);
$store_name_esc = mysqli_real_escape_string($conn, $store_name);
$message_esc = mysqli_real_escape_string($conn, $message);

$sql = "INSERT INTO store_chat_messages (user_id, store_name, message, sender_type) 
        VALUES ('$user_id_esc', '$store_name_esc', '$message_esc', 'admin')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
}
?>
