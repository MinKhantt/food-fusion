<?php 
session_start();
include "./include/db_config.php";

$user_id = $_SESSION["user_id"] ?? null;

// Handle registration POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["register_event_id"]) && $user_id) {
  $event_id = (int) $_POST["register_event_id"];
  $registrationMessageForEvent = $event_id; 

  try {
    $check = $conn->prepare("SELECT * FROM event_registration WHERE event_id = :event_id AND user_id = :user_id");
    $check->execute([
      ':event_id' => $event_id,
      ':user_id' => $user_id
    ]);

    if ($check->rowCount() === 0) {
      $insert = $conn->prepare("INSERT INTO event_registration (event_id, user_id) VALUES (:event_id, :user_id)");
      $insert->execute([
        ':event_id' => $event_id,
        ':user_id' => $user_id
      ]);
      $registrationMessage = "You’ve successfully registered!";
    } else {
      $registrationMessage = "You already registered for this event.";
    }
  } catch (PDOException $e) {
    error_log("Event Registration Error: " . $e->getMessage());
    $registrationMessage = "Something went wrong. Try again later.";
  }
}


$title = "FoodFusion";
include "./include/header.php";
?>

<section class="homepage-content">

 <?php include 'include/register_modal.php'; ?>

  <!-- Hero Section -->
  <div class="hero">
    <div class="hero-overlay">
      <h1>Welcome to <span>FoodFusion</span></h1>
      <p>Inspiring home cooks. Sharing global flavors. Building community.</p>

      <?php if (!$user_id): ?>
        <button id="joinUsBtn">Join Us</button>
      <?php endif; ?>
      <?php if ($user_id): ?>
        <a href="recipe_collection.php">Explore Recipes</a>
      <?php endif; ?>
    </div>
  </div>
  
  <!-- Mission -->
  <div class="mission">
  <h2>Our Mission</h2>
  <p class="mission-intro">FoodFusion is dedicated to inspiring home cooks, sharing global flavors, and building a vibrant community of food lovers.</p>
  <div class="mission-values">
    <div class="mission-item">
      <img src="images/icons/inspire.png" alt="Inspire Icon">
      <h3>Inspire</h3>
      <p>Empowering everyday cooks with easy and creative recipes.</p>
    </div>
    <div class="mission-item">
      <img src="images/icons/share.png" alt="Share Icon">
      <h3>Share</h3>
      <p>Celebrating diverse culinary traditions from around the world.</p>
    </div>
    <div class="mission-item">
      <img src="images/icons/community.png" alt="Community Icon">
      <h3>Connect</h3>
      <p>Bringing food lovers together in a vibrant online community.</p>
    </div>
  </div>
  </div>

  <!-- Featured Recipes -->
  <div class="news-section">
    <h2 class="news-section__title">Featured Recipes</h2>
    <div class="news-section__grid">
      <?php
      try {
        $stmt = $conn->prepare("SELECT * FROM recipes WHERE is_featured = 1 ORDER BY created_at DESC");
        $stmt->execute();
        $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($recipes):
          foreach ($recipes as $recipe):
            $image = !empty($recipe['image_url']) ? htmlspecialchars($recipe['image_url']) : 'images/recipes/default-recipe.jpg';
      ?>
        <div class="news-card">
          <img src="<?= $image ?>" alt="<?= htmlspecialchars($recipe['title']) ?>" class="news-card__img">
          <div class="news-card__content">
            <h3 class="news-card__title"><?= htmlspecialchars($recipe['title']) ?></h3>
            <p class="news-card__desc"><?= htmlspecialchars($recipe['description']) ?></p>
            <a href="view_recipe.php?recipe_id=<?= $recipe['recipe_id'] ?>" class="news-card__link">View Recipe</a>
          </div>
        </div>
      <?php
          endforeach;
        else:
          echo "<p class='news-section__empty'>No featured recipes found.</p>";
        endif;
      } catch (PDOException $e) {
        echo "<p class='news-section__error'>Error loading recipes.</p>";
      }
      ?>
    </div>
  </div>

  <!-- Culinary Trends -->
  <div class="news-section">
    <h2 class="news-section__title">Culinary Trends</h2>
    <div class="news-section__grid">
      <?php
      try {
        $stmt = $conn->prepare("SELECT * FROM recipes WHERE is_trend = 1 ORDER BY created_at DESC");
        $stmt->execute();
        $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($recipes):
          foreach ($recipes as $recipe):
            $image = !empty($recipe['image_url']) ? htmlspecialchars($recipe['image_url']) : 'images/recipes/default-recipe.jpg';
      ?>
        <div class="news-card">
          <img src="<?= $image ?>" alt="<?= htmlspecialchars($recipe['title']) ?>" class="news-card__img">
          <div class="news-card__content">
            <h3 class="news-card__title"><?= htmlspecialchars($recipe['title']) ?></h3>
            <p class="news-card__desc"><?= htmlspecialchars($recipe['description']) ?></p>
            <a href="view_recipe.php?recipe_id=<?= $recipe['recipe_id'] ?>" class="news-card__link">View Recipe</a>
          </div>
        </div>
      <?php
          endforeach;
        else:
          echo "<p class='news-section__empty'>No culinary trends found.</p>";
        endif;
      } catch (PDOException $e) {
        echo "<p class='news-section__error'>Error loading culinary trends.</p>";
      }
      ?>
    </div>
  </div>
  
  <!-- Cooking Events Carousel -->
  <div class="carousel">
    <h2>Upcoming Cooking Events</h2>
    <div class="carousel-wrapper">
      <button class="carousel-btn prev-btn" aria-label="Previous events">&#10094;</button>
      
      <div class="carousel-container" id="eventCarousel">
        <?php
          try {
            // Get current date in YYYY-MM-DD format for comparison
            $currentDate = date('Y-m-d');
            
            $stmt = $conn->prepare("SELECT * FROM events 
                                  WHERE event_date >= :currentDate 
                                  ORDER BY event_date ASC");
            $stmt->bindParam(':currentDate', $currentDate);
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($events):
              foreach ($events as $event):
                // Format date to: "Saturday, 15 Jul 2026, 6:00 PM"
                $date = date("l, j M Y, g:i A", strtotime($event['event_date']));
        ?>
          <div class="slide" id="event-<?= $event['event_id'] ?>">
            <?php if (!empty($event['image_url'])): ?>
              <img src="<?= htmlspecialchars($event['image_url']) ?>" 
                  alt="<?= htmlspecialchars($event['title']) ?>" 
                  loading="lazy">
            <?php endif; ?>
            
            <div class="event-details">
              <h3><?= htmlspecialchars($event['title']) ?></h3>
              <p class="event-date"><i class="fa fa-calendar"></i> <?= $date ?></p>
              
              <?php if (!empty($event['place'])): ?>
                <p class="event-location"><i class="fa fa-map-marker"></i> 
                  <?= htmlspecialchars($event['place']) ?>
                </p>
              <?php endif; ?>
              
              <p class="event-desc"><?= htmlspecialchars($event['description']) ?></p>

              <!-- Register Form -->
              <?php if ($user_id): ?>
                <form method="POST" action="#event-<?= $event['event_id'] ?>">
                  <input type="hidden" name="register_event_id" value="<?= $event['event_id'] ?>">
                  <button type="submit" class="register-btn">Register</button>
                </form>
              <?php else: ?>
                <a href="login.php" class="event-to-login">Log in to register</a>
              <?php endif; ?>

              <?php if (!empty($registrationMessage) && isset($registrationMessageForEvent) && $registrationMessageForEvent == $event['event_id']): ?>
                <div class="flash-msg"><?= htmlspecialchars($registrationMessage) ?></div>
              <?php endif; ?>

            </div>

          </div>
        <?php
              endforeach;
            else:
              echo '<div class="no-events"><p>No upcoming events scheduled. Check back later!</p></div>';
            endif;
          } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            echo '<div class="error"><p>We are having trouble loading events. Please try again later.</p></div>';
          }
        ?>
      </div>

      <button class="carousel-btn next-btn" aria-label="Next events">&#10095;</button>
    </div>
  </div>

  <!-- Cookie Consent -->
  <?php if (!isset($_COOKIE['cookie_consent'])): ?>
    <div class="cookie-consent" id="cookieConsent">
      <p>
        FoodFusion uses cookies to enhance your experience.
        By continuing to use this site, you agree to our 
        <a href="privacy_policy.php">Privacy Policy</a>.
      </p>
      <div class="cookie-buttons">
        <button id="declineCookies">Decline</button>
        <button id="acceptCookies">Accept</button>
      </div>
    </div>
  <?php endif; ?>

</section>


<script>
document.addEventListener("DOMContentLoaded", () => {
  // cookie functionality
  const acceptBtn = document.getElementById("acceptCookies");
  const declineBtn = document.getElementById("declineCookies");

  if (acceptBtn) {
    acceptBtn.onclick = () => {
      const date = new Date();
      date.setMonth(date.getMonth() + 1); // Expires in 1 month
      document.cookie = "cookie_consent=1; expires=" + date.toUTCString() + "; path=/";
      document.getElementById("cookieConsent").style.display = "none";
    };
  }

  if (declineBtn) {
    declineBtn.onclick = () => {
      const date = new Date();
      date.setTime(date.getTime() + (1000));
      document.cookie = "cookie_consent=0; expires=" + date.toUTCString() + "; path=/";
      document.getElementById("cookieConsent").style.display = "none";
    };
  }

  // event functionality
  const carousel = document.querySelector('.carousel-container');
  const prevBtn = document.querySelector('.prev-btn');
  const nextBtn = document.querySelector('.next-btn');
  const slides = document.querySelectorAll('.slide');
  const slideWidth = slides[0].offsetWidth + 24; 
  
  prevBtn.addEventListener('click', () => {
    carousel.scrollBy({ left: -slideWidth, behavior: 'smooth' });
  });
  
  nextBtn.addEventListener('click', () => {
    carousel.scrollBy({ left: slideWidth, behavior: 'smooth' });
  });
  
  // Hide buttons when at start/end
  carousel.addEventListener('scroll', function() {
    const atStart = carousel.scrollLeft === 0;
    const atEnd = carousel.scrollLeft >= carousel.scrollWidth - carousel.offsetWidth - 1;
    
    prevBtn.style.display = atStart ? 'none' : 'flex';
    nextBtn.style.display = atEnd ? 'none' : 'flex';
  });
  
  // Initial state
  prevBtn.style.display = 'none';
  if (carousel.scrollWidth <= carousel.offsetWidth) {
    nextBtn.style.display = 'none';
  }

  // recipe functionality
  const recipeCards = document.querySelectorAll('.news-card');
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = 1;
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, { threshold: 0.1 });
  
  recipeCards.forEach(card => {
    card.style.opacity = 0;
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(card);
  });


  // envet register
  const flashMsg = document.querySelector(".flash-msg");
  if (flashMsg) {
    setTimeout(() => {
      flashMsg.style.opacity = "0";
      flashMsg.style.transition = "opacity 0.5s ease";
    }, 10000); // 10 seconds
  }
});
</script>

<?php include("include/footer.php"); ?>
