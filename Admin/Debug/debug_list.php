<?php
require_once 'admin/connection.php';
require_once 'admin/functions.php';

try {
    $pdo = get_db_connection();
    echo "Connected via PDO (Port " . getenv('DB_PORT') . ")\n";

    // Check Orders Table Columns
    echo "\n--- Orders Table Columns ---\n";
    $stmt = $pdo->query("DESCRIBE orders");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        echo $col['Field'] . " (" . $col['Type'] . ")\n";
    }

    // Test get_customers_list
    echo "\n--- Testing get_customers_list() ---\n";
    $customers = get_customers_list($pdo);
    echo "Count: " . count($customers) . "\n";
    print_r($customers);

    // If empty, try basic Select
    if (empty($customers)) {
        echo "\n--- Debug: Basic SELECT FROM users ---\n";
        $stmt = $pdo->query("SELECT * FROM users");
        print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


