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

</body>
</html>
