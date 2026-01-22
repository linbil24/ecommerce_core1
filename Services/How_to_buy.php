<?php
session_start();
include("../Database/config.php");

// Fetch Buying Steps
$steps = [];
$check_table = mysqli_query($conn, "SHOW TABLES LIKE 'buying_steps'");
if (mysqli_num_rows($check_table) > 0) {
    $sql = "SELECT * FROM buying_steps ORDER BY step_order ASC";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $steps = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
} else {
    // Fallback data
    $steps = [
        ['step_order' => 1, 'title' => 'Search & Select', 'description' => 'Browse our wide range of products using the search bar or categories.', 'icon_class' => 'fas fa-search'],
        ['step_order' => 2, 'title' => 'Add to Cart', 'description' => 'Select your preferred variation and quantity, then click "Add to Cart".', 'icon_class' => 'fas fa-cart-plus'],
        ['step_order' => 3, 'title' => 'Checkout', 'description' => 'Review your cart and proceed to checkout.', 'icon_class' => 'fas fa-shopping-bag'],
        ['step_order' => 4, 'title' => 'Place Order', 'description' => 'Enter shipping details and confirm your purchase.', 'icon_class' => 'fas fa-check-circle']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How to Buy | IMARKET PH</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/services/how_to_buy.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <nav>
        <?php
        $path_prefix = '../';
        include '../Components/header.php';
        ?>
    </nav>

    <div class="buy-container">
        <!-- Sidebar Navigation -->
        <div class="service-sidebar">
            <h3>Customer Service</h3>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="Customer_Service.php?tab=faq"><i class="fas fa-question-circle"></i> FAQs</a></li>
                    <li><a href="Customer_Service.php?tab=submit"><i class="fas fa-edit"></i> Submit Ticket</a></li>
                    <li><a href="Customer_Service.php?tab=history"><i class="fas fa-history"></i> My Tickets</a></li>
                    <li><a href="Return & Refund.php"><i class="fas fa-undo-alt"></i> Return & Refund</a></li>
                    <li><a href="Shipping & Delivery.php"><i class="fas fa-shipping-fast"></i> Shipping & Delivery</a>
                    </li>
                    <li><a href="How_to_buy.php" class="active"><i class="fas fa-shopping-cart"></i> How to Buy</a></li>
                    <li><a href="Contact Us.php"><i class="fas fa-envelope"></i> Contact Us</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="buy-content">
            <div class="section-header">
                <h2>How to Shop in 5 Easy Steps</h2>
                <p>New to ImarketPH? Here's a quick guide to help you place your first order.</p>
            </div>

            <div class="timeline">
                <?php foreach ($steps as $index => $step): ?>
                    <div class="step-container <?php echo ($index % 2 == 0) ? 'left' : 'right'; ?>">
                        <div class="step-content">
                            <div class="step-number"><?php echo $step['step_order']; ?></div>
                            <div class="step-icon">
                                <i class="<?php echo htmlspecialchars($step['icon_class']); ?>"></i>
                            </div>
                            <div class="step-title"><?php echo htmlspecialchars($step['title']); ?></div>
                            <div class="step-desc"><?php echo htmlspecialchars($step['description']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cta-section">
                <h3>Ready to start shopping?</h3>
                <p>Explore thousands of products at the best prices.</p>
                <a href="../Content/Dashboard.php" class="btn-shop">Start Shopping Now <i
                        class="fas fa-arrow-right"></i></a>
            </div>

        </div>
    </div>

    <footer>
        <?php include '../Components/footer.php'; ?>
    </footer>
</body>

</html>
