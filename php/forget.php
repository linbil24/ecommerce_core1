<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("../Database/config.php");
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$msg = "";
$show_reset_form = false;
$email_to_reset = "";

// 1. Handle Password Reset Request (Sending Email)
if (isset($_POST['reset'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check_email) > 0) {
        $code = rand(100000, 999999);
        $update_query = mysqli_query($conn, "UPDATE users SET verification_code='$code' WHERE email='$email'");

        if ($update_query) {
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = gethostbyname('smtp.gmail.com');
                $mail->SMTPAuth = true;
                $mail->Username = 'linbilcelestre31@gmail.com';
                $mail->Password = 'ptkm lwud sfgh twdh';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->Timeout = 20;

                // Fix for XAMPP SSL issues
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                //Recipients
                $mail->setFrom('linbilcelestre31@gmail.com', 'iMarket Support');
                $mail->addAddress($email);

                // Attach Logo
                $mail->addEmbeddedImage('../image/logo.png', 'logo_img');

                //Content
                // Use a dynamic way to get the base URL if possible or hardcode based on environment
                $reset_link = "http://localhost/ecommerce%20core1/php/forget.php?email=" . urlencode($email) . "&code=" . $code;

                $mail->isHTML(true);
                $mail->Subject = 'Reset Your Password - iMarket';

                $mail_content = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f4f4f4; padding: 20px;'>
                    <div style='background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align: center;'>
                        <img src='cid:logo_img' alt='iMarket Logo' style='max-width: 150px; margin-bottom: 20px;'>
                        <h2 style='color: #333; margin-bottom: 10px;'>Password Reset Request</h2>
                        <p style='color: #666; font-size: 16px; line-height: 1.5; margin-bottom: 30px;'>
                            We received a request to reset your password. Click the button below to create a new password.
                        </p>
                        <a href='$reset_link' style='display: inline-block; padding: 12px 24px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px;'>Reset Password</a>
                        <p style='color: #999; font-size: 14px; margin-top: 30px;'>
                            If you didn't ask to reset your password, you can ignore this email.
                        </p>
                    </div>
                    <div style='text-align: center; margin-top: 20px; color: #888; font-size: 12px;'>
                        &copy; " . date('Y') . " iMarket. All rights reserved.
                    </div>
                </div>";

                $mail->Body = $mail_content;
                $mail->AltBody = 'Please reset your password using this link: ' . $reset_link;

                $mail->send();
                $msg = "<div class='alert alert-success'>Reset link has been sent to your email.</div>";
            } catch (Exception $e) {
                $msg = "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Something went wrong. Please try again.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Email not found in our records.</div>";
    }
}

// 2. Handle Verification Link Click
if (isset($_GET['code']) && isset($_GET['email'])) {
    $code = mysqli_real_escape_string($conn, $_GET['code']);
    $email_get = mysqli_real_escape_string($conn, $_GET['email']);

    $check_code = mysqli_query($conn, "SELECT * FROM users WHERE email='$email_get' AND verification_code='$code'");

    if (mysqli_num_rows($check_code) > 0) {
        $show_reset_form = true;
        $email_to_reset = $email_get;
    } else {
        $msg = "<div class='alert alert-danger'>Invalid or expired reset link.</div>";
    }
}

// 3. Handle New Password Submission
if (isset($_POST['change_password'])) {
    $email_post = mysqli_real_escape_string($conn, $_POST['email']);
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($new_pass === $confirm_pass) {
        $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

        $update_pass = mysqli_query($conn, "UPDATE users SET password='$hashed_password', verification_code=NULL WHERE email='$email_post'");

        if ($update_pass) {
            $msg = "<div class='alert alert-success'>Password updated successfully. <a href='login.php'>Login Now</a></div>";
            $show_reset_form = false;
        } else {
            $msg = "<div class='alert alert-danger'>Failed to update password.</div>";
            $show_reset_form = true;
            $email_to_reset = $email_post;
        }
    } else {
        $msg = "<div class='alert alert-danger'>Passwords do not match.</div>";
        $show_reset_form = true;
        $email_to_reset = $email_post;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - iMarket</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/login-reg-forget/forget.css">
    <style>
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="forget-card">
            <!-- Left Side: Branding -->
            <div class="brand-section">
                <div class="brand-content">
                    <img src="../image/logo.png" alt="iMarket Logo" class="brand-logo">
                    <h1>iMarket</h1>
                    <p>Account Recovery</p>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="form-section">
                <div class="form-header">
                    <h2><?php echo $show_reset_form ? 'Reset Password' : 'Forgot Password?'; ?></h2>
                    <p><?php echo $show_reset_form ? 'Enter your new password below.' : 'Enter your email address to retrieve your password.'; ?>
                    </p>
                </div>

                <?php echo $msg; ?>

                <?php if ($show_reset_form): ?>
                    <!-- New Password Form -->
                    <form action="" method="post">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email_to_reset); ?>">

                        <div class="input-group">
                            <label for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" placeholder="New Password"
                                required>
                        </div>

                        <div class="input-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password"
                                placeholder="Confirm Password" required>
                        </div>

                        <button type="submit" name="change_password" class="btn-reset">Update Password</button>
                    </form>
                <?php else: ?>
                    <!-- Request Reset Form -->
                    <form action="" method="post">
                        <div class="input-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="you@example.com" required>
                        </div>

                        <button type="submit" name="reset" class="btn-reset">Send Reset Link</button>

                        <div class="form-footer">
                            Remember your password? <a href="login.php">Back to Login</a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>



