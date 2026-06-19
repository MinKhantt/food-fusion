<?php 
session_start();
include "./include/db_config.php";

$error = "";
$success = "";
$currentUser = null;

$userID = $_SESSION["user_id"] ?? null;
$editProfileID = $_GET["user_id"] ?? null;

if(!$userID) {
    header("location: login.php");
    exit();
}

// Validate user ID
if (!$userID) {
    $error = "Invalid User ID.";
} elseif ($editProfileID != $userID) {
    $error = "Unauthorized access.";
} else {
    // Get current user data
    $currentUser = getCurrentUser($conn, $editProfileID);
}

// Fetches current user data from database
function getCurrentUser($conn, $id) {
    global $error;
    try {
        $sql = "SELECT user_id, first_name, last_name, email FROM users WHERE user_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        $error = "Error fetching user data: " . $e->getMessage();
        return null;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/";

    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = :userID");
    $stmt->execute([':userID' => $userID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($old_password, $user['password'])) {
        $error = "Old password is incorrect.";
    } 
    elseif ($old_password === $new_password) {
        $error = "New password cannot be the same as old password.";
    }
    elseif(!preg_match($pattern, $new_password)) {
        $error = "Password must be at least 8 characters and include uppercase, lowercase, number, and special character.";
    } 
    elseif ($new_password !== $confirm_password) {
        $error = "New passwords do not match.";
    } 
    else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = :password WHERE user_id = :userID");
        $stmt->execute([':password' => $hashed, ':userID' => $userID]);
        
        $_SESSION['password_change_success'] = true;
        header("Location: login.php?password_changed=1");
        session_destroy();
        exit();
    }
}

$title = "Change Password";
include "./include/header.php";
?>

<section class="change-password-section">
    <div class="container">
        <?php if ($currentUser): ?>
            <form method="post" class="change-password-form">
                <h2><i class="fas fa-lock"></i> Change Password</h2>
                
                <?php if (isset($_SESSION['password_change_success'])): ?>
                    <div class="alert alert-success">Password changed successfully!</div>
                    <?php unset($_SESSION['password_change_success']); ?>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="old_password">Old Password</label>
                    <input type="password" name="old_password" id="old_password" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" required>
                    <small class="text-muted">Must be 8+ chars with uppercase, lowercase, number, and special character</small>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Change Password</button>
                <a href="edit_profile.php?edit_profile_id=<?= $editProfileID ?>" class="btn btn-secondary">Back to Profile</a>
            </form>
        <?php else: ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        
    </div>
</section>

<?php include "./include/footer.php"; ?>