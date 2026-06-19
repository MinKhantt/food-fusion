<!-- Register Modal Overlay -->
<div id="registerModal" class="register-modal-overlay" style="display: none;">
    <!-- Register Modal Content -->
    <div class="register-modal-content">
        <h2>Join FoodFusion</h2>
        <span class="register-close-btn" id="closeJoinModal">&times;</span>

        <?php if (!empty($error)): ?>
            <div class="register-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="register.php" id="joinForm" method="post" class="join-form">
            
            <input type="hidden" name="modal_submission" value="1">
            
            <label for="fName">First Name:</label>
            <input type="text" id="fName" name="fName" placeholder="Enter Your First Name" 
                   value="<?= htmlspecialchars($_POST['fName'] ?? '') ?>" required>
            
            <label for="lName">Last Name:</label>
            <input type="text" id="lName" name="lName" placeholder="Enter Your Last Name"
                   value="<?= htmlspecialchars($_POST['lName'] ?? '') ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter Your Email Address"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter Your Password" required>
            
            <label for="conPassword">Confirm Password:</label>
            <input type="password" id="conPassword" name="conPassword" placeholder="Confirm Your Password" required>
            
            <button type="submit">
                <i class="fas fa-user-plus"></i> Create Account
            </button>
            
            <p class="register-note">
                Already have an account? 👉
                <a href="login.php" class="login-to-link">Login</a>
            </p>
        </form>
    </div>
</div>