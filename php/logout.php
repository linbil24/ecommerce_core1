<?php
session_start();

if (isset($_POST['logout_confirm'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

if (isset($_POST['cancel'])) {
    header("Location: ../Content/Dashboard.php"); // Redirect back to dashboard if cancelled
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation - iMarket</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #AEE6F6;
            /* Light pink background matching Register/Login theme */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .logout-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .logout-card h2 {
            color: #3C436D;
            margin-bottom: 20px;
        }

        .logout-card p {
            color: #555;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        button {
            padding: 12px 25px;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s;
        }

        button:hover {
            transform: translateY(-2px);
        }

        .btn-yes {
            background-color: #3C436D;
            color: white;
        }

        .btn-no {
            background-color: #ddd;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="logout-card">
        <h2>Confirm Logout</h2>
        <p>Do you logout this Ecommerce exit the system?</p>
        <form action="" method="post" class="btn-group">
            <button type="submit" name="logout_confirm" class="btn-yes">Yes, Logout</button>
            <button type="submit" name="cancel" class="btn-no">No, Stay</button>
        </form>
    </div>
</body>

</html>
