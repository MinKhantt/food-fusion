<?php
session_start();
include "./include/db_config.php";

$user_id = $_SESSION["user_id"] ?? null;

// Function to fetch resources safely using PDO
function getCulinaryResources($pdo, $type) {
    $resources = [];
    try {
        $stmt = $pdo->prepare("SELECT * FROM culinary_resources WHERE type = :type ORDER BY created_at DESC");
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->execute();
        
        $resources = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
    }
    return $resources;
}

// Get all resources
$recipeCards = getCulinaryResources($conn, 'recipe_card');
$cookingTutorials = getCulinaryResources($conn, 'cooking_tutorial');
$instructionalVideos = getCulinaryResources($conn, 'instructional_video');

$title = "Culinary Resources";
include "./include/header.php";
?>

<section class="culinary-resources">
    <div class="container">
        <div class="page-header">
            <h1 class="title"><i class="fas fa-seedling"></i>Culinary Resources</h1>
            <p class="subtitle">
                Discover downloadable recipe cards, step-by-step cooking tutorials and engaging videos covering essential techniques and clever kitchen hacks.
            </p>
        </div>

        <!-- Recipe Cards Section -->
        <div class="resource-section">
            <h2 class="section-title">Downloadable Recipe Cards</h2>
            <?php if (empty($recipeCards)): ?>
                <div class="alert alert-info">No recipe cards available at the moment.</div>
            <?php else: ?>
                <div class="resource-grid">
                    <?php foreach($recipeCards as $card): ?>
                    <div class="resource-card">
                        <div class="resource-image">
                            <img src="<?= htmlspecialchars($card['image_path']) ?>" 
                                alt="<?= htmlspecialchars($card['title']) ?>"
                                class="img-fluid">
                        </div>
                        <div class="resource-body">
                            <h3><?= htmlspecialchars($card['title']) ?></h3>
                            <p><?= htmlspecialchars($card['description']) ?></p>
                            <div class="resource-meta">
                                <small class="text-muted">Added: <?= date('M j, Y', strtotime($card['created_at'])) ?></small>
                            </div>
                            <a href="download.php?file=<?= urlencode($card['file_name']) ?>" class="btn btn-primary download-btn">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Cooking Tutorials Section -->
        <div class="resource-section mb-5">
            <h2 class="section-title">Cooking Tutorials</h2>
            <?php if (empty($cookingTutorials)): ?>
                <div class="alert alert-info">No cooking tutorials available at the moment.</div>
            <?php else: ?>
                <div class="resource-grid">
                    <?php foreach($cookingTutorials as $tutorial): ?>
                    <div class="resource-card">
                        <div class="video-container">
                            <?= !empty($tutorial['embed_code']) ? htmlspecialchars_decode($tutorial['embed_code']) : 
                                '<div class="alert alert-warning">YouTube embed code missing</div>' ?>
                        </div>
                        <div class="resource-body">
                            <h3><?= htmlspecialchars($tutorial['title']) ?></h3>
                            <p><?= htmlspecialchars($tutorial['description']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Instructional Videos Section -->
        <div class="resource-section">
            <h2 class="section-title">Instructional Videos & Kitchen Hacks</h2>
            <?php if (empty($instructionalVideos)): ?>
                <div class="alert alert-info">No instructional videos available at the moment.</div>
            <?php else: ?>
                <div class="resource-grid">
                    <?php foreach($instructionalVideos as $video): ?>
                    <div class="resource-card">
                        <div class="video-container">
                            <?= !empty($video['embed_code']) ? htmlspecialchars_decode($video['embed_code']) : 
                                '<div class="alert alert-warning">YouTube embed code missing</div>' ?>
                        </div>
                        <div class="resource-body">
                            <h3><?= htmlspecialchars($video['title']) ?></h3>
                            <p><?= htmlspecialchars($video['description']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>



<?php include "./include/footer.php"; ?>