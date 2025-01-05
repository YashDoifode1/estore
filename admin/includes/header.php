<?php
include("auth.php"); // Protect this page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="products.php">Manage Products</a>
        <a href="orders.php">Orders</a>
        <a href="users.php">Users</a>
        <a href="logout.php">Logout</a>
    </div>

    

</body>
</html>
