<?php 
// session_start();
define('APP_URL', 'http://localhost/estore/admin');

include __DIR__ . "/includes/header.php"; 
// Include the database connection file
include __DIR__ . "/includes/db.php"; // Use __DIR__ for a more reliable relative path
?>

<?php
include("includes/auth.php"); // Ensures only admins can access
?>
<div class="content">
        <h1>Welcome, !</h1>
        <p>This is your admin dashboard.</p>
    </div>