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
    echo json_encode(['success' => false, 'following' => false]);
    exit();
}

$sql = "SELECT id FROM store_followers WHERE user_id = '$user_id' AND store_name = '" . mysqli_real_escape_string($conn, $store_name) . "'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    echo json_encode(['success' => true, 'following' => true]);
} else {
    echo json_encode(['success' => true, 'following' => false]);
}
?>