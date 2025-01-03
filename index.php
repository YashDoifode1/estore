<?php include "includes/header.php"?>
<?php include "includes/db.php"?>
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
        <a href="product.php" class="cta-button">Shop Now</a>
    </div>
</div>

    <!-- Featured Categories -->
    <section id="categories" class="categories">
        <h2 class="section-title">Featured Categories</h2>
        <div class="grid">
            <div class="card">Art</div>
            <div class="card">Gaming </div>
            <div class="card">Music</div>
            <div class="card">Photography</div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="products" class="products">
        <h2 class="section-title">Bestselling Products</h2>
        <div class="grid">
            <div class="card">Product 1 - $20</div>
            <div class="card">Product 2 - $35</div>
            <div class="card">Product 3 - $50</div>
            <div class="card">Product 4 - $25</div>
        </div>
    </section>

   
  

    <div class="about-us-container">
  <h1 class="title">About Us</h1>
  <p class="description">
    We are a passionate team dedicated to revolutionizing the digital art world through blockchain technology.
  </p>
  <img src="rsc/about.jpg" alt="About Us Image" class="image">
</div>
    
    
</body>
<!--  -->
</html>
