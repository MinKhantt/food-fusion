<?php
session_start();
include "./include/db_config.php";

$user_id = $_SESSION["user_id"] ?? null;

$title = "About Us";
include "./include/header.php";
?>

<section class="about-section">
        <!-- About FoodFusion -->
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>About FoodFusion</h2>
                    <p class="lead">We believe that cooking is more than just preparing food – it's about creating memories, sharing cultures, and bringing people together.</p>
                    <p>Our mission is to inspire culinary creativity and foster a vibrant community of food enthusiasts. Whether you're a seasoned chef or just starting your culinary journey, FoodFusion provides the tools, resources, and community support you need to explore the wonderful world of cooking.</p>
                    <div class="values">
                        <div class="value-item">
                            <i class="fas fa-heart"></i>
                            <h4>Passion</h4>
                            <p>We're passionate about food and the joy it brings to people's lives.</p>
                        </div>
                        <div class="value-item">
                            <i class="fas fa-users"></i>
                            <h4>Community</h4>
                            <p>Building connections through shared culinary experiences.</p>
                        </div>
                        <div class="value-item">
                            <i class="fas fa-lightbulb"></i>
                            <h4>Creativity</h4>
                            <p>Encouraging innovation and experimentation in the kitchen.</p>
                        </div>
                        <div class="value-item">
                            <i class="fas fa-globe"></i>
                            <h4>Diversity</h4>
                            <p>Celebrating the rich tapestry of global cuisines and cultures.</p>
                        </div>   
                    </div>
                </div>
                <div class="about-image">
                    <img src="./images/about_us.jpg" alt="Cooking together">
                </div>
            </div>
        </div>
        
        <!-- Team -->
        <div class="team-section">
            <div class="container">
                <h2>Meet the Team</h2>
                <p>We are a diverse group of food lovers, chefs, and tech enthusiasts dedicated to making FoodFusion a welcoming space for everyone.</p>
            </div>
            <div class="team-members">
              <div class="member-card">
                <img src="./images/team/aung-min.jpg" alt="Aung Min" />
                <h3>Aung Min</h3>
                <p>Founder & Head Chef</p>
                <p class="member-bio">
                  Aung Min is the visionary behind FoodFusion. With over a decade of experience in professional kitchens, he founded the platform to make cooking approachable and joyful for everyone.
                </p>
              </div>
              
              <div class="member-card">
                <img src="./images/team/thiri-hlaing.jpg" alt="Thiri Hlaing" />
                <h3>Thiri Hlaing</h3>
                <p>Community Manager</p>
                <p class="member-bio">
                  Thiri manages user engagement and curates featured recipes. With a background in food blogging, she brings people together through delicious conversations.
                </p>
              </div>
              
              <div class="member-card">
                <img src="./images/team/zaw-ko-ko.jpg" alt="Zaw Ko Ko" />
                <h3>Zaw Ko Ko</h3>
                <p>Lead Developer</p>
                <p class="member-bio">
                  Zaw built the digital engine behind FoodFusion. He ensures the platform is fast, secure, and user-friendly for all food lovers.
                </p>
              </div>
              
              <div class="member-card">
                <img src="./images/team/may-thandar.jpg" alt="May Thandar" />
                <h3>May Thandar</h3>
                <p>Content & Recipe Curator</p>
                <p class="member-bio">
                  May reviews recipe submissions, writes blog content, and keeps FoodFusion fresh and inspiring with her love for food storytelling.
                </p>
              </div>
            </div>
        </div>
        
</section>

<?php include "./include/footer.php"; ?>
