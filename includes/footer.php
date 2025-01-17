<STYle>/* Footer Styles */
footer {
    background: #222;
    color: white;
    padding: 40px 0;
    font-size: 16px;
}

.footer-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    max-width: 1100px;
    margin: auto;
}

.footer-section {
    width: 250px;
    margin: 10px;
}

.footer-section h2 {
    font-size: 20px;
    margin-bottom: 15px;
}

.footer-section p, .footer-section ul {
    font-size: 14px;
    line-height: 1.6;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 10px;
}

.footer-section ul li a {
    color: white;
    text-decoration: none;
}

.footer-section ul li a:hover {
    text-decoration: underline;
}

.social-icons a {
    display: inline-block;
    color: white;
    font-size: 18px;
    margin-right: 10px;
}

.social-icons a:hover {
    color: #007bff;
}

/* Newsletter */
.newsletter input {
    width: 80%;
    padding: 8px;
    margin-top: 10px;
    border: none;
    border-radius: 5px;
}

.newsletter button {
    margin-top: 10px;
    background: #007bff;
    color: white;
    border: none;
    padding: 8px 15px;
    cursor: pointer;
    border-radius: 5px;
}

.newsletter button:hover {
    background: #0056b3;
}

/* Footer Bottom */
.footer-bottom {
    text-align: center;
    background: #111;
    padding: 10px 0;
    margin-top: 20px;
}
</STYle>
<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "estore");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            echo "<script>alert('Subscription successful!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Error: Unable to subscribe!'); window.location.href = 'index.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid email format!'); window.location.href = 'index.php';</script>";
    }
}

$conn->close();
?>

<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "estore");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch settings data
$sql = "SELECT * FROM settings LIMIT 1";
$result = $conn->query($sql);
$settings = $result->fetch_assoc();
?>

<footer>
    <div class="footer-container">

        <!-- Company Info -->
        <div class="footer-section about">
            <h2><?php echo htmlspecialchars($settings['site_name']); ?></h2>
            <p><?php echo htmlspecialchars($settings['about']); ?></p>
            <div class="social-icons">
                <a href="<?php echo htmlspecialchars($settings['facebook']); ?>"><i class="fab fa-facebook-f"></i></a>
                <a href="<?php echo htmlspecialchars($settings['twitter']); ?>"><i class="fab fa-twitter"></i></a>
                <a href="<?php echo htmlspecialchars($settings['instagram']); ?>"><i class="fab fa-instagram"></i></a>
                <a href="<?php echo htmlspecialchars($settings['linkedin']); ?>"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="footer-section links">
            <h2>Quick Links</h2>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div class="footer-section contact">
            <h2>Contact Us</h2>
            <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($settings['address']); ?></p>
            <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($settings['email']); ?></p>
            <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($settings['phone']); ?></p>
        </div>

        <!-- Newsletter Subscription -->
        <div class="footer-section newsletter">
            <h2>Subscribe to Our Newsletter</h2>
            <form action="" method="post">
                <input type="email" name="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </div>
</footer>
