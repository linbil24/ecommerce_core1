<?php
session_start();
include("../Database/config.php");

// Fetch Shipping Zones from Database
$zones = [];
// Check table existence first to handle fresh installs
$check_table = mysqli_query($conn, "SHOW TABLES LIKE 'shipping_zones'");
if (mysqli_num_rows($check_table) > 0) {
    $sql = "SELECT * FROM shipping_zones ORDER BY base_fee ASC";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $zones = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
} else {
    // Fallback data if table doesn't exist yet
    $zones = [
        ['region_name' => 'Metro Manila', 'base_fee' => 60, 'estimated_days_min' => 2, 'estimated_days_max' => 3],
        ['region_name' => 'Luzon (Provincial)', 'base_fee' => 120, 'estimated_days_min' => 3, 'estimated_days_max' => 7],
        ['region_name' => 'Visayas', 'base_fee' => 160, 'estimated_days_min' => 5, 'estimated_days_max' => 10],
        ['region_name' => 'Mindanao', 'base_fee' => 180, 'estimated_days_min' => 7, 'estimated_days_max' => 14]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping & Delivery | IMARKET PH</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/services/shipping_delivery.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <nav>
        <?php
        $path_prefix = '../';
        include '../Components/header.php';
        ?>
    </nav>

    <div class="shipping-container">
        <!-- Sidebar Navigation -->
        <div class="service-sidebar">
            <h3>Customer Service</h3>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="Customer_Service.php?tab=faq"><i class="fas fa-question-circle"></i> FAQs</a></li>
                    <li><a href="Customer_Service.php?tab=submit"><i class="fas fa-edit"></i> Submit Ticket</a></li>
                    <li><a href="Customer_Service.php?tab=history"><i class="fas fa-history"></i> My Tickets</a></li>
                    <li><a href="Return & Refund.php"><i class="fas fa-undo-alt"></i> Return & Refund</a></li>
                    <li><a href="Shipping & Delivery.php" class="active"><i class="fas fa-shipping-fast"></i> Shipping &
                            Delivery</a></li>
                    <li><a href="Contact Us.php"><i class="fas fa-envelope"></i> Contact Us</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="shipping-content">
            <div class="section-header">
                <h2>Shipping & Delivery Information</h2>
                <p>We deliver nationwide! Check our shipping rates and estimated delivery times below.</p>
            </div>

            <div class="shipping-grid">
                <?php foreach ($zones as $zone): ?>
                    <div class="shipping-card">
                        <div class="shipping-icon">
                            <?php
                            if (stripos($zone['region_name'], 'Manila') !== false) {
                                echo '<i class="fas fa-city"></i>';
                            } elseif (stripos($zone['region_name'], 'Island') !== false) {
                                echo '<i class="fas fa-umbrella-beach"></i>';
                            } else {
                                echo '<i class="fas fa-truck"></i>';
                            }
                            ?>
                        </div>
                        <h3 class="region-name"><?php echo htmlspecialchars($zone['region_name']); ?></h3>
                        <div class="shipping-details">
                            <div class="fee">₱<?php echo number_format($zone['base_fee'], 2); ?></div>
                            <div class="time">
                                <i class="far fa-clock"></i>
                                <?php echo $zone['estimated_days_min'] . ' - ' . $zone['estimated_days_max']; ?> Days
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="info-section">
                <h3>Additional Information</h3>
                <div class="info-grid">
                    <div class="info-box">
                        <h4><i class="fas fa-box-open"></i> Order Processing</h4>
                        <p>Orders are processed within 24 hours of payment confirmation. Orders placed on weekends or
                            holidays will be processed on the next business day.</p>
                    </div>
                    <div class="info-box">
                        <h4><i class="fas fa-map-marker-alt"></i> Tracking Your Order</h4>
                        <p>Once your order is shipped, you will receive a tracking number via email. You can also track
                            your order status in your <a href="Customer_Service.php?tab=history">My Tickets</a> or Order
                            History page.</p>
                    </div>
                    <div class="info-box">
                        <h4><i class="fas fa-exclamation-triangle"></i> Remote Areas</h4>
                        <p>Deliveries to remote areas or island territories may take an additional 3-5 business days
                            depending on courier accessibility.</p>
                    </div>
                    <div class="info-box">
                        <h4><i class="fas fa-handshake"></i> Courier Partners</h4>
                        <p>We partner with trusted couriers like J&T Express, Ninja Van, and LBC to ensure your package
                            arrives safely.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer>
        <?php include '../Components/footer.php'; ?>
    </footer>
</body>

</html>



