<?php
session_start();
include("include/db_config.php");

$error = "";
$lockoutDuration = 180; // 3 minutes
$lockoutEndTime = 0;
$isLocked = false;

// Check if locked
if (isset($_SESSION['lockout_time'])) {
    $now = time();
    $elapsed = $now - $_SESSION['lockout_time'];

    if ($elapsed < $lockoutDuration) {
        $remaining = $lockoutDuration - $elapsed;
        $error = "Account locked. Try again in <span id='countdown-timer'>".gmdate("i:s", $remaining)."</span>";
        $lockoutEndTime = ($_SESSION['lockout_time'] + $lockoutDuration) * 1000;
        $isLocked = true;
    } else {
        unset($_SESSION['lockout_time']);
        unset($_SESSION['login_attempts']);
        $isLocked = false;
    }
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$isLocked) {
    $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
    $password = trim($_POST["password"] ?? "");

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION["user_name"] = $user["first_name"] . " " . $user["last_name"];
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;

            if ($_SESSION['login_attempts'] >= 3) {
                $_SESSION['lockout_time'] = time();
                $error = "Account locked. Try again in <span id='countdown-timer'>03:00</span>";
                $lockoutEndTime = ($_SESSION['lockout_time'] + $lockoutDuration) * 1000;
                $isLocked = true;
            } else {
                $remaining = 3 - $_SESSION['login_attempts'];
                $error = "Incorrect login. $remaining attempt(s) left.";
            }
        }
    }
}

$title = "Login";
include("include/header.php");
?>

<section class="login-section">
    <?php include 'include/register_modal.php'; ?>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form" id="loginForm">
        <h2>Welcome Back</h2>

        <?php if (!empty($error)) : ?>
            <p class="login-error"><?= $error ?></p>
        <?php endif; ?>

        <label for="email">Email</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            placeholder="Enter your email" 
            value="<?= htmlspecialchars($email ?? '') ?>" 
            <?= $isLocked ? 'disabled' : '' ?> required>
    
        <label for="password">Password</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            placeholder="Enter your password" 
            <?= $isLocked ? 'disabled' : '' ?> required>

        <button 
            type="submit" 
            name="login" 
            class="form-btn" 
            <?= $isLocked ? 'disabled' : '' ?>>
            <i class="fas fa-sign-out-alt"></i>
            Login
        </button>

        <p class="form-note">
            Don't have an account? 👉 
            <button id="joinUsBtn" class="login-link">Register</button>
        </p>
    </form>
</section>

<script>
const lockoutEnd = <?= $lockoutEndTime ?>; // JS timestamp in ms

if (lockoutEnd) {
    const form = document.getElementById('loginForm');
    const inputs = form.querySelectorAll('input');
    const button = form.querySelector('button[type="submit"]');
    const errorMsg = document.querySelector('.login-error');
    
    function enableForm() {
        inputs.forEach(input => {
            input.disabled = false;
            input.removeAttribute('disabled');
        });
        button.disabled = false;
        button.removeAttribute('disabled');
        
        if (errorMsg) {
            errorMsg.innerHTML = "You can now try logging in again";
            errorMsg.classList.remove('error');
            errorMsg.classList.add('success');
            
            setTimeout(() => {
                errorMsg.style.opacity = '0';
                setTimeout(() => errorMsg.remove(), 300);
            }, 3000);
        }
        
        fetch("include/unlock_timer.php", { method: "POST" });
    }

    function updateCountdown() {
        const now = Date.now();
        const diff = lockoutEnd - now;

        if (diff > 0) {
            const minutes = Math.floor(diff / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            const timeStr = `${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;
            
            if (errorMsg) {
                errorMsg.innerHTML = `Account locked. Try again in <span class="countdown-timer">${timeStr}</span>`;
            }
        } else {
            enableForm();
            clearInterval(timer);
        }
    }

    updateCountdown();
    const timer = setInterval(updateCountdown, 1000);
}
</script>

<?php include("include/footer.php"); ?>