<?php
// Include header
include "includes/header.php";

// Get customer name from query string
$customer_name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : "Customer";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .confirmation-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
        }

        .confirmation-container h2 {
            margin-bottom: 20px;
        }

        .confirmation-container p {
            font-size: 16px;
            line-height: 1.5;
        }

        .confirmation-container a {
            display: inline-block;
            margin-top: 20px;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .confirmation-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="confirmation-container">
    <h2>Thank You, <?= $customer_name; ?>!</h2>
    <p>Your order has been placed successfully.</p>
    <p>We will deliver your order to your address soon.</p>
    <a href="product.php">Continue Shopping</a>
</div>
</body>
</html>

<?php
// Include footer
// include "includes/footer.php";
?>
