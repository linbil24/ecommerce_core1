<?php
// admin/login.php

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
    header('Location: dashboard.php');
    exit();
}

// 3.1 AUTO-LOGIN FROM MAIN SITE (Session Sharing)
if (isset($_SESSION['user_id']) && !isset($_SESSION['admin_logged_in'])) {
    $u_id = $_SESSION['user_id'];
    // Fetch details from 'users' table to promote to Admin session (Seller mode)
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$u_id]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user_data) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user_data['id'];
        $_SESSION['admin_username'] = $user_data['fullname'];
        $_SESSION['admin_role'] = 'Seller'; // Promotion to Seller/Admin role

        // Optional: Re-fetch if they exist in admin_users for specific roles
        $check_admin = $pdo->prepare("SELECT role FROM admin_users WHERE email = ?");
        $check_admin->execute([$user_data['email']]);
        $role_data = $check_admin->fetch(PDO::FETCH_ASSOC);
        if ($role_data) {
            $_SESSION['admin_role'] = $role_data['role'];
        }

        header('Location: dashboard.php');
        exit();
    }
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
    <link rel="stylesheet" href="../css/admin/auth.css">
    
    <style>
        /* Loading Screen Styles */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

        #loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #4A6E95 0%, #2B4560 100%);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-family: 'Poppins', sans-serif;
            transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
        }

        .loader-container {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .loader-logo-box {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .loader-brand-name {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .loader-tagline {
            font-size: 1.1rem;
            font-weight: 300;
            opacity: 0.8;
            margin-bottom: 50px;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.2);
            border-top: 3px solid #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .hidden-loader {
            opacity: 0;
            visibility: hidden;
        }
    </style>
</head>

<body>
    <!-- Loading Screen Overlay -->
    <div id="loader-overlay">
        <div class="loader-container">
            <div class="loader-logo-box">IM</div>
            <div class="text-content">
                <h1 class="loader-brand-name">iMarket</h1>
                <p class="loader-tagline">Your Market, Your Choice</p>
            </div>
            <div class="loader-spinner"></div>
        </div>
    </div>
    <div class="login-container">
        <div class="header">
            <a href="login.php"
                style="text-decoration: none; color: inherit; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                <i data-lucide="<?php echo $is_otp_page ? 'shield-check' : 'lock'; ?>" class="logo-icon"></i>
                <span class="logo-text">IMARKETPH ADMIN <?php echo $is_otp_page ? 'VERIFICATION' : 'LOGIN'; ?></span>
            </a>
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

        // Loading Screen Logic
        window.addEventListener('load', function() {
            setTimeout(function() {
                const loader = document.getElementById('loader-overlay');
                if (loader) {
                    loader.classList.add('hidden-loader');
                    setTimeout(() => loader.remove(), 500); // Remove from DOM after fade out
                }
            }, 1500); // Display time
        });
    </script>
</body>

</html>