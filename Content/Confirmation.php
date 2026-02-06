<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - iMarket</title>
    <link rel="stylesheet" href="../css/components/header.css">
    <link rel="stylesheet" href="../css/components/footer.css">
    <style>
        .confirmation-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .success-icon {
            font-size: 80px;
            color: #2ecc71;
            margin-bottom: 20px;
        }
        .btn-continue {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 30px;
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-continue:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <?php include '../Components/header.php'; ?>

    <main class="confirmation-container">
        <div class="success-icon">✓</div>
        <h1>Order Placed Successfully!</h1>
        <p>Thank you for your purchase. Your order is now being processed.</p>
        <p>Reference ID: #ORD-<?php echo rand(10000,99999); ?></p>
        
        <!-- FIXED: Link back to the main Shop page -->
        <a href="../Shop/index.php" class="btn-continue">Continue Shopping</a>
    </main>

    <?php include '../Components/footer.php'; ?>
</body>
</html>