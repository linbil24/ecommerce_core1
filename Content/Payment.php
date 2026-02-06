<?php
session_start();
include '../Database/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../php/login.php");
    exit();
}

// Get order details
// Supports single product (from Buy Now) or multiple (from Cart)
$product_name = isset($_GET['product_name']) ? $_GET['product_name'] : 'Multiple Items';
$item_price = isset($_GET['price']) ? floatval($_GET['price']) : 0;
$quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;
$image = isset($_GET['image']) ? $_GET['image'] : '../image/logo.png';

$subtotal = $item_price * $quantity;

// If amount is passed directly (from cart total)
if (isset($_GET['amount'])) {
    $subtotal = floatval($_GET['amount']);
}

$shipping_fee = 50.00;
$vat_rate = 0.12;
$vat_amount = $subtotal * $vat_rate;
$total_payment = $subtotal + $shipping_fee + $vat_amount;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Selection | IMarket</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <link rel="stylesheet" href="../css/shop/payment.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .payment-option-details {
            display: none;
            padding: 15px;
            background: #f8fafc;
            margin-top: 15px;
            border-radius: 8px;
            border: 1px dashed #2A3B7E;
            animation: fadeIn 0.3s;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        
        .payment-card-label.active .payment-card-content {
            border: 2px solid #2A3B7E;
            background-color: #f0f7ff;
            box-shadow: 0 4px 12px rgba(42, 59, 126, 0.1);
        }

        .payment-methods-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        @media (max-width: 768px) {
            .payment-methods-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <?php 
    $path_prefix = '../';
    include '../Components/header.php'; 
    ?>

    <div class="checkout-container">
        <!-- Stepper -->
        <div class="stepper-wrapper">
            <div class="stepper-item completed">
                <div class="step-counter"><i class="fas fa-check"></i></div>
                <div class="step-name">Cart</div>
            </div>
            <div class="stepper-item active">
                <div class="step-counter">2</div>
                <div class="step-name">Payment</div>
            </div>
            <div class="stepper-item">
                <div class="step-counter">3</div>
                <div class="step-name">Confirm</div>
            </div>
        </div>

        <div class="checkout-content">
            <!-- Left Side: Payment Methods -->
            <div class="checkout-details">
                <div class="card">
                    <h2 class="section-title"><i class="fas fa-wallet" style="margin-right: 10px; color: #2A3B7E;"></i> Select Payment Method</h2>
                    
                    <div class="payment-methods-grid">
                        <!-- GCash -->
                        <label class="payment-card-label" onclick="selectMethod('gcash')">
                            <input type="radio" name="payment_method" value="gcash" id="radio-gcash">
                            <div class="payment-card-content">
                                <div class="payment-icon">
                                    <img src="../image/Banks/Gcash.jpeg" alt="GCash" style="width: 50px; height: 50px; object-fit: contain;">
                                </div>
                                <div class="payment-title">GCash</div>
                                <div class="payment-subtitle">E-wallet</div>
                            </div>
                        </label>

                        <!-- PayMaya -->
                        <label class="payment-card-label" onclick="selectMethod('paymaya')">
                            <input type="radio" name="payment_method" value="paymaya" id="radio-paymaya">
                            <div class="payment-card-content">
                                <div class="payment-icon">
                                    <img src="../image/Banks/Paymaya.jpeg" alt="PayMaya" style="width: 50px; height: 50px; object-fit: contain;">
                                </div>
                                <div class="payment-title">PayMaya</div>
                                <div class="payment-subtitle">E-wallet</div>
                            </div>
                        </label>

                        <!-- Mastercard -->
                        <label class="payment-card-label" onclick="selectMethod('card')">
                            <input type="radio" name="payment_method" value="card" id="radio-card">
                            <div class="payment-card-content">
                                <div class="payment-icon">
                                    <img src="../image/Banks/Master-card.png" alt="Card" style="width: 50px; height: 50px; object-fit: contain;">
                                </div>
                                <div class="payment-title">Credit/Debit Card</div>
                                <div class="payment-subtitle">Visa, Mastercard</div>
                            </div>
                        </label>

                        <!-- Maya (Alternative) -->
                        <label class="payment-card-label" onclick="selectMethod('maya')">
                            <input type="radio" name="payment_method" value="maya" id="radio-maya">
                            <div class="payment-card-content">
                                <div class="payment-icon">
                                    <img src="../image/Banks/Maya.png" alt="Maya" style="width: 50px; height: 50px; object-fit: contain;">
                                </div>
                                <div class="payment-title">Maya</div>
                                <div class="payment-subtitle">E-wallet</div>
                            </div>
                        </label>

                        <!-- BDO -->
                        <label class="payment-card-label" onclick="selectMethod('bdo')">
                            <input type="radio" name="payment_method" value="bdo" id="radio-bdo">
                            <div class="payment-card-content">
                                <div class="payment-icon">
                                    <img src="../image/Banks/BDO.png" alt="BDO" style="width: 50px; height: 50px; object-fit: contain;">
                                </div>
                                <div class="payment-title">BDO</div>
                                <div class="payment-subtitle">Bank Transfer</div>
                            </div>
                        </label>

                        <!-- COD -->
                        <label class="payment-card-label" onclick="selectMethod('cod')">
                            <input type="radio" name="payment_method" value="cod" id="radio-cod">
                            <div class="payment-card-content">
                                <div class="payment-icon">
                                    <i class="fas fa-hand-holding-dollar" style="font-size: 2.5rem; color: #333;"></i>
                                </div>
                                <div class="payment-title">Cash on Delivery</div>
                                <div class="payment-subtitle">Pay when delivered</div>
                            </div>
                        </label>
                    </div>

                    <!-- Method Specific Details -->
                    <div id="method-details-box" class="payment-option-details">
                        <div id="gcash-info" style="display:none;">
                            <strong>GCash Payment:</strong> You will be redirected to the GCash portal to authorize payment.
                        </div>
                        <div id="card-info" style="display:none;">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input type="text" class="form-control" placeholder="0000 0000 0000 0000">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Expiry Date</label>
                                    <input type="text" class="form-control" placeholder="MM/YY">
                                </div>
                                <div class="form-group">
                                    <label>CVV</label>
                                    <input type="text" class="form-control" placeholder="123">
                                </div>
                            </div>
                        </div>
                        <div id="cod-info" style="display:none;">
                            <strong>Cash on Delivery Details:</strong><br>
                            Cash Tendered: <input type="number" class="form-control" placeholder="0.00" style="display:inline-block; width:150px; margin: 10px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Order Summary -->
            <div class="checkout-sidebar">
                <div class="summary-card">
                    <h3>Order Summary</h3>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>₱<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Shipping Fee</span>
                        <span>₱<?php echo number_format($shipping_fee, 2); ?></span>
                    </div>
                    
                    <div class="summary-row">
                        <span>VAT (12%)</span>
                        <span>₱<?php echo number_format($vat_amount, 2); ?></span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total Payment</span>
                        <span style="color: #2A3B7E; font-size: 1.4rem;">₱<?php echo number_format($total_payment, 2); ?></span>
                    </div>

                    <button class="btn-place-order" onclick="processPayment()">Place Order Now</button>
                    
                    <p style="font-size: 0.75rem; color: #888; text-align: center; margin-top: 15px;">
                        By placing your order, you agree to our <a href="#">Terms & Conditions</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedMethod = '';

        function selectMethod(method) {
            selectedMethod = method;
            
            // Remove active class from all
            document.querySelectorAll('.payment-card-label').forEach(label => {
                label.classList.remove('active');
            });
            
            // Add active class to selected
            const radio = document.getElementById('radio-' + method);
            if (radio) {
                radio.checked = true;
                radio.closest('.payment-card-label').classList.add('active');
            }

            // Show relevant info box
            const detailsBox = document.getElementById('method-details-box');
            detailsBox.style.display = 'block';
            
            // Hide all sub-infos
            document.getElementById('gcash-info').style.display = 'none';
            document.getElementById('card-info').style.display = 'none';
            document.getElementById('cod-info').style.display = 'none';

            if (method === 'gcash') document.getElementById('gcash-info').style.display = 'block';
            if (method === 'card') document.getElementById('card-info').style.display = 'block';
            if (method === 'cod') document.getElementById('cod-info').style.display = 'block';
        }

        function processPayment() {
            if (!selectedMethod) {
                alert('Please select a payment method before placing order.');
                return;
            }

            // Show loading state
            const btn = document.querySelector('.btn-place-order');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            btn.disabled = true;

            setTimeout(() => {
                window.location.href = 'Confirmation.php?status=success&method=' + selectedMethod + '&amount=<?php echo $total_payment; ?>';
            }, 1500);
        }
    </script>
</body>
</html>