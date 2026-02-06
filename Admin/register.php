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
    header('Location: dashboard.php');
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

        // Logic check: Ensure files are uploaded for ID and Profile
        if (!isset($_FILES['id_verification']) || $_FILES['id_verification']['error'] !== UPLOAD_ERR_OK) {
             header("Location: register.php?msg=" . urlencode("Identity Verification (ID) is required for professional registration."));
             exit();
        }

        $reg_result = create_admin_account($pdo, $username, $password, $email, $phone_number, $full_name);

        if ($reg_result['success']) {
            $admin_id = $reg_result['user_id'];

            // Handle Profile Image Upload if provided
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                handle_profile_image_upload($_FILES['profile_image'], $admin_id);
            }

            // Handle ID Verification Upload
            if (isset($_FILES['id_verification']) && $_FILES['id_verification']['error'] === UPLOAD_ERR_OK) {
                // We'll use a specific naming convention for ID verification files
                $upload_dir = get_profile_upload_directory();
                ensure_profile_upload_directory();
                $ext = pathinfo($_FILES['id_verification']['name'], PATHINFO_EXTENSION);
                $new_name = $admin_id . "_ID_VERIFICATION." . $ext;
                $target = $upload_dir . DIRECTORY_SEPARATOR . $new_name;
                move_uploaded_file($_FILES['id_verification']['tmp_name'], $target);
                
                // You might want to save this path in the database too, 
                // but since we're using a naming convention like glob, we'll keep it simple for now.
            }

            // Registration SUCCESS: Initiate OTP immediately
            $otp = generate_otp();
            if (save_otp($pdo, $admin_id, $otp)) {
                send_otp_email($reg_result['email'], $otp, $reg_result['username']);

                $_SESSION['admin_awaiting_otp'] = true;
                $_SESSION['temp_admin_id'] = $admin_id;
                $_SESSION['temp_admin_username'] = $reg_result['username'];

                header("Location: login.php?msg=" . urlencode("Registration successful! Please verify the OTP sent to your email."));
            } else {
                header("Location: login.php?msg=" . urlencode("Account created, but OTP failed. Please log in to retry."));
            }
        } else {
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
    <title>Professional Admin Registration | IMARKETPH</title>
    <link rel="icon" type="image/png" href="../image/logo.png?v=3.5">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Custom Auth CSS -->
    <link rel="stylesheet" href="../css/admin/auth.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap');

        body {
            font-family: 'Outfit', sans-serif;
            background: #f8fafc;
        }

        .login-container {
            max-width: 650px;
            padding: 3rem;
        }

        .section-title {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748b;
            font-weight: 800;
            margin: 2rem 0 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 0.5rem;
        }

        .grid-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        @media (max-width: 600px) {
            .grid-inputs { grid-template-columns: 1fr; }
        }

        .upload-field {
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            background: #fbfcfe;
        }

        .upload-field:hover {
            border-color: #4f46e5;
            background: #f5f3ff;
        }

        .upload-field input[type="file"] {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            opacity: 0; cursor: pointer;
        }

        .upload-text {
            color: #64748b;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .upload-text strong {
            color: #4f46e5;
        }

        .file-preview {
            display: none;
            font-size: 0.8rem;
            color: #059669;
            font-weight: 600;
            margin-top: 0.5rem;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="header" style="margin-bottom: 3rem;">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 0.75rem; box-shadow: 0 8px 16px rgba(79, 70, 229, 0.2);">
                    <i data-lucide="user-plus" style="width: 28px; height: 28px; color: white;"></i>
                </div>
                <span style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em; color: #1e293b;">IMARKET | ADMIN PORTAL</span>
                <p style="color: #64748b; font-size: 0.9375rem; margin-top: 0.25rem;">Complete the professional registration to access the dashboard.</p>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="alert-message <?php echo strpos($message, 'successful') !== false ? 'alert-success' : 'alert-error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="register">

            <div class="section-title">
                <i data-lucide="id-card" style="width: 1.25rem; height: 1.25rem;"></i>
                Personal Details
            </div>
            
            <div class="grid-inputs">
                <div class="form-group">
                    <label>Full Name</label>
                    <div class="input-group">
                        <i data-lucide="user" class="input-icon"></i>
                        <input type="text" name="full_name" required placeholder="Juan Dela Cruz">
                    </div>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-group">
                        <i data-lucide="at-sign" class="input-icon"></i>
                        <input type="text" name="username" required placeholder="admin_juan">
                    </div>
                </div>
            </div>

            <div class="grid-inputs">
                <div class="form-group">
                    <label>Email (Verification)</label>
                    <div class="input-group">
                        <i data-lucide="mail" class="input-icon"></i>
                        <input type="email" name="email" required placeholder="juan@imarketph.com">
                    </div>
                </div>
                <div class="form-group">
                    <label>Phone (Optional)</label>
                    <div class="input-group">
                        <i data-lucide="phone" class="input-icon"></i>
                        <input type="tel" name="phone_number" placeholder="0917xxxxxxx">
                    </div>
                </div>
            </div>

            <div class="section-title">
                <i data-lucide="shield-check" style="width: 1.25rem; height: 1.25rem;"></i>
                Account Security
            </div>

            <div class="grid-inputs">
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <i data-lucide="lock" class="input-icon"></i>
                        <input type="password" name="password" required placeholder="••••••••">
                    </div>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="input-group">
                        <i data-lucide="check-circle-2" class="input-icon"></i>
                        <input type="password" name="confirm_password" required placeholder="••••••••">
                    </div>
                </div>
            </div>

            <div class="section-title">
                <i data-lucide="user-cog" style="width: 1.25rem; height: 1.25rem;"></i>
                Professional Verification
            </div>

            <div class="grid-inputs">
                <div class="form-group">
                    <label>Identity Verification (ID)</label>
                    <div class="upload-field" id="id-upload-field">
                        <i data-lucide="file-up" style="width: 2rem; height: 2rem; color: #94a3b8; margin-bottom: 0.5rem;"></i>
                        <div class="upload-text"><strong>Upload ID</strong> or drag as drop</div>
                        <div class="upload-text" style="font-size: 0.75rem;">JPG, PNG or PDF (Max 5MB)</div>
                        <input type="file" name="id_verification" required onchange="handleFileSelect(this, 'id-preview')">
                        <div id="id-preview" class="file-preview"><i data-lucide="check" style="width: 1rem; height: 1rem;"></i> <span>File Selected</span></div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Profile Picture</label>
                    <div class="upload-field" id="profile-upload-field">
                        <i data-lucide="camera" style="width: 2rem; height: 2rem; color: #94a3b8; margin-bottom: 0.5rem;"></i>
                        <div class="upload-text"><strong>Upload Photo</strong> (Headshot)</div>
                        <div class="upload-text" style="font-size: 0.75rem;">JPG, PNG (Square preferred)</div>
                        <input type="file" name="profile_image" onchange="handleFileSelect(this, 'profile-preview')">
                        <div id="profile-preview" class="file-preview"><i data-lucide="check" style="width: 1rem; height: 1rem;"></i> <span>File Selected</span></div>
                    </div>
                </div>
            </div>

            <!-- Terms & Conditions Section -->
            <div class="section-title" style="margin-top: 2rem;">
                <i data-lucide="file-text" style="width: 1.25rem; height: 1.25rem;"></i>
                Terms & Conditions
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem;">
                <div style="max-height: 200px; overflow-y: auto; padding-right: 10px; margin-bottom: 1rem;">
                    <h4 style="color: #1e293b; font-size: 0.95rem; margin-top: 0;">IMARKETPH Admin Portal - Terms of Service</h4>
                    <p style="font-size: 0.85rem; color: #475569; line-height: 1.6; margin-bottom: 0.75rem;">
                        <strong>1. Account Responsibility:</strong> You are responsible for maintaining the confidentiality of your admin credentials and for all activities that occur under your account.
                    </p>
                    <p style="font-size: 0.85rem; color: #475569; line-height: 1.6; margin-bottom: 0.75rem;">
                        <strong>2. Data Protection:</strong> All customer and business data must be handled in accordance with the Data Privacy Act of 2012 (RA 10173). Unauthorized disclosure is strictly prohibited.
                    </p>
                    <p style="font-size: 0.85rem; color: #475569; line-height: 1.6; margin-bottom: 0.75rem;">
                        <strong>3. System Integrity:</strong> You agree not to attempt to gain unauthorized access to any portion of the system or engage in any activity that disrupts or interferes with the platform's performance.
                    </p>
                    <p style="font-size: 0.85rem; color: #475569; line-height: 1.6; margin-bottom: 0.75rem;">
                        <strong>4. Acceptable Use:</strong> The admin portal is provided for legitimate business operations only. Any misuse, including but not limited to data theft, sabotage, or fraudulent activities, will result in immediate account termination and legal action.
                    </p>
                    <p style="font-size: 0.85rem; color: #475569; line-height: 1.6; margin-bottom: 0.75rem;">
                        <strong>5. Limitation of Liability:</strong> IMARKETPH is not liable for any damages or losses resulting from unauthorized access to your account due to negligence in safeguarding your credentials.
                    </p>
                    <p style="font-size: 0.85rem; color: #475569; line-height: 1.6; margin-bottom: 0;">
                        <strong>6. Termination:</strong> IMARKETPH reserves the right to suspend or terminate your access at any time if you violate these Terms or engage in conduct that may harm the platform or its users.
                    </p>
                </div>

                <label style="display: flex; align-items: start; gap: 0.75rem; cursor: pointer; padding: 0.75rem; background: white; border-radius: 8px; border: 2px solid #e2e8f0; transition: all 0.2s;">
                    <input type="checkbox" name="accept_terms" id="accept_terms" required 
                        style="width: 1.25rem; height: 1.25rem; cursor: pointer; margin-top: 2px; accent-color: #2a3b7e;">
                    <span style="font-size: 0.875rem; color: #334155; line-height: 1.5;">
                        I have read and agree to the <strong style="color: #2a3b7e;">Terms & Conditions</strong> and acknowledge that I will handle all platform data responsibly and in compliance with applicable laws.
                    </span>
                </label>
            </div>

            <p style="font-size: 0.8125rem; color: #94a3b8; margin: 1rem 0; text-align: center;">
                <i data-lucide="shield-check" style="width: 1rem; height: 1rem; display: inline-block; vertical-align: middle;"></i>
                Email verification (OTP) will be sent immediately after registration.
            </p>

            <button type="submit" id="submit-btn" class="btn-base btn-primary" style="height: 3.5rem; font-size: 1rem; border-radius: 12px; margin-top: 1rem; background: #2a3b7e; width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                <i data-lucide="user-plus" style="width: 1.25rem; height: 1.25rem;"></i>
                Initialize Admin Registration
            </button>
        </form>

        <p class="switch-link" style="margin-top: 2rem; color: #64748b;">
            Already managed an account? <a href="login.php" style="color: #4f46e5; border-bottom: 2px solid rgba(79, 70, 229, 0.1);">Log In Here</a>
        </p>
    </div>

    <script>
        lucide.createIcons();

        function handleFileSelect(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const span = preview.querySelector('span');
                span.textContent = fileName.length > 20 ? fileName.substring(0, 17) + '...' : fileName;
                preview.style.display = 'flex';
                lucide.createIcons();
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</body>

</html>