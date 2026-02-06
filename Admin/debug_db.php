<?php
require_once 'connection.php';
$pdo = get_db_connection();
$stmt = $pdo->query("SHOW COLUMNS FROM products");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($columns, JSON_PRETTY_PRINT);
?>
