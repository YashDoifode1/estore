<?php
// session_start();
include "..\includes/header.php";
include "..\includes/db.php"; // Database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch orders and corresponding order items from the database
$sql = "SELECT o.id AS order_id, o.customer_email, o.payment_method, o.total_amount, o.order_status, o.created_at,
               oi.product_id, oi.quantity, oi.price
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        WHERE o.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - eShop</title>
    <link rel="stylesheet" href="..\css/style.css">
    <style>
    

    .orders table, .order-details table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .orders th, .orders td, .order-details th, .order-details td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .orders th {
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

    <!-- Orders Section -->
    <section class="orders">
        <h2>My Orders</h2>

        <?php if ($result->num_rows > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Email</th>
                        <th>Payment</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Loop through orders and their items
                    while ($order = $result->fetch_assoc()) { 
                        $order_id = $order['order_id'];
                        $product_id = $order['product_id'];
                        $quantity = $order['quantity'];
                        $price = $order['price'];
                    ?>
                        <tr>
                            <td>#<?php echo $order['order_id']; ?></td>
                            <td><?php echo $order['customer_email']; ?></td>
                            <td><?php echo $order['payment_method']; ?></td>
                            <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td><span class="status <?php echo strtolower($order['order_status']); ?>"><?php echo $order['order_status']; ?></span></td>
                            <td><?php echo date("d M Y, h:i A", strtotime($order['created_at'])); ?></td>
                            <td>
                                <a href="details.php?order_id=<?php echo $order['order_id']; ?>" class="btn">View</a>
                                <!-- <br />
                                <strong>Product:</strong> <?php echo $product_id; ?>
                                <br />
                                <strong>Quantity:</strong> <?php echo $quantity; ?>
                                <br />
                                <strong>Price:</strong> $<?php echo number_format($price, 2); ?>
                            </td> -->
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No orders found.</p>
        <?php } ?>
    </section>
<br><br><br><br><br><br><br><br><br><br>
</body>
</html>
<?php
include "..\includes/footer.php";
?>

