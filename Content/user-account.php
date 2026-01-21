<?php
session_start();
include("../Database/config.php");

// 1. Check Login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../php/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";

// Ensure columns exist (Self-healing DB for this feature)
if (isset($conn)) {
    $cols_check = mysqli_query($conn, "SHOW COLUMNS FROM users LIKE 'address'");
    if (mysqli_num_rows($cols_check) == 0) {
        // Add missing columns if they don't exist
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN fullname VARCHAR(255) AFTER username");
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN phone VARCHAR(50) AFTER fullname");
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN address TEXT AFTER phone");
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN city VARCHAR(100) AFTER address");
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN zip VARCHAR(20) AFTER city");
    }
}

// 2. Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $zip = mysqli_real_escape_string($conn, $_POST['zip']);

    $update_sql = "UPDATE users SET fullname='$fullname', phone='$phone', address='$address', city='$city', zip='$zip' WHERE id='$user_id'";

    if (mysqli_query($conn, $update_sql)) {
        $msg = "<div class='alert-success'>Profile updated successfully!</div>";
    } else {
        $msg = "<div class='alert-error'>Error updating profile: " . mysqli_error($conn) . "</div>";
    }
}

// 3. Fetch Data
$sql = "SELECT * FROM users WHERE id='$user_id'";
$res = mysqli_query($conn, $sql);
$u = mysqli_fetch_assoc($res);

// Defaults
$fname = $u['fullname'] ?? '';
$uphone = $u['phone'] ?? '';
$uaddr = $u['address'] ?? '';
$ucity = $u['city'] ?? '';
$uzip = $u['zip'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY ACCOUNT | IMARKET PH</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .account-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .form-card {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .form-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
            /* Important for padding */
        }

        .form-control:focus {
            border-color: #0f8392ff;
            outline: none;
        }

        .btn-save {
            background-color: #0f8392ff;
            color: #fff;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-save:hover {
            background-color: #0a6572;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }
    </style>
</head>

<body>
    <nav>
        <?php
        $path_prefix = '../';
        include $path_prefix . 'components/header.php';
        ?>
    </nav>

    <div class="account-container">
        <div class="form-card">
            <?php echo $msg; ?>

            <div class="form-title">My Account Settings</div>

            <div style="margin-bottom:20px; color:#666; font-size:14px;">
                Manage your shipping information and profile details.
            </div>

            <!-- Preserve return params after submission -->
            <?php
            $return_data = isset($_GET['return_data']) ? $_GET['return_data'] : '';
            $action_url = "";
            if ($return_data) {
                $action_url = "?return_data=" . htmlspecialchars($return_data);
            }
            ?>
            <form action="<?php echo $action_url; ?>" method="POST">

                <!-- (Form fields remain the same) -->
                <div class="form-row">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="fullname" class="form-control"
                            value="<?php echo htmlspecialchars($fname); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" class="form-control"
                            value="<?php echo htmlspecialchars($uphone); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Default Shipping Address</label>
                    <textarea name="address" class="form-control" rows="3"
                        required><?php echo htmlspecialchars($uaddr); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" class="form-control"
                            value="<?php echo htmlspecialchars($ucity); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Postal Code</label>
                        <input type="text" name="zip" class="form-control"
                            value="<?php echo htmlspecialchars($uzip); ?>" required>
                    </div>
                </div>

                <div style="margin-top:20px;">
                    <button type="submit" class="btn-save">Save Changes</button>
                    <?php if ($return_data): ?>
                        <a href="buy-now.php?<?php echo base64_decode($return_data); ?>"
                            style="margin-left:15px; text-decoration:none; color:#0f8392ff; font-weight:600;">&larr; Return
                            to Checkout</a>
                    <?php else: ?>
                        <a href="../Shop-now/index.php" style="margin-left:15px; text-decoration:none; color:#777;">Back to
                            Shopping</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <?php
        include $path_prefix . 'components/footer.php';
        ?>
    </footer>
</body>

</html>


