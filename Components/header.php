<?php
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}
if (!isset($path_prefix)) {
    $path_prefix = '../';
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="<?php echo $path_prefix; ?>Css/Components/header.css">

<header class="header">
    <div class="header-container">
        <!-- Left Section: Logo & Nav -->
        <div class="header-left">
            <a href="<?php echo $path_prefix; ?>Content/Dashboard.php" class="logo-link">
                <img src="<?php echo $path_prefix; ?>Image/logo.png" alt="Imarket Logo" class="logo-img">
                <span class="logo-text">IMARKET</span>
            </a>

            <nav class="header-nav">
                <a href="<?php echo $path_prefix; ?>Content/Dashboard.php" class="nav-item active"><i
                        class="fas fa-home"></i>
                    Home</a>
                <a href="#" class="nav-item"><i class="fas fa-store"></i> Mall</a>
                <a href="#" class="nav-item"><i class="fas fa-percent"></i> Flash Deals</a>
                <div class="nav-item dropdown">
                    <a href="#" class="dropdown-toggle"><i class="fas fa-list"></i> Categories <i
                            class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $path_prefix; ?>Categories/Best-selling/index.php"><i
                                    class="fas fa-fire"></i> Best Selling</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/New-arrivals/index.php"><i
                                    class="fas fa-star"></i> New Arrivals</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/Electronics/index.php"><i
                                    class="fas fa-desktop"></i> Electronics</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/Fashion & Apparel/index.php"><i
                                    class="fas fa-tshirt"></i> Fashion & Apparel</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/Home-living/index.php"><i
                                    class="fas fa-home"></i>
                                Home & Living</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/Beauty & Health/index.php"><i
                                    class="fas fa-heart"></i> Beauty & Health</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/Sports & outdoor/index.php"><i
                                    class="fas fa-football-ball"></i> Sports & Outdoor</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/Toys & Games/index.php"><i
                                    class="fas fa-gamepad"></i> Toys & Games</a></li>
                        <li><a href="<?php echo $path_prefix; ?>Categories/Groceries/index.php"><i
                                    class="fas fa-shopping-basket"></i> Groceries</a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Center Section: Search -->
        <div class="header-center">
            <div class="search-container">
                <input type="text" placeholder="Search for products, brands and more..." class="search-input">
                <button class="search-btn"><i class="fas fa-search"></i></button>
            </div>
        </div>

        <!-- Right Section: Icons -->
        <div class="header-right">
            <a href="<?php echo $path_prefix; ?>Content/Check-out.php" class="header-icon"><i
                    class="fas fa-shopping-cart"></i></a>

            <?php if (isset($_SESSION['user_name'])): ?>
                <div class="user-profile-container">
                    <div class="user-avatar-circle">
                        <i class="far fa-user"></i>
                    </div>
                    <span class="user-display-name">
                        <?php
                        $name = $_SESSION['user_name'];
                        echo htmlspecialchars(strlen($name) > 10 ? substr($name, 0, 10) . '...' : $name);
                        ?>
                    </span>
                    <div class="user-dropdown-toggle">
                        <i class="fas fa-chevron-down"></i>
                        <ul class="user-dropdown-menu"> <!-- Moved inside toggle for hover/click or adjacent -->
                            <li><a href="<?php echo $path_prefix; ?>Content/user-account.php"><i class="fas fa-user"></i>
                                    My Profile</a></li>
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
        const userMenu = document.querySelector('.user-dropdown-menu');

        if (userToggle && userMenu) {
            // Toggle only when clicking the arrow/container directly, NOT children inside the menu
            userToggle.addEventListener('click', function (e) {
                // If the click is inside the menu (e.g. a link), let it function normally and don't toggle
                if (userMenu.contains(e.target)) {
                    return;
                }

                e.preventDefault();
                e.stopPropagation();
                userMenu.classList.toggle('show');
                // Close other dropdown if open
                if (dropdownMenu && dropdownMenu.classList.contains('show')) dropdownMenu.classList.remove('show');
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function (e) {
            // Check for Categories Dropdown
            if (dropdownToggle && dropdownMenu) {
                if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                }
            }

            // Check for User Dropdown
            // Note: Since userMenu is strictly INSIDE userToggle in HTML, userToggle.contains includes userMenu.
            // But we need to close if clicking OUTSIDE the toggle entirely.
            if (userToggle && userMenu) {
                if (!userToggle.contains(e.target)) {
                    userMenu.classList.remove('show');
                }
            }
        });
    });
</script>