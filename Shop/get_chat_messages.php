<?php
session_start();
include("../Database/config.php");

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit();
}

$user_id = $_SESSION['user_id'];
$store_name = $_GET['store_name'] ?? '';

if (empty($store_name)) {
    echo json_encode(['success' => false, 'messages' => []]);
    exit();
}

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
