<?php
session_start();
include "./include/db_config.php";

$user_id = $_SESSION["user_id"] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $user_id) {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $image_url = null;

    if (empty($title) || empty($description)) {
        echo "Please fill in all required fields.";
        exit;
    }

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "images/uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);

        $imageName = basename($_FILES['image']['name']);
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageFileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            $uniqueName = uniqid() . "_" . $imageName;
            $imagePath = $target_dir . $uniqueName;
            if (move_uploaded_file($imageTmp, $imagePath)) {
                $image_url = $imagePath;
            } else {
                echo "Image upload failed.";
                exit;
            }
        } else {
            echo "Invalid image type.";
            exit;
        }
    }

    // Insert into DB
    try {
        $stmt = $conn->prepare("INSERT INTO community_posts (user_id, title, description, image_url, created_at) VALUES (:user_id, :title, :description, :image_url, NOW())");
        $stmt->execute([
            ':user_id' => $user_id,
            ':title' => $title,
            ':description' => $description,
            ':image_url' => $image_url
        ]);

        header("Location: community_cookbook.php?success=1");
        exit;
    } catch (PDOException $e) {
        echo "DB Error: " . $e->getMessage();
    }
}

// Handle like toggle
if (isset($_GET['like']) && $user_id) {
    $recipe_id = (int)$_GET['like'];
    try {
        $stmt = $conn->prepare("SELECT * FROM likes WHERE user_id = :user_id AND post_id = :recipe_id");
        $stmt->execute([
            ':user_id' => $user_id,
            ':recipe_id' => $recipe_id
        ]);

        if ($stmt->rowCount() == 0) {
            $stmt = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)");
            $stmt->execute([
                ':user_id' => $user_id,
                ':post_id' => $recipe_id
            ]);
        } else {
            $stmt = $conn->prepare("DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id");
            $stmt->execute([
                ':user_id' => $user_id,
                ':post_id' => $recipe_id
            ]);
        }

        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit;
    } catch (PDOException $e) {
        error_log("Like error: " . $e->getMessage());
    }
}

$title = "Community Cookbook";
include "./include/header.php";
?>

<section class="community-cookbook">
        <div class="page-header">
            <h2><i class="fas fa-users"></i> Community Cookbook</h2>
            <p>Share your favorite recipes and discover culinary gems from our community</p>
            
            <?php if (!$user_id): ?>
                <a href="login.php" class="btn btn-primary">
                    <i class="fas fa-sign-out-alt"></i> Login to Share Post
                </a>
            <?php else: ?>
                <button onclick="openModal()" class="btn btn-primary">Share Post</button>
            <?php endif; ?>
        </div>
        
        <h3>Shared Posts</h3>
        <div class="recipe-grid">
            <?php
            try {
                $stmt = $conn->query("
                    SELECT r.*, 
                        u.first_name, 
                        u.last_name,
                        (SELECT COUNT(*) FROM likes WHERE post_id = r.id) AS like_count,
                        (SELECT COUNT(*) FROM comments WHERE post_id = r.id) AS comment_count
                    FROM community_posts r
                    JOIN users u ON r.user_id = u.user_id
                    ORDER BY r.created_at DESC
                ");
                
                if ($stmt->rowCount() > 0): 
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <div class="recipe-card">
                            <?php if ($row['image_url']): ?>
                                <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="Recipe Image" class="recipe-image">
                            <?php else: ?>
                                <div class="recipe-no-image">
                                    <i class="fa-solid fa-image"></i>
                                    <p>No image available</p>
                                </div>
                            <?php endif; ?>
                            
                            <div class="recipe-content">
                                <h3 class="recipe-title"><?= htmlspecialchars($row['title']) ?></h3>
                                <p class="recipe-description"><?= htmlspecialchars(substr($row['description'], 0, 46)) ?>...</p>
                                <sapn class="stat-item">❤️ <?= $row['like_count'] ?></sapn>
                                <sapn class="stat-item">💬 <?= $row['comment_count'] ?></sapn>
                                
                                <div class="recipe-meta">
                                    <span class="recipe-author">By <?= htmlspecialchars($row['first_name']) ?> <?= htmlspecialchars($row['last_name']) ?></span>
                                    <span><?= date("M j, Y", strtotime($row['created_at'])) ?></span>
                                    <a href="each_post.php?post_id=<?= $row['id'] ?>" class="see-more">See More</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; 
                else: ?>
                    <div class="empty-state">
                        <h3>No posts shared yet</h3>
                        <p>Be the first to share your favorite recipe with the community!</p>
                    </div>
                <?php endif;
            } catch (PDOException $e) { ?>
                <div class="empty-state">
                    <h3>Error loading posts</h3>
                    <p>We encountered an issue loading the posts. Please try again later.</p>
                </div>
            <?php } ?>
        </div>
        
        <!-- Post Submission Modal -->
        <div id="recipeModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h2>Share Your Post</h2>
                <form class="recipe-form" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" name="title" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                    <label for="description" class="form-label">What's on your mind?</label>
                    <textarea id="description" name="description" class="form-control" rows="15" required placeholder="Share your favourite recipe, cooking tip or culinary experience..."></textarea>

                </div>
                
                <div class="form-group">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" id="image" name="image" class="form-control file-input" accept="image/*">
                </div>
                
                <button type="submit" class="btn btn-primary">Share</button>
            </form>
        </div>
    </div>
    
    <script>
        function openModal() {
            document.getElementById('recipeModal').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('recipeModal').style.display = 'none';
        }
        
        window.onclick = function(event) {
            const modal = document.getElementById('recipeModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>

</section>
<?php include "./include/footer.php"; ?>
