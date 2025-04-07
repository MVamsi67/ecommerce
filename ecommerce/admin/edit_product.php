<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Product ID missing!");
}

$product_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $image = trim($_POST['image']);

    $updateStmt = $conn->prepare("UPDATE products SET name = ?, price = ?, image = ? WHERE id = ?");
    $updateStmt->execute([$name, $price, $image, $product_id]);

    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="edit-container">
    <h2>Edit Product</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

        <label>Price:</label>
        <input type="text" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>

        <label>Image URL:</label>
        <input type="text" name="image" value="<?= htmlspecialchars($product['image']) ?>" required>

        <button type="submit">Update Product</button>
    </form>
    <a href="manage_products.php" class="back-btn">Back to Products</a>
</div>

</body>
</html>
