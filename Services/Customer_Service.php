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
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'faq';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Handle Ticket Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_ticket'])) {
    if (!$user_id) {
        $msg = "<div class='alert alert-error'>You must be logged in to submit a ticket.</div>";
    } else {
        $category = clean_input($_POST['category']);
        $subject = clean_input($_POST['subject']);
        $message = clean_input($_POST['message']);

        if (!empty($category) && !empty($subject) && !empty($message)) {
            // Just-In-Time Repair: Ensure all necessary columns exist
            $required_cols = [
                'ticket_number' => "VARCHAR(50) DEFAULT NULL AFTER id",
                'customer_id' => "INT(11) DEFAULT NULL AFTER ticket_number",
                'category' => "VARCHAR(100) DEFAULT NULL AFTER customer_id",
                'is_read' => "TINYINT(1) DEFAULT 0"
            ];
            foreach ($required_cols as $col => $def) {
                $check_col = mysqli_query($conn, "SHOW COLUMNS FROM support_tickets LIKE '$col'");
                if (mysqli_num_rows($check_col) == 0) {
                    mysqli_query($conn, "ALTER TABLE support_tickets ADD COLUMN $col $def");
                }
            }

            // Fix for 'user_id' doesn't have default value
            $check_u = mysqli_query($conn, "SHOW COLUMNS FROM support_tickets LIKE 'user_id'");
            if (mysqli_num_rows($check_u) > 0) {
                mysqli_query($conn, "ALTER TABLE support_tickets MODIFY COLUMN user_id INT(11) DEFAULT NULL");
            }

            // Ensure unique index on ticket_number
            $check_idx = mysqli_query($conn, "SHOW INDEX FROM support_tickets WHERE Key_name = 'ticket_number'");
            if (mysqli_num_rows($check_idx) == 0) {
                mysqli_query($conn, "ALTER TABLE support_tickets ADD UNIQUE (ticket_number)");
            }

            $ticket_number = 'TKT-' . date('Y') . '-' . mt_rand(1000, 9999);
            $sql = "INSERT INTO support_tickets (ticket_number, customer_id, category, subject, message, status) VALUES ('$ticket_number', '$user_id', '$category', '$subject', '$message', 'Open')";
            if (mysqli_query($conn, $sql)) {
                header("Location: ../Admin/dashboard.php?msg=" . urlencode("Ticket submitted successfully!"));
                exit();
            } else {
                $msg = "<div class='alert alert-error'>Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $msg = "<div class='alert alert-error'>All fields are required.</div>";
        }
    }
}

// Fetch User Tickets (if logged in)
$my_tickets = [];
if ($user_id) {
    $sql_tickets = "SELECT * FROM support_tickets WHERE customer_id = '$user_id' ORDER BY created_at DESC";
    $result_tickets = mysqli_query($conn, $sql_tickets);
    if ($result_tickets) {
        $my_tickets = mysqli_fetch_all($result_tickets, MYSQLI_ASSOC);

        // Mark as read if viewing history tab
        if ($tab == 'history' && count($my_tickets) > 0) {
            $sql_mark_read = "UPDATE support_tickets SET is_read = 1 WHERE customer_id = '$user_id'";
            mysqli_query($conn, $sql_mark_read);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUSTOMER SERVICE | IMARKET PH</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/services/customer_service.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <nav>
        <?php
        $path_prefix = '../';
        include '../Components/header.php';
        ?>
    </nav>

    <div class="service-container">
        <!-- Sidebar -->
        <div class="service-sidebar">
            <h3>Customer Service</h3>
            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="?tab=faq" class="<?php echo $tab == 'faq' ? 'active' : ''; ?>">
                            <i class="fas fa-question-circle"></i> FAQs
                        </a>
                    </li>
                    <li>
                        <a href="?tab=submit" class="<?php echo $tab == 'submit' ? 'active' : ''; ?>">
                            <i class="fas fa-edit"></i> Submit a Ticket
                        </a>
                    </li>
                    <li>
                        <a href="?tab=history" class="<?php echo $tab == 'history' ? 'active' : ''; ?>">
                            <i class="fas fa-history"></i> My Tickets
                        </a>
                    </li>
                    <li>
                        <a href="Contact Us.php">
                            <i class="fas fa-envelope"></i> Contact Us
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="service-content">
            <?php echo $msg; ?>

            <!-- FAQ Tab -->
            <?php if ($tab == 'faq'): ?>
                <div class="section-header">
                    <h2>Frequently Asked Questions</h2>
                    <p>Find quick answers to common questions.</p>
                </div>

                <div class="faq-item">
                    <h4><i class="fas fa-shipping-fast"></i> How long does shipping take?</h4>
                    <p>Standard shipping takes 3-5 business days within Metro Manila and 5-10 business days for provincial
                        areas.</p>
                </div>
                <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

                <div class="faq-item">
                    <h4><i class="fas fa-undo"></i> What is the return policy?</h4>
                    <p>You can return items within 7 days of receipt if they are defective or damaged. Please visit our <a
                            href="Return & Refund.php">Return Policy</a> page for more details.</p>
                </div>
                <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

                <div class="faq-item">
                    <h4><i class="fas fa-user-lock"></i> How do I reset my password?</h4>
                    <p>Go to the login page and click on "Forgot Password". Follow the instructions sent to your email.</p>
                </div>

                <!-- Submit Ticket Tab -->
            <?php elseif ($tab == 'submit'): ?>
                <div class="section-header">
                    <h2>Submit a Support Ticket</h2>
                    <p>Tell us about your issue and we'll help you resolve it.</p>
                </div>

                <?php if ($user_id): ?>
                    <form action="?tab=submit" method="POST" class="ticket-form">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category" required>
                                <option value="">Select a Category</option>
                                <option value="Order Issue">Order Issue (Tracking, Missing Items)</option>
                                <option value="Product Inquiry">Product Inquiry</option>
                                <option value="Account & Login">Account & Login</option>
                                <option value="Returns & Refunds">Returns & Refunds</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" name="subject" placeholder="Brief summary of the issue" required>
                        </div>

                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="message" rows="6" placeholder="Describe your issue in detail..."
                                required></textarea>
                        </div>

                        <button type="submit" name="submit_ticket" class="btn-submit">
                            Submit Ticket <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-lock"></i>
                        <h3>Login Required</h3>
                        <p>Please log in to submit a support ticket.</p>
                        <!-- Assuming a login modal or page exists, linking to a generic login path or just checking session -->
                        <!-- If you have a specific login link, add it here. For now just text. -->
                    </div>
                <?php endif; ?>

                <!-- Ticket History Tab -->
            <?php elseif ($tab == 'history'): ?>
                <div class="section-header">
                    <h2>My Support Tickets</h2>
                    <p>Track the status of your reported issues.</p>
                </div>

                <?php if ($user_id): ?>
                    <?php if (count($my_tickets) > 0): ?>
                        <div style="overflow-x: auto;">
                            <table class="ticket-list">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Category</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($my_tickets as $ticket): ?>
                                        <tr>
                                            <td>#<?php echo $ticket['ticket_number']; ?></td>
                                            <td><?php echo date('M d, Y', strtotime($ticket['created_at'])); ?></td>
                                            <td><?php echo htmlspecialchars($ticket['category']); ?></td>
                                            <td>
                                                <?php echo htmlspecialchars($ticket['subject']); ?>
                                                <?php if (isset($ticket['is_read']) && $ticket['is_read'] == 0): ?>
                                                    <span
                                                        style="background: #ff4d4f; color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px; margin-left: 5px; font-weight: bold;">NEW</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = 'status-open';
                                                if ($ticket['status'] == 'In Progress')
                                                    $statusClass = 'status-inprogress';
                                                if ($ticket['status'] == 'Resolved')
                                                    $statusClass = 'status-resolved';
                                                if ($ticket['status'] == 'Closed')
                                                    $statusClass = 'status-closed';
                                                ?>
                                                <span class="badge <?php echo $statusClass; ?>"><?php echo $ticket['status']; ?></span>
                                            </td>
                                        </tr>
                                        <?php if (!empty($ticket['admin_reply'])): ?>
                                            <tr style="background-color: #f9fafb;">
                                                <td colspan="5" style="padding: 15px; color: #4b5563; font-size: 0.9em;">
                                                    <strong style="color: #2A3B7E;"><i class="fas fa-reply"></i> Admin
                                                        Response:</strong><br>
                                                    <?php echo nl2br(htmlspecialchars($ticket['admin_reply'])); ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-ticket-alt"></i>
                            <p>You haven't submitted any tickets yet.</p>
                            <a href="?tab=submit" class="btn-submit" style="text-decoration: none;">Submit a Request</a>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-lock"></i>
                        <h3>Login Required</h3>
                        <p>Please log in to view your tickets.</p>
                    </div>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>

    <footer>
        <?php include '../Components/footer.php'; ?>
    </footer>
</body>

</html>