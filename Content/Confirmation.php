<?php
session_start();
include("../Database/config.php");

// Check if order_id is present
if (!isset($_GET['order_id'])) {
    header("Location: ../landing.php");
    exit();
}

$order_id = intval($_GET['order_id']);

// Fetch Order Details
$sql = "SELECT * FROM orders WHERE id = '$order_id'";
$result = mysqli_query($conn, $sql);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    echo "Order not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f7f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Rough centering, though full page layout preferred generally */
            min-height: 100vh;
            flex-direction: column;
        }

        /* Using the Header/Footer might be needed? User image implies a clean modal-like page or full page. 
           I'll include nav/footer for consistency but style the main content as the card. 
        */

        nav,
        footer {
            width: 100%;
        }

        .confirmation-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            width: 100%;
            box-sizing: border-box;
        }

        .confirmation-card {
            background: #fff;
            width: 100%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border-top: 5px solid #28a745;
            /* Green top border */
            text-align: center;
            padding: 2rem;
        }

        .success-icon {
            color: #28a745;
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        h1 {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 1.8rem;
        }

        .sub-text {
            color: #666;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .order-details-box {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 1.5rem;
            text-align: left;
        }

        .details-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 0.5rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .detail-label {
            color: #777;
            font-weight: 500;
        }

        .detail-value {
            color: #333;
            font-weight: 600;
            text-align: right;
            max-width: 60%;
        }

        .btn-home {
            display: inline-block;
            margin-top: 2rem;
            background-color: #2A3B7E;
            color: #fff;
            padding: 0.75rem 2rem;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .btn-home:hover {
            background-color: #1f2c5e;
        }

        .actions-row {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
            /* Handle mobile */
        }

        .btn-home,
        .btn-orders {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 2rem;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.2s;
            margin-top: 0;
            /* Override previous margin since handled by container gap */
        }

        /* Specific overrides */
        .btn-home {
            background-color: #2A3B7E;
            /* Confirmation darker blue */
            color: #fff;
        }

        .btn-orders {
            background-color: #fff;
            color: #333;
            border: 1px solid #ddd;
        }

        .btn-orders:hover {
            background-color: #f8f9fa;
            border-color: #bbb;
        }
    </style>
</head>

<body>

    <!-- Simple Nav wrapper to reuse header -->
    <nav>
        <?php
        $path_prefix = '../';
        include $path_prefix . 'Components/header.php';
        ?>
    </nav>

    <div class="confirmation-container">
        <div class="confirmation-card">
            <div class="success-icon"><i class="fas fa-check-circle"></i></div>

            <h1>Thank You for Your Purchase!</h1>
            <p class="sub-text">Your order has been successfully placed and is being processed.</p>

            <div class="order-details-box">
                <!-- Shop Header -->
                <div
                    style="display: flex; align-items: center; padding-bottom: 20px; border-bottom: 1px solid #e0e0e0; margin-bottom: 25px; gap: 15px;">
                    <img src="../image/logo.png" alt="Shop Logo"
                        style="width: 45px; height: 45px; object-fit: contain;">
                    <div>
                        <?php
                        // Determine header based on order's product (image or ID)
                        $is_best_selling_confirm = false;

                        // Check 1: Product ID (if stored in DB accurately)
                        $pid = isset($order['product_id']) ? intval($order['product_id']) : 0;
                        if ($pid >= 101 && $pid <= 112) {
                            $is_best_selling_confirm = true;
                        } else {
                            // Check 2: Image URL Keywords
                            $img_check = isset($order['image_url']) ? strtolower($order['image_url']) : '';
                            $best_selling_keywords = ['best-seller', 'best-selling', 'bag-', 'notebook', 'shoes', 'earphone', 'speaker'];
                            foreach ($best_selling_keywords as $kw) {
                                if (strpos($img_check, $kw) !== false) {
                                    $is_best_selling_confirm = true;
                                    break;
                                }
                            }
                        }
                        ?>

                        <?php if ($is_best_selling_confirm): ?>
                            <h4 style="margin: 0; font-size: 18px; color: #2A3B7E; font-weight: bold;">IMarket Best Selling
                            </h4>
                            <span style="font-size: 12px; color: #555;">Top Rated Products</span>
                        <?php else: ?>
                            <h4 style="margin: 0; font-size: 18px; color: #2A3B7E; font-weight: bold;">| UrbanWear PH</h4>
                            <span style="font-size: 12px; color: #555;">Streetwear & Casual Outfits</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="details-title">Order Details</div>

                <div class="detail-row">
                    <span class="detail-label">Order Number:</span>
                    <span class="detail-value">ORD-<?php echo str_pad($order['id'], 8, '0', STR_PAD_LEFT); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Tracking Number:</span>
                    <span class="detail-value"
                        style="color: #2A3B7E; font-weight: 700;"><?php echo htmlspecialchars($order['tracking_number'] ?? 'Pending'); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Order Date:</span>
                    <span
                        class="detail-value"><?php echo date("M d, Y @ h:i A", strtotime($order['created_at'])); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Payment Method:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($order['payment_method']); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Shipping Address:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($order['address']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Contact Number:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($order['phone_number']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Amount:</span>
                    <span class="detail-value">₱<?php echo number_format($order['total_amount'], 2); ?></span>
                </div>
            </div>

            <div class="actions-row">
                <a href="Order-history.php" class="btn-orders"><i class="fas fa-list"></i> View All Orders</a>
                <!-- Dynamic Continue Shopping Link -->
                <?php
                $continue_url = $is_best_selling_confirm ? '../Categories/best-selling/index.php' : '../Shop-now/index.php';
                ?>
                <a href="<?php echo $continue_url; ?>" class="btn-home"><i class="fas fa-home"></i> Continue
                    Shopping</a>
            </div>
        </div>
    </div>

    <footer>
        <?php include $path_prefix . 'Components/footer.php'; ?>
    </footer>

</body>

</html>