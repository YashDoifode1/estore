<?php include "includes/header.php"?>
<?php include "includes/db.php";

$query = "SELECT * FROM categories";

// Execute the query and get the result
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit;
}
?>

<style>
    .about-us-container {
  text-align: center;
  padding: 50px;
}

.title {
  font-size: 36px;
  font-weight: bold;
  margin-bottom: 20px;
}

.description {
  font-size: 18px;
  line-height: 1.5;
  margin-bottom: 20px;
}

.image {
  max-width: 100%;
  border-radius: 10px;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
}
</style>
<body>
    <!-- Header -->
    

    <!-- Hero Section -->
    <div class="hero" style="background-image: url('rsc/nft.jpg'); background-size: cover; background-position: center center;">
    <div>
        <h1>Welcome to E-Shop</h1>
        <p>Discover amazing deals on top products</p>
        <a href="action/product.php" class="cta-button">Shop Now</a>
    </div>
</div>

    <!-- Featured Categories -->
    <section id="categories" class="categories">
    <h2 class="section-title">Featured Categories</h2>
    <div class="grid">
        <?php
        // Check if categories are available
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                // Create a link with category_id as a URL parameter
                

                echo '<div class="card">';
                
                echo '<a href="action/category.php?id=' . $row["id"] . '">' . $row["name"] . '</a>';
                echo '</div>';
            }
        } else {
            echo "<p>No categories found</p>";
        }
        ?>
    </div>
</section>

    <!-- Featured Products -->
    <?php
include("includes/db.php");

// Fetch top 3 bestselling products (assuming order_items table tracks sales)
$query = "
    SELECT p.name, p.price, p.image 
    FROM products p 
    JOIN order_items oi ON p.id = oi.product_id 
    GROUP BY p.id 
    ORDER BY SUM(oi.quantity) DESC 
    LIMIT 3
";

$result = $conn->query($query);
?>

<section id="products" class="products">
    <h2 class="section-title">Bestselling Products</h2>
    <div class="grid">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="card">
                <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="product-img">
                <h3><?php echo $row['name']; ?></h3>
                <p>$<?php echo number_format($row['price'], 2); ?></p>
                <a href="action/product.php" class="view-more-btn">View More</a>
            </div>
            
        <?php } ?>
    </div>
</section>


   
  
<?php include("includes/about.html"); ?>
   
</body>
<!--  -->
</html>
<?php include("INCLUDES/FOOTER.PHP"); ?>
