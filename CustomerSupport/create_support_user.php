<?php
require_once __DIR__ . '/connection.php';
require_once __DIR__ . '/functions.php';

try {
    $pdo = get_db_connection();
    
    // Create a support user
    $username = 'support_admin';
    $password = 'password123';
    $email = 'linbilcelestre31@gmail.com'; // Using the email found in config so user receives OTP
    $fullname = 'Support Admin';

    // Check if exists
    $stmt = $pdo->prepare("SELECT id FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        echo "User '$username' already exists.<br>";
        
        // Update password just in case
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $pdo->prepare("UPDATE admin_users SET password_hash = ? WHERE username = ?")->execute([$hash, $username]);
        echo "Password reset to '$password'.<br>";
    } else {
        $result = register_support_user($pdo, $username, $password, $email, $fullname);
        if ($result['success']) {
            echo "User created successfully.<br>";
            echo "Username: $username<br>";
            echo "Password: $password<br>";
        } else {
            echo "Error: " . $result['message'] . "<br>";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
