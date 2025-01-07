<?php
// session_start();
include "..\includes/header.php";
include "..\includes/db.php"; // Database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the order ID from the URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;

// Check if the order_id is valid
if ($order_id == 0) {
    echo "Invalid order ID.";
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch order details from the orders table
$sql = "SELECT o.id AS order_id, o.customer_email, o.payment_method, o.total_amount, o.order_status, o.created_at 
        FROM orders o
        WHERE o.id = ? AND o.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order_result = $stmt->get_result();

// If no order found for the user
if ($order_result->num_rows == 0) {
    echo "Order not found.";
    exit();
}

// Fetch order items from the order_items table
$item_sql = "SELECT oi.product_id, oi.quantity, oi.price, p.name AS product_name
             FROM order_items oi
             LEFT JOIN products p ON oi.product_id = p.id
             WHERE oi.order_id = ?";

$item_stmt = $conn->prepare($item_sql);
$item_stmt->bind_param("i", $order_id);
$item_stmt->execute();
$item_result = $item_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - eShop</title>
    <link rel="stylesheet" href="..\css/style.css">
    <style>
    .order-details, .order-items {
        max-width: 900px;
        margin: 40px auto;
        padding: 20px;
        background: white;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .order-details h2, .order-items h3 {
        margin-bottom: 20px;
    }

    .order-details table, .order-items table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .order-details th, .order-details td, .order-items th, .order-items td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .order-details th {
        background: #007bff;
        color: white;
    }

    .status {
        padding: 5px 10px;
        border-radius: 5px;
    }

    .status.pending { background: orange; color: white; }
    .status.completed { background: green; color: white; }
    .status.cancelled { background: red; color: white; }

    .btn {
        display: inline-block;
        padding: 10px 15px;
        background: #007bff;
        color: white;
        text-decoration: none;
        margin-top: 10px;
    }
    </style>
</head>
<body>

    <!-- Order Details Section -->
    <section class="order-details">
        <?php 
        // Fetch order information
        $order = $order_result->fetch_assoc();
        ?>
        <h2>Order #<?php echo $order['order_id']; ?> - Details</h2>

        <table>
            <tr>
                <th>Customer Email</th>
                <td><?php echo $order['customer_email']; ?></td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td><?php echo $order['payment_method']; ?></td>
            </tr>
            <tr>
                <th>Total Amount</th>
                <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
            </tr>
            <tr>
                <th>Order Status</th>
                <td><span class="status <?php echo strtolower($order['order_status']); ?>"><?php echo $order['order_status']; ?></span></td>
            </tr>
            <tr>
                <th>Order Date</th>
                <td><?php echo date("d M Y, h:i A", strtotime($order['created_at'])); ?></td>
            </tr>
        </table>
    </section>

    <!-- Order Items Section -->
    <section class="order-items">
        <h3>Ordered Items</h3>
        <?php if ($item_result->num_rows > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = $item_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $item['product_name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>$<?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No items found for this order.</p>
        <?php } ?>
    </section>

    <a href="order.php" class="btn">Back to My Orders</a>

</body>
</html>

<?php
include "..\includes/footer.php";
?>
