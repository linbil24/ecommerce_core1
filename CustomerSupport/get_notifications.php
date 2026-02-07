<?php
// CustomerSupport/get_notifications.php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
require_once('../Database/config.php');

header('Content-Type: application/json');

if (!isset($_SESSION['support_logged_in']) || $_SESSION['support_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

function timeAgo($timestamp) {
    if (!$timestamp) return 'Unknown time';
    $time = is_numeric($timestamp) ? $timestamp : strtotime($timestamp);
    if (!$time) return 'Invalid date';
    $diff = time() - $time;
    if ($diff < 0) return 'Just now';
    if ($diff < 60) return $diff . ' seconds ago';
    if ($diff < 120) return '1 minute ago';
    if ($diff < 3600) return floor($diff / 60) . ' minutes ago';
    if ($diff < 7200) return '1 hour ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    if ($diff < 172800) return 'Yesterday';
    if ($diff < 604800) return floor($diff / 86400) . ' days ago';
    return date('M d, Y', $time);
}

$notifications = [];

// 1. Get Chat Notifications
$chat_sql = "SELECT scm.*, u.fullname as customer_name FROM store_chat_messages scm LEFT JOIN users u ON scm.user_id = u.id WHERE scm.sender_type = 'customer' AND scm.is_read = 0 ORDER BY scm.created_at DESC LIMIT 15";
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
            'is_read' => false
        ];
    }
}

// 2. Get Support Tickets
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
            'is_read' => $row['is_read'] == 1
        ];
    }
}

usort($notifications, function ($a, $b) { return $b['raw_time'] - $a['raw_time']; });
$final_notifications = array_slice($notifications, 0, 50);

echo json_encode(['success' => true, 'notifications' => $final_notifications, 'count' => count($final_notifications)]);
?>
