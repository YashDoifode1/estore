<?php
// Start session and include necessary files

include "..\includes/header.php";
include "..\includes/db.php";

// if (!isset($_SESSION['user_id'])) { // Replace 'user_id' with the session variable you want to check
//     // Redirect to the login page using the APP_URL
//     header("Location: " . APP_URL . "/login.php"); // Ensure APP_URL ends without a trailing slash
//     exit(); // Stop further script execution
// }

// Fetch product details based on product_id
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
$sql = "SELECT id, name, description, price, image FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Handle add-to-cart functionality
if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    $product_image = $_POST['product_image']; // Add product image

    // Add product to cart
    $item = [
        'id' => $product_id,
        'name' => $product_name,
        'price' => $product_price,
        'quantity' => $product_quantity,
        'image' => $product_image // Include the image in the cart item
    ];

    // Check if product already exists in the cart
    $is_found = false;
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] === $product_id) {
            $cart_item['quantity'] += $product_quantity;
            $is_found = true;
            break;
        }
    }

    if (!$is_found) {
        $_SESSION['cart'][] = $item;
    }

    // Redirect to Cart Page after adding to cart
    header("Location: cart.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Info</title>
    <link rel="stylesheet" href="..\css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .info-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
        }

        .info-container img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .info-container h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .info-container p {
            font-size: 16px;
            line-height: 1.5;
        }

        .info-container form {
            margin-top: 20px;
        }

        input[type="number"] {
            width: 60px;
            padding: 5px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="info-container">
    <?php if ($product): ?>
        <img src="..\<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
        <h2><?= htmlspecialchars($product['name']); ?></h2>
        <p><?= htmlspecialchars($product['description']); ?></p>
        <p><strong>Price: $<?= htmlspecialchars($product['price']); ?></strong></p>
        <form method="POST">
    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
    <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']); ?>">
    <input type="hidden" name="product_price" value="<?= $product['price']; ?>">
    <input type="hidden" name="product_image" value="<?= htmlspecialchars($product['image']); ?>">
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="product_quantity" value="1" min="1">
    <button type="submit" name="add_to_cart">Add to Cart</button>
</form>

        <div class="back-button">
            <button onclick="window.location.href='product.php'">Back to Products</button>
        </div>
    <?php else: ?>
        <p>Product not found. <a href="product.php">Go back to shop</a></p>
    <?php endif; ?>
</div>
</body>
</html>

<?php
// Include footer
include "..\includes/footer.php";
?>
