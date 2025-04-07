<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../db.php';

$user_id = $_SESSION['user_id'];

// Fetch the user's cart items
$stmt = $conn->prepare("SELECT cart.id, cart.quantity, products.name, products.price, products.image 
                        FROM cart 
                        JOIN products ON cart.product_id = products.id 
                        WHERE cart.user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - My eCommerce Store</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
    <h1>Your Shopping Cart</h1>
    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<main>
    <?php if (isset($_SESSION['message'])): ?>
    <p style="color: green;"><?= $_SESSION['message']; ?></p>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

    <?php if (empty($cart_items)): ?>
        <p style="font-size: 18px; color: red;">Your cart is empty. <a href="../index.php">Continue Shopping</a></p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php 
            $total_price = 0;
            foreach ($cart_items as $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total_price += $subtotal;
            ?>
            <tr>
                <td>
                    <img src="../images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="50">
                    <?= htmlspecialchars($item['name']) ?>
                </td>
                <td>₹<?= htmlspecialchars($item['price']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>₹<?= $subtotal ?></td>
                <td>
                    <a href="remove_from_cart.php?id=<?= $item['id'] ?>">Remove</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td colspan="2">₹<?= $total_price ?></td>
            </tr>
        </table>
        <br>
        <a href="checkout.php">Proceed to Checkout</a>
    <?php endif; ?>
</main>

</body>
</html>
