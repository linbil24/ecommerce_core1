<?php
session_start();
include("../Database/config.php");

// 1. Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../php/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";

// Initialize variables
$order_items = [];
$from_cart = (isset($_GET['from_cart']) && $_GET['from_cart'] == 1);
$selected_ids_str = isset($_GET['selected_ids']) ? $_GET['selected_ids'] : '';

// 2. Fetch Items (Cart or Single)
if ($from_cart && !empty($selected_ids_str)) {
    // Process Cart Items
    $ids_array = array_map('intval', explode(',', $selected_ids_str));
    if (!empty($ids_array)) {
        $ids_string = implode(',', $ids_array);
        $sql = "SELECT * FROM cart WHERE user_id = '$user_id' AND id IN ($ids_string)";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $order_items[] = [
                'product_id' => intval($row['product_id']),
                'product_name' => $row['product_name'],
                'price' => floatval($row['price']),
                'quantity' => intval($row['quantity']),
                'image' => $row['image'] // Full path for shop items usually
            ];
        }
    }
} else {
    // Single Item parameters from URL (Fallback)
    $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
    $product_name = isset($_GET['product_name']) ? $_GET['product_name'] : 'Product';
    $price = isset($_GET['price']) ? floatval($_GET['price']) : 0;
    $quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;
    $image_file = isset($_GET['image']) ? $_GET['image'] : '';

    $order_items[] = [
        'product_id' => $product_id,
        'product_name' => $product_name,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $image_file
    ];
}

// Calculate Totals
$subtotal = 0;
foreach ($order_items as $item) {
    $subtotal += ($item['price'] * $item['quantity']);
}
$shipping = 50.00;
$tax = $subtotal * 0.12;
$total = $subtotal + $shipping + $tax;

// 3. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {

    // Sanitize Inputs
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);

    $status = "Pending";
    $last_order_id = 0;

    // Create Orders Table if not exists
    $create_table = "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        tracking_number VARCHAR(50),
        product_id INT DEFAULT 0,
        product_name VARCHAR(255) NOT NULL,
        quantity INT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        total_amount DECIMAL(10,2) NOT NULL,
        full_name VARCHAR(255) NOT NULL,
        phone_number VARCHAR(50) NOT NULL,
        address TEXT NOT NULL,
        city VARCHAR(100) NOT NULL,
        postal_code VARCHAR(20) NOT NULL,
        payment_method VARCHAR(50) NOT NULL,
        status VARCHAR(50) DEFAULT 'Pending',
        image_url VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    mysqli_query($conn, $create_table);

    // Generate Tracking Number (OTP for Shipment Tracking)


    // Prepare data for Order
    $all_product_names = [];
    foreach ($order_items as $itm) {
        $all_product_names[] = $itm['product_name'] . " (x" . $itm['quantity'] . ")";
    }
    // Escape the product name string for SQL
    $product_name_str = mysqli_real_escape_string($conn, implode(", ", $all_product_names));

    $total_qty = 0;
    foreach ($order_items as $itm)
        $total_qty += $itm['quantity'];

    $first_image = isset($order_items[0]['image']) ? mysqli_real_escape_string($conn, $order_items[0]['image']) : '';
    $first_product_id = isset($order_items[0]['product_id']) ? intval($order_items[0]['product_id']) : 0;

    $sql = "INSERT INTO orders (user_id, tracking_number, product_id, product_name, quantity, price, total_amount, full_name, phone_number, address, city, postal_code, payment_method, status, image_url)
            VALUES ('$user_id', '$tracking_number', '$first_product_id', '$product_name_str', '$total_qty', '$subtotal', '$total', '$full_name', '$phone_number', '$address', '$city', '$postal_code', '$payment_method', '$status', '$first_image')";

    if (mysqli_query($conn, $sql)) {
        $last_order_id = mysqli_insert_id($conn);

        // Remove from cart if applicable
        if (isset($_POST['from_cart']) && $_POST['from_cart'] == 1) {
            $sel_ids_str = $_POST['selected_ids'];
            if (!empty($sel_ids_str)) {
                $sel_ids_arr = array_map('intval', explode(',', $sel_ids_str));
                $clean_ids = implode(',', $sel_ids_arr);
                @mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id' AND id IN ($clean_ids)");
            }
        }

        // Redirect to Confirmation (Categories/best-selling/Confirmation.php as it has the latest updates)
        // Or shop/Confirmation.php. The user mentioned integrating, so sticking to one Confirmation is good.
        // I will link to ../Categories/best-selling/Confirmation.php as requested by recent context clues,
        // or safer: ../shop/Confirmation.php which is classic.
        // Let's use ../shop/Confirmation.php for now.
        // Redirect to unified Confirmation in Content/
        header("Location: Confirmation.php?order_id=" . $last_order_id);
        exit();
    } else {
        $msg = "<div class='alert-error'>Error placing order: " . mysqli_error($conn) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <!-- Use Shop CSS -->
    <link rel="stylesheet" href="../css/shop/payment.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 4px;
            border: 1px solid #f5c6cb;
            margin-bottom: 1.5rem;
        }

        .items-list-container {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #eee;
            border-radius: 6px;
            margin-bottom: 1rem;
        }

        .item-card {
            border-bottom: 1px solid #eee;
            border-radius: 0;
            margin-bottom: 0;
        }

        .item-card:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body>
    <nav>
        <?php
        $path_prefix = '../';
        include '../Components/header.php';
        ?>
    </nav>

    <div class="checkout-container">
        <!-- Stepper -->
        <div class="stepper-wrapper">
            <div class="stepper-item completed">
                <div class="step-counter"><i class="fas fa-check"></i></div>
                <div class="step-name">Product Selected</div>
            </div>
            <div class="stepper-item active">
                <div class="step-counter">2</div>
                <div class="step-name">Shipping & Payment</div>
            </div>
            <div class="stepper-item">
                <div class="step-counter">3</div>
                <div class="step-name">Confirmation</div>
            </div>
        </div>

        <form action="" method="POST">
            <!-- Hidden Fields -->
            <input type="hidden" name="from_cart" value="<?php echo $from_cart ? '1' : '0'; ?>">
            <input type="hidden" name="selected_ids" value="<?php echo htmlspecialchars($selected_ids_str); ?>">

            <div class="checkout-content">
                <!-- Left Side -->
                <div class="checkout-details">
                    <div class="card">
                        <?php echo $msg; ?>

                        <h2>Checkout</h2>

                        <div class="shop-header-container"
                            style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 20px;">
                            <img src="../image/logo.png" alt="Shop Logo" class="shop-logo"
                                style="width: 50px; height: 50px; object-fit: contain;">
                            <div>
                                <?php
                                // Determine header based on first item category
                                $header_title = "IMarket PH";
                                $header_subtitle = "Official Store";

                                if (!empty($order_items)) {
                                    $check_img = strtolower($order_items[0]['image']);

                                    if (strpos($check_img, 'electronics') !== false) {
                                        $header_title = "Electronics";
                                        $header_subtitle = "Latest Gadgets & Tech";
                                    } elseif (strpos($check_img, 'fashion') !== false || strpos($check_img, 'apparel') !== false) {
                                        $header_title = "Fashion & Apparel";
                                        $header_subtitle = "Trendy Styles";
                                    } elseif (strpos($check_img, 'home') !== false || strpos($check_img, 'living') !== false) {
                                        $header_title = "Home & Living";
                                        $header_subtitle = "Comfort & Style";
                                    } elseif (strpos($check_img, 'beauty') !== false || strpos($check_img, 'health') !== false) {
                                        $header_title = "Beauty & Health";
                                        $header_subtitle = "Glow & Wellness";
                                    } elseif (strpos($check_img, 'sports') !== false || strpos($check_img, 'outdoor') !== false) {
                                        $header_title = "Sports & Outdoor";
                                        $header_subtitle = "Get Active";
                                    } elseif (strpos($check_img, 'new-arrivals') !== false) {
                                        $header_title = "New Arrivals";
                                        $header_subtitle = "Fresh Picks";
                                    } elseif (strpos($check_img, 'best') !== false) {
                                        $header_title = "Best Selling";
                                        $header_subtitle = "Top Rated Products";
                                    } elseif (strpos($check_img, 'groceries') !== false) {
                                        $header_title = "Groceries";
                                        $header_subtitle = "Fresh & Essentials";
                                    } elseif (strpos($check_img, 'toys') !== false || strpos($check_img, 'games') !== false) {
                                        $header_title = "Toys & Games";
                                        $header_subtitle = "Fun & Play";
                                    } elseif (strpos($check_img, 'shop') !== false) {
                                        $header_title = "IMarket Shop";
                                        $header_subtitle = "Verified Store";
                                    }
                                }
                                ?>

                                <div>
                                    <h4 style="margin: 0; font-size: 18px; color: #2A3B7E; font-weight: bold;">
                                        <?php echo htmlspecialchars($header_title); ?>
                                    </h4>
                                    <span
                                        style="font-size: 12px; color: #555;"><?php echo htmlspecialchars($header_subtitle); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Product Summary -->
                        <div class="section-title">Selected Item(s)</div>

                        <div class="items-list-container">
                            <?php foreach ($order_items as $item): ?>
                                <div class="item-card">
                                    <?php
                                    // Robust Image Path Correction
                                    $raw_img = $item['image'];

                                    // 1. Strip all leading relative components to get the clean path from root (e.g., image/Category/file.jpg)
                                    // This handles inputs like "../../image/...", "../image/...", or "image/..."
                                    $clean_path = preg_replace('/^(\.\.\/)+/', '', $raw_img);

                                    // 2. Construct path relative to THIS file (Content/Payment.php needs ../image/...)
                                    $display_img = '../' . $clean_path;

                                    // 3. Fallback: If strict path doesn't exist, try searching in common Image directories by filename
                                    if (!file_exists($display_img)) {
                                        $filename = basename($clean_path);
                                        $candidates = [
                                            '../image/' . $filename,
                                            '../image/Best/' . $filename,
                                            '../image/Electronics/' . $filename,
                                            '../image/Fashion & Apparel/' . $filename,
                                            '../image/Home & living/' . $filename,
                                            '../image/Beauty & Health/' . $filename,
                                            '../image/Sports & outdoor/' . $filename,
                                            '../image/Groceries/' . $filename,
                                            '../image/Toys & Games/' . $filename,
                                            '../image/New-arrivals/' . $filename,
                                            '../image/Shop/' . $filename,
                                        ];
                                        foreach ($candidates as $cand) {
                                            if (file_exists($cand)) {
                                                $display_img = $cand;
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                    <img src="<?php echo htmlspecialchars($display_img); ?>"
                                        alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="item-image"
                                        style="object-fit: contain; background: #f9f9f9;">
                                    <div class="item-info">
                                        <span class="item-title"
                                            style="font-weight: 600; color: #333; display: block; margin-bottom: 5px;">
                                            <?php echo htmlspecialchars($item['product_name']); ?>
                                        </span>
                                        <div class="item-price" style="color: #2A3B7E; font-weight: bold;">
                                            ₱<?php echo number_format($item['price'], 2); ?>
                                        </div>
                                        <div class="item-qty" style="color: #777; font-size: 0.9em;">
                                            Qty: <?php echo $item['quantity']; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div style="margin-top: 2rem;"></div>

                        <!-- Shipping Info (Default Address) -->
                        <div class="section-title"><i class="fas fa-map-marker-alt"
                                style="margin-right: 10px;"></i>Shipping Address</div>
                        <?php
                        // Fetch user details
                        $u_sql = "SELECT * FROM users WHERE id = '$user_id'";
                        $u_res = mysqli_query($conn, $u_sql);
                        $user_data = mysqli_fetch_assoc($u_res);

                        $d_name = isset($user_data['fullname']) ? $user_data['fullname'] : (isset($user_data['username']) ? $user_data['username'] : 'My Name');
                        $d_phone = isset($user_data['phone']) ? $user_data['phone'] : '09123456789';
                        $d_address = isset($user_data['address']) ? $user_data['address'] : 'No default address set.';
                        $d_city = isset($user_data['city']) ? $user_data['city'] : 'Metro Manila';
                        $d_zip = isset($user_data['zip']) ? $user_data['zip'] : '1000';
                        ?>

                        <div class="address-card">
                            <div class="address-card-header">
                                <i class="fas fa-map-marker-alt address-title-icon"></i> Default Address
                            </div>
                            <div class="address-details">
                                <strong><?php echo htmlspecialchars($d_name); ?></strong> |
                                <?php echo htmlspecialchars($d_phone); ?><br>
                                <?php echo htmlspecialchars($d_address); ?><br>
                                <?php echo htmlspecialchars($d_city); ?>, <?php echo htmlspecialchars($d_zip); ?>
                            </div>

                            <!-- Tracking / Location Map Preview -->
                            <div
                                style="margin-top: 15px; border-radius: 4px; overflow: hidden; border: 1px solid #eee;">
                                <iframe width="100%" height="200" frameborder="0" scrolling="no" marginheight="0"
                                    marginwidth="0"
                                    src="https://maps.google.com/maps?q=<?php echo urlencode($d_address . ' ' . $d_city); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed">
                                </iframe>
                            </div>

                            <!-- Link to User Account setting. Where is it? Categories/best-selling/user-account.php seems to be the one. -->
                            <a href="../Categories/best-selling/user-account.php?return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                                class="address-change-link">Change</a>
                        </div>

                        <input type="hidden" name="full_name" value="<?php echo htmlspecialchars($d_name); ?>">
                        <input type="hidden" name="phone_number" value="<?php echo htmlspecialchars($d_phone); ?>">
                        <input type="hidden" name="address" value="<?php echo htmlspecialchars($d_address); ?>">
                        <input type="hidden" name="city" value="<?php echo htmlspecialchars($d_city); ?>">
                        <input type="hidden" name="postal_code" value="<?php echo htmlspecialchars($d_zip); ?>">

                        <div style="margin-top: 2rem;"></div>

                        <!-- Payment Method -->
                        <div class="section-title">Payment Method</div>
                        <div class="payment-methods">
                            <!-- Helper to display payment option -->
                            <?php
                            $methods = [
                                ['val' => 'GCash', 'img' => '../image/Banks/Gcash.jpeg', 'label' => 'GCash', 'sub' => 'E-wallet'],
                                ['val' => 'PayMaya', 'img' => '../image/Banks/Paymaya.jpeg', 'label' => 'PayMaya', 'sub' => 'E-wallet'],
                                ['val' => 'Credit Card', 'img' => '../image/Banks/Master-card.png', 'label' => 'Credit/Debit Card', 'sub' => 'Visa, Mastercard'],
                                ['val' => 'Maya', 'img' => '../image/Banks/Maya.png', 'label' => 'Maya', 'sub' => 'E-wallet'],
                                ['val' => 'BDO', 'img' => '../image/Banks/BDO.png', 'label' => 'BDO', 'sub' => 'Bank Transfer'],
                                ['val' => 'Cash On Delivery', 'img' => '', 'icon' => 'fas fa-money-bill-wave', 'label' => 'Cash on Delivery', 'sub' => 'Pay when delivered', 'checked' => true]
                            ];

                            foreach ($methods as $m) {
                                $checked = isset($m['checked']) ? 'checked' : '';
                                ?>
                                <label class="payment-card-label" onclick="selectPayment(this)">
                                    <input type="radio" name="payment_method" value="<?php echo $m['val']; ?>" <?php echo $checked; ?>>
                                    <div class="payment-card-content">
                                        <div class="payment-icon"
                                            style="width: auto; height: 60px; margin-bottom: 0.5rem; <?php if (isset($m['icon']))
                                                echo 'font-size:30px; display:flex; align-items:center; justify-content:center; color:#2A3B7E;'; ?>">
                                            <?php if (isset($m['img']) && $m['img']): ?>
                                                <img src="<?php echo $m['img']; ?>"
                                                    style="height: 100%; width: auto; object-fit: contain;">
                                            <?php else: ?>
                                                <i class="<?php echo $m['icon']; ?>"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="payment-title"><?php echo $m['label']; ?></div>
                                        <div class="payment-subtitle"><?php echo $m['sub']; ?></div>
                                    </div>
                                </label>
                            <?php } ?>
                        </div>

                        <!-- Cash Change Calculation Section (Hidden by default, shown for COD) -->
                        <div id="cash-calculation-section" style="display: block; margin-top: 20px; background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #e9ecef;">
                            <div style="font-weight: 600; margin-bottom: 10px; color: #333;">Cash Payment Details</div>
                            <div style="display: flex; gap: 15px; align-items: center;">
                                <div style="flex: 1;">
                                    <label style="font-size: 0.9em; color: #555;">Cash Tendered (₱)</label>
                                    <input type="number" id="cash_tendered" name="cash_tendered" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" placeholder="0.00" oninput="calculateChange()">
                                </div>
                                <div style="flex: 1;">
                                    <label style="font-size: 0.9em; color: #555;">Change (₱)</label>
                                    <input type="text" id="change_amount" name="change_amount" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; background: #e9ecef; font-weight: bold; color: #2A3B7E;" readonly value="0.00">
                                </div>
                            </div>
                            <div id="payment-warning" style="color: #dc3545; font-size: 0.85em; margin-top: 5px; display: none;">Insufficient cash amount.</div>
                        </div>

                    </div>
                </div>

                <!-- Right Side (Summary) -->
                <div class="summary-card">
                    <h3>Order Summary</h3>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>₱<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping Fee</span>
                        <span>₱<?php echo number_format($shipping, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>VAT (12%)</span>
                        <span>₱<?php echo number_format($tax, 2); ?></span>
                    </div>
                    <div class="summary-row total">
                        <span>Total Payment</span>
                        <span id="total_display_amount" data-amount="<?php echo $total; ?>">₱<?php echo number_format($total, 2); ?></span>
                    </div>

                    <button type="submit" name="place_order" id="btn-place-order" class="btn-place-order">Place Order Now</button>
                    <p style="margin-top:1rem; font-size:0.8rem; color:#777; text-align:center;">
                        By placing an order, you agree to our Terms of Service.
                    </p>
                </div>
            </div>
        </form>

    <script>
        function selectPayment(element) {
            document.querySelectorAll('.payment-card-label').forEach(el => el.classList.remove('selected'));
            element.classList.add('selected');
            const radio = element.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                toggleCashSection(radio.value);
            }
        }

        function toggleCashSection(method) {
            const cashSection = document.getElementById('cash-calculation-section');
            if (method === 'Cash On Delivery') {
                cashSection.style.display = 'block';
            } else {
                cashSection.style.display = 'none';
            }
        }

        function calculateChange() {
            const total = parseFloat(document.getElementById('total_display_amount').getAttribute('data-amount'));
            const cashInput = document.getElementById('cash_tendered');
            const changeInput = document.getElementById('change_amount');
            const warning = document.getElementById('payment-warning');
            const placeOrderBtn = document.getElementById('btn-place-order');
            
            const cash = parseFloat(cashInput.value);

            if (isNaN(cash) || cash < total) {
                changeInput.value = "0.00";
                if(cashInput.value.length > 0) {
                     warning.style.display = 'block';
                     // placeOrderBtn.disabled = true; // Optional: disable button
                     // placeOrderBtn.style.opacity = '0.5';
                }
            } else {
                const change = cash - total;
                changeInput.value = change.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                warning.style.display = 'none';
                // placeOrderBtn.disabled = false;
                // placeOrderBtn.style.opacity = '1';
            }
        }

        // Initialize state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const selected = document.querySelector('input[name="payment_method"]:checked');
            if(selected) {
               toggleCashSection(selected.value);
            } else {
               // Default logic (COD is usually checked by default in PHP loop above? Yes)
               toggleCashSection('Cash On Delivery'); 
            }
        });
    </script>
</body>

</html>