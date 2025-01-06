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
</head>
<body>
<header>
    <div class="logo">E-Shop</div>
    <nav>
        <a href="<?= APP_URL ?>/">Home</a>
        <a href="<?= APP_URL ?>/action/product.php">Products</a>
        <?php if ($is_logged_in): ?>
            <a href="<?= APP_URL ?>/account/profile.php">Profile</a>
            <a href="<?= APP_URL ?>/logout.php">Logout</a>
        <?php else: ?>
            <a href="<?= APP_URL ?>/login.php">Login</a>
            <a href="<?= APP_URL ?>/register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>
