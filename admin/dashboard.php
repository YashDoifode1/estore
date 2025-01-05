<?php
include("includes/auth.php");
include("includes/header.php");
include("includes/db.php");

// Fetch total statistics
$total_orders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$total_revenue = $conn->query("SELECT SUM(total_amount) as revenue FROM orders")->fetch_assoc()['revenue'];
$total_customers = $conn->query("SELECT COUNT(DISTINCT customer_email) as customers FROM orders")->fetch_assoc()['customers'];

// Fetch orders by status
$order_statuses = $conn->query("SELECT order_status, COUNT(*) as count FROM orders GROUP BY order_status");

// Fetch revenue per month
$revenue_data = $conn->query("SELECT DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_amount) as revenue FROM orders GROUP BY month");

$order_status_labels = [];
$order_status_counts = [];
while ($row = $order_statuses->fetch_assoc()) {
    $order_status_labels[] = $row['order_status'];
    $order_status_counts[] = $row['count'];
}

$revenue_months = [];
$revenue_values = [];
while ($row = $revenue_data->fetch_assoc()) {
    $revenue_months[] = $row['month'];
    $revenue_values[] = $row['revenue'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
     <style>
     body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
}

/* .sidebar {
    width: 200px;
    background-color: #333;
    color: white;
    height: 100vh;
    padding: 20px;
    position: fixed;
}

.sidebar h2 {
    text-align: center;
}

.sidebar a {
    display: block;
    padding: 10px;
    color: white;
    text-decoration: none;
    margin-top: 10px;
    border-radius: 5px;
}

.sidebar a:hover {
    background-color: #555;
} */

.content {
    /* margin-left: 220px;
    padding: 20px; */
    width: calc(100% - 220px);
}

.stats {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.stat-box {
    background: #36a2eb;
    color: white;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
    font-size: 18px;
    width: 30%;
}
</style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="index.php">Dashboard</a>
        <a href="orders.php">Manage Orders</a>
        <a href="products.php">Manage Products</a>
        <a href="logout.php">Logout</a>
    </div> -->

    <div class="content">
        <h1>Admin Dashboard</h1>

        <div class="stats">
            <div class="stat-box">Total Orders: <strong><?php echo $total_orders; ?></strong></div>
            <div class="stat-box">Total Revenue: <strong>$<?php echo number_format($total_revenue, 2); ?></strong></div>
            <div class="stat-box">Total Customers: <strong><?php echo $total_customers; ?></strong></div>
        </div>

        <h3>Order Status Breakdown</h3>
        <canvas id="orderStatusChart"></canvas>

        <h3>Revenue Trend</h3>
        <canvas id="revenueChart"></canvas>

    </div>

    <script>
        const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
        new Chart(orderStatusCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($order_status_labels); ?>,
                datasets: [{
                    label: 'Orders by Status',
                    data: <?php echo json_encode($order_status_counts); ?>,
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff']
                }]
            }
        });

        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($revenue_months); ?>,
                datasets: [{
                    label: 'Revenue ($)',
                    data: <?php echo json_encode($revenue_values); ?>,
                    borderColor: '#36a2eb',
                    fill: false
                }]
            }
        });
    </script>

</body>
</html>
