<?php
session_start();
include("../Database/config.php");

// 1. Auth Check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../php/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";
$view = isset($_GET['view']) ? $_GET['view'] : 'profile'; // profile, orders, tracking

// ---------------------------------------------------------
// SELF-HEALING DB: Ensure 'users' table has profile columns
// ---------------------------------------------------------
if (isset($conn)) {
    // Check for 'address' column as a proxy for the update
    $cols_check = mysqli_query($conn, "SHOW COLUMNS FROM users LIKE 'address'");
    if (mysqli_num_rows($cols_check) == 0) {
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN fullname VARCHAR(255) AFTER email");
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN phone VARCHAR(50) AFTER fullname");
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN address TEXT AFTER phone");
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN city VARCHAR(100) AFTER address");
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN zip VARCHAR(20) AFTER city");
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN gender VARCHAR(20) DEFAULT 'Not Specified'");
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN birthdate DATE NULL");
    }

    // Check for 'gender' specifically if added later
    $gender_check = mysqli_query($conn, "SHOW COLUMNS FROM users LIKE 'gender'");
    if (mysqli_num_rows($gender_check) == 0) {
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN gender VARCHAR(20) DEFAULT 'Not Specified'");
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN birthdate DATE NULL");
    }
}

// ---------------------------------------------------------
// HANDLE FORM SUBMISSIONS (Profile Update)
// ---------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_profile') {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $zip = mysqli_real_escape_string($conn, $_POST['zip']);
    // Optional fields
    $gender = isset($_POST['gender']) ? mysqli_real_escape_string($conn, $_POST['gender']) : '';
    $birthdate = isset($_POST['birthdate']) ? mysqli_real_escape_string($conn, $_POST['birthdate']) : NULL;
    $bd_sql_part = $birthdate ? ", birthdate='$birthdate'" : "";

    $update_sql = "UPDATE users SET fullname='$fullname', phone='$phone', address='$address', city='$city', zip='$zip', gender='$gender' $bd_sql_part WHERE id='$user_id'";

    if (mysqli_query($conn, $update_sql)) {
        $msg = "<div class='alert-success'><i class='fas fa-check-circle'></i> Profile updated successfully!</div>";
    } else {
        $msg = "<div class='alert-error'>Error updating profile: " . mysqli_error($conn) . "</div>";
    }
}

// ---------------------------------------------------------
// FETCH USER DATA
// ---------------------------------------------------------
$sql = "SELECT * FROM users WHERE id='$user_id'";
$res = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($res);

// ---------------------------------------------------------
// FETCH ORDERS (If view is orders or tracking)
// ---------------------------------------------------------
$my_orders = [];
if ($view == 'orders' || $view == 'tracking') {
    // Ensure table exists (in case Payment.php wasn't run yet)
    $check_orders = mysqli_query($conn, "SHOW TABLES LIKE 'orders'");
    if (mysqli_num_rows($check_orders) > 0) {
        $order_sql = "SELECT * FROM orders WHERE user_id='$user_id' ORDER BY created_at DESC";
        $order_res = mysqli_query($conn, $order_sql);
        while ($r = mysqli_fetch_assoc($order_res)) {
            $my_orders[] = $r;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | IMARKET PH</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/components/user-account.css?v=<?php echo time(); ?>">

    <style>
        /* Inline overrides if needed */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <nav>
        <?php
        $path_prefix = '../';
        include('../Components/header.php');
        ?>
    </nav>

    <div class="user-account-wrapper">

        <!-- SIDEBAR -->
        <aside class="account-sidebar">
            <div class="sidebar-profile">
                <div class="sidebar-avatar"></div>
                <div>
                    <div class="sidebar-username">
                        <?php echo htmlspecialchars(!empty($user['username']) ? $user['username'] : (!empty($user['fullname']) ? $user['fullname'] : $user['email'])); ?>
                    </div>
                    <a href="?view=profile" class="sidebar-edit-link"><i class="fas fa-pen"></i> Edit Profile</a>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="?view=profile" class="sidebar-menu-title">
                        <i class="fas fa-user"></i> My Account
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="?view=profile"
                                class="<?php echo $view == 'profile' ? 'active' : ''; ?>">Profile</a></li>
                        <li><a href="#">Banks & Cards</a></li>
                        <li><a href="#">Addresses</a></li>
                        <li><a href="#">Change Password</a></li>
                    </ul>
                </li>
                <li class="sidebar-menu-item">
                    <a href="?view=orders" class="sidebar-menu-title">
                        <i class="fas fa-clipboard-list"></i> My Purchase
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-title">
                        <i class="fas fa-bell"></i> Notifications
                    </a>
                </li>
            </ul>

            <!-- SELLER CENTRE BUTTON (Integration Point) -->
            <!-- Assuming Seller/Login.php or similar exists, or just a placeholder for Team 2 -->
            <a href="../Seller/index.php" class="seller-btn">
                <i class="fas fa-store"></i> Seller Centre
            </a>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="account-content">

            <!-- VIEW: PROFILE -->
            <?php if ($view == 'profile'): ?>
                <div class="content-header">
                    <div class="content-title">My Profile</div>
                    <div class="content-subtitle">Manage and protect your account</div>
                </div>

                <?php echo $msg; ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update_profile">

                    <div style="display: flex;">
                        <div style="flex: 1; padding-right: 40px;">

                            <div class="profile-input-group">
                                <div class="profile-input-label">Username</div>
                                <div class="profile-input-field" style="padding-top:10px;">
                                    <?php echo htmlspecialchars(!empty($user['username']) ? $user['username'] : (!empty($user['fullname']) ? $user['fullname'] : $user['email'])); ?>
                                </div>
                            </div>

                            <div class="profile-input-group">
                                <div class="profile-input-label">Name</div>
                                <div class="profile-input-field">
                                    <input type="text" name="fullname"
                                        value="<?php echo htmlspecialchars($user['fullname'] ?? ''); ?>" required>
                                </div>
                            </div>

                            <div class="profile-input-group">
                                <div class="profile-input-label">Phone Number</div>
                                <div class="profile-input-field">
                                    <input type="text" name="phone"
                                        value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="profile-input-group">
                                <div class="profile-input-label">Address</div>
                                <div class="profile-input-field">
                                    <textarea name="address"
                                        rows="2"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                                </div>
                            </div>

                            <div class="profile-input-group">
                                <div class="profile-input-label">City</div>
                                <div class="profile-input-field">
                                    <input type="text" name="city"
                                        value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="profile-input-group">
                                <div class="profile-input-label">Postal Code</div>
                                <div class="profile-input-field">
                                    <input type="text" name="zip"
                                        value="<?php echo htmlspecialchars($user['zip'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="profile-input-group">
                                <div class="profile-input-label">Gender</div>
                                <div class="profile-input-field"> <!-- Simple Radio or Select -->
                                    <?php $g = $user['gender'] ?? ''; ?>
                                    <select name="gender">
                                        <option value="" disabled <?php echo empty($g) ? 'selected' : ''; ?>>Select Gender
                                        </option>
                                        <option value="Male" <?php echo ($g == 'Male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?php echo ($g == 'Female') ? 'selected' : ''; ?>>Female
                                        </option>
                                        <option value="Other" <?php echo ($g == 'Other') ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="save-btn-container">
                                <button type="submit" class="btn-primary">Save</button>
                            </div>

                        </div>

                        <!-- Avatar Section (Visual Only for now) -->
                        <div
                            style="width: 280px; border-left: 1px solid #efefef; display: flex; flex-direction: column; align-items: center; justify-content: center; padding-left: 40px;">
                            <div
                                style="width: 100px; height: 100px; background: #eee; border-radius: 50%; margin-bottom: 20px; display:flex; align-items:center; justify-content:center; color:#ccc; font-size:40px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <button type="button" class="btn-outline">Select Image</button>
                            <div style="margin-top: 15px; font-size: 12px; color: #999; text-align: center;">
                                File size: maximum 1 MB<br>
                                File extension: .JPEG, .PNG
                            </div>
                        </div>
                    </div>
                </form>

                <!-- VIEW: ORDERS -->
            <?php elseif ($view == 'orders'): ?>

                <div class="order-tabs">
                    <a href="#" class="order-tab active">All</a>
                    <a href="#" class="order-tab">To Pay</a>
                    <a href="#" class="order-tab">To Ship</a>
                    <a href="#" class="order-tab">To Receive</a>
                    <a href="#" class="order-tab">Completed</a>
                    <a href="#" class="order-tab">Cancelled</a>
                </div>

                <!-- Search Bar for Orders -->
                <div style="background:#eaeaea; padding:10px; margin-bottom:20px; border-radius:2px;">
                    <i class="fas fa-search" style="color:#666; margin-left:10px;"></i>
                    <input type="text" placeholder="Search orders by Order ID or Product Name"
                        style="background:transparent; border:none; outline:none; padding:5px; width:90%;">
                </div>

                <?php if (empty($my_orders)): ?>
                    <div class="empty-state">
                        <img src="../image/no-orders.png" alt="" style="width:100px; opacity:0.5; margin-bottom:15px;">
                        <div>No orders yet</div>
                    </div>
                <?php else: ?>
                    <?php foreach ($my_orders as $order): ?>
                        <div class="order-card">
                            <div class="order-header">
                                <div class="shop-name">
                                    <i class="fas fa-store"></i> IMarket Shop <button class="btn-outline"
                                        style="padding:2px 8px; font-size:11px; margin-left:10px;">Chat</button>
                                </div>
                                <div class="order-status">
                                    <?php
                                    // Status Mapping
                                    echo htmlspecialchars($order['status']);
                                    if ($order['status'] == 'Pending')
                                        echo " | To Pay";
                                    ?>
                                </div>
                            </div>

                            <a href="?view=tracking&order_id=<?php echo $order['id']; ?>" style="text-decoration:none;">
                                <div class="order-items">
                                    <div class="order-item-row">
                                        <img src="<?php echo htmlspecialchars(!empty($order['image_url']) ? $order['image_url'] : '../image/imarket.png'); ?>"
                                            class="item-img" alt="Product">
                                        <div class="item-info">
                                            <div class="item-name"><?php echo htmlspecialchars($order['product_name']); ?></div>
                                            <div class="item-meta">Quantity: x<?php echo $order['quantity']; ?></div>
                                        </div>
                                        <div class="item-price">₱<?php echo number_format($order['price'], 2); ?></div>
                                    </div>
                                </div>
                            </a>

                            <div class="order-footer">
                                <div class="order-total-label">Order Total:</div>
                                <div class="order-total-price">₱<?php echo number_format($order['total_amount'], 2); ?></div>

                                <a href="?view=tracking&order_id=<?php echo $order['id']; ?>" class="btn-primary">Track Order</a>
                                <button class="btn-outline">Buy Again</button>
                                <button class="btn-outline">Contact Seller</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- VIEW: TRACKING -->
            <?php elseif ($view == 'tracking'):
                $track_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
                // Fetch specific order
                $curr_order = null;
                foreach ($my_orders as $o) {
                    if ($o['id'] == $track_id) {
                        $curr_order = $o;
                        break;
                    }
                }

                if (!$curr_order) {
                    echo "<div class='empty-state'>Order not found. <a href='?view=orders'>Back to orders</a></div>";
                } else {
                    $st = $curr_order['status']; // Pending, Paid, Shipped, Delivered
                    // Determine step active index
                    $step_idx = 1;
                    if (strcasecmp($st, 'Pending') == 0)
                        $step_idx = 1;
                    if (strcasecmp($st, 'Paid') == 0)
                        $step_idx = 2;
                    if (strcasecmp($st, 'Shipped') == 0)
                        $step_idx = 3;
                    if (strcasecmp($st, 'Delivered') == 0)
                        $step_idx = 4;
                    if (strcasecmp($st, 'Completed') == 0)
                        $step_idx = 5;
                    ?>
                    <div class="content-header">
                        <a href="?view=orders" style="text-decoration:none; color:#555; font-size:14px; margin-right:10px;"><i
                                class="fas fa-arrow-left"></i> Back</a>
                        <span class="content-title" style="font-size:18px;">Order Details |
                            <?php echo htmlspecialchars($curr_order['tracking_number']); ?></span>
                    </div>

                    <div class="tracking-container">

                        <div
                            style="background:#fffcf5; border:1px solid #ffeedb; padding:15px; margin-bottom:30px; border-radius:4px; display:flex; justify-content:space-between;">
                            <div>
                                <div style="font-size:16px; color:#2A3B7E; font-weight:500;">Order Status:
                                    <?php echo htmlspecialchars($st); ?>
                                </div>
                                <div style="font-size:13px; color:#777; margin-top:5px;">Estimated Delivery: 3-5 days</div>
                            </div>
                        </div>

                        <!-- STEPPER -->
                        <div class="track-stepper">
                            <!-- Step 1 -->
                            <div class="track-step <?php echo ($step_idx >= 1) ? 'active' : ''; ?>">
                                <div class="step-icon"><i class="fas fa-file-invoice"></i></div>
                                <div class="step-label">Order Placed</div>
                                <div class="track-time"><?php echo date('M d H:i', strtotime($curr_order['created_at'])); ?>
                                </div>
                            </div>
                            <!-- Step 2 -->
                            <div class="track-step <?php echo ($step_idx >= 2) ? 'active' : ''; ?>">
                                <div class="step-icon"><i class="fas fa-money-bill-wave"></i></div>
                                <div class="step-label">Paid</div>
                                <?php if ($step_idx >= 2): ?>
                                    <div class="track-time">
                                        <?php echo date('M d H:i', strtotime($curr_order['created_at'] . ' + 1 hour')); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Step 3 -->
                            <div class="track-step <?php echo ($step_idx >= 3) ? 'active' : ''; ?>">
                                <div class="step-icon"><i class="fas fa-box-open"></i></div>
                                <div class="step-label">Shipped Out</div>
                                <?php if ($step_idx >= 3): ?>
                                    <div class="track-time">
                                        <?php echo date('M d H:i', strtotime($curr_order['created_at'] . ' + 1 day')); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Step 4 -->
                            <div class="track-step <?php echo ($step_idx >= 4) ? 'active' : ''; ?>">
                                <div class="step-icon"><i class="fas fa-shipping-fast"></i></div>
                                <div class="step-label">To Receive</div>
                            </div>
                            <!-- Step 5 -->
                            <div class="track-step <?php echo ($step_idx >= 5) ? 'active' : ''; ?>">
                                <div class="step-icon"><i class="fas fa-star"></i></div>
                                <div class="step-label">Completed</div>
                            </div>
                        </div>

                        <!-- Detailed Timeline -->
                        <div style="margin-top:40px;">
                            <div style="font-weight:500; color:#333; margin-bottom:15px;">Tracking History</div>
                            <div
                                style="border-left:2px solid #e0e0e0; margin-left:15px; padding-left:25px; padding-bottom:20px; position:relative;">
                                <div
                                    style="position:absolute; left:-6px; top:0; width:10px; height:10px; background:#2A3B7E; border-radius:50%;">
                                </div>
                                <div style="font-size:14px; color:#333;">Your order is being processed by the seller.</div>
                                <div style="font-size:12px; color:#999; margin-top:2px;">
                                    <?php echo date('Y-m-d H:i', strtotime($curr_order['created_at'])); ?>
                                </div>
                            </div>
                            <?php if ($step_idx >= 2): ?>
                                <div
                                    style="border-left:2px solid #e0e0e0; margin-left:15px; padding-left:25px; padding-bottom:20px; position:relative;">
                                    <div
                                        style="position:absolute; left:-6px; top:0; width:10px; height:10px; background:#ccc; border-radius:50%;">
                                    </div>
                                    <div style="font-size:14px; color:#333;">Payment confirmed.</div>
                                    <div style="font-size:12px; color:#999; margin-top:2px;">...</div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Order Items Small View -->
                        <div style="margin-top:30px; border-top:1px solid #eee; padding-top:20px;">
                            <div style="font-weight:500; margin-bottom:10px;">Product Info</div>
                            <div style="display:flex; gap:15px;">
                                <img src="<?php echo htmlspecialchars(!empty($curr_order['image_url']) ? $curr_order['image_url'] : '../image/imarket.png'); ?>"
                                    style="width:60px; height:60px; border:1px solid #eee;">
                                <div>
                                    <div style="font-size:14px; font-weight:600;">
                                        <?php echo htmlspecialchars($curr_order['product_name']); ?>
                                    </div>
                                    <div style="font-size:13px; color:#777;">Quantity: x<?php echo $curr_order['quantity']; ?>
                                    </div>
                                    <div style="font-size:14px; color:#2A3B7E;">
                                        ₱<?php echo number_format($curr_order['total_amount'], 2); ?></div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php
                } // End if/else for curr_order
            endif;
            ?>

        </main>
    </div>

</body>

</html>