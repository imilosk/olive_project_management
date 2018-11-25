-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 23, 2018 at 12:53 AM
-- Server version: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `olive`
--
CREATE DATABASE IF NOT EXISTS `olive` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `olive`;

-- --------------------------------------------------------

CREATE TABLE `organisations` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `idOrganisation` int(10) UNSIGNED NOT NULL,
   FOREIGN KEY (`idOrganisation`) REFERENCES `organisations`(`id`),
  `email` varchar(244) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `verified` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `resettable` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `roles_mask` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `registered` int(10) UNSIGNED NOT NULL,
  `last_login` int(10) UNSIGNED DEFAULT NULL,
  `force_logout` mediumint(7) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idOrganisation` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idOrganisation`) REFERENCES `organisations`(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `userprojects` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idUser` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idUser`) REFERENCES `users`(`id`),
  `idProject` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idProject`) REFERENCES `projects`(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idProject` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idProject`) REFERENCES `projects`(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `PSPS` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tasksusersprojects` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idUser` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idUser`) REFERENCES `users`(`id`),
  `idTask` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idTask`) REFERENCES `tasks`(`id`),
  `idPSP` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idPSP`) REFERENCES `PSPS`(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `phases` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `PSPtasks` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idPhase` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idPhase`) REFERENCES `phases`(`id`),
  `idPSP` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idPSP`) REFERENCES `PSPS`(`id`),
  `startdate` date NOT NULL,
  `finishdate` date NOT NULL,
  `starttime` time NOT NULL,
  `finishtime` time NOT NULL,
  `prekinitev` int(10) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `units` int(10) UNSIGNED NOT NULL,
  `estimatedtime` int(10) UNSIGNED NOT NULL,
  `estimatedunits` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `errors` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idCategory` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idCategory`) REFERENCES `categories`(`id`),
  `phaseEntry` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`phaseEntry`) REFERENCES `phases`(`id`),
  `phaseFinish` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`phaseFinish`) REFERENCES `phases`(`id`),
  `idPSP` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idPSP`) REFERENCES `PSPS`(`id`),
  `finishtime` time NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `idOrganisation`, `email`, `password`, `username`, `status`, `verified`, `resettable`, `roles_mask`, `registered`, `last_login`, `force_logout`) VALUES
(6, null, 'milos.kostadinovski97@gmail.com', '$2y$10$fnLI8ea/Wbg7Mg9BiGW2IuRjjNMz4uJH1BwyqkdkG8I3a6AI45E4C', 'milosko', 0, 1, 1, 0, 1542896581, 1542897735, 3),
(7, null, 'mihc124@gmail.com', '$2y$10$aE64rzn4kwth8ozh19wOieCMmiM/w4CKwChNuJssD/n2r2XMFuksW', 'milton124', 0, 1, 1, 0, 1542898998, 1542899110, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_confirmations`
--

CREATE TABLE `users_confirmations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selector` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_confirmations`
--

INSERT INTO `users_confirmations` (`id`, `user_id`, `email`, `selector`, `token`, `expires`) VALUES
(1, 1, 'milos.kostadinovski97@gmail.com', 'H-Tt0XSjAIjGQN9e', '$2y$10$acEK9JktYQXnreOYTwDgze6cm4Zyhr56Sz2ChvIfvMw51.2DqaaPq', 1542979430),
(2, 2, 'mk1991@student.uni-lj.si', '7MDphSdpphFP9Fkm', '$2y$10$mrW0NfsHl6.1OrLsQ2xDheDKe5uQOFpYdGW1T6jcC5uEgo8kXpr9e', 1542980399),
(3, 3, 'milos.kostadinovski97@gmail.com', 'EhzItumyf0achh3S', '$2y$10$DbuZTfmnm2Ulc4GVtaLD/uKzhifo78kj35om6M6EeEjtVqep4MpXO', 1542980984),
(4, 4, 'milos.kostadinovski97@gmail.com', 'Uzl9TEfXpksghDWy', '$2y$10$OjQW.jfLaBcLj8/p8uhnluAnsVmvRG7xRuiy6wEc6Zf96AmqJOR3O', 1542981556),
(5, 5, 'milos.kostadinovski97@gmail.com', 'bkN3Ceg2ExDc9AUF', '$2y$10$6bHGLN6JBKMmbBBYzoO1juhmmOeWLiqZfJvnPN2VcGG9kpm8DSHIe', 1542981773);

-- --------------------------------------------------------

--
-- Table structure for table `users_remembered`
--

CREATE TABLE `users_remembered` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_resets`
--

CREATE TABLE `users_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `selector` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_throttling`
--

CREATE TABLE `users_throttling` (
  `bucket` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `tokens` float UNSIGNED NOT NULL,
  `replenished_at` int(10) UNSIGNED NOT NULL,
  `expires_at` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_throttling`
--

INSERT INTO `users_throttling` (`bucket`, `tokens`, `replenished_at`, `expires_at`) VALUES
('hNaWWBEVaqkgKxP5d1y7w961eYZsZx1mqj83GKp44LI', 34.3074, 1542897735, 1543437735),
('So76zVeqLV3-uvj9fL-KjhATBHBJo58pg2LDFe_voNc', 0.0542331, 1542895373, 1543327373),
('tVFJU9j9YF_vG_q7SyWShyfr8C4EE0znlK2THahyeEk', 73.0083, 1542896610, 1543436610),
('tSfsS5U9-5Qu-sHbCDRIIJp8kjis-8gMt0zotu5L9fY', 4, 1542896581, 1543328581),
('TQ6sUjnchAJ74LYpPfEJUbZPVF22hB4yqOfZIEnYuBk', 73.0311, 1542899110, 1543439110),
('BRMhqEO7yZI9QuogKCmZWRb2iDItfXH1EVKKA0TAf44', 4, 1542898998, 1543330998);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users_confirmations`
--
ALTER TABLE `users_confirmations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `email_expires` (`email`,`expires`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users_remembered`
--
ALTER TABLE `users_remembered`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `users_resets`
--
ALTER TABLE `users_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `user_expires` (`user`,`expires`);

--
-- Indexes for table `users_throttling`
--
ALTER TABLE `users_throttling`
  ADD PRIMARY KEY (`bucket`),
  ADD KEY `expires_at` (`expires_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users_confirmations`
--
ALTER TABLE `users_confirmations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users_remembered`
--
ALTER TABLE `users_remembered`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_resets`
--
ALTER TABLE `users_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;