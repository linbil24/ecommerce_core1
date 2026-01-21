<?php
// Admin/login.php

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
$is_otp_page = isset($_SESSION['admin_awaiting_otp']) && $_SESSION['admin_awaiting_otp'] === true;

// 4. HANDLE POST REQUESTS (Login & OTP)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // --- RETURN TO LOGIN (Clear OTP state) ---
    if ($action === 'return_to_login') {
        unset($_SESSION['admin_awaiting_otp']);
        unset($_SESSION['temp_admin_id']);
        unset($_SESSION['temp_admin_username']);
        header("Location: login.php");
        exit();
    }

    // --- LOGIN ACTION ---
    if ($action === 'login') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $auth_result = authenticate_admin($pdo, $username, $password);

        if ($auth_result['success'] && $auth_result['redirect_view'] === 'otp') {
            // OTP initiated, refresh page to show OTP form
            header("Location: login.php?msg=" . urlencode($auth_result['message']));
            exit();
        } else {
            // Failed
            header("Location: login.php?msg=" . urlencode($auth_result['message']));
            exit();
        }
    }

    // --- OTP VERIFY ACTION ---
    if ($action === 'otp_verify') {
        $otp_input = isset($_POST['otp_code']) ? trim(strval($_POST['otp_code'])) : '';
        $user_id = isset($_SESSION['temp_admin_id']) ? intval($_SESSION['temp_admin_id']) : (isset($_POST['user_id']) ? intval($_POST['user_id']) : null);

        if (empty($otp_input)) {
            header("Location: login.php?msg=" . urlencode("Error: Please enter the OTP code."));
            exit();
        }

        $otp_input = preg_replace('/[^0-9]/', '', $otp_input);
        if (strlen($otp_input) !== 6) {
            header("Location: login.php?msg=" . urlencode("Error: OTP must be 6 digits."));
            exit();
        }

        if (!$user_id || $user_id <= 0) {
            // Session lost
            unset($_SESSION['admin_awaiting_otp']);
            header("Location: login.php?msg=" . urlencode("Session error. Please log in again."));
            exit();
        }

        $verification_result = verify_otp_and_login($pdo, $user_id, $otp_input);

        // Check success based on string return (as per original logic)
        if (stripos($verification_result, 'successful') !== false || stripos($verification_result, 'welcome') !== false) {
            header("Location: dashboard.php?msg=" . urlencode($verification_result));
        } else {
            header("Location: login.php?msg=" . urlencode($verification_result));
        }
        exit();
    }
}

// 5. HANDLE GET ACTIONS (e.g. return_to_login via URL)
if (isset($_GET['action']) && $_GET['action'] === 'return_to_login') {
    unset($_SESSION['admin_awaiting_otp']);
    unset($_SESSION['temp_admin_id']);
    unset($_SESSION['temp_admin_username']);
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_otp_page ? 'OTP Verification | IMARKETPH' : 'ADMIN LOGIN | IMARKETPH'; ?></title>
    <link rel="icon" type="image/png" href="../image/logo.png?v=3.5">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Custom Auth CSS -->
    <link rel="stylesheet" href="../Css/Admin/auth.css">
</head>

<body>
    <div class="login-container">
        <div class="header">
            <i data-lucide="<?php echo $is_otp_page ? 'shield-check' : 'lock'; ?>" class="logo-icon"></i>
            <span class="logo-text">IMARKETPH ADMIN <?php echo $is_otp_page ? 'VERIFICATION' : 'LOGIN'; ?></span>
            <p style="color: var(--color-gray-500); font-size: 0.875rem; margin-top: 0.5rem;">
                <?php
                if ($is_otp_page) {
                    $u = htmlspecialchars($_SESSION['temp_admin_username'] ?? 'User');
                    echo "Enter the 6-digit code sent to your **Email Address** to continue login for **{$u}**.";
                } else {
                    echo 'Enter your credentials to access the portal. **Email OTP verification is required for login.**';
                }
                ?>
            </p>
        </div>

        <?php if ($message): ?>
            <div
                class="alert-message <?php echo strpos($message, 'successful') !== false || strpos($message, 'DEMO CODE') !== false ? 'alert-success' : 'alert-error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($is_otp_page): ?>
            <!-- OTP Verification Form -->
            <form method="POST" action="login.php" id="otp-form">
                <input type="hidden" name="action" value="otp_verify">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['temp_admin_id'] ?? ''; ?>">

                <div class="form-group otp-input-group">
                    <label for="otp_code">OTP Code (6 Digits)</label>
                    <input type="text" id="otp_code" name="otp_code" required maxlength="6" minlength="6" pattern="[0-9]{6}"
                        placeholder="000000" autocomplete="one-time-code" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value.length > 6) this.value = this.value.slice(0, 6);">
                    <p style="font-size: 0.75rem; color: var(--color-gray-500); margin-top: 0.5rem; text-align: center;">
                        Enter the 6-digit code sent to your email
                    </p>
                </div>

                <button type="submit" class="btn-base btn-primary w-full">
                    <i data-lucide="shield-check" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                    Verify & Log In
                </button>
            </form>

            <div class="otp-nav">
                <a href="login.php?action=return_to_login">
                    <i data-lucide="refresh-cw" style="width: 1rem; height: 1rem; margin-right: 0.25rem;"></i>
                    Re-attempt Login (New OTP)
                </a>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const otpInput = document.getElementById('otp_code');
                    if (otpInput) otpInput.focus();
                });
            </script>

        <?php else: ?>
            <!-- Login Form -->
            <form method="POST" action="login.php">
                <input type="hidden" name="action" value="login">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <i data-lucide="user" class="input-icon"></i>
                        <input type="text" placeholder="Enter your username" id="username" name="username" required
                            autocomplete="username">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <i data-lucide="lock" class="input-icon"></i>
                        <input type="password" placeholder="Enter your password" id="password" name="password" required
                            autocomplete="current-password">
                    </div>
                </div>

                <button type="submit" class="btn-base btn-primary">
                    <i data-lucide="log-in" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                    Log In
                </button>
            </form>
            <p class="switch-link">
                Don't have an account? <a href="register.php">Create Account</a>
            </p>
        <?php endif; ?>
    </div>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
