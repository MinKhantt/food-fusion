<?php 
session_start();
include("include/db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));

    if (empty($email)) {
        $_SESSION["newsletter_error"] = "Email field cannot be empty.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["newsletter_error"] = "Invalid email format.";
    } else {
        try {
            // First check if email already exists
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM newsletter_subscribers WHERE email = :email");
            $checkStmt->execute([':email' => $email]);
            $emailExists = $checkStmt->fetchColumn();
            
            if ($emailExists > 0) {
                $_SESSION["newsletter_error"] = "That email is already subscribed!";
            } else {
                // Only insert if email doesn't exist
                $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (:email)");
                $stmt->execute([':email' => $email]);
                $_SESSION["newsletter_success"] = "Thank you for subscribing with the email: " . htmlspecialchars($email);
            }
        } catch (PDOException $e) {
            $_SESSION["newsletter_error"] = "Database error: " . $e->getMessage();
        }
    }

    // Redirect back to the previous page 
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit;
}
?>