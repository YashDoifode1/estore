<?php
// Start session


// Include header and database connection
include "includes/header.php";
include "includes/db.php";

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Calculate total cost
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Handle form submission for order placement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = htmlspecialchars($_POST['customer_name']);
    $customer_email = htmlspecialchars($_POST['customer_email']);
    $customer_address = htmlspecialchars($_POST['customer_address']);
    $payment_method = htmlspecialchars($_POST['payment_method']);

    // Placeholder for order confirmation
    // In a real application, you would save order details to the database here

    // Clear cart
    $_SESSION['cart'] = [];

    // Redirect to a confirmation page
    header("Location: confirmation.php?name=" . urlencode($customer_name));
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .checkout-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .checkout-container h2 {
            margin-bottom: 20px;
        }

        .checkout-container form {
            display: flex;
            flex-direction: column;
        }

        .checkout-container label {
            margin-top: 10px;
            font-weight: bold;
        }

        .checkout-container input, .checkout-container select {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .checkout-container button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            margin-top: 20px;
        }

        .checkout-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="checkout-container">
    <h2>Checkout</h2>
    <p>Total Amount: <strong>$<?= number_format($total, 2); ?></strong></p>
    <form method="POST">
        <label for="customer_name">Name:</label>
        <input type="text" id="customer_name" name="customer_name" required>

        <label for="customer_email">Email:</label>
        <input type="email" id="customer_email" name="customer_email" required>

        <label for="customer_address">Address:</label>
        <textarea id="customer_address" name="customer_address" rows="4" required></textarea>

        <label for="payment_method">Payment Method:</label>
        <select id="payment_method" name="payment_method" required>
            <option value="credit_card">Credit Card</option>
            <option value="debit_card">Debit Card</option>
            <option value="paypal">PayPal</option>
            <option value="cash_on_delivery">Cash on Delivery</option>
        </select>

        <button type="submit">Place Order</button>
    </form>
</div>
</body>
</html>

<?php
// Include footer
// include "includes/footer.php";
?>
