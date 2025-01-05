<?php
// Database connection
include '..\includes/header.php';
include '..\includes/db.php';

// Get the category id from the URL
$category_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Get the category id from the URL
$category_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch category details
$sql = "SELECT * FROM categories WHERE id = $category_id";
$category_result = $conn->query($sql);

if ($category_result->num_rows > 0) {
    $category = $category_result->fetch_assoc();
    $category_name = $category['name'];
    // $category_image = $category['image']; // Path to the category image

    // Fetch products for this category
    $product_sql = "SELECT * FROM products WHERE category_id = $category_id";
    $product_result = $conn->query($product_sql);
} else {
    echo "<p>Category not found.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category_name; ?> - Category</title>
    <link rel="stylesheet" href="..\css/style.css">
    <style>/* Category Header Image */
.category-header {
    text-align: center;
    margin-bottom: 30px;
}

.category-image {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin-bottom: 20px;
}

/* Product Image Styling */
.product-image {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin-bottom: 10px;
}

/* Card Layout */
.card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}
</style>
</head>
<body>

<section id="category-details">
    <h2 class="section-title"><?php echo $category_name; ?> - Products</h2>
    <div class="category-header">
        <!-- <img src="<?php echo $category_image; ?>" alt="<?php echo $category_name; ?> Image" class="category-image"> -->
        <p>Welcome to the <?php echo $category_name; ?> category. Below are the products available in this category:</p>
    </div>

    <div class="grid">
        <?php
        if ($product_result->num_rows > 0) {
            // Output products in this category
            while ($product = $product_result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<img src="../' . htmlspecialchars($product["image"]) . '" alt="' . htmlspecialchars($product["name"]) . ' Image" class="product-image">';

                echo '<h3>' . $product["name"] . '</h3>';
                echo '<p>Price: $' . $product["price"] . '</p>';
                echo '<a href="product.php?id=' . $product["id"] . '">View Product</a>';
                echo '</div>';
            }
        } else {
            echo "<p>No products found in this category.</p>";
        }
        ?>
    </div>
</section>

</body>
</html>

<?php
$conn->close();
?>