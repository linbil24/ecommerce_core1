<?php
// admin/forgot_password.php
require_once 'connection.php';
require_once 'functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$message = $_GET['msg'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    // In a real application, you would check if the email exists and send a reset link.
    // For now, we'll just show a message.
    $message = "If an account exists with that email, a reset link has been sent. (Simulation)";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | IMARKETPH</title>
    <link rel="icon" type="image/png" href="../image/logo.png?v=3.5">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="../css/admin/auth.css">
</head>
<body>
    <div class="login-container">
        <div class="header">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                <div style="width: 48px; height: 48px; background: #f5f3ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 0.5rem;">
                    <i data-lucide="help-circle" style="width: 24px; height: 24px; color: #4f46e5;"></i>
                </div>
                <span style="font-size: 1.25rem; font-weight: 800; letter-spacing: -0.01em; color: #1e293b;">Forgot Password</span>
            </div>
            <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.75rem;">Enter your email to receive a password reset link.</p>
        </div>

        <?php if ($message): ?>
            <div class="alert-message alert-success">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="forgot_password.php">
            <div class="form-group">
                <label>Email Address</label>
                <div class="input-group">
                    <i data-lucide="mail" class="input-icon"></i>
                    <input type="email" placeholder="admin@example.com" name="email" required>
                </div>
            </div>

            <button type="submit" class="btn-base btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">
                Send Reset Link
            </button>
        </form>

        <div style="margin-top: 1.5rem; text-align: center;">
            <a href="login.php" class="switch-link" style="color: #4f46e5; font-weight: 600; text-decoration: none;">
                <i data-lucide="arrow-left" style="width: 1rem; height: 1rem; vertical-align: middle; display: inline-block;"></i> Back to Login
            </a>
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
