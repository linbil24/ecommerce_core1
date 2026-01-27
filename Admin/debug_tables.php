<?php
require_once __DIR__ . "/../Database/config.php";
$tables = ['store_chat_messages', 'support_tickets', 'reviews', 'orders'];
foreach ($tables as $table) {
    echo "--- $table ---\n";
    if (isset($conn) && $conn) {
        $res = $conn->query("DESCRIBE $table");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                echo "{$row['Field']} ({$row['Type']})\n";
            }
        } else {
            echo "Error: " . $conn->error . "\n";
        }
    } else {
        echo "Error: \$conn is not defined\n";
    }
}
?>