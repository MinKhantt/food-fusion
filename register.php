<?php
include "./include/db_config.php";

$error = "";
$modalSubmission = isset($_POST['modal_submission']);
$responseData = [
    'success' => false,
    'error' => '',
    'clearFields' => []
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $fName = trim(filter_input(INPUT_POST, "fName", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $lName = trim(filter_input(INPUT_POST, "lName", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
    $password = trim($_POST["password"] ?? "");
    $confirmPsw = trim($_POST["conPassword"] ?? "");

    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/";

    // Validate fields
    if (!$fName || !$lName || !$email || !$password || !$confirmPsw) {
        $error = "All fields are required!";
        $responseData['clearFields'] = array_keys(array_filter([
            'fName' => !$fName,
            'lName' => !$lName,
            'email' => !$email,
            'password' => !$password,
            'conPassword' => !$confirmPsw
        ]));
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
        $responseData['clearFields'] = ['email'];
    } elseif (!preg_match($pattern, $password)) {
        $error = "Password must be at least 8 characters, include upper and lower case letters, a number, and a special character.";
        $responseData['clearFields'] = ['password', 'conPassword'];
    } elseif ($password !== $confirmPsw) {
        $error = "Passwords do not match!";
        $responseData['clearFields'] = ['password', 'conPassword'];
    } else {
        try {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);

            if ($stmt->fetchColumn() > 0) {
                $error = "Email already exists!";
                $responseData['clearFields'] = ['email'];
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password)
                                        VALUES (:fName, :lName, :email, :password)");
                $stmt->execute([
                    ':fName' => $fName,
                    ':lName' => $lName,
                    ':email' => $email,
                    ':password' => $hash
                ]);

                $responseData['success'] = true;
                $responseData['redirect'] = 'login.php';
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}

$responseData['error'] = $error;

// For modal submissions
if ($modalSubmission) {
    header('Content-Type: application/json');
    echo json_encode($responseData);
    exit();
}

// For regular form submissions
$title = "Register";
include("include/header.php");
?>