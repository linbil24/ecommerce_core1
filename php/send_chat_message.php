<?php
session_start();
include("../Database/config.php");

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? null;
$store_name = $_POST['store_name'] ?? 'Customer Support';
$message = $_POST['message'] ?? '';

if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'Login required']);
    exit();
}

if (empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Empty message']);
    exit();
}

$u_id = mysqli_real_escape_string($conn, $user_id);
$s_name = mysqli_real_escape_string($conn, $store_name);
$msg = mysqli_real_escape_string($conn, $message);

$sql = "INSERT INTO store_chat_messages (user_id, store_name, message, sender_type) 
        VALUES ('$u_id', '$s_name', '$msg', 'customer')";

if (mysqli_query($conn, $sql)) {
    // Optional: Update notifications for support staff here
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
}
?>
