<?php
session_start();
include("../Database/config.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_address'])) {
    $user_id = $_SESSION['user_id'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $zip = mysqli_real_escape_string($conn, $_POST['zip']);

    // 1. Update the Main User Table
    $sql1 = "UPDATE users SET address='$address', city='$city', zip='$zip' WHERE id='$user_id'";
    $res1 = mysqli_query($conn, $sql1);

    // 2. Update Default Address in user_addresses if it exists
    $sql2 = "UPDATE user_addresses SET address='$address', city='$city', zip='$zip' WHERE user_id='$user_id' AND is_default=1";
    $res2 = mysqli_query($conn, $sql2);

    // If no default exists, maybe create one?
    if (mysqli_affected_rows($conn) == 0 && $res2) {
        // Check if any address exists
        $check = mysqli_query($conn, "SELECT id FROM user_addresses WHERE user_id='$user_id'");
        if (mysqli_num_rows($check) == 0) {
            // Get user info for fullname/phone
            $u_sql = mysqli_query($conn, "SELECT fullname, phone FROM users WHERE id='$user_id'");
            $u_data = mysqli_fetch_assoc($u_sql);
            $fn = mysqli_real_escape_string($conn, $u_data['fullname'] ?? 'User');
            $ph = mysqli_real_escape_string($conn, $u_data['phone'] ?? '0000');

            mysqli_query($conn, "INSERT INTO user_addresses (user_id, fullname, phone, address, city, zip, is_default) VALUES ('$user_id', '$fn', '$ph', '$address', '$city', '$zip', 1)");
        }
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>