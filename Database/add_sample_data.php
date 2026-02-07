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

// 2. Add Sample Reviews for Product 115 (Phone Ring Holder)
$product_id = 115;
$sample_reviews = [
    // Positive Reviews
    ['user_idx' => 0, 'rating' => 5, 'comment' => 'Sulit na sulit! The adhesive is very strong and the design is premium. Highly recommended!'],
    ['user_idx' => 1, 'rating' => 5, 'comment' => 'Ganda ng quality, ayos na ayos sa phone ko. Mabilis din dumating yung item.'],
    ['user_idx' => 3, 'rating' => 5, 'comment' => 'Amazing product! Best ring holder I have ever used. Very satisfied.'],
    ['user_idx' => 2, 'rating' => 4, 'comment' => 'Maganda siya, legit na durable. Worth the price!'],
    
    // Negative Reviews
    ['user_idx' => 4, 'rating' => 1, 'comment' => 'Pangit ng quality, madaling natanggal yung paint. Waste of money, wag niyo na bilhin.'],
    ['user_idx' => 2, 'rating' => 1, 'comment' => 'Sira agad after 1 week. Sobrang bagal pa ng shipping. Sayang lang pera dito.'],
    ['user_idx' => 0, 'rating' => 1, 'comment' => 'Bad experience. The ring became loose after just 2 days. Terrible quality.'],
    ['user_idx' => 1, 'rating' => 2, 'comment' => 'Disappointed. Not as described. It feels very cheap and weak.'],

    // Neutral Reviews
    ['user_idx' => 3, 'rating' => 3, 'comment' => 'Okay naman siya, sakto lang sa presyo. Durable enough for daily use.'],
    ['user_idx' => 1, 'rating' => 3, 'comment' => 'sakto lang, pwede na for its price. standard quality.'],
    ['user_idx' => 4, 'rating' => 3, 'comment' => 'Fine product. Not great but not bad either. Just average.'],
    ['user_idx' => 2, 'rating' => 3, 'comment' => 'Okay naman, normal lang na ring holder. Matagal lang shipping.']
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

echo "Sample users and reviews added successfully for Product 115!";
?>
