<?php
// CustomerSupport/get_unread_chat_count.php
session_start();
require_once('../Database/config.php');

header('Content-Type: application/json');

if (!isset($_SESSION['support_logged_in']) || $_SESSION['support_logged_in'] !== true) {
    echo json_encode(['success' => false, 'unread_count' => 0]);
    exit();
}

$sql = "SELECT COUNT(*) as unread_count FROM store_chat_messages WHERE sender_type = 'customer' AND is_read = 0";
$result = mysqli_query($conn, $sql);
$unread_count = 0;

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $unread_count = $row['unread_count'];
}

echo json_encode(['success' => true, 'unread_count' => $unread_count]);
?>
