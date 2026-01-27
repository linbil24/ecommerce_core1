<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
require_once('../Database/config.php');

header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

/**
 * Enhanced Time Ago Function
 */
function timeAgo($timestamp)
{
    if (!$timestamp)
        return 'Unknown time';

    $time = is_numeric($timestamp) ? $timestamp : strtotime($timestamp);
    if (!$time)
        return 'Invalid date';

    $diff = time() - $time;

    if ($diff < 0)
        return 'Just now';
    if ($diff < 60)
        return $diff . ' seconds ago';
    if ($diff < 120)
        return '1 minute ago';
    if ($diff < 3600)
        return floor($diff / 60) . ' minutes ago';
    if ($diff < 7200)
        return '1 hour ago';
    if ($diff < 86400)
        return floor($diff / 3600) . ' hours ago';
    if ($diff < 172800)
        return 'Yesterday';
    if ($diff < 604800)
        return floor($diff / 86400) . ' days ago';

    return date('M d, Y', $time);
}

$notifications = [];

// 1. Get Chat Notifications
$chat_sql = "SELECT scm.*, u.fullname as customer_name 
             FROM store_chat_messages scm 
             LEFT JOIN users u ON scm.user_id = u.id 
             WHERE scm.sender_type = 'customer' AND scm.is_read = 0 
             ORDER BY scm.created_at DESC 
             LIMIT 15";
$chat_result = mysqli_query($conn, $chat_sql);

if ($chat_result) {
    while ($row = mysqli_fetch_assoc($chat_result)) {
        $msg_text = $row['message'] ?? $row['message_text'] ?? '';
        $notifications[] = [
            'id' => 'chat_' . $row['id'],
            'type' => 'chat',
            'title' => 'Message from ' . ($row['customer_name'] ?? 'Customer'),
            'message' => substr($msg_text, 0, 60) . (strlen($msg_text) > 60 ? '...' : ''),
            'time_ago' => timeAgo($row['created_at']),
            'raw_time' => strtotime($row['created_at']),
            'is_read' => false,
            'source' => 'Store Chat'
        ];
    }
}

// 2. Get Recent Support Tickets
$ticket_sql = "SELECT * FROM support_tickets WHERE status = 'Open' ORDER BY created_at DESC LIMIT 10";
$ticket_result = mysqli_query($conn, $ticket_sql);

if ($ticket_result) {
    while ($row = mysqli_fetch_assoc($ticket_result)) {
        $notifications[] = [
            'id' => 'ticket_' . $row['id'],
            'type' => 'support',
            'title' => 'Ticket #' . $row['ticket_number'],
            'message' => $row['subject'],
            'time_ago' => timeAgo($row['created_at']),
            'raw_time' => strtotime($row['created_at']),
            'is_read' => $row['is_read'] == 1,
            'source' => 'Support Desk'
        ];
    }
}

// 3. Get Recent Reviews
$review_sql = "SELECT r.*, u.fullname as customer_name 
               FROM reviews r 
               LEFT JOIN users u ON r.user_id = u.id 
               ORDER BY r.created_at DESC 
               LIMIT 10";
$review_result = mysqli_query($conn, $review_sql);

if ($review_result) {
    while ($row = mysqli_fetch_assoc($review_result)) {
        $comment = $row['comment'] ?? '';
        $notifications[] = [
            'id' => 'review_' . $row['id'],
            'type' => 'review',
            'title' => 'New ' . $row['rating'] . '-Star Review',
            'message' => '"' . substr($comment, 0, 45) . (strlen($comment) > 45 ? '...' : '') . '"',
            'time_ago' => timeAgo($row['created_at']),
            'raw_time' => strtotime($row['created_at']),
            'is_read' => false,
            'source' => 'Marketplace'
        ];
    }
}

// 4. Get Order Notifications
$order_sql = "SELECT id, full_name, total_amount, status, created_at 
              FROM orders 
              WHERE status IN ('Pending', 'Processing') 
              ORDER BY created_at DESC 
              LIMIT 10";
$order_result = mysqli_query($conn, $order_sql);

if ($order_result) {
    while ($row = mysqli_fetch_assoc($order_result)) {
        $notifications[] = [
            'id' => 'order_' . $row['id'],
            'type' => 'order',
            'title' => 'New Order From ' . $row['full_name'],
            'message' => 'Order Total: ₱' . number_format($row['total_amount'], 2) . ' (Status: ' . $row['status'] . ')',
            'time_ago' => timeAgo($row['created_at']),
            'raw_time' => strtotime($row['created_at']),
            'is_read' => false,
            'source' => 'Sales Gateway'
        ];
    }
}

// Sort by most recent using raw_time
usort($notifications, function ($a, $b) {
    return $b['raw_time'] - $a['raw_time'];
});

// Limit final output
$final_notifications = array_slice($notifications, 0, 50);

echo json_encode([
    'success' => true,
    'notifications' => $final_notifications,
    'count' => count($final_notifications),
    'timestamp' => time()
]);
?>