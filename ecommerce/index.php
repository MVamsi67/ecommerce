<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - My eCommerce Store</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <!-- Navigation Bar -->
    <header>
        <h1>Welcome to Our Store</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="pages/cart.php">Cart</a></li>
                <li><a href="pages/orders.php">Orders</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="pages/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="pages/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Success Message -->
    <div id="cart-message" style="display: none; color: green; font-weight: bold; text-align: center;"></div>

    <!-- Main Content -->
    <main>
        <h2>Featured Products</h2>
        <div class="product-list">
            <?php
            try {
                $stmt = $conn->prepare("SELECT id, name, price, image FROM products");
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($products)) {
                    foreach ($products as $product) {
                        ?>
                        <div class='product'>
                            <img src='<?= htmlspecialchars($product['image']) ?>' alt='<?= htmlspecialchars($product['name']) ?>' width='150'>
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <p>₹<?= htmlspecialchars($product['price']) ?></p>
                            <button class='add-to-cart' data-id='<?= $product['id'] ?>'>Add to Cart</button>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No products available.</p>";
                }
            } catch (PDOException $e) {
                echo "<p style='color: red;'>Error fetching products: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            ?>
        </div>
    </main>

    <script>
    $(document).ready(function() {
        $(".add-to-cart").click(function() {
            var productId = $(this).data("id");

            $.ajax({
                url: "pages/add_to_cart.php",
                type: "POST",
                data: { product_id: productId },
                dataType: "json",
                success: function(response) {
                    $("#cart-message").text(response.message).css("color", response.status === "success" ? "green" : "red").fadeIn().delay(2000).fadeOut();
                },
                error: function() {
                    $("#cart-message").text("Error adding product to cart.").css("color", "red").fadeIn().delay(2000).fadeOut();
                }
            });
        });
    });
    </script>

</body>
</html>
