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

<?php
function logWebsiteDetails($logFile = "website_log.txt") {
    // Get user IP address
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

    // Get the full URL including protocol, domain, subfolders, and query parameters
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'] ?? 'UNKNOWN';
    $requestUri = $_SERVER['REQUEST_URI'] ?? 'UNKNOWN'; // This includes subfolders and file names
    $fullUrl = "$protocol://$host$requestUri";

    // Get User-Agent (browser & device information)
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';

    // Get Referer (where the user came from)
    $referer = $_SERVER['HTTP_REFERER'] ?? 'Direct Visit';

    // Get current timestamp
    $timestamp = date("Y-m-d H:i:s");

    // Format log entry
    $logEntry = "[$timestamp] IP: $ip - URL: $fullUrl - Referrer: $referer - User-Agent: $userAgent\n";

    // Write log entry to file
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

// Call the function automatically when included
logWebsiteDetails();
?>
