<?php
session_start();
include("../Database/config.php");

// Clean input helper
function clean_input($data)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

$msg = "";
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_return'])) {
    if (!$user_id) {
        $msg = "<div class='alert alert-error' style='background:#f8d7da; color:#721c24; padding:15px; margin-bottom:20px; border-radius:8px;'>Please login to request a return.</div>";
    } else {
        $order_id = clean_input($_POST['order_id']);
        $product_name = clean_input($_POST['product_name']);
        $reason = clean_input($_POST['reason']);
        $details = clean_input($_POST['details']);

        // Handle File Upload
        $image_proof = NULL;
        if (isset($_FILES['image_proof']) && $_FILES['image_proof']['error'] == 0) {
            $target_dir = "../image/Returns/";
            // Create dir if not exists
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $file_extension = strtolower(pathinfo($_FILES["image_proof"]["name"], PATHINFO_EXTENSION));
            $new_filename = "return_" . time() . "_" . $user_id . "." . $file_extension;
            $target_file = $target_dir . $new_filename;

            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($file_extension, $allowed_types)) {
                if (move_uploaded_file($_FILES["image_proof"]["tmp_name"], $target_file)) {
                    $image_proof = 'image/Returns/' . $new_filename; // Store relative path for DB
                } else {
                    $msg = "<div class='alert alert-error'>Failed to upload image.</div>";
                }
            } else {
                $msg = "<div class='alert alert-error'>Invalid file type. Only JPG, PNG, GIF are allowed.</div>";
            }
        }

        if (empty($msg)) {
            $sql = "INSERT INTO return_refund_requests (user_id, order_id, product_name, reason, details, image_proof) 
                    VALUES ('$user_id', '$order_id', '$product_name', '$reason', '$details', '$image_proof')";

            if (mysqli_query($conn, $sql)) {
                $msg = "<div class='alert alert-success' style='background:#d4edda; color:#155724; padding:15px; margin-bottom:20px; border-radius:8px;'>Return Request Submitted Successfully!</div>";
            } else {
                $msg = "<div class='alert alert-error' style='background:#f8d7da; color:#721c24; padding:15px; margin-bottom:20px; border-radius:8px;'>Error: " . mysqli_error($conn) . "</div>";
            }
        }
    }
}

// Fetch Previous Requests
$my_requests = [];
if ($user_id) {
    // Check if table exists first to avoid error if SQL not imported yet
    $check_table = mysqli_query($conn, "SHOW TABLES LIKE 'return_refund_requests'");
    if (mysqli_num_rows($check_table) > 0) {
        $sql_requests = "SELECT * FROM return_refund_requests WHERE user_id = '$user_id' ORDER BY created_at DESC";
        $result_requests = mysqli_query($conn, $sql_requests);
        if ($result_requests) {
            $my_requests = mysqli_fetch_all($result_requests, MYSQLI_ASSOC);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return & Refund | IMARKET PH</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/services/return_refund.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <nav>
        <?php
        $path_prefix = '../';
        include '../Components/header.php';
        ?>
    </nav>

    <div class="return-container">
        <!-- Sidebar Navigation -->
        <div class="service-sidebar">
            <h3>Customer Service</h3>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="Customer_Service.php?tab=faq"><i class="fas fa-question-circle"></i> FAQs</a></li>
                    <li><a href="Customer_Service.php?tab=submit"><i class="fas fa-edit"></i> Submit Ticket</a></li>
                    <li><a href="Customer_Service.php?tab=history"><i class="fas fa-history"></i> My Tickets</a></li>
                    <li><a href="Return & Refund.php" class="active"><i class="fas fa-undo-alt"></i> Return & Refund</a>
                    </li>
                    <li><a href="Contact Us.php"><i class="fas fa-envelope"></i> Contact Us</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="return-content">
            <div class="section-header">
                <h2>Return & Refund Request</h2>
                <p>We're sorry you weren't satisfied with your purchase. Request a return below.</p>
            </div>

            <?php echo $msg; ?>

            <div class="policy-card">
                <h4><i class="fas fa-info-circle"></i> Return Policy Update</h4>
                <ul class="policy-list">
                    <li>Items can be returned within <strong>7 days</strong> of delivery.</li>
                    <li>Items must be unused, in original packaging, and with all tags attached.</li>
                    <li>Refunds are processed to the original payment method within 5-10 business days after approval.
                    </li>
                </ul>
            </div>

            <?php if ($user_id): ?>
                <form action="" method="POST" enctype="multipart/form-data" class="return-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Order ID</label>
                            <input type="text" name="order_id" placeholder="e.g., ORD-12345" required>
                        </div>
                        <div class="form-group">
                            <label>Product Name / SKU</label>
                            <input type="text" name="product_name" placeholder="Item to return" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Reason for Return</label>
                        <select name="reason" required>
                            <option value="">Select a Reason</option>
                            <option value="Damaged">Damaged / Defective</option>
                            <option value="Wrong Item">Received Wrong Item</option>
                            <option value="Incomplete">Incomplete / Missing Parts</option>
                            <option value="Changed Mind">Changed Mind (Unopened)</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Additional Details</label>
                        <textarea name="details" rows="5" required
                            placeholder="Please provide more details about the issue..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Upload Proof (Image)</label>
                        <input type="file" name="image_proof" accept="image/*">
                        <small style="color: #6c757d;">Recommended for damaged or wrong items.</small>
                    </div>

                    <button type="submit" name="submit_return" class="btn-submit">
                        Submit Request <i class="fas fa-paper-plane"></i>
                    </button>
                </form>

                <!-- History Section -->
                <?php if (!empty($my_requests)): ?>
                    <div style="margin-top: 50px;">
                        <h3>My Return Requests</h3>
                        <div style="overflow-x: auto;">
                            <table class="request-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Order ID</th>
                                        <th>Product</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($my_requests as $req): ?>
                                        <tr>
                                            <td>#<?php echo $req['request_id']; ?></td>
                                            <td><?php echo date('M d, Y', strtotime($req['created_at'])); ?></td>
                                            <td><?php echo htmlspecialchars($req['order_id']); ?></td>
                                            <td><?php echo htmlspecialchars($req['product_name']); ?></td>
                                            <td><?php echo htmlspecialchars($req['reason']); ?></td>
                                            <td>
                                                <?php
                                                $statusClass = 'status-pending';
                                                if ($req['status'] == 'Approved')
                                                    $statusClass = 'status-approved';
                                                if ($req['status'] == 'Rejected')
                                                    $statusClass = 'status-rejected';
                                                if ($req['status'] == 'Refunded')
                                                    $statusClass = 'status-refunded';
                                                ?>
                                                <span class="badge <?php echo $statusClass; ?>"><?php echo $req['status']; ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div style="text-align: center; padding: 40px; color: #6c757d;">
                    <i class="fas fa-lock" style="font-size: 3rem; margin-bottom: 20px;"></i>
                    <h3>Login Required</h3>
                    <p>Please log in to submit a return request.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <?php include '../Components/footer.php'; ?>
    </footer>
</body>

</html>



