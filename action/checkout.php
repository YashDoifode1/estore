<?php
include "../includes/header.php";
include "../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: " . APP_URL . "/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Fetch user details from the database for autofill
$user_query = "SELECT username, email, address FROM users WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$stmt->close();

// Initialize variables
$cart_items = [];
$total = 0;

// Fetch product details from the database
foreach ($_SESSION['cart'] as $cart_item) {
    $product_id = intval($cart_item['id']);
    $quantity = intval($cart_item['quantity']);

    $query = "SELECT id, name, price, image, description FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $row['quantity'] = $quantity;
        $cart_items[] = $row;
        $total += $row['price'] * $quantity;
    }
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = htmlspecialchars($_POST['customer_name']);
    $customer_email = htmlspecialchars($_POST['customer_email']);
    $customer_address = htmlspecialchars($_POST['customer_address']);
    $payment_method = htmlspecialchars($_POST['payment_method']);

    if (!empty($customer_name) && !empty($customer_email) && !empty($customer_address) && !empty($payment_method)) {
        // Insert order into database
        $order_query = "INSERT INTO orders (user_id, customer_name, customer_email, customer_address, payment_method, total_amount) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($order_query);
        $stmt->bind_param("issssd", $user_id, $customer_name, $customer_email, $customer_address, $payment_method, $total);
        $stmt->execute();
        $order_id = $stmt->insert_id;
        $stmt->close();

        // Insert order items
        foreach ($cart_items as $item) {
            $item_query = "INSERT INTO order_items (order_id, user_id, product_id, quantity, price) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($item_query);
            $stmt->bind_param("iiiid", $order_id, $user_id, $item['id'], $item['quantity'], $item['price']);
            $stmt->execute();
            $stmt->close();
        }

        // Clear cart
        $_SESSION['cart'] = [];

        // Redirect to a confirmation page
        header("Location: confirmation.php?name=" . urlencode($customer_name) . "&order_id=" . urlencode($order_id));
        exit();
    } else {
        echo "<p style='color:red;'>Please fill in all required fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { font-family: Arial, sans-serif; }
        .checkout-container { max-width: 800px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        .checkout-container h2 { margin-bottom: 20px; }
        .product-details { display: flex; align-items: center; margin-bottom: 15px; }
        .product-details img { width: 80px; height: 80px; object-fit: cover; margin-right: 15px; border-radius: 5px; }
        .product-info { flex-grow: 1; }
        .total { text-align: right; font-size: 18px; font-weight: bold; margin-top: 20px; }
        .checkout-container form { margin-top: 30px; display: flex; flex-direction: column; }
        .checkout-container label { margin-top: 10px; font-weight: bold; }
        .checkout-container input, .checkout-container textarea, .checkout-container select { padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; width: 100%; }
        .checkout-container button { background-color: #007bff; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-top: 20px; }
        .checkout-container button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
<div class="checkout-container">
    <h2>Checkout</h2>
    <?php foreach ($cart_items as $item): ?>
        <div class="product-details">
            <img src="../<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>">
            <div class="product-info">
                <h4><?= htmlspecialchars($item['name']); ?></h4>
                <p><?= htmlspecialchars($item['description']); ?></p>
                <p>Price: $<?= number_format($item['price'], 2); ?> x <?= $item['quantity']; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
    <p class="total">Total: $<?= number_format($total, 2); ?></p>

    <form method="POST">
        <label for="customer_name">Name:</label>
        <input type="text" id="customer_name" name="customer_name" value="<?= htmlspecialchars($user['username']); ?>" required>

        <label for="customer_email">Email:</label>
        <input type="email" id="customer_email" name="customer_email" value="<?= htmlspecialchars($user['email']); ?>" required>

        <label for="customer_address">Address:</label>
        <textarea id="customer_address" name="customer_address" rows="4" required><?= htmlspecialchars($user['address']); ?></textarea>

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

<?php include "../includes/footer.php"; ?>
