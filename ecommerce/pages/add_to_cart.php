<?php
session_start();
include '../db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'] ?? 0;

    if ($user_id == 0) {
        echo json_encode(["status" => "error", "message" => "Please log in to add items to your cart."]);
        exit();
    }

    try {
        $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cartItem) {
            $newQuantity = $cartItem['quantity'] + 1;
            $updateStmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $updateStmt->execute([$newQuantity, $cartItem['id']]);
        } else {
            $insertStmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
            $insertStmt->execute([$user_id, $product_id]);
        }

        echo json_encode(["status" => "success", "message" => "Product added to cart!"]);
        exit();
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
        exit();
    }
}
?>
