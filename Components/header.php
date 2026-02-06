<?php
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}

// SECURITY: Global Headers (The Invisible Shield)
// Only send if headers haven't been sent yet
if (!headers_sent()) {
    header("X-Frame-Options: DENY");
    header("X-XSS-Protection: 1; mode=block");
    header("X-Content-Type-Options: nosniff");
}

// SECURITY: Session Timeout (The Stopwatch)
// Only applies if user is logged in
if (isset($_SESSION['user_id'])) {
    $timeout_duration = 1800; // 30 minutes
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
        session_unset();
        session_destroy();

        // Redirect to login with timeout message
        // Use path_prefix if available, else default to relative
        $redirect_path = (isset($path_prefix) ? $path_prefix : '../') . 'php/login.php?timeout=1';

        if (!headers_sent()) {
            header("Location: " . $redirect_path);
        } else {
            // Fallback for when headers are already sent (e.g. inside body)
            echo "<script>window.location.href='" . $redirect_path . "';</script>";
        }
        exit();
    }
    $_SESSION['last_activity'] = time(); // Reset timer
}

if (!isset($path_prefix)) {
    $path_prefix = '../';
}

// Fetch notification count for unread support tickets
$unread_tickets_count = 0;
if (isset($_SESSION['user_id'])) {
    // We need a database connection. If $conn isn't set, try to include config.php
    if (!isset($conn)) {
        include_once $path_prefix . 'Database/config.php';
    }

    if (isset($conn)) {
        $u_id = $_SESSION['user_id'];
        $n_sql = "SELECT COUNT(*) as unread FROM support_tickets WHERE customer_id = '$u_id' AND is_read = 0";
        $n_result = mysqli_query($conn, $n_sql);
        if ($n_result) {
            $n_row = mysqli_fetch_assoc($n_result);
            $unread_tickets_count = $n_row['unread'];
        }
    }
}
?>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- Core Component Styles -->
<link rel="stylesheet" href="<?php echo $path_prefix; ?>css/components/header.css?v=<?php echo time(); ?>">

<header class="header">
    <div class="header-container">
        <!-- Left Section: Logo & Nav -->
        <div class="header-left">
            <a href="<?php echo $path_prefix; ?>Content/Dashboard.php" class="logo-link">
                <img src="<?php echo $path_prefix; ?>image/logo.png?v=3.5" alt="Imarket Logo" class="logo-img">
                <span class="logo-text">IMARKET</span>
            </a>

            <nav class="header-nav">
                <a href="<?php echo $path_prefix; ?>Content/Dashboard.php" class="nav-item active"><i
                        class="fas fa-home"></i>
                    Home</a>
                <a href="<?php echo $path_prefix; ?>Shop/index.php" class="nav-item"><i class="fas fa-store"></i> Mall</a>
                <a href="<?php echo $path_prefix; ?>Categories/best-selling/index.php" class="nav-item"><i class="fas fa-percent"></i> Flash Deals</a>
                <div class="nav-item dropdown">
                    <a href="#" class="dropdown-toggle"><i class="fas fa-list"></i> Categories <i
                            class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $path_prefix; ?>Categories/best-selling/index.php"><i
                                    class="fas fa-fire"></i> Best Selling</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/new-arrivals/index.php"><i
                                    class="fas fa-star"></i> New Arrivals</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/electronics/index.php"><i
                                    class="fas fa-desktop"></i> Electronics</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/fashion-apparel/index.php"><i
                                    class="fas fa-tshirt"></i> Fashion & Apparel</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/home-living/index.php"><i
                                    class="fas fa-home"></i> Home & Living</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/beauty-health/index.php"><i
                                    class="fas fa-heart"></i> Beauty & Health</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/sports-outdoor/index.php"><i
                                    class="fas fa-football-ball"></i> Sports & Outdoor</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/toys-games/index.php"><i
                                    class="fas fa-gamepad"></i> Toys & Games</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/groceries/index.php"><i
                                    class="fas fa-shopping-basket"></i> Groceries</a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Center Section: Search -->
        <div class="header-center">
            <?php include $path_prefix . 'Search-bar.php'; ?>
        </div>

        <!-- Right Section: Icons -->
        <div class="header-right">
            <a href="<?php echo $path_prefix; ?>Content/Check-out.php" class="header-icon"><i
                    class="fas fa-shopping-cart"></i></a>

            <?php if (isset($_SESSION['user_name'])): ?>
                <div class="user-profile-container">
                    <div class="user-avatar-circle">
                        <i class="far fa-user"></i>
                        <?php if ($unread_tickets_count > 0): ?>
                            <span class="notification-badge"><?php echo $unread_tickets_count; ?></span>
                        <?php endif; ?>
                    </div>
                    <span class="user-display-name">
                        <?php
                        $name = $_SESSION['user_name'];
                        echo htmlspecialchars(strlen($name) > 10 ? substr($name, 0, 10) . '...' : $name);
                        ?>
                    </span>
                    <div class="user-dropdown-toggle">
                        <i class="fas fa-chevron-down"></i>
                        <ul class="user-dropdown-menu">
                            <li><a href="<?php echo $path_prefix; ?>Content/user-account.php"><i class="fas fa-user"></i>
                                    My Profile</a></li>
                            <li><a href="<?php echo $path_prefix; ?>Services/Customer_Service.php?tab=history"><i
                                        class="fas fa-ticket-alt"></i>
                                    Support Tickets <?php if ($unread_tickets_count > 0): ?><span
                                            class="badge-mini"><?php echo $unread_tickets_count; ?></span><?php endif; ?></a>
                            </li>
                            <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                            <li><a href="<?php echo $path_prefix; ?>php/logout.php"><i class="fas fa-sign-out-alt"></i>
                                    Logout</a></li>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?php echo $path_prefix; ?>php/login.php" class="header-icon"><i class="far fa-user"></i></a>
            <?php endif; ?>
        </div>
    </div>

</header>

<!-- AI Features Logic & Modal (Moved from Floating Buttons) -->
<link rel="stylesheet" href="<?php echo $path_prefix; ?>css/components/ai-features.css">
<div id="ai-modal-overlay" class="ai-modal-overlay">
    <div id="ai-modal-content-inject" class="ai-modal-content"></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet"></script>
<script src="<?php echo $path_prefix; ?>javascript/ai-features.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Categories Dropdown
        const dropdownToggle = document.querySelector('.dropdown-toggle');
        const dropdownMenu = document.querySelector('.dropdown-menu');

        if (dropdownToggle && dropdownMenu) {
            dropdownToggle.addEventListener('click', function (e) {
                e.preventDefault();
                dropdownMenu.classList.toggle('show');
                // Close other dropdown if open
                if (userMenu && userMenu.classList.contains('show')) userMenu.classList.remove('show');
            });
        }

        // User Profile Dropdown
        const userToggle = document.querySelector('.user-dropdown-toggle');
        const userMenu = document.querySelector('.user-dropdown-menu'); // Note: 'userMenu' was not defined in previous scope properly if not grabbed

        if (userToggle && userMenu) {
            userToggle.addEventListener('click', function (e) {
                if (userMenu.contains(e.target)) {
                    return;
                }
                e.preventDefault();
                e.stopPropagation();
                userMenu.classList.toggle('show');
                if (dropdownMenu && dropdownMenu.classList.contains('show')) dropdownMenu.classList.remove('show');
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function (e) {
            if (dropdownToggle && dropdownMenu) {
                if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                }
            }
            if (userToggle && userMenu) {
                if (!userToggle.contains(e.target)) {
                    userMenu.classList.remove('show');
                }
            }
        });
    });
</script>