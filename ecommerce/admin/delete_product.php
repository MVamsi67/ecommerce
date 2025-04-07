<?php
include '../db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Delete product
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo "<script>alert('Product deleted successfully!'); window.location.href='manage_products.php';</script>";
    } else {
        echo "<script>alert('Error deleting product!'); window.location.href='manage_products.php';</script>";
    }
} else {
    echo "<script>alert('Invalid product ID!'); window.location.href='manage_products.php';</script>";
}
?>
