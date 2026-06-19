<?php
  if (!isset($user_id)) $user_id = $_SESSION["user_id"] ?? null;
  $current = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar">
  <div class="nav-container">
    <a href="index.php" class="nav-logo">
      <i class="fas fa-utensils"></i> FoodFusion
    </a>

    <input type="checkbox" id="menu-toggle" class="menu-toggle">
    <label for="menu-toggle" class="menu-icon">
      <i class="fas fa-bars open-icon"></i>
      <i class="fas fa-times close-icon"></i>
    </label>

    <div class="nav-links">
      <div class="mobile-brand">
        <i class="fas fa-utensils"></i> FoodFusion
      </div>
      
      <div class="nav-pages">
        <a href="recipe_collection.php" class="<?= $current === 'recipe_collection.php' ? 'active' : '' ?>">
          <i class="fas fa-book-open"></i> Recipe
        </a>
        <a href="community_cookbook.php" class="<?= $current === 'community_cookbook.php' ? 'active' : '' ?>">
          <i class="fas fa-users"></i> Community
        </a>
        <a href="about_us.php" class="<?= $current === 'about_us.php' ? 'active' : '' ?>">
          <i class="fas fa-info-circle"></i> About Us
        </a>
        <a href="contact_us.php" class="<?= $current === 'contact_us.php' ? 'active' : '' ?>">
          <i class="fas fa-envelope"></i> Contact
        </a>

        <div class="dropdown">
          <a class="dropdown-toggle" data-dropdown-trigger>
            <i class="fas fa-lightbulb"></i> Resources ▾
          </a>
          <div class="dropdown-menu">
            <a href="culinary_resources.php" class="<?= $current === 'culinary_resources.php' ? 'active' : '' ?>">
              Culinary
            </a>
            <a href="educational_resources.php" class="<?= $current === 'educational_resources.php' ? 'active' : '' ?>">
               Educational
            </a>
          </div>
        </div>
      </div>

      <div class="nav-user">
        <?php if ($user_id): ?>
          <div class="dropdown">
            <a class="dropdown-toggle user-toggle" data-dropdown-trigger>
              <i class="fas fa-user-circle"></i>
              <span><?= htmlspecialchars($_SESSION["user_name"] ?? "User"); ?> ▾</span>
            </a>
            <div class="dropdown-menu">
              <a href="edit_profile.php?edit_profile_id=<?= $user_id ?>">
                <i class="fas fa-user-edit"></i> Edit Profile
              </a>
              <a href="logout.php?logout_id=<?= $user_id ?>">
                <i class="fas fa-sign-out-alt"></i> Log Out
              </a>
            </div>
          </div>
        <?php else: ?>
          <a href="login.php">
            <i class="fas fa-sign-out-alt"></i> Log In
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menu-toggle");
    const dropdownTriggers = document.querySelectorAll("[data-dropdown-trigger]");

    // Handle dropdown toggles
    dropdownTriggers.forEach((trigger) => {
      trigger.addEventListener("click", function (e) {
        // Only prevent default on mobile/tablet
        if (window.innerWidth <= 1140) {
          e.preventDefault();
          e.stopPropagation();
        }
        
        const dropdown = this.closest(".dropdown");
        const isOpen = dropdown.classList.contains("open");
        
        // Close all other dropdowns
        document.querySelectorAll(".dropdown.open").forEach(drop => {
          if (drop !== dropdown) drop.classList.remove("open");
        });
        
        // Toggle current dropdown
        dropdown.classList.toggle("open", !isOpen);
      });
    });

    // Close dropdowns when clicking outside
    document.addEventListener("click", function(e) {
      if (!e.target.closest(".dropdown")) {
        document.querySelectorAll(".dropdown.open").forEach(drop => {
          drop.classList.remove("open");
        });
      }
    });

    // Close mobile menu when clicking a regular link
    document.querySelectorAll(".nav-links a:not([data-dropdown-trigger])").forEach(link => {
      link.addEventListener("click", function() {
        if (window.innerWidth <= 1140) {
          menuToggle.checked = false;
        }
      });
    });
  });
</script>