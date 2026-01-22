<?php
session_start();
include("../Database/config.php");

// Product ID is needed to show reviews for ONE product. 
// If generic "My Reviews", we filter by user. But the screenshot says "Product Ratings".
// Let's support both or focus on product.
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Fetch Reviews
// Join with Users table to get reviewer name
$sql = "SELECT r.*, u.full_name, u.email FROM reviews r 
        LEFT JOIN users u ON r.user_id = u.id 
        WHERE r.product_id = '$product_id' 
        ORDER BY r.created_at DESC";

if ($product_id == 0) {
    // Fallback: If no product ID, maybe fetch all (or generic placeholder)
    // Or if user just submitted review without ID context (unlikely from Rate logic), we just show recent.
    $sql = "SELECT r.*, u.full_name FROM reviews r LEFT JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC LIMIT 20";
}

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Ratings</title>
    <link rel="icon" type="image/x-icon" href="../image/imarket.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        nav {
            background-color: white;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        h2.page-title {
            color: #2A3B7E;
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .review-item {
            padding: 20px 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: #e0e0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #555;
            flex-shrink: 0;
        }

        .review-content {
            flex-grow: 1;
        }

        .reviewer-name {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 2px;
        }

        .review-meta {
            font-size: 12px;
            color: #888;
            margin-bottom: 8px;
        }

        .rating-stars {
            color: #ff4500;
            /* Orange-red ish like Shopee? Or standard gold */
            color: #ffc107;
            font-size: 12px;
            margin-right: 10px;
        }

        .review-text {
            font-size: 14px;
            line-height: 1.4;
            margin-bottom: 10px;
            color: #333;
        }

        .review-media img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #eee;
            cursor: pointer;
        }

        .no-reviews {
            text-align: center;
            padding: 40px;
            color: #777;
        }

        .rate-link-footer {
            margin-top: 20px;
            text-align: right;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .rate-link-footer a {
            color: #2A3B7E;
            text-decoration: none;
            font-weight: 600;
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

    <div class="container">
        <h2 class="page-title">Product Ratings</h2>

        <div class="reviews-list">
            <?php
            if (!$result):
                echo "<div class='alert-danger'>Database Error: " . mysqli_error($conn) . "</div>";
            elseif (mysqli_num_rows($result) > 0):
                ?>
                <?php while ($row = mysqli_fetch_assoc($result)):
                    $initial = strtoupper(substr($row['full_name'] ? $row['full_name'] : "User", 0, 1));
                    $stars = $row['rating'];
                    ?>
                    <div class="review-item">
                        <div class="user-avatar"><?php echo $initial; ?></div>
                        <div class="review-content">
                            <div class="reviewer-name"><?php echo htmlspecialchars($row['full_name']); ?></div>
                            <div class="rating-stars">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <?php if ($i < $stars): ?>
                                        <i class="fas fa-star"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <div class="review-meta"><?php echo $row['created_at']; ?></div>

                            <div class="review-text">
                                <?php echo nl2br(htmlspecialchars($row['comment'])); ?>
                            </div>

                            <?php if (!empty($row['media_url'])): ?>
                                <div class="review-media">
                                    <img src="../<?php echo htmlspecialchars($row['media_url']); ?>" alt="Review Image">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-reviews">
                    <i class="far fa-comment-dots" style="font-size: 40px; margin-bottom: 10px;"></i>
                    <p>No ratings yet for this product.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="rate-link-footer">
            <!-- Link back to Product or Home? -->
            <a href="../Categories/best-selling/selling.php">Continue Shopping <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>

</body>

</html>
