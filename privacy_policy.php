<?php
session_start();
include "./include/db_config.php";

$title = "Privacy Policy";
include "./include/header.php";
?>

<section class="privacy-section">
  <div class="privacy-container">
    <h1>Privacy Policy</h1>
    <p>At FoodFusion, we are committed to protecting your privacy. This policy outlines how we handle your personal data.</p>

    <h2>1. Information We Collect</h2>
    <p>We may collect your name, email, and preferences when you register, submit recipes, or contact us.</p>

    <h2>2. How We Use Your Information</h2>
    <p>Your data helps us improve the website, personalize your experience, and communicate updates or offers.</p>

    <h2>3. Data Protection</h2>
    <p>We implement industry-standard security to protect your information from unauthorized access or disclosure.</p>

    <h2>4. Third-Party Services</h2>
    <p>We may use tools like analytics or social media plugins, which may collect anonymized data. Please refer to their respective privacy policies.</p>

    <h2>5. Your Consent</h2>
    <p>By using our site, you consent to our privacy policy. You may request data deletion by contacting us.</p>

    <h2>6. Updates</h2>
    <p>We may update this policy occasionally. Changes will be posted on this page with a revised date.</p>
  </div>
</section>

<?php include "./include/footer.php"; ?>
