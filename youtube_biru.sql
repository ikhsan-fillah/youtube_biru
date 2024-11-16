-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 16, 2024 at 09:52 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `youtube_biru`
--

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `subscribed_to` int NOT NULL,
  `subscribed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `subscribers` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `subscribers`) VALUES
(1, 'ikzy', 'ikhsanfillah10@gmail.com', '$2y$10$SlcCn76o7CSTRpXZnzx97uqa2ngjUZNWW1DOJMVY2tgqGFbaEa0ia', 0),
(2, 'admin21', 'adminikzy10@gmail.com', '$2y$10$MDuvTHjHVkvFg.F7OZYHK.lIrmq73QVgyty.77sIqbZtNlmyOFi6S', 2),
(6, 'ikzyyy21', 'ichsanfilahhidayat@gmail.com', '$2y$10$M.gVgQY8SbKnbUEpKnpJt.WE4MIyItA91uRj.O8mwfU9D5TkgaZde', 0),
(7, '23127581646', 'ichsanfilahhisdayat@gmail.com', '$2y$10$H5iUJ7VnYlRmMPNa9MrkoOvXbrJvt1gde6xKhaHHpDgI3Unjs/Ybu', 0),
(8, 'ikzy2201', 'ikhsanfillahhidayat@gmail.com', '$2y$10$XW0D8zoXuKK3qcMYB7WJHO2hybcI58.NMfO8TOND1U0sWUN5mktBq', 1),
(9, 'gtgni', 'ikzy@gmail.com', '$2y$10$3bh2cZG5Z3p3U2ZnImZJU.bDSBMGOIapWxzanZc0ItJ1lxbk7fJKC', 1),
(12, 'ian', 'iankocak@gmail.com', '$2y$10$z4ABDCoSg/GsECikjMF5bO/YEVfPoAu02yahsx1SXQmD3P5lH3qeK', 0),
(13, 'ikhsan123', 'ichsanfh@gmail.com', '$2y$10$qAKTkkr8.RkbA8I72IbtUew5FXnGsK/qo8P1llK0uH7y/7L4QOdb.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `video_id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `video_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `thumbnail_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `duration` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `views` int DEFAULT '0',
  `likes` int DEFAULT '0',
  `dislikes` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`video_id`, `user_id`, `title`, `description`, `video_path`, `thumbnail_path`, `duration`, `views`, `likes`, `dislikes`, `created_at`, `updated_at`, `upload_date`) VALUES
(4, 8, 'udil dan celiboy to evos', 'rill cuy', '6728e42337d58.mp4', 'th (1).jpg', NULL, 20, 1, 0, '2024-11-04 15:11:31', '2024-11-05 17:14:08', '2024-11-05 17:14:08'),
(5, 9, 'kucing lucu', 'mememeeeeeee desktop wallpaper', '672a404569729.mp4', '672a404579545.jpg', NULL, 49, 1, 0, '2024-11-05 15:56:53', '2024-11-06 10:20:49', '2024-11-06 10:20:49'),
(6, 12, 'kocak', 'woiiii', '672b4385408ff.mp4', '672b4385442b7.jpg', NULL, 2, 1, 0, '2024-11-06 10:23:01', '2024-11-06 10:23:18', '2024-11-06 10:23:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`subscribed_to`),
  ADD KEY `subscribed_to` (`subscribed_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`video_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `video_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `subscriptions_ibfk_2` FOREIGN KEY (`subscribed_to`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
