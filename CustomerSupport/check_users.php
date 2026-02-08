<?php
// CustomerSupport/check_users.php
require_once __DIR__ . '/connection.php';

echo "<h1>Admin Users Debug List</h1>";

try {
    $pdo = get_db_connection();
    $stmt = $pdo->query("SELECT id, username, email, role, full_name, created_at FROM admin_users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($users)) {
        echo "<p style='color:red'>No users found in 'admin_users' table.</p>";
    } else {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Full Name</th><th>Created</th></tr>";
        foreach ($users as $u) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($u['id']) . "</td>";
            echo "<td>" . htmlspecialchars($u['username']) . "</td>";
            echo "<td>" . htmlspecialchars($u['email']) . "</td>";
            echo "<td>" . htmlspecialchars($u['role']) . "</td>";
            echo "<td>" . htmlspecialchars($u['full_name']) . "</td>";
            echo "<td>" . htmlspecialchars($u['created_at']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo "<br><br><a href='create_support_user.php'>Go to Account Setup</a> | <a href='login.php'>Go to Login</a>";
?>
