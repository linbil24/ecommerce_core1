<?php
include("../Database/config.php");
$product_name = $_GET['product_name'] ?? '';
$product_id = abs(crc32($product_name)) % 2147483647;

$sql = "SELECT r.*, u.fullname FROM reviews r 
        LEFT JOIN users u ON r.user_id = u.id 
        WHERE r.product_id = '$product_id' 
        ORDER BY r.created_at DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $name = htmlspecialchars($row['fullname'] ?? 'User');
        $initial = strtoupper(substr($name, 0, 1));
        $comment = htmlspecialchars($row['comment']);
        $rating = intval($row['rating']);
        $date = date('M d, Y', strtotime($row['created_at']));

        $stars = '';
        for ($i = 0; $i < 5; $i++) {
            if ($i < $rating)
                $stars .= '<i class="fas fa-star"></i>';
            else
                $stars .= '<i class="far fa-star"></i>';
        }

        echo '
        <div class="review-item">
            <div class="review-header">
                <span class="user-name">' . $name . '</span>
                <span class="review-rating">' . $stars . '</span>
            </div>
            <div class="review-text">' . $comment . '</div>
            <div class="review-date">' . $date . '</div>
        </div>';
    }
} else {
    echo '<div style="text-align:center; padding:20px; color:#888;">No reviews yet. Be the first to rate!</div>';
}
?>