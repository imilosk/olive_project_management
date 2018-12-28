-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Gostitelj: localhost
-- Čas nastanka: 28. dec 2018 ob 17.58
-- Različica strežnika: 5.7.24-0ubuntu0.16.04.1
-- Različica PHP: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `olive`
--
CREATE DATABASE IF NOT EXISTS `olive` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `olive`;

-- --------------------------------------------------------

--
-- Struktura tabele `organisations`
--

CREATE TABLE `organisations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIJE ZA TABELO `organisations`:
--

--
-- Odloži podatke za tabelo `organisations`
--

INSERT INTO `organisations` (`id`, `name`, `description`) VALUES
(1, 'Olive developers', 'This is the olive developers organisation description'),
(2, 'Test org', 'This is a test description'),
(5, 'Mobilen test', 'Danes je 25'),
(6, 'Albania', 'adasdsad'),
(7, 'PicaB', 'Pica bureeek');

-- --------------------------------------------------------

--
-- Struktura tabele `organisationsusers`
--

CREATE TABLE `organisationsusers` (
  `idOrganisation` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIJE ZA TABELO `organisationsusers`:
--   `idOrganisation`
--       `organisations` -> `id`
--   `idUser`
--       `users` -> `id`
--

--
-- Odloži podatke za tabelo `organisationsusers`
--

INSERT INTO `organisationsusers` (`idOrganisation`, `idUser`) VALUES
(1, 3),
(1, 7),
(2, 3),
(5, 6),
(6, 3),
(7, 6);

-- --------------------------------------------------------

--
-- Struktura tabele `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `idOrganisation` int(10) UNSIGNED NOT NULL,
  `idLeader` int(11) NOT NULL,
  `name` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIJE ZA TABELO `projects`:
--   `idLeader`
--       `users` -> `id`
--   `idOrganisation`
--       `organisations` -> `id`
--

--
-- Odloži podatke za tabelo `projects`
--

INSERT INTO `projects` (`id`, `idOrganisation`, `idLeader`, `name`, `description`) VALUES
(2, 2, 0, 'Test ', 'Testi projekt za katalon'),
(3, 2, 0, 'Test proje', 'Testi projekt za katalon'),
(11, 2, 0, 'Katalon', 'Katalon test project'),
(12, 1, 0, 'Faks', '#naredimoFaks');

-- --------------------------------------------------------

--
-- Struktura tabele `psps`
--

CREATE TABLE `psps` (
  `id` int(10) UNSIGNED NOT NULL,
  `programing_language` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIJE ZA TABELO `psps`:
--

-- --------------------------------------------------------

--
-- Struktura tabele `psp_errors`
--

CREATE TABLE `psp_errors` (
  `id` int(10) UNSIGNED NOT NULL,
  `idCategory` int(10) UNSIGNED NOT NULL,
  `phaseEntry` int(10) UNSIGNED NOT NULL,
  `phaseFinish` int(10) UNSIGNED NOT NULL,
  `idPSP` int(10) UNSIGNED NOT NULL,
  `resolve_time` int(11) NOT NULL,
  `num_fixed_errors` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIJE ZA TABELO `psp_errors`:
--   `idCategory`
--       `psp_errors_categories` -> `id`
--   `phaseEntry`
--       `psp_phases` -> `id`
--   `phaseFinish`
--       `psp_phases` -> `id`
--   `idPSP`
--       `psps` -> `id`
--

-- --------------------------------------------------------

--
-- Struktura tabele `psp_errors_categories`
--

CREATE TABLE `psp_errors_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIJE ZA TABELO `psp_errors_categories`:
--

--
-- Odloži podatke za tabelo `psp_errors_categories`
--

INSERT INTO `psp_errors_categories` (`id`, `name`) VALUES
(2, 'Documentation'),
(3, 'Syntax'),
(4, 'Construction'),
(5, 'Arranging'),
(6, 'Interface'),
(7, 'Checking'),
(8, 'Data'),
(9, 'Functions'),
(10, 'System'),
(11, 'Environment');

-- --------------------------------------------------------

--
-- Struktura tabele `psp_phases`
--

CREATE TABLE `psp_phases` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIJE ZA TABELO `psp_phases`:
--

--
-- Odloži podatke za tabelo `psp_phases`
--

INSERT INTO `psp_phases` (`id`, `name`) VALUES
(1, 'Planing'),
(2, 'Infrastructuring'),
(3, 'Coding'),
(4, 'Code review'),
(5, 'Compiling'),
(6, 'Testing'),
(7, 'Analysis');

-- --------------------------------------------------------

--
-- Struktura tabele `psp_tasks`
--

CREATE TABLE `psp_tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `idPhase` int(10) UNSIGNED NOT NULL,
  `idPSP` int(10) UNSIGNED NOT NULL,
  `start` timestamp NULL DEFAULT NULL,
  `end` timestamp NULL DEFAULT NULL,
  `pause` int(10) UNSIGNED NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `units` int(10) UNSIGNED NOT NULL,
  `estimatedtime` int(10) UNSIGNED NOT NULL,
  `estimatedunits` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIJE ZA TABELO `psp_tasks`:
--   `idPhase`
--       `psp_phases` -> `id`
--   `idPSP`
--       `psps` -> `id`
--

-- --------------------------------------------------------

--
-- Struktura tabele `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `idProject` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIJE ZA TABELO `tasks`:
--   `idProject`
--       `projects` -> `id`
--

-- --------------------------------------------------------

--
-- Struktura tabele `tasksusersprojects`
--

CREATE TABLE `tasksusersprojects` (
  `idUser` int(10) UNSIGNED NOT NULL,
  `idTask` int(10) UNSIGNED NOT NULL,
  `idPSP` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIJE ZA TABELO `tasksusersprojects`:
--   `idPSP`
--       `psps` -> `id`
--   `idTask`
--       `tasks` -> `id`
--   `idUser`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Struktura tabele `userprojects`
--

CREATE TABLE `userprojects` (
  `idProject` int(10) UNSIGNED NOT NULL,
  `idUser` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIJE ZA TABELO `userprojects`:
--   `idProject`
--       `projects` -> `id`
--   `idUser`
--       `users` -> `id`
--

--
-- Odloži podatke za tabelo `userprojects`
--

INSERT INTO `userprojects` (`idProject`, `idUser`) VALUES
(2, 3),
(2, 4),
(11, 3),
(12, 3);

-- --------------------------------------------------------

--
-- Struktura tabele `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `verified` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `resettable` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `roles_mask` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `registered` int(10) UNSIGNED NOT NULL,
  `last_login` int(10) UNSIGNED DEFAULT NULL,
  `force_logout` mediumint(7) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIJE ZA TABELO `users`:
--

--
-- Odloži podatke za tabelo `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`, `status`, `verified`, `resettable`, `roles_mask`, `registered`, `last_login`, `force_logout`) VALUES
(3, 'milos.kostadinovski97@gmail.com', '$2y$10$oRIyHRU70d0uEwt8opVUkuDqPDNPO989oQdvZFlSZDy40xu7EAWuS', NULL, 0, 1, 1, 0, 1543679404, 1545823279, 38),
(4, 'test@test.si', '$2y$10$9upbq0vAnoZ6lpiJ/4QCOOQgSV6OCyqUL0bErgRnBRQJ7bR3iJiie', NULL, 0, 1, 1, 0, 1544460326, 1546005740, 2),
(5, 'test123@test.si', '$2y$10$ZBCUaBGTWBHgWgdQ7TliKuKIHDaPoBFlKyinlbet4jySwAZhh60p.', NULL, 0, 1, 1, 0, 1544635196, 1545823288, 13),
(6, 'blaz@test.si', '$2y$10$xbaYJSfXnuiu8LMNGa7ADe7lLrY1n9UGGStUoSF3APtEgabkbgDFW', NULL, 0, 1, 1, 0, 1544721905, 1545832181, 4),
(7, 'test1@gmail.com', '$2y$10$ntUMiByO3v5DfPjoi4Mp/.waIUr6Y.TENZJsBo6FZYZ2cflNn5rZa', NULL, 0, 1, 1, 0, 1544988424, 1545489068, 0),
(8, 'mihad@hotmail.com', '$2y$10$EIIvIJJ3/9diBRO4Gy2lWOiHFwbEvktIRHJnR2i6TKlpjZHuAHJT.', NULL, 0, 1, 1, 0, 1545062843, NULL, 0);

-- --------------------------------------------------------

--
-- Struktura tabele `users_confirmations`
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
-- RELACIJE ZA TABELO `users_confirmations`:
--

-- --------------------------------------------------------

--
-- Struktura tabele `users_remembered`
--

CREATE TABLE `users_remembered` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIJE ZA TABELO `users_remembered`:
--

-- --------------------------------------------------------

--
-- Struktura tabele `users_resets`
--

CREATE TABLE `users_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `selector` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIJE ZA TABELO `users_resets`:
--

-- --------------------------------------------------------

--
-- Struktura tabele `users_throttling`
--

CREATE TABLE `users_throttling` (
  `bucket` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `tokens` float UNSIGNED NOT NULL,
  `replenished_at` int(10) UNSIGNED NOT NULL,
  `expires_at` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIJE ZA TABELO `users_throttling`:
--

--
-- Odloži podatke za tabelo `users_throttling`
--

INSERT INTO `users_throttling` (`bucket`, `tokens`, `replenished_at`, `expires_at`) VALUES
('hNaWWBEVaqkgKxP5d1y7w961eYZsZx1mqj83GKp44LI', 73.0108, 1545823278, 1546363278),
('So76zVeqLV3-uvj9fL-KjhATBHBJo58pg2LDFe_voNc', 2.02139, 1543679404, 1544111404),
('xk_0P82Dv6TydZzq0_8BpF69U3ixeWrdOfuZeR91xLE', 73.0075, 1543683909, 1544223909),
('5jq3AH19WlBEFyhOTeZP3LbPx95GoJ8-QpAxJJAnewc', 47.7874, 1544461287, 1545001287),
('8qFHGFuZ3H-aldgtg_mtXLJh2TTLVhlhEqc9szv_DFk', 74, 1543856106, 1544396106),
('PCzUm55pdDAqjYYPz3AWLJQy262Q_Zl3_9OzjJhKV-k', 73.0325, 1545062843, 1545602843),
('H-PH7FwamVmjbxFIcmyz63Zrujg5w5IZJp7pRhu7BCU', 4, 1545062843, 1545494843),
('U4ys0_piHGd3En-OGMiOHkshHfXdTXgRbUNa9SmOcpo', 19, 1544460553, 1544496553),
('c-8J-zRTdUcdxOAHX8kD0KM0OyMiY0MsM4AZ1aWV0Fc', 499, 1544460553, 1544633353),
('E4nXgfd4s6uCMiY9fxcTLwx3PkHNZHH4oItpeIeam8E', 49.6426, 1544659108, 1545199108),
('fDGrEUHZRKBb7Xv3j43hJzwTzegVp4R50yUYFpJgdAc', 4, 1544635196, 1545067196),
('LTkql0BA6xIuv434gtEVdWYWFsHTnbW_bFN4b9cLTmI', 19, 1544639024, 1544675024),
('Cf9XPA77LXVS-DfQ8TYjEoWWwxG219B7rL7ul0WMmZQ', 499, 1545652183, 1545824983),
('x_J_qARWB7QH7q644fxvjAAVTIBYMnZ6L9Yco7kXNXg', 73.0011, 1544658727, 1545198727),
('ja8JzGOqkv1n-3_kUthi6hRecvNLqk7sICMsqawZH5Q', 72.0159, 1544721919, 1545261919),
('_wceZPqA5nuvuxNFUegEfQ-USS36nJ-g6BGHIZDhx2o', 19, 1544721863, 1544757863),
('9FxMHNh5YM-utgy9ra4k7t1rGaCpNEq2jkiWb5ckgX4', 499, 1544721863, 1544894663),
('msgb-JKS0Kn_cbX_c7fmikSPUmNfI79WaR8XzoP913A', 4, 1544721905, 1545153905),
('yPBSh_s7OQ2IzQcBrlnNbFkQy_6b0vQ76z6oLZHzAQo', 74, 1544727686, 1545267686),
('FpCk6bEgI6YAfTXmVlgQM0ftgGFjoRLg-buFNzE2QtE', 19, 1544727686, 1544763686),
('2Cdy6f0wyijhl6dkDptQ9gP0B4dii7K9cvUnn-geZmE', 499, 1545727224, 1545900024),
('3n7tZpNvVRLOeU6wTrPEnfsZ4WJQd11PqhDToPSeJDw', 74, 1545823288, 1546363288),
('PDwrMpioKyjD84TwbMWjnhWqrRSKeaWQcubdWZHNcSk', 74, 1544978594, 1545518594),
('c1ZvIgBSw4l9zOmg_Rl2ONcnIA7eR6lpoegHLZ2ffIQ', 73.0119, 1545832181, 1546372181),
('LUK3m6pAIqX5wHErCd5Innv6RufQ2PpZcYSdZWt7XdA', 19, 1544981266, 1545017266),
('TQ6sUjnchAJ74LYpPfEJUbZPVF22hB4yqOfZIEnYuBk', 74, 1545673468, 1546213468),
('_tAWvxsp3y2qlWL3tl-OND8XHXbARBCOv4U1BxU-zQM', 73.0039, 1544985819, 1545525819),
('vS_jRi8hTqkIhlTVUB-2z4mIkuZZNxUF2q1HdRmIrtU', 73.0017, 1544988430, 1545528430),
('G6V0SDiefWJICYARrqPdcUzyNX_ubnCAxIEHCbleISc', 4, 1544988424, 1545420424),
('qGclkiH2l4Xi5_UsN_fXKykAH7-WwR3OYPCoRZL9V8M', 74, 1545044306, 1545584306),
('FX3R0l0ctxw5eeiSOqUZw9WckzxgeMA3IrzMwcSKOiE', 74, 1545059655, 1545599655),
('yrabbxw-AdRgf1J-CvUt6X1EAHPAC5NIUorW0Bhfd1w', 74, 1545063920, 1545603920),
('0DR9r5_hDItG4xBwVj-OfzL7hGzbxs3xlybeM5bOC6M', 74, 1545145436, 1545685436),
('krIuNjuUXivvIFOhbuGSdeYcFBkRz67fgGeNRsWiSWU', 73.0053, 1545251523, 1545791523),
('WBBLpWL2b4dV6wwGbSURhKBQdaec6oh_KX-RLmKveMo', 19, 1545251523, 1545287523),
('G5iEhyvdf1jvRVzbHB6w7DoPKi63Jd7Q-PuTfgKW5LM', 73.0047, 1545489067, 1546029067),
('P2qFuo9HJFjomRETkhtUE5DKNN2ugI2Kh_7SckHsJiY', 73.0019, 1545727230, 1546267230),
('NCxLwg4AoceqU06aCQhzPKR2BQCWfrSG1Akcp3Bm1gM', 74, 1546005740, 1546545740),
('2s0syKNqgFhejbL3wBX3vBc5ZXT_TTdUXG4RWSoXLMw', 19, 1545652183, 1545688183),
('hgWOql1VRs-Hv0wDa3WNRzyPukSMNGHc4AMVipW4t7A', 19, 1545727224, 1545763224);

-- --------------------------------------------------------

--
-- Struktura tabele `user_psp_data`
--

CREATE TABLE `user_psp_data` (
  `idUser` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `planning_time` int(11) NOT NULL,
  `infrastructuring_time` int(11) NOT NULL,
  `coding_time` int(11) NOT NULL,
  `code_review_time` int(11) NOT NULL,
  `compiling_time` int(11) NOT NULL,
  `testing_time` int(11) NOT NULL,
  `analysis_time` int(11) NOT NULL,
  `planning_in_err` int(11) NOT NULL,
  `infrastructuring_in_err` int(11) NOT NULL,
  `coding_in_err` int(11) NOT NULL,
  `code_review_in_err` int(11) NOT NULL,
  `compiling_in_err` int(11) NOT NULL,
  `testing_in_err` int(11) NOT NULL,
  `analysis_in_err` int(11) NOT NULL,
  `planning_res_err` int(11) NOT NULL,
  `infrastructuring_res_err` int(11) NOT NULL,
  `coding_res_err` int(11) NOT NULL,
  `code_review_res_err` int(11) NOT NULL,
  `compiling_res_err` int(11) NOT NULL,
  `testing_res_err` int(11) NOT NULL,
  `analysis_res_err` int(11) NOT NULL,
  `psp_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIJE ZA TABELO `user_psp_data`:
--   `idUser`
--       `users` -> `id`
--

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `organisations`
--
ALTER TABLE `organisations`
  ADD PRIMARY KEY (`id`);

--
-- Indeksi tabele `organisationsusers`
--
ALTER TABLE `organisationsusers`
  ADD PRIMARY KEY (`idOrganisation`,`idUser`),
  ADD KEY `idOrganisation` (`idOrganisation`),
  ADD KEY `idUser` (`idUser`);

--
-- Indeksi tabele `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idOrganisation` (`idOrganisation`),
  ADD KEY `idLeader` (`idLeader`);

--
-- Indeksi tabele `psps`
--
ALTER TABLE `psps`
  ADD PRIMARY KEY (`id`);

--
-- Indeksi tabele `psp_errors`
--
ALTER TABLE `psp_errors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCategory` (`idCategory`),
  ADD KEY `phaseEntry` (`phaseEntry`),
  ADD KEY `phaseFinish` (`phaseFinish`),
  ADD KEY `idPSP` (`idPSP`);

--
-- Indeksi tabele `psp_errors_categories`
--
ALTER TABLE `psp_errors_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeksi tabele `psp_phases`
--
ALTER TABLE `psp_phases`
  ADD PRIMARY KEY (`id`);

--
-- Indeksi tabele `psp_tasks`
--
ALTER TABLE `psp_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPhase` (`idPhase`),
  ADD KEY `idPSP` (`idPSP`);

--
-- Indeksi tabele `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProject` (`idProject`);

--
-- Indeksi tabele `tasksusersprojects`
--
ALTER TABLE `tasksusersprojects`
  ADD PRIMARY KEY (`idUser`,`idTask`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idTask` (`idTask`),
  ADD KEY `idPSP` (`idPSP`);

--
-- Indeksi tabele `userprojects`
--
ALTER TABLE `userprojects`
  ADD PRIMARY KEY (`idProject`,`idUser`),
  ADD KEY `idProject` (`idProject`),
  ADD KEY `idUser` (`idUser`);

--
-- Indeksi tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksi tabele `users_confirmations`
--
ALTER TABLE `users_confirmations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `email_expires` (`email`,`expires`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksi tabele `users_remembered`
--
ALTER TABLE `users_remembered`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `user` (`user`);

--
-- Indeksi tabele `users_resets`
--
ALTER TABLE `users_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `user_expires` (`user`,`expires`);

--
-- Indeksi tabele `users_throttling`
--
ALTER TABLE `users_throttling`
  ADD PRIMARY KEY (`bucket`),
  ADD KEY `expires_at` (`expires_at`);

--
-- Indeksi tabele `user_psp_data`
--
ALTER TABLE `user_psp_data`
  ADD KEY `idUser` (`idUser`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `organisations`
--
ALTER TABLE `organisations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT tabele `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT tabele `psps`
--
ALTER TABLE `psps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT tabele `psp_errors`
--
ALTER TABLE `psp_errors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT tabele `psp_errors_categories`
--
ALTER TABLE `psp_errors_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT tabele `psp_phases`
--
ALTER TABLE `psp_phases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT tabele `psp_tasks`
--
ALTER TABLE `psp_tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT tabele `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT tabele `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT tabele `users_confirmations`
--
ALTER TABLE `users_confirmations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT tabele `users_remembered`
--
ALTER TABLE `users_remembered`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT tabele `users_resets`
--
ALTER TABLE `users_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`idOrganisation`) REFERENCES `organisations` (`id`);

--
-- Omejitve za tabelo `psp_errors`
--
ALTER TABLE `psp_errors`
  ADD CONSTRAINT `psp_errors_ibfk_1` FOREIGN KEY (`idCategory`) REFERENCES `psp_errors_categories` (`id`),
  ADD CONSTRAINT `psp_errors_ibfk_2` FOREIGN KEY (`phaseEntry`) REFERENCES `psp_phases` (`id`),
  ADD CONSTRAINT `psp_errors_ibfk_3` FOREIGN KEY (`phaseFinish`) REFERENCES `psp_phases` (`id`),
  ADD CONSTRAINT `psp_errors_ibfk_4` FOREIGN KEY (`idPSP`) REFERENCES `psps` (`id`);

--
-- Omejitve za tabelo `psp_tasks`
--
ALTER TABLE `psp_tasks`
  ADD CONSTRAINT `psp_tasks_ibfk_1` FOREIGN KEY (`idPhase`) REFERENCES `psp_phases` (`id`),
  ADD CONSTRAINT `psp_tasks_ibfk_2` FOREIGN KEY (`idPSP`) REFERENCES `psps` (`id`);

--
-- Omejitve za tabelo `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`idProject`) REFERENCES `projects` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
