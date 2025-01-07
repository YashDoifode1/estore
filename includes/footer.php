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
<footer>
    <div class="footer-container">

        <!-- Company Info -->
        <div class="footer-section about">
            <h2>eShop</h2>
            <p>Your one-stop destination for high-quality products at unbeatable prices.</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="footer-section links">
            <h2>Quick Links</h2>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <!-- <li><a href="about.html">About Us</a></li> -->
                <!-- <li><a href="contact.html">Contact</a></li>
                <li><a href="privacy-policy.html">Privacy Policy</a></li> -->
            </ul>
        </div>

        <!-- Contact Info -->
        <div class="footer-section contact">
            <h2>Contact Us</h2>
            <p><i class="fas fa-map-marker-alt"></i> Dhamna Amravati Road Nagpur 440023</p>
            <p><i class="fas fa-envelope"></i> support@eshop.com</p>
            <p><i class="fas fa-phone"></i> +91 98765 43210</p>
        </div>

        <!-- Newsletter Subscription -->
        <div class="footer-section newsletter">
            <h2>Subscribe to Our Newsletter</h2>
            <form action="#">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </div>

    <!-- Copyright -->
    <!-- <div class="footer-bottom">
        <p>&copy; 2025 eShop. All rights reserved.</p>
    </div> -->
</footer>
