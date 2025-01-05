<?php
// Include header
include "..\includes/header.php";
include "..\includes/db.php";

// Fetch products from the database
$sql = "SELECT id, name, description, price, image FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dynamic Product Page</title>
    <link rel="stylesheet" href="..\css/style.css">
    <style>
        .product {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px;
            width: 300px;
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .product:hover {
            transform: scale(1.05);
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
        }

        .product img {
            max-width: 100%;
            border-radius: 10px;
        }

        .product button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .product button:hover {
            background-color: #0056b3;
        }

        .product-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<center><h2>Our Products</h2></center>
<div class="product-container">
    <?php
    if ($result->num_rows > 0) {
        // Output data for each product
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<img src=\"../" . htmlspecialchars($row['image']) . "\" alt=\"" . htmlspecialchars($row['name']) . "\">";

            echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
            echo "<p>Price: $" . htmlspecialchars($row['price']) . "</p>";

            // More Info button
            echo "<form method='GET' action='info.php'>";
            echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($row['id']) . "'>";
            echo "<button type='submit'>More Info</button>";
            echo "</form>";

            echo "</div>";
        }
    } else {
        echo "<p>No products available.</p>";
    }
    ?>
</div>
</body>
</html>

<?php
// Close connection
$conn->close();

// Include footer
// include "..\includes/footer.php";
?>
