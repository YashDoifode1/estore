<?php
session_start(); // Start the session to track user login state
define('APP_URL', 'http://localhost/estore');

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Shop the best deals on electronics, fashion, home décor, gadgets, and more at eStore. Secure payment, fast shipping, and unbeatable prices!">
    <meta name="keywords" content="eStore, online shopping, electronics, gadgets, fashion, home decor, best deals, discounts, secure payment, fast shipping">
    <meta name="robots" content="index, follow">
    <meta name="author" content="eStore">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>E-Commerce Website</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Add styles for the dropdown menu */
        .nav-item {
            position: relative;
            display: inline-block;
        }

        .dropdown {
            display: none;
            position: absolute;
            background-color: white;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            min-width: 150px;
        }

        .nav-item:hover .dropdown {
            display: block;
        }

        .dropdown a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">E-Shop</div>
    <nav>
        <a href="<?= APP_URL ?>/">Home</a>
        <a href="<?= APP_URL ?>/action/product.php">Products</a>
        <?php if ($is_logged_in): ?>
            <div class="nav-item">
                <a href="<?= APP_URL ?>/account/profile.php">Profile</a>
                <div class="dropdown">
                    <a href="<?= APP_URL ?>/account/profile.php">View Profile</a>
                    <a href="<?= APP_URL ?>/account/order.php">My Orders</a>
                    <!-- <a href="<?= APP_URL ?>/orders.php">My Orders</a> -->
                    <a href="<?= APP_URL ?>/account/change.php">Change Password</a>
                </div>
            </div>
            <a href="<?= APP_URL ?>/logout.php">Logout</a>
        <?php else: ?>
            <a href="<?= APP_URL ?>/login.php">Login</a>
            <a href="<?= APP_URL ?>/register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>
