<?php
require_once 'admin/connection.php';

try {
    $pdo = get_db_connection();

    echo "--- Checking customer_addresses table ---\n";
    try {
        $stmt = $pdo->query("SELECT * FROM customer_addresses");
        $addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Count: " . count($addresses) . "\n";
        print_r($addresses);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    echo "\n--- Checking users table addresses ---\n";
    try {
        $stmt = $pdo->query("SELECT id, fullname, address, city, zip FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r($users);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

} catch (Exception $e) {
    echo "Connection error: " . $e->getMessage();
}


