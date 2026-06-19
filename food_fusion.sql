-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2025 at 04:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_fusion`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`, `created_at`) VALUES
(1, 2, 5, 'Really great ', '2025-10-20 02:43:20'),
(2, 2, 7, 'The apple pie looks nice', '2025-10-20 02:50:20'),
(6, 4, 5, 'good tip!', '2025-10-20 03:05:32'),
(9, 8, 5, 'hello', '2025-10-20 03:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `community_posts`
--

CREATE TABLE `community_posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_posts`
--

INSERT INTO `community_posts` (`id`, `user_id`, `title`, `description`, `image_url`, `created_at`) VALUES
(1, 5, 'Quick Garlic Shrimp', 'Need a delicious dinner fast? This quick garlic shrimp recipe is packed with flavor and ready in just 15 minutes. Fresh shrimp are sautéed in butter with minced garlic, a pinch of chili flakes for subtle heat, and finished off with a squeeze of fresh lemon juice to brighten the flavors. Serve it over rice, pasta, or with crusty bread to soak up the garlicky sauce. Perfect for weeknights when time is short but you want something satisfying and tasty!', 'images/uploads/687db92f5872e_shrimp.jpg', '2025-10-19 21:50:35'),
(2, 6, 'Grandma’s Apple Pie', 'This classic apple pie recipe has been lovingly passed down through generations in my family. It features crisp, tart apples perfectly balanced with just the right amount of cinnamon and sugar. The buttery, flaky crust is handmade, giving the pie a tender texture that melts in your mouth. Baking this pie fills the kitchen with the warm aroma of autumn spices, making it an ideal dessert for cozy gatherings or holiday celebrations. Tip: Use Granny Smith apples for the best tartness and texture.', 'images/uploads/687e20612e9f3_apple_pie.jpg', '2025-10-19 21:55:35'),
(3, 5, 'My Secret to Fluffy Pancakes', 'Everyone loves fluffy pancakes, but getting them just right can be tricky. My secret is to separate the egg whites and beat them until stiff peaks form before folding them gently into the batter. This technique traps air, making the pancakes light and airy. I also like to add a splash of vanilla extract and a pinch of cinnamon to the batter for extra warmth. Cook on a medium-low heat and resist flipping too early to get a perfectly golden crust. Serve with fresh berries and maple syrup!', 'images/uploads/68c53fg456y34_fluffy_pancakes.jpg', '2025-10-19 22:00:35'),
(4, 6, 'Cooking Tip: Perfect Rice', 'Cooking rice perfectly can be frustrating, but a few simple tricks can make all the difference. Always rinse your rice under cold water until the water runs clear to remove excess starch, which prevents it from becoming gummy. Use a ratio of 1 cup rice to 1.5 cups water for fluffy results. Bring the water to a boil, then cover and simmer on low heat without lifting the lid. Let the rice rest off heat for 10 minutes before fluffing with a fork. This method works great for jasmine, basmati, and long-grain rice varieties.', 'images/uploads/687f22ba86c4b_aung_min.jpg', '2025-10-19 22:05:35'),
(5, 7, 'Learning to Cook with My Grandmother', 'Growing up, I spent countless afternoons in my grandmother’s kitchen, watching her cook with a grace and rhythm that only comes from experience. She never measured ingredients — just a pinch of this, a dash of that — yet everything tasted perfect. Her signature dish was a slow-cooked beef stew that filled the house with warmth and comfort. I learned more than recipes from her — I learned patience, the value of tradition, and how food can bring people together. Now, every time I cook her stew, it feels like she’s there with me, guiding my hands. It’s more than a dish — it’s a memory passed down through flavors.', NULL, '2025-10-19 22:10:35'),
(6, 5, 'Authentic Thai Green Curry\r\n\r\n', 'This authentic Thai green curry recipe combines the vibrant flavors of fresh green chilies, lemongrass, kaffir lime leaves, and Thai basil. Simmered in rich coconut milk and enhanced with tender chicken and crunchy bamboo shoots, this dish strikes the perfect balance between spicy, creamy, and aromatic. Serve it with steamed jasmine rice to soak up the flavorful curry sauce. Whether you\'re a curry enthusiast or trying it for the first time, this dish offers a restaurant-quality experience right at home.', 'images/uploads/6881r56h4u565_authentic_thai_green_curry.png', '2025-10-19 22:15:35'),
(7, 7, 'How to Keep Herbs Fresh Longer', 'Tired of throwing away wilted herbs? Wrap soft herbs like cilantro and parsley in a damp paper towel and store them in a sealed plastic bag in the fridge. For woody herbs like rosemary or thyme, place them in a small jar of water (like flowers) and cover loosely with a plastic bag. This easy trick keeps herbs fresh for over a week and reduces waste in the kitchen.', 'images/uploads/6881g45g6r867_herbs.jpg', '2025-10-19 22:20:35'),
(8, 5, 'Discovering Street Food in Yangon', 'A few months ago, I spent a weekend exploring the bustling street food markets of Yangon. From spicy samosas and mohinga at 7 AM to sweet coconut rice pancakes in the evening, every bite was a discovery. I talked with local vendors, watched them cook on tiny charcoal stoves, and learned how much love and skill goes into every dish. It was a beautiful reminder that some of the best culinary stories aren’t found in fancy restaurants, but on the streets where people pour their culture into every plate.', 'images/uploads/687g45674g6t6_discovering_street_food_in_yangon.png', '2025-10-19 22:25:35'),
(12, 8, 'Burmese Coconut Noodles (Ohn No Khao Swè)', 'A comforting bowl of Burmese-style noodles made with creamy coconut milk, tender chicken, and egg noodles. \r\n   The dish is topped with crispy fried onions, boiled eggs, and fresh lime for the perfect balance of flavor. \r\n   It’s one of Myanmar’s most beloved traditional dishes—rich, aromatic, and slightly spicy.', 'images/uploads/4552drt345trr45_burmese_coconut_noodles.jpg', '2025-10-19 22:40:35');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone_number`, `subject`, `message`, `submitted_at`) VALUES
(1, 'Min Khant Maung', 'minkhant@gmail.com', '+959680034747', 'General Inquiry', 'fsfsfs', '2025-10-20 03:43:56');

-- --------------------------------------------------------

--
-- Table structure for table `cuisines`
--

CREATE TABLE `cuisines` (
  `cuisine_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuisines`
--

INSERT INTO `cuisines` (`cuisine_id`, `name`) VALUES
(1, 'Italian'),
(2, 'Indian '),
(3, 'Korean'),
(4, 'Japanese'),
(5, 'Burmese'),
(6, 'British');

-- --------------------------------------------------------

--
-- Table structure for table `culinary_resources`
--

CREATE TABLE `culinary_resources` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `embed_code` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `culinary_resources`
--

INSERT INTO `culinary_resources` (`id`, `title`, `description`, `type`, `file_name`, `image_path`, `embed_code`, `created_at`) VALUES
(1, 'Italian Pasta Recipe', 'Classic spaghetti carbonara with creamy sauce', 'recipe_card', 'pasta-carbonara.pdf', 'images/recipe-cards/pasta-carbonara.jpg', NULL, '2025-10-21 03:06:45'),
(2, 'Vegetable Stir Fry', 'Quick and healthy vegetable stir fry in 15 minutes', 'recipe_card', 'vegetable-stir-fry.pdf', 'images/recipe-cards/stir-fry.jpg', NULL, '2025-10-21 03:06:45'),
(3, 'Chocolate Chip Cookies', 'Soft and chewy cookies with melty chocolate', 'recipe_card', 'chocolate-cookies.pdf', 'images/recipe-cards/cookies.jpg', NULL, '2025-10-21 03:06:45'),
(4, 'Knife Skills 101', 'Learn proper knife techniques for safer, faster prep', 'instructional_video', '', NULL, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/G-Fg7l7G1zw?si=-tiT8SAZtEe8gpTq\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', '2025-10-21 03:06:45'),
(5, 'Perfect Rice Every Time', 'Master the art of cooking fluffy rice', 'cooking_tutorial', NULL, NULL, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/Xx7sxWI9FNI?si=n4O_eHpe3pozbL0_\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', '2025-10-21 03:06:45'),
(6, '10 Kitchen Hacks', 'Time-saving tricks every home cook should know', 'instructional_video', '', NULL, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/mTdF4Q-OKWg?si=x-JwMj1ZxcykPHd_\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', '2025-10-21 03:06:45'),
(7, 'Meal Prep Like a Pro', 'Weekly meal preparation strategies', 'instructional_video', NULL, NULL, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/AVO0ifle-OU?si=neAd_-3h6ShTdT_1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', '2025-10-21 03:06:45'),
(8, 'Essential Sauces Every Cook Should Know', 'Learn the 5 mother sauces that form the foundation of French cuisine', 'cooking_tutorial', NULL, NULL, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/xniS7kMpW4I?si=-ylCEEDdYUYVn4D6\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', '2025-10-21 03:06:45'),
(9, 'Perfect Roast Chicken Technique', 'Master the art of roasting chicken with crispy skin and juicy meat', 'cooking_tutorial', NULL, NULL, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/mH8uaWnr4FA?si=MtdOhDc-fsHXrM_I\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', '2025-10-21 03:06:45');

-- --------------------------------------------------------

--
-- Table structure for table `dietary_preferences`
--

CREATE TABLE `dietary_preferences` (
  `dietary_id` int(11) NOT NULL,
  `preference` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dietary_preferences`
--

INSERT INTO `dietary_preferences` (`dietary_id`, `preference`) VALUES
(1, 'Non-Vegetarian'),
(2, 'Vegan'),
(3, 'Gluten-Free'),
(4, 'Vegetarian');

-- --------------------------------------------------------

--
-- Table structure for table `difficulties`
--

CREATE TABLE `difficulties` (
  `difficulty_id` int(11) NOT NULL,
  `label` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `difficulties`
--

INSERT INTO `difficulties` (`difficulty_id`, `label`) VALUES
(1, 'Easy'),
(2, 'Medium'),
(3, 'Hard');

-- --------------------------------------------------------

--
-- Table structure for table `educational_resources`
--

CREATE TABLE `educational_resources` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `embed_code` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `educational_resources`
--

INSERT INTO `educational_resources` (`id`, `title`, `description`, `type`, `file_name`, `image_path`, `embed_code`, `created_at`) VALUES
(1, 'Solar-Powered Food Processing Plant', 'food processing facility that utilizes solar panels to generate electricity for various operations, such as powering machinery and refrigeration systems.', 'document', 'solar-powered-food-processing-plant.pdf', 'images/edu-resources/solar-powered-food-processing-plant.jpg', NULL, '2025-10-21 03:07:15'),
(2, 'Healthy food infographic', '', 'infographic', '', 'images/edu-resources/healthy-food-infographic.jpg', NULL, '2025-10-21 03:07:15'),
(3, 'Biogas Production from Food Waste', 'Anaerobic digestion can be used to convert food waste into biogas, a renewable fuel that can be used for heating, electricity generation, or even as a transportation fuel.', 'video', NULL, '', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/alljc5elqqw?si=qUChXMwWhB4jJH04\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', '2025-10-21 03:07:15'),
(4, 'Sustainability in Food Production', 'A video discussing the importance of sustainable food production practices and how renewable energy can play a crucial role in reducing the environmental impact of the food industry.', 'video', NULL, '', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/pk1d7vBBvnE?si=iBklKY6PV9DYQQt4\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', '2025-10-21 03:07:15'),
(5, 'Nutrition Food Pyramid', NULL, 'infographic', NULL, 'images/edu-resources/food-pyramid.jpg', NULL, '2025-10-21 03:07:15');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `event_date` timestamp NULL DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `title`, `description`, `event_date`, `image_url`, `place`) VALUES
(3, 'Sizzling BBQ Night', 'Master grilling techniques with pitmaster John Doe. Perfect for all skill levels.', '2026-07-15 11:30:00', 'images/events/sizzling-bbq-night.jpg', 'The Grill House, 12 Carnaby St, London W1F 9QW'),
(6, 'Plant-Based Cooking 101', 'Learn easy, delicious vegan recipes from Chef Amy Green. No experience needed!', '2026-06-02 03:30:00', 'images/events/plant-based.jpg', 'Online (Live Zoom Class)'),
(7, 'French Pastry Workshop', 'Bake flaky croissants and macarons with Chef Claire Laurent. Hands-on class!', '2026-07-26 04:30:00', 'images/events/french-pastry.jpg', 'Le Petit Four, 45 Baker St, Manchester M1 1FE'),
(8, 'Kids Cooking Camp', 'Fun, safe cooking for ages 6–12! Pizza, kebabs, and more. Parents welcome.', '2026-06-19 03:00:00', 'images/events/kids-cooking.jpg', 'The Culinary Hub, 30 Royal Mile, Edinburgh EH1 1QS'),
(9, 'Sushi Making Masterclass', 'Roll sushi like a pro with Chef Hiro Tanaka. Includes sake tasting!', '2026-07-06 12:30:00', 'images/events/sushi-masterclass.jpg', 'Sakura Kitchen, 8 Covent Garden, London WC2E 8RF'),
(10, 'Holiday Cookie Decorating', 'Decorate festive cookies with icing and sprinkles. All supplies provided!', '2026-07-21 07:30:00', 'images/events/holiday-cookies.jpg', 'The Sugar Studio, 22 King’s Rd, Brighton BN1 1NA');

-- --------------------------------------------------------

--
-- Table structure for table `event_registration`
--

CREATE TABLE `event_registration` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `registration_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_registration`
--

INSERT INTO `event_registration` (`id`, `event_id`, `user_id`, `registration_date`) VALUES
(1, 6, 5, '2025-10-21 07:34:29'),
(2, 6, 6, '2025-10-21 07:40:28'),
(3, 3, 6, '2025-10-21 07:45:15'),
(4, 8, 6, '2025-10-21 07:52:05');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `created_at`) VALUES
(10, 7, 2, '2025-10-20 06:45:50'),
(14, 5, 2, '2025-10-20 06:45:50'),
(28, 6, 4, '2025-10-20 06:45:50'),
(30, 6, 3, '2025-10-20 06:45:50'),
(32, 5, 4, '2025-10-20 06:45:50'),
(33, 7, 4, '2025-10-20 06:45:50'),
(37, 7, 8, '2025-10-20 06:45:50'),
(56, 5, 8, '2025-10-20 06:45:50'),
(57, 5, 12, '2025-10-20 06:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subscribed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletter_subscribers`
--

INSERT INTO `newsletter_subscribers` (`id`, `email`, `subscribed_at`) VALUES
(1, 'minkhant@gmail.com', '2025-10-19 23:46:50'),
(2, 'scott@gmail.com', '2025-10-20 00:50:50'),
(3, 'chris@gmail.com', '2025-10-20 01:15:50'),
(4, 'djidhdh2558@gmail.com', '2025-10-20 01:46:50'),
(5, 'min890704@gmail.com', '2025-10-20 01:54:50');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `ingredients` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `difficulty_id` int(11) DEFAULT NULL,
  `cuisine_id` int(11) DEFAULT NULL,
  `dietary_id` int(11) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_trend` tinyint(1) DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`recipe_id`, `title`, `description`, `ingredients`, `instructions`, `difficulty_id`, `cuisine_id`, `dietary_id`, `is_featured`, `is_trend`, `image_url`, `created_at`) VALUES
(1, 'Spaghetti Carbonara', 'Classic Italian pasta dish with pancetta, eggs, and cheese.', '• 200g spaghetti\n• 2 tbsp olive oil\n• 3 cloves garlic, minced\n• Salt & pepper to taste', 'Cook pasta, sauté pancetta, mix with beaten eggs and cheese, and combine.', 2, 1, 1, 0, 0, 'images/recipes/spaghetti-carbonara.jpg', '2025-10-20 01:45:50'),
(2, 'Vegan Buddha Bowl', 'A healthy mix of quinoa, roasted veggies, and tahini dressing.', '• 1 cup basmati rice\n• 1.5 cups water\n• 1 tsp salt\n• 1 tbsp ghee or oil', 'Cook quinoa, roast vegetables, prepare tahini sauce, and assemble the bowl.', 1, 2, 2, 0, 1, 'images/recipes/buddha-bowl.jpg', '2025-10-20 01:45:50'),
(3, 'Korean Fried Chicken', 'Crispy chicken with sweet-spicy gochujang glaze.', '• 2 chicken breasts\n• 1 tsp paprika\n• 1/2 tsp cumin\n• 1 tbsp olive oil\n• Salt & pepper', 'Fry chicken twice for extra crispiness, coat in gochujang-based sauce.', 3, 3, 1, 1, 0, 'images/recipes/korean-fried-chicken.jpg', '2025-10-20 01:45:50'),
(4, 'Matcha Pancakes', 'Fluffy green pancakes with a hint of matcha flavor.', '• 1 avocado\n• 2 slices of bread\n• 1/2 lemon\n• Pinch of chili flakes\n• Salt to taste', 'Mix pancake batter with matcha, cook on skillet, and top with syrup.', 1, 4, 4, 0, 0, 'images/recipes/matcha-pancakes.jpg', '2025-10-20 01:45:50'),
(5, 'Margherita Pizza', 'Thin-crust pizza with tomato sauce, mozzarella, and basil.', '• 1 banana\n• 1/2 cup rolled oats\n• 1 cup milk (or plant-based)\n• 1 tbsp honey\n• Cinnamon (optional)', 'Prepare dough, spread sauce, add cheese and basil, and bake until golden.', 2, 1, 4, 0, 0, 'images/recipes/margherita.jpg', '2025-10-20 01:45:50'),
(7, 'Bibimbap', 'Korean mixed rice bowl', '2 cups rice\n200g beef\n1 carrot\n1 zucchini\n2 eggs\nGochujang sauce', '1. Cook rice\n2. Prepare toppings separately\n3. Arrange in bowl\n4. Top with egg and sauce', 3, 3, 1, 0, 1, 'images/recipes/bibimbap.jpg', '2025-10-20 01:45:50'),
(8, 'Matcha Cheesecake', 'Japanese green tea dessert', '250g cream cheese\n100g white chocolate\n2 tsp matcha powder\n200ml heavy cream', '1. Melt chocolate\n2. Mix with cheese\n3. Whip cream\n4. Layer and chill overnight', 3, 4, 2, 1, 0, 'images/recipes/matcha-cheesecake.jpg', '2025-10-20 01:45:50'),
(9, 'Caprese Salad', 'Simple Italian appetizer', '2 ripe tomatoes\n200g fresh mozzarella\nFresh basil\nOlive oil\nBalsamic glaze', '1. Slice tomatoes and cheese\n2. Arrange alternately\n3. Add basil leaves\n4. Drizzle with oil and glaze', 1, 1, 4, 0, 0, 'images/recipes/caprese.jpg', '2025-10-20 01:45:50'),
(10, 'Mohinga', 'Myanmar\'s iconic fish noodle soup breakfast', '300g rice noodles\n500g catfish\n2 tbsp fish sauce\n1 stalk lemongrass\n1 tsp turmeric\nHandful of chickpea fritters', '1. Boil fish with lemongrass\n2. Strain broth and shred fish\n3. Add turmeric and fish sauce\n4. Serve over noodles with toppings', 2, 5, 1, 0, 1, 'images/recipes/mohinga.jpg', '2025-10-20 01:45:50'),
(11, 'Lahpet Thoke', 'Fermented tea leaf salad with crunchy textures', '1 cup fermented tea leaves\n2 cups cabbage\n1/2 cup toasted peanuts\n1/2 cup fried garlic\n2 tbsp sesame seeds\n1 lime', '1. Rinse tea leaves\n2. Mix all dry ingredients\n3. Add lime juice and oil\n4. Toss just before serving', 1, 5, 4, 0, 0, 'images/recipes/lahpet-thoke.jpg', '2025-10-20 01:45:50'),
(12, 'Fish & Chips', 'Classic UK pub food with crispy batter', '4 cod fillets\n200g flour\n300ml beer\n1kg potatoes\nMalt vinegar for serving', '1. Cut potatoes into chips\n2. Make beer batter\n3. Fry fish at 190°C\n4. Fry chips twice for crispness', 2, 6, 1, 0, 0, 'images/recipes/fish-and-chips.jpg', '2025-10-20 01:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `created_at`) VALUES
(5, 'Min', 'Khant', 'minkhant@gmail.com', '$2y$10$GlTiZ4UqmlcNt9eQq8u7HeGGhW1E7q3M3chCv4gvs6PG3SABL7N8u', '2025-10-19 18:45:01'),
(6, 'Chris', 'Brown', 'chris@gmail.com', '$2y$10$//LPXznRvhWuc61RgjxwLeM3ZM3wA1LE5FsmbNb4URtapfFw6SYw.', '2025-10-19 18:50:01'),
(7, 'Scott', 'Scott', 'scott@gmail.com', '$2y$10$8Ol.srUOhKR.e7rQyFiNBu7XML4N6fm4usd/PJmGfPABu7cnthlzi', '2025-10-19 18:56:01'),
(8, 'nick', 'nick', 'nick@gmail.com', '$2y$10$GeBKTGhLlA1YrVfrfMUVeuVB7sOa25lisRE1ky6tBFB22vgMggWzm', '2025-10-19 19:50:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`) USING BTREE;

--
-- Indexes for table `community_posts`
--
ALTER TABLE `community_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cuisines`
--
ALTER TABLE `cuisines`
  ADD PRIMARY KEY (`cuisine_id`);

--
-- Indexes for table `culinary_resources`
--
ALTER TABLE `culinary_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dietary_preferences`
--
ALTER TABLE `dietary_preferences`
  ADD PRIMARY KEY (`dietary_id`);

--
-- Indexes for table `difficulties`
--
ALTER TABLE `difficulties`
  ADD PRIMARY KEY (`difficulty_id`);

--
-- Indexes for table `educational_resources`
--
ALTER TABLE `educational_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_registration`
--
ALTER TABLE `event_registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_registration` (`event_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`) USING BTREE;

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `difficulty_id` (`difficulty_id`),
  ADD KEY `cuisine_id` (`cuisine_id`),
  ADD KEY `dietary_id` (`dietary_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `community_posts`
--
ALTER TABLE `community_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cuisines`
--
ALTER TABLE `cuisines`
  MODIFY `cuisine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `culinary_resources`
--
ALTER TABLE `culinary_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `dietary_preferences`
--
ALTER TABLE `dietary_preferences`
  MODIFY `dietary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `difficulties`
--
ALTER TABLE `difficulties`
  MODIFY `difficulty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `educational_resources`
--
ALTER TABLE `educational_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_registration`
--
ALTER TABLE `event_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `community_posts` (`id`);

--
-- Constraints for table `community_posts`
--
ALTER TABLE `community_posts`
  ADD CONSTRAINT `community_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `event_registration`
--
ALTER TABLE `event_registration`
  ADD CONSTRAINT `event_registration_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_registration_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `community_posts` (`id`);

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`difficulty_id`) REFERENCES `difficulties` (`difficulty_id`),
  ADD CONSTRAINT `recipes_ibfk_2` FOREIGN KEY (`cuisine_id`) REFERENCES `cuisines` (`cuisine_id`),
  ADD CONSTRAINT `recipes_ibfk_3` FOREIGN KEY (`dietary_id`) REFERENCES `dietary_preferences` (`dietary_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
