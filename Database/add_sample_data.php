<?php
include('../Database/config.php');

// 1. Create Sample Users if they don't exist
$sample_users = [
    ['fullname' => 'John Doe', 'email' => 'john@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'username' => 'johndoe'],
    ['fullname' => 'Maria Clara', 'email' => 'maria@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'username' => 'mariac'],
    ['fullname' => 'Pedro Penduko', 'email' => 'pedro@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'username' => 'pedrop'],
    ['fullname' => 'Juana Change', 'email' => 'juana@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'username' => 'juanac'],
    ['fullname' => 'Boy Bawang', 'email' => 'boy@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'username' => 'boyb']
];

$user_ids = [];
foreach ($sample_users as $user) {
    $email = $user['email'];
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $row = mysqli_fetch_assoc($check);
        $user_ids[] = $row['id'];
    } else {
        $fullname = $user['fullname'];
        $pass = $user['password'];
        $username = $user['username'];
        mysqli_query($conn, "INSERT INTO users (fullname, email, password, username) VALUES ('$fullname', '$email', '$pass', '$username')");
        $user_ids[] = mysqli_insert_id($conn);
    }
}

// 2. Add Sample Reviews for Product 113 (USB C Cable)
$product_id = 113;
$sample_reviews = [
    ['user_idx' => 0, 'rating' => 5, 'comment' => 'Great product, works perfectly for my iPhone. Fast shipping too!'],
    ['user_idx' => 1, 'rating' => 3, 'comment' => "It's okay but the cable is a bit stiff. Works as expected though."],
    ['user_idx' => 2, 'rating' => 1, 'comment' => 'Very disappointed, it stopped working after two days. Do not buy!'],
    ['user_idx' => 3, 'rating' => 5, 'comment' => 'Fast charging is really fast! Highly recommended for everyone.'],
    ['user_idx' => 4, 'rating' => 2, 'comment' => 'Poor quality, feels very cheap and the connector is loose.']
];

// Clear existing reviews for this product to avoid duplicates for this demo
mysqli_query($conn, "DELETE FROM reviews WHERE product_id = '$product_id'");

foreach ($sample_reviews as $review) {
    $uid = $user_ids[$review['user_idx']];
    $rating = $review['rating'];
    $comment = mysqli_real_escape_string($conn, $review['comment']);
    
    $sql = "INSERT INTO reviews (user_id, product_id, order_id, rating, comment, created_at) 
            VALUES ('$uid', '$product_id', 0, '$rating', '$comment', NOW())";
    mysqli_query($conn, $sql);
}

echo "Sample users and reviews added successfully for Product 113!";
?>
