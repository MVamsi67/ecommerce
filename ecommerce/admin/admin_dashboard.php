<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General Reset */
        body, h2, a {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Page Styling */
        body {
            background-color: #f8f9fa;
            text-align: center;
            padding: 50px;
        }

        .admin-container {
            width: 50%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
            color: #007bff;
        }

        .admin-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn {
            display: block;
            padding: 12px;
            text-align: center;
            color: white;
            background: #007bff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn:hover {
            background: #0056b3;
        }

        .btn-logout {
            background: #dc3545;
        }

        .btn-logout:hover {
            background: #c82333;
        }
    </style>
</head>
<body>

<div class="admin-container">
    <h2>Admin Dashboard</h2>
    <div class="admin-actions">
        <a href="manage_products.php" class="btn">Manage Products</a>
        <a href="manage_orders.php" class="btn">Manage Orders</a>
        <a href="manage_users.php" class="btn">Manage Users</a>
        <a href="admin_logout.php" class="btn btn-logout">Logout</a>
    </div>
</div>

</body>
</html>
