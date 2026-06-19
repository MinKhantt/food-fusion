<?php
include './include/db_config.php';

$recipe_id = $_GET['recipe_id'] ?? null;

if (!$recipe_id) {
  echo "Recipe not found.";
  exit;
}

// Join to get related labels
$stmt = $conn->prepare("
  SELECT r.*, 
         c.name AS cuisine_name, 
         d.preference AS dietary_name, 
         l.label AS difficulty_label 
  FROM recipes r
  LEFT JOIN cuisines c ON r.cuisine_id = c.cuisine_id
  LEFT JOIN dietary_preferences d ON r.dietary_id = d.dietary_id
  LEFT JOIN difficulties l ON r.difficulty_id = l.difficulty_id
  WHERE r.recipe_id = :id
");
$stmt->execute([':id' => $recipe_id]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
  echo "Recipe not found.";
  exit;
}

$title = $recipe['title'];
include './include/header.php';
?>

<section class="view-recipe">
  <div class="recipe-wrapper">
    
    <!-- Recipe Image -->
    <div class="recipe-image-container">
      <img src="<?= htmlspecialchars($recipe['image_url']) ?>" alt="<?= htmlspecialchars($recipe['title']) ?>" class="recipe-img">
    </div>

    <!-- Recipe Content -->
    <div class="recipe-content">
      <h1 class="recipe-title"><?= htmlspecialchars($recipe['title']) ?></h1>

      <div class="recipe-meta">
        <span><i class="fas fa-bowl-food"></i> <?= htmlspecialchars($recipe['cuisine_name']) ?></span>
        <span><i class="fas fa-seedling"></i> <?= htmlspecialchars($recipe['dietary_name']) ?></span>
        <span><i class="fas fa-fire"></i> <?= htmlspecialchars($recipe['difficulty_label']) ?></span>
      </div>


      <div class="recipe-section">
        <h2><i class="fas fa-info-circle"></i> Description</h2>
        <p><?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
      </div>

      <div class="recipe-section">
        <h2><i class="fas fa-book-open"></i> Instructions</h2>
        <p><?= nl2br(htmlspecialchars($recipe['instructions'])) ?></p>
      </div>
      <?php if (!empty($recipe['ingredients'])): ?>
        <div class="recipe-section">
          <h2><i class="fas fa-carrot"></i> Ingredients</h2>
          <p><?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
        </div>
      <?php endif; ?>


      <!-- Back Button -->
      <a href="recipe_collection.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Recipes</a>
    </div>
    
  </div>
</section>

<?php include './include/footer.php'; ?>
