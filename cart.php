<?php
// Start session


// Include header
include "includes/header.php";

// Check if the cart exists in the session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Calculate total cost
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Handle item removal
if (isset($_POST['remove_item'])) {
    $item_id = $_POST['item_id'];

    // Remove the item from the cart
    foreach ($cart as $key => $item) {
        if ($item['id'] == $item_id) {
            unset($cart[$key]);
        }
    }

    // Update session cart
    $_SESSION['cart'] = $cart;

    // Redirect to refresh the page
    header("Location: cart.php");
    exit();
}

// Handle updating item quantities
if (isset($_POST['update_quantity'])) {
    $item_id = $_POST['item_id'];
    $new_quantity = intval($_POST['new_quantity']);

    // Update quantity in the cart
    foreach ($cart as &$item) {
        if ($item['id'] == $item_id) {
            $item['quantity'] = $new_quantity;
        }
    }

    // Update session cart
    $_SESSION['cart'] = $cart;

    // Redirect to refresh the page
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .cart-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .cart-container h2 {
            margin-bottom: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        .cart-item-details {
            flex-grow: 1;
            margin-left: 20px;
        }

        .cart-item-actions {
            text-align: center;
        }

        .cart-item-actions input {
            width: 60px;
            padding: 5px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .cart-item-actions button {
            margin-top: 5px;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .cart-item-actions button:hover {
            background-color: #0056b3;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }

        .checkout-button {
            display: block;
            text-align: center;
            margin-top: 20px;
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .checkout-button:hover {
            background-color: #218838;
        }

        .empty-cart {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="cart-container">
    <h2>Your Cart</h2>
    <?php if (!empty($cart)): ?>
        <?php foreach ($cart as $item): ?>
            <div class="cart-item">
            <img src="<?= isset($item['image']) ? htmlspecialchars($item['image']) : 'images/default.jfif'; ?>" alt="<?= htmlspecialchars($item['name']); ?>">


                <div class="cart-item-details">
                    <h4><?= htmlspecialchars($item['name']); ?></h4>
                    <p>Price: $<?= htmlspecialchars(number_format($item['price'], 2)); ?></p>
                </div>
                <div class="cart-item-actions">
                    <form method="POST">
                        <input type="hidden" name="item_id" value="<?= $item['id']; ?>">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="new_quantity" value="<?= $item['quantity']; ?>" min="1">
                        <button type="submit" name="update_quantity">Update</button>
                        <button type="submit" name="remove_item" style="background-color: #dc3545;">Remove</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
        <p class="total">Total: $<?= number_format($total, 2); ?></p>
        <a href="checkout.php" class="checkout-button">Proceed to Checkout</a>
    <?php else: ?>
        <p class="empty-cart">Your cart is empty. <a href="product.php">Continue Shopping</a></p>
    <?php endif; ?>
</div>
</body>
</html>

<?php
// Include footer
// include "includes/footer.php";
?>
