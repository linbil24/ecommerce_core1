<?php
require_once 'admin/connection.php';
// require_once 'admin/functions.php'; // Skipping to avoid path issues

try {
    $pdo = get_db_connection();
    echo "Connected via PDO (Port " . getenv('DB_PORT') . ")\n";

    // Check Orders Table Columns
    echo "\n--- Orders Table Columns ---\n";
    try {
        $stmt = $pdo->query("DESCRIBE orders");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($columns as $col) {
            echo $col['Field'] . " (" . $col['Type'] . ")\n";
        }
    } catch (Exception $e) {
        echo "Orders table error: " . $e->getMessage() . "\n";
    }

    // Manual Query matching get_customers_list
    echo "\n--- Testing Query ---\n";
    $sql = "SELECT c.id, c.fullname as full_name, c.email, c.phone as phone_number, 'Active' as status, '2024-01-01' as created_at,
                   (SELECT COUNT(*) FROM orders WHERE customer_id = c.id) as total_orders,
                   (SELECT SUM(total_amount) FROM orders WHERE customer_id = c.id AND status != 'Cancelled') as total_spent
            FROM users c
            ORDER BY c.id DESC";

    try {
        $stmt = $pdo->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Count: " . count($customers) . "\n";
        print_r($customers);
    } catch (Exception $e) {
        echo "Query Error: " . $e->getMessage() . "\n";
    }

} catch (Exception $e) {
    echo "Connection error: " . $e->getMessage();
}


