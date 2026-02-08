<?php
// CustomerSupport/create_support_user.php
require_once __DIR__ . '/connection.php';
require_once __DIR__ . '/functions.php';

$message = "";
$status = "info"; 

try {
    $pdo = get_db_connection();
    
    // Target Credentials
    // User requested "admin" with password "admin123"
    $username = 'admin';
    $password = 'admin123';
    $email = 'linbilcelestre31@gmail.com'; 
    $fullname = 'Administrator';

    // Check if "admin" exists
    $stmt = $pdo->prepare("SELECT id FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    
    if ($stmt->fetch()) {
        // User 'admin' exists -> Update Password & Email
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        // We update email too, because authentication requires an email for OTP.
        $updateStmt = $pdo->prepare("UPDATE admin_users SET password_hash = ?, email = ? WHERE username = ?");
        $updateStmt->execute([$hash, $email, $username]);
        
        $message = "User '<strong>$username</strong>' updated!<br>Password is now: <strong>$password</strong>";
        $status = "success";
    } else {
        // User 'admin' does not exist -> Create it
        // We use 'admin' as username, but role 'Support' (or we could default to Support)
        // Since this is the "admin" user, let's just make them Support role via the existing function
        // or insert manually if we wanted a different role. 
        // The register_support_user function hardcodes 'Support' role.
        $result = register_support_user($pdo, $username, $password, $email, $fullname);
        
        if ($result['success']) {
            $message = "User '<strong>$username</strong>' created!<br>Password: <strong>$password</strong>";
            $status = "success";
        } else {
            $message = "Error creating user: " . $result['message'];
            $status = "error";
        }
    }

} catch (Exception $e) {
    $message = "Error: " . $e->getMessage();
    $status = "error";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Setup Admin User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #eef2f6; margin: 0; }
        .card { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); text-align: center; max-width: 400px; width: 90%; border-top: 5px solid #2563eb; }
        h2 { margin-top: 0; color: #1e293b; }
        .btn { display: inline-block; margin-top: 1.5rem; padding: 12px 24px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; transition: background 0.2s; }
        .btn:hover { background: #1d4ed8; }
        .success { color: #059669; background: #d1fae5; padding: 1rem; border-radius: 6px; text-align: left; font-size: 0.95rem; line-height: 1.5; }
        .error { color: #dc2626; background: #fee2e2; padding: 1rem; border-radius: 6px; }
        .info { color: #2563eb; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Admin Account Setup</h2>
        <div class="<?php echo $status; ?>">
            <?php echo $message; ?>
        </div>
        <a href="login.php" class="btn">Login as Admin</a>
    </div>
</body>
</html>
