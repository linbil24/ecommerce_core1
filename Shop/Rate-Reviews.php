<?php
session_start();
include("../Database/config.php");

$product_name = $_GET['product_name'] ?? 'Product';
// Generate a pseudo-unique ID for the product based on its name
// This allows us to link reviews to specific products without a dedicated products table for now
// Use modulo to ensure it fits in a standard signed INT (max ~2 billion)
$product_id = abs(crc32($product_name)) % 2147483647;

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login or show error
        header("Location: ../php/login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $rating = intval($_POST['rating'] ?? 5);
    $comment = mysqli_real_escape_string($conn, $_POST['comment'] ?? '');

    // Insert into reviews table
    // Using the generated product_id
    $sql = "INSERT INTO reviews (user_id, product_id, order_id, rating, comment, created_at) 
            VALUES ('$user_id', '$product_id', 0, '$rating', '$comment', NOW())";

    if (mysqli_query($conn, $sql)) {
        $success_msg = "Thank you! Your review for <strong>" . htmlspecialchars($product_name) . "</strong> has been submitted.";

        // --- Notification Logic ---
        // Email Notification to Admin
        require '../PHPMailer/src/Exception.php';
        require '../PHPMailer/src/PHPMailer.php';
        require '../PHPMailer/src/SMTP.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'linbilcelestre31@gmail.com';
            $mail->Password = 'erdrvfcuoeibstxo'; // App Password
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('no-reply@imarketph.com', 'IMarket PH');
            $mail->addAddress('linbilcelestre31@gmail.com', 'Admin');

            $mail->isHTML(true);
            $mail->Subject = 'New Product Review: ' . $product_name;
            $user_name = $_SESSION['fullname'] ?? 'A customer';
            $mail->Body = "<h3>New Product Review Received</h3>
                           <p><b>Product:</b> $product_name</p>
                           <p><b>Rating:</b> $rating Stars</p>
                           <p><b>Customer:</b> $user_name</p>
                           <p><b>Comment:</b></p>
                           <p>$comment</p>
                           <hr>
                           <p><a href='http://localhost/ecommerce%20core1/Admin/dashboard.php'>View in Admin Dashboard</a></p>";
            $mail->AltBody = "New Product Review Received\nProduct: $product_name\nRating: $rating Stars\nCustomer: $user_name\nComment: $comment";

            $mail->send();
        } catch (Exception $e) {
            // Silently fail email but review is already saved
        }
    } else {
        $error_msg = "Error submitting review: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Product -
        <?php echo htmlspecialchars($product_name); ?> | iMarket
    </title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">

    <!-- Link Shop CSS -->
    <link rel="stylesheet" href="../css/shop/shop.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .rate-container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .rate-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .rate-header h1 {
            font-size: 24px;
            color: #2A3B7E;
            margin-bottom: 10px;
        }

        .product-name {
            font-size: 18px;
            color: #666;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
        }

        /* Star Rating Input */
        .rating-input {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 10px;
        }

        .rating-input input {
            display: none;
        }

        .rating-input label {
            cursor: pointer;
            font-size: 30px;
            color: #ddd;
            transition: color 0.2s;
        }

        .rating-input input:checked~label,
        .rating-input label:hover,
        .rating-input label:hover~label {
            color: #ffc107;
        }

        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            min-height: 120px;
            resize: vertical;
            outline: none;
        }

        textarea:focus {
            border-color: #2A3B7E;
        }

        .btn-submit {
            background: #2A3B7E;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: #1a2552;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            color: #2A3B7E;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>

<body>
    <nav>
        <?php $path_prefix = '../';
        include '../Components/header.php'; ?>
    </nav>

    <div class="rate-container">
        <?php if ($success_msg): ?>
            <div class="alert-success">
                <?php echo $success_msg; ?>
            </div>
            <div style="text-align: center;">
                <a href="index.php" class="btn-submit"
                    style="display: inline-block; width: auto; text-decoration: none;">Return to Shop</a>
            </div>
        <?php else: ?>
            <div class="rate-header">
                <h1>Rate Product</h1>
                <div class="product-name">
                    <?php echo htmlspecialchars($product_name); ?>
                </div>
            </div>

            <?php if ($error_msg): ?>
                <div
                    style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 20px; text-align: center; border: 1px solid #f5c6cb;">
                    <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label style="text-align: center;">How would you rate this product?</label>
                    <div class="rating-input">
                        <input type="radio" name="rating" id="star5" value="5" required>
                        <label for="star5" title="5 Stars"><i class="fas fa-star"></i></label>

                        <input type="radio" name="rating" id="star4" value="4">
                        <label for="star4" title="4 Stars"><i class="fas fa-star"></i></label>

                        <input type="radio" name="rating" id="star3" value="3">
                        <label for="star3" title="3 Stars"><i class="fas fa-star"></i></label>

                        <input type="radio" name="rating" id="star2" value="2">
                        <label for="star2" title="2 Stars"><i class="fas fa-star"></i></label>

                        <input type="radio" name="rating" id="star1" value="1">
                        <label for="star1" title="1 Star"><i class="fas fa-star"></i></label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="comment">Write a Review</label>
                    <textarea name="comment" id="comment"
                        placeholder="Share your experience with this product..."></textarea>
                </div>

                <button type="submit" class="btn-submit">Submit Review</button>
            </form>

            <a href="javascript:history.back()" class="back-link">
                <i class="fas fa-arrow-left"></i> Cancel and go back
            </a>
        <?php endif; ?>
    </div>
</body>

</html>