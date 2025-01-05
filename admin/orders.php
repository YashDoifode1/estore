<?php
include("includes/auth.php");
include("includes/header.php");
include("includes/db.php");

// Handle Order Status Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $stmt = $conn->prepare("UPDATE orders SET order_status=? WHERE id=?");
    $stmt->bind_param("si", $order_status, $order_id);
    $stmt->execute();
    header("Location: orders.php");
}

// Fetch all orders
$orders = $conn->query("SELECT * FROM orders");

// Fetch order items if order is selected
$order_items = [];
if (isset($_GET['view'])) {
    $order_id = $_GET['view'];
    $order_items = $conn->query("SELECT oi.*, p.name AS product_name FROM order_items oi 
                                 JOIN products p ON oi.product_id = p.id 
                                 WHERE oi.order_id = $order_id");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
     <style>body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
}

.sidebar {
    width: 250px;
    height: 100vh;
    background: #2C3E50;
    color: white;
    position: fixed;
    padding-top: 20px;
}

.sidebar h2 {
    text-align: center;
}

.sidebar a {
    display: block;
    color: white;
    padding: 15px;
    text-decoration: none;
    text-align: center;
}

.sidebar a:hover {
    background: #34495E;
}

.content {
    margin-left: 250px;
    padding: 20px;
    width: 100%;
}

h1 {
    color: #333;
}

form input, form select {
    display: block;
    margin: 5px;
    padding: 8px;
}

button {
    padding: 10px;
    background: blue;
    color: white;
    border: none;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border: 1px solid black;
}

th {
    background: #f4f4f4;
}

#editForm {
    margin-top: 20px;
    padding: 10px;
    background: #f8f8f8;
    border: 1px solid #ccc;
}
</style>
</head>
<body>

    <!-- <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="index.php">Dashboard</a>
        <a href="orders.php">Manage Orders</a>
        <a href="logout.php">Logout</a>
    </div> -->

    <div class="content">
        <h1>Manage Orders</h1>

        <h3>All Orders</h3>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Customer Email</th>
                <th>Payment Method</th>
                <th>Total Amount</th>
                <th>Order Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $orders->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['customer_email']; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><?php echo $row['total_amount']; ?></td>
                <td><?php echo $row['order_status']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <a href="orders.php?view=<?php echo $row['id']; ?>">View Items</a>
                    <button onclick="updateStatus('<?php echo $row['id']; ?>', '<?php echo $row['order_status']; ?>')">Update Status</button>
                </td>
            </tr>
            <?php } ?>
        </table>

        <?php if (isset($_GET['view'])) { ?>
        <h3>Order Items</h3>
        <table border="1">
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <?php while ($item = $order_items->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $item['product_name']; ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo $item['price']; ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php } ?>

        <div id="statusForm" style="display:none;">
            <h3>Update Order Status</h3>
            <form method="POST">
                <input type="hidden" name="order_id" id="statusOrderId">
                <select name="order_status" id="statusSelect">
                    <option value="Pending">Pending</option>
                    <option value="Processing">Processing</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
                <button type="submit" name="update_status">Update</button>
                <button type="button" onclick="document.getElementById('statusForm').style.display='none'">Cancel</button>
            </form>
        </div>

    </div>

    <script>
        function updateStatus(orderId, currentStatus) {
            document.getElementById("statusOrderId").value = orderId;
            document.getElementById("statusSelect").value = currentStatus;
            document.getElementById("statusForm").style.display = "block";
        }
    </script>

</body>
</html>
