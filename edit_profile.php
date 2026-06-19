<?php
session_start();
require_once "./include/db_config.php";

$error = "";
$success = "";
$currentUser = null;

$user_id = $_SESSION["user_id"];
$editProfileID = filter_input(INPUT_GET, "edit_profile_id", FILTER_VALIDATE_INT);


// Validate session and user ID
if (!isset($user_id) || empty($user_id)) {
    header("Location: login.php");
    exit();
}

// Validate profile ID
if (!$editProfileID) {
    $error = "Invalid profile ID.";
} elseif ($editProfileID != $user_id) {
    $error = "Unauthorized access.";
} else {
    // Get current user data
    $currentUser = getCurrentUser($conn, $editProfileID);
    
    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editBtn"])) {
        if (updateProfile($conn, $editProfileID)) {
            // To prevent form resubmission
            $_SESSION['profile_update_success'] = true;
            header("Location: edit_profile.php?edit_profile_id=" . $editProfileID);
            exit();
        }
        // Refresh user data after updated
        $currentUser = getCurrentUser($conn, $editProfileID);
    }
}

// Check for success message from PRG pattern
if (isset($_SESSION['profile_update_success'])) {
    $success = "Profile updated successfully!";
    unset($_SESSION['profile_update_success']);
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


// Updates user profile in database
function updateProfile($conn, $id) {
    global $error;
    
    // Validate and sanitize inputs
    $fName = trim(filter_input(INPUT_POST, "fname", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $lName = trim(filter_input(INPUT_POST, "lname", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    
    // Validate required fields
    if (empty($fName)) {
        $error = "First name is required!";
        return false;
    }
    if (empty($lName)) {
        $error = "Last name is required!";
        return false;
    }
    
    try {
        $sql = "UPDATE users SET first_name = :fName, last_name = :lName WHERE user_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":fName" => $fName,
            ":lName" => $lName,
            ":id" => $id
        ]);
        
        // Update session name
        $_SESSION["user_name"] = $fName . " " . $lName;
        return true;
    } catch(PDOException $e) {
        $error = "Error updating profile: " . $e->getMessage();
        return false;
    }
}

$title = "Edit Profile";
include "./include/header.php";
?>

<section class="profile-section">
    <div class="container">
        <?php if ($currentUser): ?>
            <form class="profile-form" method="POST" novalidate>
                <h2><i class="fas fa-user-edit"></i> Edit Your Profile</h2>
                
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input type="text" id="fname" name="fname" class="form-control" 
                           value="<?= htmlspecialchars($currentUser['first_name']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input type="text" id="lname" name="lname" class="form-control" 
                           value="<?= htmlspecialchars($currentUser['last_name']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" class="form-control" 
                           value="<?= htmlspecialchars($currentUser['email']) ?>" disabled>
                    <small class="text-muted">Note: Email cannot be changed.</small>
                </div>
                
                <button type="submit" name="editBtn" class="btn btn-primary">Update Profile</button>
                <a href="change_password.php?user_id=<?= $editProfileID ?>" class="btn btn-secondary">Change Password</a>
            </form>
        <?php else: ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
    </div>
</section>

<?php include "./include/footer.php"; ?>