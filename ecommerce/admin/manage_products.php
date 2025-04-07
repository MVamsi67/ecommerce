<?php
session_start(); // Start session before any output
include '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            padding: 30px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
            font-size: 2rem;
        }

        .admin-container {
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .admin-actions {
            text-align: center;
            margin-bottom: 30px;
        }

        .admin-actions .btn {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            font-size: 1rem;
            margin: 5px;
            border-radius: 5px;
            display: inline-block;
            transition: 0.3s;
        }

        .admin-actions .btn:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table td {
            background-color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #e9ecef;
        }

        img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .btn-edit,
        .btn-delete {
            padding: 8px 15px;
            color: white;
            font-size: 14px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 5px;
            transition: 0.3s;
        }

        .btn-edit {
            background-color: #28a745;
        }

        .btn-edit:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            font-size: 14px;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="admin-container">
    <h2>Manage Products</h2>

    <div class="admin-actions">
        <a href="add_product.php" class="btn btn-add">Add New Product</a>
        <a href="admin_dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td>₹<?= htmlspecialchars($product['price']) ?></td>
                <td>
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image">
                </td>
                <td>
                    <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-edit">Edit</a>
                    <a href="manage_products.php?delete_id=<?= $product['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
