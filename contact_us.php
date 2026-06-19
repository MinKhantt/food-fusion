<?php
session_start();
include './include/db_config.php';

$error = "";
$success = "";

$name = $email = $phone = $subject = $message = $country_code = $phone_number = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $$name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
  $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
  $country_code = filter_input(INPUT_POST, 'country_code', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $phone_number = trim(filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
  $phone = $country_code . $phone_number; // Combine country code and phone number
  $subject = trim(filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
  $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

  if (!$name || !$email || !$subject || !$message || !$phone) {
      $error = "All fields are required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = "Invalid email format.";
  } elseif ($country_code === '+95') {
    if (!preg_match('/^9\d{7,9}$/', $phone_number)) {
      $error = "Myanmar phone numbers must start with 9 and be 8 to 10 digits.";
    }
  } elseif ($country_code === '+1') {
    if (!preg_match('/^[2-9]\d{9}$/', $phone_number)) {
      $error = "US phone numbers must be exactly 10 digits and start with 2–9.";
    }
  } elseif ($country_code === '+44') {
    if (!preg_match('/^7\d{9}$/', $phone_number)) {
      $error = "UK mobile numbers must start with 7 and be 10 digits long.";
    }
  }

  if(!$error) {
    try {
      $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone_number, subject, message) 
                              VALUES (:name, :email, :phone, :subject, :message)");

      $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':subject' => $subject,
        ':message' => $message
      ]);

      $success = "Message sent successfully!";
      // Reset form values
      $name = $email = $phone = $subject = $message = $country_code = $phone_number = "";
    } catch (PDOException $e) {
      // error_log($e->getMessage());
      $error = "Something went wrong. Please try again later.";
    }
  }
}

$title = "Contact Us";
include './include/header.php';
?>

<section class="contact-section">
  <div class="container">
    <h2>Get in Touch</h2>
    <div class="contact-content">
      <div class="contact-info">
        <p>Have a question, recipe request, or feedback? We'd love to hear from you!</p>
        <div class="contact-item">
          <i class="fas fa-envelope"></i>
          <span>hello@foodfusion.com.mm</span>
        </div>
        <div class="contact-item">
          <i class="fas fa-phone"></i>
          <span>+95 9 765 432 109</span>
        </div>
        <div class="contact-item">
          <i class="fas fa-map-marker-alt"></i>
          <span>Near Shwedagon Pagoda, Dagon Township, Yangon, Myanmar</span>
        </div>
      </div>

      <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="contact-form" method="POST">
        <?php if ($error): ?>
          <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
          <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" placeholder="Your Name" required value="<?= htmlspecialchars($name) ?>">
        </div>

        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" placeholder="Your Email" required value="<?= htmlspecialchars($email) ?>">
        </div>

        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <div style="display: flex; gap: 0.5rem;">
                <select name="country_code" id="country_code" required>
                <option value="">Select Country Code</option>
                <option value="+95" <?= $country_code === '+95' ? 'selected' : '' ?>>🇲🇲 +95 (Myanmar)</option>
                <option value="+1" <?= $country_code === '+1' ? 'selected' : '' ?>>🇺🇸 +1 (USA)</option>
                <option value="+44" <?= $country_code === '+44' ? 'selected' : '' ?>>🇬🇧 +44 (UK)</option>
                </select>
                <input type="text" name="phone_number" id="phone_number" placeholder="Your Phone Number" required value="<?= htmlspecialchars($phone_number) ?>">
            </div>
        </div>


        <div class="form-group">
          <label for="subject">Subject:</label>
          <select id="subject" name="subject" required>
            <option value="">Select Subject</option>
            <option value="General Inquiry" <?= $subject === 'General Inquiry' ? 'selected' : '' ?>>General Inquiry</option>
            <option value="Recipe Request" <?= $subject === 'Recipe Request' ? 'selected' : '' ?>>Recipe Request</option>
            <option value="Feedback" <?= $subject === 'Feedback' ? 'selected' : '' ?>>Feedback</option>
            <option value="Technical Support" <?= $subject === 'Technical Support' ? 'selected' : '' ?>>Technical Support</option>
          </select>
        </div>

        <div class="form-group">
          <label for="message">Message:</label>
          <textarea id="message" name="message" placeholder="Your Message" rows="5" required><?= htmlspecialchars($message) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Send Message</button>
      </form>
    </div>
  </div>
</section>

<?php include './include/footer.php'; ?>
