<?php
session_start();
include "./include/db_config.php";

$title = "Recipe Collection";
include "./include/header.php";

$cuisine = $_GET['cuisine'] ?? '';
$dietary = $_GET['dietary'] ?? '';
$difficulty = $_GET['difficulty'] ?? '';

// Fetch dropdown options
$cuisines = $conn->query("SELECT * FROM cuisines")->fetchAll();
$diets = $conn->query("SELECT * FROM dietary_preferences")->fetchAll();
$levels = $conn->query("SELECT * FROM difficulties")->fetchAll();

// Prepare filtered query
$sql = "SELECT r.*, d.label as difficulty_name, c.name as cuisine_name, dp.preference as dietary_name
        FROM recipes r
        JOIN difficulties d ON r.difficulty_id = d.difficulty_id
        JOIN cuisines c ON r.cuisine_id = c.cuisine_id
        JOIN dietary_preferences dp ON r.dietary_id = dp.dietary_id
        WHERE 1=1";

$params = [];
if ($cuisine) {
  $sql .= " AND r.cuisine_id = :cuisine";
  $params[':cuisine'] = $cuisine;
}
if ($dietary) {
  $sql .= " AND r.dietary_id = :dietary";
  $params[':dietary'] = $dietary;
}
if ($difficulty) {
  $sql .= " AND r.difficulty_id = :difficulty";
  $params[':difficulty'] = $difficulty;
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$recipes = $stmt->fetchAll();
?>

<section class="recipe-collection">
  <div class="container">
    <h2><i class="fas fa-book-open"></i> Recipe Collection</h2>
    <p class="collection-desc">
      A curated collection of diverse recipes from around the world, categorised by cuisine type, dietary preferences, and cooking difficulty.
    </p>

    <form class="filters" method="GET">
      <select name="cuisine">
        <option value="">All Cuisines</option>
        <?php foreach ($cuisines as $c): ?>
          <option value="<?= $c['cuisine_id'] ?>" <?= $cuisine == $c['cuisine_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <select name="dietary">
        <option value="">All Diets</option>
        <?php foreach ($diets as $d): ?>
          <option value="<?= $d['dietary_id'] ?>" <?= $dietary == $d['dietary_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($d['preference']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <select name="difficulty">
        <option value="">All Difficulty</option>
        <?php foreach ($levels as $l): ?>
          <option value="<?= $l['difficulty_id'] ?>" <?= $difficulty == $l['difficulty_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($l['label']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <button type="submit">Filter</button>
      <a href="recipe_collection.php" class="reset-btn">Reset</a>
    </form>

    <div class="recipe-grid">
      <?php if (count($recipes) > 0): ?>
        <?php foreach ($recipes as $recipe): ?>
          <div class="recipe-card">
            <img src="<?= htmlspecialchars($recipe['image_url']) ?>" alt="<?= htmlspecialchars($recipe['title']) ?>">
            <div class="recipe-info">
              <h3><?= htmlspecialchars($recipe['title']) ?></h3>
              <div class="recipe-meta">
                <p><i class="fas fa-bowl-food"></i> <?= htmlspecialchars($recipe['cuisine_name']) ?></p>
                <p><i class="fas fa-seedling"></i> <?= htmlspecialchars($recipe['dietary_name']) ?></p>
                <p><i class="fas fa-fire"></i> <?= htmlspecialchars($recipe['difficulty_name']) ?></p>
              </div>
              <a href="view_recipe.php?recipe_id=<?= $recipe['recipe_id'] ?>" class="view-btn">View Recipe</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="no-results">
          <p>No recipes found for the selected filters.</p>
          <a href="recipe_collection.php" class="reset-btn">Show All Recipes</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include "./include/footer.php"; ?>