<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <div class="footer-brand">
                    <i class="fas fa-utensils"></i>
                    <span>FoodFusion</span>
                </div>
                <p>Bringing culinary creativity to your kitchen, one recipe at a time.</p>
                <div class="social-links">
                    <a href="https://www.facebook.com" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.x.com" aria-label="X"><i class="fab fa-x-twitter"></i></a>
                    <a href="https://www.youtube.com" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.pinterest.com" aria-label="Pinterest"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="about_us.php">About Us</a></li>
                    <li><a href="recipe_collection.php">Recipes Collection</a></li>
                    <li><a href="community_cookbook.php">Community Cookbook</a></li>
                    <li><a href="culinary_resources.php">Culinary Resources</a></li>
                    <li><a href="educational_resources.php">Educational Resources</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Support</h4>
                <ul>
                    <li><a href="contact_us.php">Contact Us</a></li>
                    <li><a href="privacy_policy.php">Privacy Policy</a></li>
                    <li><a href="terms.php">Terms of Service</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Newsletter</h4>
                <p>Subscribe to get the latest recipes and cooking tips!</p>
                <form action="subscribe_newsletter.php" method="post" class="newsletter-form">
                    <input type="email" name="email" placeholder="Your email address" required>
                    <input type="submit" value="Subscribe" class="btn btn-primary">
                    <div class="subscription-message">
                        <?php if (!empty($_SESSION["newsletter_success"])): ?>
                            <p class="success"><?= htmlspecialchars($_SESSION["newsletter_success"]) ?></p>
                            <?php unset($_SESSION["newsletter_success"]); ?>
                        <?php elseif (!empty($_SESSION["newsletter_error"])): ?>
                            <p class="error"><?= htmlspecialchars($_SESSION["newsletter_error"]) ?></p>
                            <?php unset($_SESSION["newsletter_error"]); ?>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date("Y") ?> FoodFusion. All rights reserved.</p>
        </div>
    </div>
</footer>
</body>
</html>