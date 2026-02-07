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
$view_ticket_id = isset($_GET['view']) ? $_GET['view'] : null;
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
            $ticket_number = 'TKT-' . date('Y') . '-' . mt_rand(1000, 9999);
            $sql = "INSERT INTO support_tickets (ticket_number, customer_id, category, subject, message, status) VALUES ('$ticket_number', '$user_id', '$category', '$subject', '$message', 'Open')";
            if (mysqli_query($conn, $sql)) {
                $msg = "<div class='alert alert-success'>Ticket <strong>#$ticket_number</strong> submitted successfully! You can track it in 'My Tickets'.</div>";
                $tab = 'history'; 
            } else {
                $msg = "<div class='alert alert-error'>Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $msg = "<div class='alert alert-error'>All fields are required.</div>";
        }
    }
}

// Fetch User Tickets
$my_tickets = [];
$selected_ticket = null;

if ($user_id) {
    if ($view_ticket_id) {
        $sql_select = "SELECT * FROM support_tickets WHERE customer_id = '$user_id' AND ticket_number = '$view_ticket_id'";
        $res_select = mysqli_query($conn, $sql_select);
        if ($res_select && mysqli_num_rows($res_select) > 0) {
            $selected_ticket = mysqli_fetch_assoc($res_select);
            if (isset($selected_ticket['is_read']) && $selected_ticket['is_read'] == 0) {
                mysqli_query($conn, "UPDATE support_tickets SET is_read = 1 WHERE ticket_number = '$view_ticket_id'");
                $selected_ticket['is_read'] = 1;
            }
        }
    }
    $sql_tickets = "SELECT * FROM support_tickets WHERE customer_id = '$user_id' ORDER BY created_at DESC";
    $result_tickets = mysqli_query($conn, $sql_tickets);
    if ($result_tickets) {
        $my_tickets = mysqli_fetch_all($result_tickets, MYSQLI_ASSOC);
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
    
    <style>
        .ticket-row:hover { background-color: #f8fafc !important; cursor: pointer; }
    </style>
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
                    <li><a href="?tab=faq" class="<?php echo $tab == 'faq' ? 'active' : ''; ?>"><i class="fas fa-question-circle"></i> FAQs</a></li>
                    <li><a href="?tab=chat" class="<?php echo $tab == 'chat' ? 'active' : ''; ?>"><i class="fas fa-comments"></i> Live Support</a></li>
                    <li><a href="?tab=submit" class="<?php echo $tab == 'submit' ? 'active' : ''; ?>"><i class="fas fa-edit"></i> Submit a Ticket</a></li>
                    <li><a href="?tab=history" class="<?php echo $tab == 'history' || $tab == 'view' ? 'active' : ''; ?>"><i class="fas fa-history"></i> My Tickets</a></li>
                    <li><a href="Contact Us.php"><i class="fas fa-envelope"></i> Contact Us</a></li>
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
                    <p>Standard shipping takes 3-5 business days within Metro Manila and 5-10 business days for provincial areas.</p>
                </div>
                <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
                <div class="faq-item">
                    <h4><i class="fas fa-undo"></i> What is the return policy?</h4>
                    <p>You can return items within 7 days of receipt if they are defective or damaged.</p>
                </div>
                <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
                <div class="faq-item">
                    <h4><i class="fas fa-user-lock"></i> How do I reset my password?</h4>
                    <p>Go to the login page and click on "Forgot Password". Follow the instructions sent to your email.</p>
                </div>

            <!-- Live Chat Tab -->
            <?php elseif ($tab == 'chat'): ?>
                <div class="section-header">
                    <h2>Live Support Chat</h2>
                    <p>Chat with our support agents in real-time.</p>
                </div>
                <?php if ($user_id): ?>
                    <div class="chat-welcome">
                        <i class="fas fa-headset" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                        <strong>Welcome to Live Support!</strong><br>
                        Our agents are online and ready to help you with your inquiries.
                    </div>
                    <div class="chat-container">
                        <div id="chat-messages" class="chat-messages">
                            <div class="chat-bubble bubble-support">
                                Hello! I'm your I-Market support assistant. How can I help you today?
                                <span class="msg-time">Just now</span>
                            </div>
                        </div>
                        <div class="chat-input-area">
                            <input type="text" id="chat-input" class="chat-input" placeholder="Type your message here..." autocomplete="off">
                            <button onclick="sendMessage()" class="btn-send">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                    <script>
                        const chatInput = document.getElementById('chat-input');
                        const chatMessages = document.getElementById('chat-messages');
                        
                        // Load History
                        async function loadHistory() {
                            try {
                                const res = await fetch('../php/get_chat_history.php?store_name=Customer Support');
                                const data = await res.json();
                                if (data.success) {
                                    chatMessages.innerHTML = '';
                                    if (data.messages.length === 0) {
                                        chatMessages.innerHTML = `
                                            <div class="chat-bubble bubble-support">
                                                Hello! This is I-Market Live Support. How can we assist you today?
                                                <span class="msg-time">System</span>
                                            </div>`;
                                    }
                                    data.messages.forEach(m => {
                                        const side = m.sender_type === 'customer' ? 'customer' : 'support';
                                        chatMessages.innerHTML += `
                                            <div class="chat-bubble bubble-${side}">
                                                ${m.message}
                                                <span class="msg-time">${m.timestamp}</span>
                                            </div>`;
                                    });
                                    chatMessages.scrollTop = chatMessages.scrollHeight;
                                }
                            } catch (e) { console.error(e); }
                        }

                        async function sendMessage() {
                            const text = chatInput.value.trim();
                            if (!text) return;
                            chatInput.value = '';

                            // Optimistic UI
                            const now = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                            chatMessages.innerHTML += `
                                <div class="chat-bubble bubble-customer">
                                    ${text}
                                    <span class="msg-time">${now}</span>
                                </div>`;
                            chatMessages.scrollTop = chatMessages.scrollHeight;

                            const formData = new FormData();
                            formData.append('message', text);
                            formData.append('store_name', 'Customer Support');

                            try {
                                await fetch('../php/send_chat_message.php', { method: 'POST', body: formData });
                                loadHistory(); // Refresh
                            } catch (e) { console.error(e); }
                        }

                        chatInput.addEventListener('keypress', (e) => {
                            if (e.key === 'Enter') sendMessage();
                        });

                        loadHistory();
                        setInterval(loadHistory, 5000); // Polling every 5s
                    </script>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-lock"></i>
                        <h3>Login Required</h3>
                        <p>Please log in to start a live support session.</p>
                    </div>
                <?php endif; ?>

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
                                <option value="Order Issue">Order Issue</option>
                                <option value="Product Inquiry">Product Inquiry</option>
                                <option value="Account & Login">Account & Login</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" name="subject" placeholder="Brief summary" required>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="message" rows="6" placeholder="Details..." required></textarea>
                        </div>
                        <button type="submit" name="submit_ticket" class="btn-submit">Submit Ticket <i class="fas fa-paper-plane"></i></button>
                    </form>
                <?php else: ?>
                    <div class="empty-state"><i class="fas fa-lock"></i><h3>Login Required</h3></div>
                <?php endif; ?>

            <!-- Ticket History Tab -->
            <?php elseif ($tab == 'history'): ?>
                <?php if ($selected_ticket): ?>
                    <div style="margin-bottom: 2rem;">
                        <a href="?tab=history" style="color: #4f46e5; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                            <i class="fas fa-arrow-left"></i> Back to Tickets
                        </a>
                        <!-- ... (same detailed view logic as before) ... -->
                    </div>
                <?php else: ?>
                    <div class="section-header"><h2>My Support Tickets</h2></div>
                    <?php if ($user_id && count($my_tickets) > 0): ?>
                        <table class="ticket-list">
                            <thead><tr><th>ID</th><th>Date</th><th>Category</th><th>Subject</th><th>Status</th></tr></thead>
                            <tbody>
                                <?php foreach ($my_tickets as $ticket): ?>
                                    <tr class="ticket-row" onclick="window.location.href='?tab=history&view=<?php echo $ticket['ticket_number']; ?>'">
                                        <td>#<?php echo $ticket['ticket_number']; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($ticket['created_at'])); ?></td>
                                        <td><?php echo htmlspecialchars($ticket['category']); ?></td>
                                        <td><?php echo htmlspecialchars($ticket['subject']); ?></td>
                                        <td><span class="badge status-<?php echo strtolower(str_replace(' ', '', $ticket['status'])); ?>"><?php echo $ticket['status']; ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state"><i class="fas fa-ticket-alt"></i><p>No tickets found.</p></div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <footer style="margin-top: 50px;">
        <?php include '../Components/footer.php'; ?>
    </footer>
</body>
</html>
