<?php
require_once 'admin/connection.php';

try {
    $pdo = get_db_connection();

    echo "--- Tables in DB ---\n";
    $stmt = $pdo->query("SHOW TABLES");
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        echo $row[0] . "\n";
    }

    echo "\n--- Users (Customer) Table ---\n";
    try {
        $stmt = $pdo->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Count: " . count($users) . "\n";
        print_r($users);
    } catch (Exception $e) {
        echo "Error reading users: " . $e->getMessage() . "\n";
    }

    echo "\n--- Admin Users Table ---\n";
    try {
        $stmt = $pdo->query("SELECT * FROM admin_users");
        $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Count: " . count($admins) . "\n";
        print_r($admins);
    } catch (Exception $e) {
        echo "Error reading admin_users: " . $e->getMessage() . "\n";
    }

} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}


