<?php
// admin/register.php

// 1. DATABASE CONNECTION & FUNCTIONS
require_once 'connection.php';
require_once 'functions.php';

// Initialize Database Connection
try {
    $pdo = get_db_connection();
} catch (RuntimeException $e) {
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}

// 2. START SESSION
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 3. CHECK IF ALREADY LOGGED IN
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php'); // Route through index to Dashboard
    exit();
}

$message = $_GET['msg'] ?? '';

// 4. HANDLE POST REQUEST (Register)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'register') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $email = $_POST['email'] ?? '';
        $full_name = $_POST['full_name'] ?? '';
        $phone_number = $_POST['phone_number'] ?? '';

        if (empty($username) || empty($password) || empty($email) || empty($full_name) || $password !== $confirm_password) {
            header("Location: register.php?msg=" . urlencode("Registration failed: All fields required and passwords must match."));
            exit();
        }

        $reg_result = create_admin_account($pdo, $username, $password, $email, $phone_number, $full_name);

        if ($reg_result['success']) {
            // Registration SUCCESS: Initiate OTP immediately
            $otp = generate_otp();
            if (save_otp($pdo, $reg_result['user_id'], $otp)) {
                send_otp_email($reg_result['email'], $otp, $reg_result['username']);

                // Set temp session for login.php to pick up
                $_SESSION['admin_awaiting_otp'] = true;
                $_SESSION['temp_admin_id'] = $reg_result['user_id'];
                $_SESSION['temp_admin_username'] = $reg_result['username'];

                // Redirect to LOGIN page (which handles OTP view)
                header("Location: login.php?msg=" . urlencode("Account created! Please verify OTP sent to your email."));
            } else {
                header("Location: login.php?msg=" . urlencode("Registration successful, but OTP failed. Try logging in."));
            }
        } else {
            // Failed
            header("Location: register.php?msg=" . urlencode($reg_result['message']));
        }
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration | IMARKETPH</title>
    <link rel="icon" type="image/png" href="../image/logo.png?v=3.5">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Custom Auth CSS -->
    <link rel="stylesheet" href="../css/admin/auth.css">
</head>

<body>
    <div class="login-container">
        <div class="header">
            <i data-lucide="user-plus" class="logo-icon"></i>
            <span class="logo-text">iMARKET ADMIN REGISTRATION</span>
            <p style="color: var(--color-gray-500); font-size: 0.875rem; margin-top: 0.5rem;">
                Create your new administrator account. **Full Name and Email Address are required for OTP login.**
            </p>
        </div>

        <?php if ($message): ?>
            <div
                class="alert-message <?php echo strpos($message, 'successful') !== false ? 'alert-success' : 'alert-error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Registration Form -->
        <form method="POST" action="register.php">
            <input type="hidden" name="action" value="register">

            <div class="form-group">
                <label for="full_name">Full Name</label>
                <div class="input-group">
                    <i data-lucide="user" class="input-icon"></i>
                    <input type="text" id="full_name" name="full_name" required autocomplete="name"
                        placeholder="E.g., Juan Dela Cruz">
                </div>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-group">
                    <i data-lucide="user-check" class="input-icon"></i>
                    <input type="text" placeholder="Enter your username" id="username" name="username" required
                        autocomplete="new-username">
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address (Used for OTP)</label>
                <div class="input-group">
                    <i data-lucide="mail" class="input-icon"></i>
                    <input type="email" id="email" name="email" required autocomplete="email"
                        placeholder="e.g. admin@example.com">
                </div>
            </div>

            <div class="form-group">
                <label for="phone_number">Mobile Number (Optional)</label>
                <div class="input-group">
                    <i data-lucide="phone" class="input-icon"></i>
                    <input type="tel" id="phone_number" name="phone_number" autocomplete="tel"
                        placeholder="E.g., 09xxxxxxxxx">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password (Min 6 Characters)</label>
                <div class="input-group">
                    <i data-lucide="key" class="input-icon"></i>
                    <input type="password" placeholder="Password" id="password" name="password" required
                        autocomplete="new-password">
                </div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <div class="input-group">
                    <i data-lucide="key-round" class="input-icon"></i>
                    <input type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password"
                        required autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="btn-base btn-primary">
                <i data-lucide="user-plus" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                Create Account
            </button>
        </form>
        <p class="switch-link">
            Already have an account? <a href="login.php">Log In</a>
        </p>
    </div>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>