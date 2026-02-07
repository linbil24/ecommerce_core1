<?php
session_start();
include("../Database/config.php");

header('Content-Type: application/json');

$user_id = $_POST['user_id'] ?? '';
$store_name = $_POST['store_name'] ?? '';
$message = $_POST['message'] ?? '';

if (empty($user_id) || empty($store_name) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit();
}

$sql = "INSERT INTO store_chat_messages (user_id, store_name, message, sender_type) 
        VALUES ('$user_id', '" . mysqli_real_escape_string($conn, $store_name) . "', '" . mysqli_real_escape_string($conn, $message) . "', 'admin')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
}
?>
