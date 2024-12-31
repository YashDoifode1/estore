<?php 
session_start();
define('APP_URL', 'http://localhost/estore');

include __DIR__ . "/admin/includes/header.php"; 
// Include the database connection file
include __DIR__ . "/../includes/db.php"; // Use __DIR__ for a more reliable relative path

// Check if the user is an admin
// Ensure the session is started
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . APP_URL . "/login.php"); // Redirect to login if not an admin
    exit();
}

// Fetch data for the dashboard (e.g., user count, product count)
$user_count = 0;
$product_count = 0;

// Fetch user count
$sql_users = "SELECT COUNT(*) as count FROM users";
$result_users = $conn->query($sql_users);
if ($result_users->num_rows > 0) {
    $user_count = $result_users->fetch_assoc()['count'];
}

// Fetch product count
$sql_products = "SELECT COUNT(*) as count FROM products";
$result_products = $conn->query($sql_products);
if ($result_products->num_rows > 0) {
    $product_count = $result_products->fetch_assoc()['count'];
}
?>


        <div id="main">
            <div class="card">
                <h3>Total Users</h3>
                <p><?= $user_count ?></p>
            </div>
            <div class="card">
                <h3>Total Products</h3>
                <p><?= $product_count ?></p>
            </div>
            <div class="card">
                <h3>Admin Actions</h3>
                <p>Perform administrative tasks here. </p>


                </p>
                

            </div>
        </div>
    
    </div>
</body>
</html>
