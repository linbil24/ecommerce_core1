<?php
session_start();
include("../Database/config.php");

header('Content-Type: application/json');

function timeAgo($timestamp)
{
    $time = strtotime($timestamp);
    $diff = time() - $time;

    if ($diff < 60)
        return 'Just now';
    if ($diff < 3600)
        return floor($diff / 60) . ' minutes ago';
    if ($diff < 86400)
        return floor($diff / 3600) . ' hours ago';
    if ($diff < 604800)
        return floor($diff / 86400) . ' days ago';
    return date('M d, Y', $time);
}

$notifications = [];

// Get chat notifications
$chat_sql = "SELECT scm.*, u.fullname as customer_name 
             FROM store_chat_messages scm 
             LEFT JOIN users u ON scm.user_id = u.id 
             WHERE scm.sender_type = 'customer' AND scm.is_read = 0 
             ORDER BY scm.created_at DESC 
             LIMIT 10";
$chat_result = mysqli_query($conn, $chat_sql);

if ($chat_result) {
    while ($row = mysqli_fetch_assoc($chat_result)) {
        $notifications[] = [
            'id' => $row['id'],
            'type' => 'chat',
            'title' => 'New Chat Message',
            'message' => ($row['customer_name'] ?? 'Customer') . ' sent a message about ' . $row['store_name'],
            'time_ago' => timeAgo($row['created_at']),
            'is_read' => false
        ];
    }
}

// Get support ticket notifications
$ticket_sql = "SELECT * FROM support_tickets WHERE status = 'Open' ORDER BY created_at DESC LIMIT 5";
$ticket_result = mysqli_query($conn, $ticket_sql);

if ($ticket_result) {
    while ($row = mysqli_fetch_assoc($ticket_result)) {
        $notifications[] = [
            'id' => 'ticket_' . $row['id'],
            'type' => 'support',
            'title' => 'New Support Ticket',
            'message' => 'Ticket #' . $row['ticket_number'] . ': ' . substr($row['subject'], 0, 50),
            'time_ago' => timeAgo($row['created_at']),
            'is_read' => $row['is_read'] == 1
        ];
    }
}

// Sort by most recent
usort($notifications, function ($a, $b) {
    return strcmp($b['time_ago'], $a['time_ago']);
});

echo json_encode(['success' => true, 'notifications' => array_slice($notifications, 0, 10)]);
?>