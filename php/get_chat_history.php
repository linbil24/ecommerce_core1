<?php
session_start();
include("../Database/config.php");

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? null;
$store_name = $_GET['store_name'] ?? 'Customer Support';

if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'Login required']);
    exit();
}

$u_id = mysqli_real_escape_string($conn, $user_id);
$s_name = mysqli_real_escape_string($conn, $store_name);

$sql = "SELECT m.*, DATE_FORMAT(m.created_at, '%h:%i %p') as timestamp 
        FROM store_chat_messages m 
        WHERE m.user_id = '$u_id' AND m.store_name = '$s_name' 
        ORDER BY m.created_at ASC";

$result = mysqli_query($conn, $sql);
$messages = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
    
    // Mark messages as read by human (optional, if admin views it it might mark read)
    // For now just return history
    echo json_encode(['success' => true, 'messages' => $messages]);
} else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
}
?>
