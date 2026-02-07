<?php
include("../Components/security.php"); // Handles session_start()
include("../Database/config.php");

$msg = "";
$email = "";

if (isset($_SESSION['email_to_verify'])) {
    $email = $_SESSION['email_to_verify'];
} else {
    // If no email in session, redirect to login
    header("Location: login.php");
    exit();
}

if (isset($_POST['verify'])) {
    // Optional: verify_csrf_token(); // You can enable this if you want to protect verification too
    $verification_code = mysqli_real_escape_string($conn, $_POST['verification_code']);

    $query = "SELECT * FROM users WHERE email='$email' AND verification_code='$verification_code'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Login the user
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_name'] = $row['fullname'];

        // Clear temp session
        unset($_SESSION['email_to_verify']);

        header("Location: ../Content/Dashboard.php");
        exit();
    } else {
        $msg = "<div class='alert alert-danger'>Invalid verification code.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account - iMarket</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/login-reg-forget/login.css">
    <style>
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 0.9rem;
            text-align: center;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-card">
            <!-- Left Side: Branding -->
            <div class="brand-section">
                <div class="brand-content">
                    <img src="../image/logo.png" alt="iMarket Logo" class="brand-logo">
                    <h1>iMarket</h1>
                    <p>Verify Your Identity</p>
                </div>
            </div>

            <!-- Right Side: Verify Form -->
            <div class="form-section">
                <div class="form-header">
                    <h2>Verify Account</h2>
                    <p>Enter the 6-digit code sent to<br><strong><?php echo htmlspecialchars($email); ?></strong></p>
                </div>

                <?php
                echo $msg;
                if (isset($_SESSION['resend_msg'])) {
                    echo str_replace(['alert-success', 'alert-error'], ['alert alert-success', 'alert alert-danger'], $_SESSION['resend_msg']);
                    unset($_SESSION['resend_msg']);
                }
                ?>

                <form action="" method="post">
                    <?php echo get_csrf_input_field(); ?>
                    <div class="input-group">
                        <label for="verification_code">Verification Code</label>
                        <input type="text" id="verification_code" name="verification_code"
                            placeholder="Enter 6-digit code" required
                            style="text-align: center; letter-spacing: 5px; font-size: 1.2rem;">
                    </div>

                    <button type="submit" name="verify" class="btn-login">Verify Account</button>

                    <div class="form-footer">
                        <a href="login.php">Back to Login</a>
                    </div>
                </form>

                <div class="resend-container"
                    style="text-align: center; margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
                    <p style="margin-bottom: 10px; font-size: 0.9rem; color: #666;">Didn't receive the code?</p>
                    <form action="login.php" method="post">
                        <?php echo get_csrf_input_field(); ?>
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                        <button type="submit" name="resend"
                            style="background:none; border:none; color: #007bff; cursor: pointer; text-decoration: none; font-weight: 500;">Resend
                            Code</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
