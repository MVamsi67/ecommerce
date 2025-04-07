<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $image_url = trim($_POST['image_url']); // External image URL input

    if (!empty($name) && !empty($price) && !empty($image_url) && filter_var($image_url, FILTER_VALIDATE_URL)) {
        $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
        $stmt->execute([$name, $price, $image_url]);
        echo "<script>alert('Product added successfully!'); window.location.href='manage_products.php';</script>";
    } else {
        echo "<script>alert('Please fill in all fields and provide a valid image URL!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        h2 {
            margin-bottom: 20px;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background: #0056b3;
        }
        a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        a:hover {
            color: #0056b3;
        }
        /* Image Preview */
        .preview-container {
            margin-top: 10px;
            position: relative;
            text-align: center;
        }
        .preview-container img {
            max-width: 100%;
            border-radius: 5px;
            display: none;
            border: 2px solid #ddd;
        }
        .error-message {
            color: red;
            font-size: 14px;
            display: none;
        }
    </style>
</head>
<body>

    <h2>Add Product</h2>

    <div class="form-container">
        <form method="POST" onsubmit="return validateForm()">
            <label>Product Name</label>
            <input type="text" name="name" required>

            <label>Price</label>
            <input type="number" name="price" step="0.01" required>

            <label>Image URL</label>
            <input type="text" name="image_url" id="image_url" required placeholder="Paste Image URL" oninput="previewImage()">
            
            <!-- Image Preview -->
            <div class="preview-container">
                <img id="preview" src="" alt="Image Preview">
                <p class="error-message" id="image-error">Invalid image URL</p>
            </div>

            <button type="submit">Add Product</button>
        </form>

        <a href="manage_products.php">Back to Products</a>
    </div>

    <script>
        function previewImage() {
            var url = document.getElementById("image_url").value;
            var img = document.getElementById("preview");
            var errorMsg = document.getElementById("image-error");

            if (url) {
                img.src = url;
                img.style.display = "block";

                img.onerror = function () {
                    img.style.display = "none";
                    errorMsg.style.display = "block";
                };

                img.onload = function () {
                    errorMsg.style.display = "none";
                };
            } else {
                img.style.display = "none";
                errorMsg.style.display = "none";
            }
        }

        function validateForm() {
            var imageUrl = document.getElementById("image_url").value;
            var errorMsg = document.getElementById("image-error");

            if (!imageUrl || errorMsg.style.display === "block") {
                alert("Please enter a valid image URL.");
                return false;
            }
            return true;
        }
    </script>

</body>
</html>
