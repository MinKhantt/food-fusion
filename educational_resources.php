<?php
session_start();
include "./include/db_config.php";

function getEducationalResources($pdo, $type) {
    $resources = [];
    try {
        $stmt = $pdo->prepare("SELECT * FROM educational_resources WHERE type = :type ORDER BY created_at DESC");
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->execute();
        $resources = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
    }
    return $resources;
}

$documents = getEducationalResources($conn, 'document');
$infographics = getEducationalResources($conn, 'infographic');
$videos = getEducationalResources($conn, 'video');

$title = "Educational Resources";
include "./include/header.php";
?>

<section class="educational-resources">
    <div class="container">
        <div class="page-header">
            <h1 class="title"><i class="fas fa-graduation-cap"></i>Educational Resources</h1>
            <p class="subtitle">
                Explore informative downloads, engaging infographics, and instructional videos about renewable energy. 
                Stay informed, stay inspired.
            </p>
        </div>

        <!-- Documents Section -->
        <div class="resource-section">
            <h2 class="section-title">Resources</h2>
            <?php if (empty($documents)): ?>
                <div class="alert info">No resources available at the moment.</div>
            <?php else: ?>
                <div class="resource-grid">
                    <?php foreach($documents as $document): ?>
                    <div class="resource-card">
                        <div class="resource-image">
                            <img src="<?= htmlspecialchars($document['image_path']) ?>" 
                                alt="<?= htmlspecialchars($document['title']) ?>">
                        </div>
                        <div class="resource-body">
                            <h3><?= htmlspecialchars($document['title']) ?></h3>
                            <p><?= htmlspecialchars($document['description']) ?></p>
                            <div class="resource-footer">
                                <span class="date">Added: <?= date('M j, Y', strtotime($document['created_at'])) ?></span>
                                <a href="download.php?file=<?= urlencode($document['file_name']) ?>" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Infographics Section -->
        <div class="resource-section">
            <h2 class="section-title">Infographics</h2>
            <?php if (empty($infographics)): ?>
                <div class="alert info">No infographics available at the moment.</div>
            <?php else: ?>
                <div class="infographics-grid">
                    <?php foreach($infographics as $infographic): ?>
                    <div class="infographic-card">
                        <div class="infographic-image">
                            <img src="<?= htmlspecialchars($infographic['image_path']) ?>" 
                                alt="<?= htmlspecialchars($infographic['title']) ?>">
                        </div>
                        <div class="infographic-body">
                            <h3><?= htmlspecialchars($infographic['title']) ?></h3>
                            <span class="date">Added: <?= date('M j, Y', strtotime($infographic['created_at'])) ?>
                            </span>
                            <a href="<?= $infographic['image_path']?>" class="download-btn-infographic" download>
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Videos Section -->
        <div class="resource-section">
            <h2 class="section-title">Renewable Energy Topics</h2>
            <?php if (empty($videos)): ?>
                <div class="alert info">No videos available at the moment.</div>
            <?php else: ?>
                <div class="video-carousel-container">
                    <button class="carousel-btn prev" onclick="changeVideo(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    
                    <div class="video-carousel">
                        <div class="video-wrapper">
                            <?php foreach($videos as $index => $video): ?>
                            <div class="video-slide<?= $index === 0 ? ' active' : '' ?>">
                                <div class="video-container">
                                    <?= !empty($video['embed_code']) ? htmlspecialchars_decode($video['embed_code']) : 
                                        '<div class="alert warning">Video embed code missing</div>' ?>
                                </div>
                                <div class="video-info">
                                    <h3><?= htmlspecialchars($video['title']) ?></h3>
                                    <p><?= htmlspecialchars($video['description']) ?></p>
                                    <span class="date">Added: <?= date('M j, Y', strtotime($video['created_at'])) ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <button class="carousel-btn next" onclick="changeVideo(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                
                <div class="indicators">
                    <?php foreach($videos as $index => $video): ?>
                        <span class="indicator<?= $index === 0 ? ' active' : '' ?>" 
                            onclick="goToVideo(<?= $index ?>)"></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    let currentVideoIndex = 0;
    const slides = document.querySelectorAll(".video-slide");
    const indicators = document.querySelectorAll(".indicator");

    function changeVideo(step) {
        slides[currentVideoIndex].classList.remove("active");
        indicators[currentVideoIndex].classList.remove("active");
        
        currentVideoIndex = (currentVideoIndex + step + slides.length) % slides.length;
        
        slides[currentVideoIndex].classList.add("active");
        indicators[currentVideoIndex].classList.add("active");
    }

    function goToVideo(index) {
        slides[currentVideoIndex].classList.remove("active");
        indicators[currentVideoIndex].classList.remove("active");
        
        currentVideoIndex = index;
        
        slides[currentVideoIndex].classList.add("active");
        indicators[currentVideoIndex].classList.add("active");
    }
</script>

<?php include "./include/footer.php"; ?>