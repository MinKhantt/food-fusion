<?php 
session_start();
include "./include/db_config.php";

$title = "Terms of Service";
include "./include/header.php";
?>

<section class="faq-section">
  <div class="container">
    <h2>Frequently Asked Questions</h2>
    <div class="faq-list">

      <div class="faq-item">
        <h4>What is FoodFusion?</h4>
        <p>FoodFusion is a platform that brings together food lovers, home cooks, and professional chefs to share, discover, and enjoy delicious recipes from around the world.</p>
      </div>

      <div class="faq-item">
        <h4>Do I need an account to view recipes?</h4>
        <p>No, you can browse recipes without creating an account. However, registering allows you to like, save, and submit your own recipes.</p>
      </div>

      <div class="faq-item">
        <h4>How can I submit my own recipe?</h4>
        <p>Once you're logged in, go to the “Community Cookbook” section and click on “Submit Recipe.” Fill in your recipe details and submit for review.</p>
      </div>

      <div class="faq-item">
        <h4>Are the recipes reviewed before publishing?</h4>
        <p>Yes, every user-submitted recipe is reviewed by our content team to ensure quality, accuracy, and originality before it goes live.</p>
      </div>

      <div class="faq-item">
        <h4>Can I download recipes?</h4>
        <p>Yes! Many recipes include a downloadable PDF version. Look for the download icon on the culinary resources page.</p>
      </div>

    </div>
  </div>
</section>
<?php include 'include/footer.php'; ?>