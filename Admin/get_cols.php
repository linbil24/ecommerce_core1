<?php
header('Content-Type: application/json');
require_once __DIR__ . "/../Database/config.php";
$result = [];
$tables = ['store_chat_messages', 'support_tickets', 'reviews', 'orders'];
foreach ($tables as $table) {
    $res = $conn->query("DESCRIBE $table");
    if ($res) {
        $cols = [];
        while ($row = $res->fetch_assoc()) {
            $cols[] = $row['Field'];
        }
        $result[$table] = $cols;
    } else {
        $result[$table] = "Error: " . $conn->error;
    }
}
echo json_encode($result);
?>