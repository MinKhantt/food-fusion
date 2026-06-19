<?php
session_start();
include "./include/db_config.php";

$user_id = $_SESSION["user_id"] ?? null;
$post_id = $_GET['post_id'] ?? 0;

// Get recipe details
try {
    $stmt = $conn->prepare("
        SELECT r.*, 
               u.first_name, 
               u.last_name,
               (SELECT COUNT(*) FROM likes WHERE post_id = r.id) AS like_count
        FROM community_posts r
        JOIN users u ON r.user_id = u.user_id
        WHERE r.id = ?
    ");
    $stmt->execute([$post_id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        echo "<p>Post not found.</p>";
        exit;
    }

    $is_liked = false;
    if ($user_id) {
        $check = $conn->prepare("SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id");
        $check->execute([
            ':user_id' => $user_id,
            ':post_id' => $post_id
        ]);
        $is_liked = $check->rowCount() > 0;
    }

    $comments = $conn->prepare("
        SELECT c.*, u.first_name, u.last_name, c.created_at
        FROM comments c
        JOIN users u ON c.user_id = u.user_id
        WHERE c.post_id = ?
        ORDER BY c.created_at DESC
    ");
    $comments->execute([$post_id]);
} catch (PDOException $e) {
    echo "Error loading post.";
    exit;
}

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && $user_id && isset($_POST['comment'])) {
    $comment = $_POST['comment'];

    try {
        $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (:post_id, :user_id, :comment)");
        $stmt->execute([
            ':post_id' => $post_id,
            ':user_id' => $user_id,
            ':comment' => $comment
        ]);
        header("Location: each_post.php?post_id=$post_id#comments");
        exit;
    } catch (PDOException $e) {
        echo "Failed to post comment.";
    }
}



$title = htmlspecialchars($post['title']);
include './include/header.php';
?>

<section>
    <div class="post-details">
        <?php if ($post['image_url']): ?>
            <img src="<?= htmlspecialchars($post['image_url']) ?>" alt="Post Image" class="post-full-image">
        <?php endif; ?>

        <div class="post-full-content">
            <h1 class="post-full-title"><?= htmlspecialchars($post['title']) ?></h1>
            <p class="post-full-description"><?= htmlspecialchars($post['description']) ?></p>

            <div class="post-meta">
                <?php if ($user_id): ?>
                    <div class="post-actions">
                        <span>Show some love with a heart</span>
                        <button class="action-btn like-btn <?= $is_liked ? 'liked' : '' ?>" onclick="likePost(<?= $post_id ?>, this)">
                        <span class="icon">❤️</span> <span class="count"><?= $post['like_count'] ?></span>
                        </button>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary">
                        <i class="fas fa-sign-out-alt"></i> Login to react
                    </a>
                <?php endif; ?>

                <div>
                    <span class="post-author">By <?= htmlspecialchars($post['first_name'] . ' ' . $post['last_name']) ?></span>
                    <span> on <?= date("M j, Y · g:i A", strtotime($post['created_at'])) ?></span>
                </div>
            </div>
        </div>

        <div id="comments" class="comments-section">
            <h3>Comments (<?= $comments->rowCount() ?>)</h3>

            <?php if ($user_id): ?>
                <form class="comment-form" method="POST">
                    <label for="comment">Add a comment</label>
                    <textarea name="comment" id="comment" rows="3" required></textarea>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </form>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary">
                    <i class="fas fa-sign-out-alt"></i> Login to comment
                </a>
            <?php endif; ?>

            <div class="comment-list">
                <?php while ($comment = $comments->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="comment">
                        <div class="comment-header">
                            <span class="comment-author"><?= htmlspecialchars($comment['first_name'] . ' ' . $comment['last_name']) ?></span>
                            <span class="comment-date">
                                <?= date("M j, Y · g:i A", strtotime($comment['created_at'])) ?>
                            </span> 
                        </div>
                        <p><?= htmlspecialchars($comment['comment']) ?></p>
                    </div>
                <?php endwhile; ?>

                <?php if ($comments->rowCount() == 0): ?>
                    <p>No comments yet. Be the first to comment!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="back-link-wrapper">
      <a href="community_cookbook.php" class="back-link">← Back to Community Cookbook</a>
    </div>


    <script>
        function likePost(postId, element) {
            fetch(`community_cookbook.php?like=${postId}`)
                .then(() => {
                    const countElement = element.querySelector('.count');
                    const isLiked = element.classList.contains('liked');
                    const count = parseInt(countElement.textContent);

                    element.classList.toggle('liked');
                    countElement.textContent = isLiked ? count - 1 : count + 1;
                });
        }
        
    </script>
</section>

<?php include './include/footer.php'; ?>
