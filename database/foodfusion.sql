-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2026 at 11:10 AM
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
-- Database: `foodfusion`
--

-- --------------------------------------------------------

--
-- Table structure for table `community_cookbook`
--

CREATE TABLE `community_cookbook` (
  `submission_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipe_title` varchar(150) DEFAULT NULL,
  `recipe_content` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `totalLike` int(11) DEFAULT 0,
  `totalComment` int(11) DEFAULT 0,
  `cuisine_type` varchar(50) DEFAULT NULL,
  `difficulty` enum('Easy','Medium','Hard') DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_cookbook`
--

INSERT INTO `community_cookbook` (`submission_id`, `user_id`, `recipe_title`, `recipe_content`, `image_url`, `totalLike`, `totalComment`, `cuisine_type`, `difficulty`, `submitted_at`) VALUES
(10, 1, 'Testing', 'Descriptive text is a genre of writing that vividly portrays a specific person, place, animal, or object to create a detailed image in the reader\'s mind. It utilizes sensory details, adjectives, and simple present tense to describe features, forms, and characteristics. The structure typically includes identification followed by detailed description. \r\nMedium\r\nMedium\r\n +2\r\nKey Aspects of Descriptive Text:\r\nPurpose: To inform or entertain by describing a particular subject in detail, rather than a general, broad category.\r\nStructure:\r\nIdentification: Introduces the subject to be described (e.g., a specific, unique subject like \"my pet cat\" or \"Borobudur Temple\").\r\nDescription: Details the characteristics, features, parts, or qualities of the subject.\r\nLanguage Features:\r\nSpecific Participants: Focuses on one, unique subject.\r\nAdjectives: Used to clarify and qualify nouns (e.g., beautiful, small, quick).\r\nSimple Present Tense: Used to state facts about the subject.\r\nSensory Details: Appeals to sight, sound, smell, taste, and touch to create vivid imagery.\r\nCommon Techniques: Uses, similes, metaphors, and sensory language to make descriptions more engaging. \r\nMedium\r\nMedium\r\n +5\r\nExample Subjects:\r\nPlaces: Describing the atmosphere, sights, and sounds of a beach.\r\nPeople/Objects: Detailing the appearance and personality of a friend, or the features of a specific item. \r\nScribd\r\nScribd\r\n +1', '1773215248.jpg', 2, 1, NULL, NULL, '2026-03-11 07:47:28'),
(12, 1, 'Testing', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '1773654056.jpg', 2, 2, 'Myanmar', 'Hard', '2026-03-16 09:40:56'),
(13, 4, 'Testing', 'Testing', '1773656921.jpg', 1, 0, 'Chinese', 'Hard', '2026-03-16 10:28:41'),
(14, 6, 'Traditional Mohinga', 'Ingredients:\r\n- Rice noodles\r\n- Catfish\r\n- Lemongrass, Ginger, Garlic\r\n- Banana stem', '1773676287.png', 0, 0, 'Myanmar', 'Hard', '2026-03-16 15:51:27');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`message_id`, `name`, `email`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'testing', 'testing@gmail.com', 'testing', 'testing', 'read', '2026-03-04 09:08:15');

-- --------------------------------------------------------

--
-- Table structure for table `cookbook_comments`
--

CREATE TABLE `cookbook_comments` (
  `comment_id` int(11) NOT NULL,
  `submission_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cookbook_comments`
--

INSERT INTO `cookbook_comments` (`comment_id`, `submission_id`, `user_id`, `comment`, `created_at`) VALUES
(4, 12, 1, 'Hi/Hello', '2026-03-16 09:54:51'),
(6, 10, 4, 'hi', '2026-03-16 10:27:41'),
(7, 12, 6, 'Hi/Hello', '2026-03-16 15:45:06');

-- --------------------------------------------------------

--
-- Table structure for table `cookbook_likes`
--

CREATE TABLE `cookbook_likes` (
  `like_id` int(11) NOT NULL,
  `submission_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cookbook_likes`
--

INSERT INTO `cookbook_likes` (`like_id`, `submission_id`, `user_id`, `created_at`) VALUES
(4, 10, 6, '2026-03-16 08:22:03'),
(7, 12, 1, '2026-03-16 09:54:38'),
(9, 12, 4, '2026-03-16 10:27:21'),
(10, 10, 4, '2026-03-16 10:27:31'),
(12, 13, 6, '2026-03-16 15:45:31');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `cuisine_type` varchar(50) DEFAULT NULL,
  `dietary_preference` varchar(50) DEFAULT NULL,
  `difficulty` enum('Easy','Medium','Hard') DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`recipe_id`, `title`, `description`, `cuisine_type`, `dietary_preference`, `difficulty`, `image_url`, `created_at`, `user_id`) VALUES
(2, 'နန်းကြီးသုပ်', 'နန်းကြီးသုပ်', 'Myanmar', 'Non-Vegetarian', 'Hard', 'uploads/1772616849_download.jpg', '2026-03-04 09:34:09', 1),
(3, 'Pizza', 'PizzaPizza', 'UK', 'Non-Vegetarian', 'Medium', 'uploads/recipes/1772699510_download (1).jpg', '2026-03-05 08:31:50', NULL),
(4, 'Dog', '1.Eat\r\n2.Sleep\r\n3.Eat\r\n4.Sleep\r\n5.Eat\r\n6.Sleep', 'Myanmar', 'Non-Veg', 'Easy', 'uploads/1772699890_dog.jpg', '2026-03-05 08:38:10', 4),
(5, 'Testing', 'Testing\r\nTesting\r\nTesting\r\nTesting', 'Testing', 'Non-Vegetarian', 'Easy', 'uploads/recipes/1772787513_images (3).jpg', '2026-03-06 08:58:33', NULL),
(6, 'Testing11', 'Testing1122222', 'Testing11', 'Non-Vegetarian', 'Easy', 'uploads/recipes/1772787697_vision1.jpg', '2026-03-06 09:01:37', 2);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subscribed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `subscribed_at`) VALUES
(1, 'zero@gmail.com', '2026-03-05 09:23:36'),
(2, 'testing@gmail.com', '2026-03-05 09:44:37'),
(3, 'phyozawhein2000@gmail.com', '2026-03-16 04:17:58'),
(5, 'phyozawhein200@gmail.com', '2026-03-16 04:18:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `failed_attempts` int(11) DEFAULT 0,
  `lockout_until` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `failed_attempts`, `lockout_until`, `created_at`) VALUES
(1, 'phyo', 'phyo', 'phyo@gmail.com', '$2y$10$THuqmKbO58iBNM0TZDRcH.E5b8FkrNbz.FGFjOKy.pC9x.z9cm/4S', 'user', 0, NULL, '2026-03-04 04:56:57'),
(2, 'admin', 'admin', 'admin@gmail.com', '$2y$10$FPobCpyyYNq42MXpCZBvgeluPenJ9Ad1ZFQkUWQ41AqL53NNgRdDW', 'admin', 0, NULL, '2026-03-04 06:05:58'),
(4, 'su', 'su', 'su@gmail.com', '$2y$10$pvTGLQgGMMZvIgtPYf.YbOsbO.tNTU7nnRTFdJLMMRtgbG9bLi0pG', 'user', 0, NULL, '2026-03-05 08:36:04'),
(5, 'te', 'sting', 'testing@gmail.com', '$2y$10$tpRO0QYa6Wb0Je72b/m5mu05SZ0KtyMJTxhBAmWjNKGZ3lAnSlWgm', 'user', 0, NULL, '2026-03-11 06:25:09'),
(6, 'mg', 'KyawKyaw', 'mg@gmail.com', '$2y$10$/WMEzOWEeyj8SiCfHeNvZe6qNDrmXP6e1QU7oizcEwFGmToatuLsi', 'user', 0, NULL, '2026-03-11 08:37:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `community_cookbook`
--
ALTER TABLE `community_cookbook`
  ADD PRIMARY KEY (`submission_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `cookbook_comments`
--
ALTER TABLE `cookbook_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `submission_id` (`submission_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cookbook_likes`
--
ALTER TABLE `cookbook_likes`
  ADD PRIMARY KEY (`like_id`),
  ADD UNIQUE KEY `unique_like` (`submission_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `community_cookbook`
--
ALTER TABLE `community_cookbook`
  MODIFY `submission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cookbook_comments`
--
ALTER TABLE `cookbook_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cookbook_likes`
--
ALTER TABLE `cookbook_likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `community_cookbook`
--
ALTER TABLE `community_cookbook`
  ADD CONSTRAINT `community_cookbook_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cookbook_comments`
--
ALTER TABLE `cookbook_comments`
  ADD CONSTRAINT `cookbook_comments_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `community_cookbook` (`submission_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cookbook_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cookbook_likes`
--
ALTER TABLE `cookbook_likes`
  ADD CONSTRAINT `cookbook_likes_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `community_cookbook` (`submission_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cookbook_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
