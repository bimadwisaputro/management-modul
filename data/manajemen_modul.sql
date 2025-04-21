-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 06:35 PM
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
-- Database: `manajemen_modul`
--

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `id` int(11) NOT NULL,
  `majors_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `address` text NOT NULL,
  `phone` varchar(13) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `majors_id`, `user_id`, `title`, `gender`, `address`, `phone`, `photo`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 3, 4, 'Skom', 1, 'Jl Pondok Ungu Bekasi', '0812992382999', 'uploads/instructors/2.jpg', 1, '2025-04-21 05:43:23', '2025-04-21 05:49:12'),
(3, 4, 3, 'Skom', 2, 'Jl Proklamasi 19 Depok', '081238829399', 'uploads/instructors/3.jpg', 1, '2025-04-21 05:51:06', '0000-00-00 00:00:00'),
(4, 5, 9, 'S1 Content Creator', 2, 'Jl Utara Kramat Jakarta', '081293812399', 'uploads/instructors/4.jpg', 1, '2025-04-21 05:51:54', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `learning_moduls`
--

CREATE TABLE `learning_moduls` (
  `id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learning_moduls`
--

INSERT INTO `learning_moduls` (`id`, `instructor_id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(27, 2, 'Javascript Modul', 'Pertemuan 1-5', 1, '2025-04-21 11:40:21', '2025-04-21 15:47:21');

-- --------------------------------------------------------

--
-- Table structure for table `learning_modul_details`
--

CREATE TABLE `learning_modul_details` (
  `id` int(11) NOT NULL,
  `learning_modul_id` int(11) NOT NULL,
  `file_name` varchar(50) NOT NULL,
  `file` varchar(100) NOT NULL,
  `reference_link` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learning_modul_details`
--

INSERT INTO `learning_modul_details` (`id`, `learning_modul_id`, `file_name`, `file`, `reference_link`, `created_at`, `updated_at`) VALUES
(35, 27, '5a911916.pdf', 'uploads/learning_moduls/27/5a911916.pdf', 'awdawdwadawd', '2025-04-21 16:35:28', NULL),
(36, 27, '9b41469b.pdf', 'uploads/learning_moduls/34/9b41469b.pdf', 'wwwwwww', '2025-04-21 16:35:28', NULL),
(37, 27, 'ee779c4f.pdf', 'uploads/learning_moduls/37/ee779c4f.pdf', 'aaaaaaaaaaaaa', '2025-04-21 16:35:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `majors`
--

CREATE TABLE `majors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `majors`
--

INSERT INTO `majors` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 'Web Programming', 1, '2025-04-21 04:34:42', NULL),
(4, 'Mobile Programming', 1, '2025-04-21 04:35:01', NULL),
(5, 'Content Creator', 1, '2025-04-21 04:35:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `majors_detail`
--

CREATE TABLE `majors_detail` (
  `id` int(11) NOT NULL,
  `majors_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `majors_detail`
--

INSERT INTO `majors_detail` (`id`, `majors_id`, `user_id`, `created_at`, `updated_at`) VALUES
(4, 4, 7, '2025-04-21 04:35:01', NULL),
(14, 5, 6, '2025-04-21 04:40:27', NULL),
(15, 5, 7, '2025-04-21 04:40:27', NULL),
(16, 5, 3, '2025-04-21 04:40:27', NULL),
(20, 3, 3, '2025-04-21 13:32:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 1, '2025-04-21 02:22:16', '0000-00-00 00:00:00'),
(2, 'Admin', 1, '2025-04-21 03:41:09', '2025-04-21 03:41:43'),
(3, 'PIC', 1, '2025-04-21 03:41:56', '2025-04-21 03:42:06'),
(4, 'Instructor', 1, '2025-04-21 03:42:28', '0000-00-00 00:00:00'),
(5, 'Student', 1, '2025-04-21 03:42:47', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `majors_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `place_of_birth` varchar(50) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `majors_id`, `user_id`, `gender`, `date_of_birth`, `place_of_birth`, `photo`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 3, 5, 1, '2025-04-21', 'Jakarta', 'uploads/students/1.jpg', 1, '2025-04-21 05:59:23', '2025-04-21 06:03:23'),
(2, 4, 10, 1, '2025-04-21', 'Japan', 'uploads/students/2.jpg', 1, '2025-04-21 05:59:48', '2025-04-21 06:03:11'),
(3, 5, 11, 1, '2025-04-16', 'Surabaya', 'uploads/students/3.jpg', 1, '2025-04-21 06:00:14', '2025-04-21 06:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', '$2y$10$020phvAFHVsr.TODjAgar.6Eu4SViLbBLGWnpMHBy0OOAQO4JS2cC', 1, '2025-04-21 02:22:56', '2025-04-21 03:04:43'),
(2, 'Bima', 'bima@gmail.com', '$2y$10$LafpGPxU/.eMW8/B3RultuGUCFby6CmwbJb5TpqIy1hChXeeYGZTi', 1, '2025-04-21 04:07:27', NULL),
(3, 'Ria', 'ria@gmail.com', '$2y$10$qL/x1TA5Ff8rNGTrnZbrZ.Q.l9zD8bBpgDRUSHD8nuBbTRIOivFfy', 1, '2025-04-21 04:07:53', '2025-04-21 04:14:59'),
(4, 'Reza', 'reza@gmail.com', '$2y$10$CLQT1xIW2gLRePCdoM4dxuyUk82YqNPpA14KWO6drkJo90EiNdtO.', 1, '2025-04-21 04:15:37', NULL),
(5, 'John Doe', 'john@gmail.com', '$2y$10$lQUzJwwq4jOUWuv9ilQxMuqd/YmjnnAtt4E1Fc9Q1XRYCrfhi31di', 1, '2025-04-21 04:16:10', NULL),
(6, 'Luna', 'luna@gmail.com', '$2y$10$tBDr/qhM5rshYHycFjnP4.Id0HChZDBMB8PwY.ka5eJcIgWBH.nAK', 1, '2025-04-21 04:29:16', NULL),
(7, 'Robert', 'robert', '$2y$10$KdzaHuUaR.9OKaW1WbHsXuy//XvN95GBUs/BcVFDoimKYcb.q8uJ.', 1, '2025-04-21 04:30:55', NULL),
(9, 'Veronica', 'veronica@gmail.com', '$2y$10$H.FR61HmiMyUKbfB8AoUwuS53txEwPnnC2UI4scUYbUs1yk/6WBCi', 1, '2025-04-21 05:49:59', NULL),
(10, 'Hikaru', 'hikaru@gmail.com', '$2y$10$8haAPVeXat5ByYCsXYcGV.T01juxE/erR2VlHClL6v6/McMqeUaxe', 1, '2025-04-21 05:57:17', NULL),
(11, 'Gilbert', 'gilbert@gmail.com', '$2y$10$VHI9NygMznGhmfyNRVW4L.HoQB4/AdwkfCiHvWKuD1AOx23XBQpm6', 1, '2025-04-21 05:57:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-04-21 02:23:32', NULL),
(3, 2, 2, '2025-04-21 04:11:47', NULL),
(5, 4, 4, '2025-04-21 04:15:37', NULL),
(6, 5, 5, '2025-04-21 04:16:10', NULL),
(7, 3, 3, '2025-04-21 04:16:23', NULL),
(8, 3, 4, '2025-04-21 04:16:23', NULL),
(9, 6, 3, '2025-04-21 04:29:16', NULL),
(10, 7, 3, '2025-04-21 04:30:55', NULL),
(12, 9, 4, '2025-04-21 05:49:59', NULL),
(13, 10, 5, '2025-04-21 05:57:17', NULL),
(14, 11, 5, '2025-04-21 05:57:42', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `majors_id` (`majors_id`);

--
-- Indexes for table `learning_moduls`
--
ALTER TABLE `learning_moduls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instructur_id` (`instructor_id`);

--
-- Indexes for table `learning_modul_details`
--
ALTER TABLE `learning_modul_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `learning_modul_id` (`learning_modul_id`);

--
-- Indexes for table `majors`
--
ALTER TABLE `majors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `majors_detail`
--
ALTER TABLE `majors_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `majors_id` (`majors_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `majors_id` (`majors_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `learning_moduls`
--
ALTER TABLE `learning_moduls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `learning_modul_details`
--
ALTER TABLE `learning_modul_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `majors`
--
ALTER TABLE `majors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `majors_detail`
--
ALTER TABLE `majors_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `instructors`
--
ALTER TABLE `instructors`
  ADD CONSTRAINT `instructors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `instructors_ibfk_2` FOREIGN KEY (`majors_id`) REFERENCES `majors` (`id`);

--
-- Constraints for table `learning_moduls`
--
ALTER TABLE `learning_moduls`
  ADD CONSTRAINT `learning_moduls_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`id`);

--
-- Constraints for table `learning_modul_details`
--
ALTER TABLE `learning_modul_details`
  ADD CONSTRAINT `learning_modul_details_ibfk_1` FOREIGN KEY (`learning_modul_id`) REFERENCES `learning_moduls` (`id`);

--
-- Constraints for table `majors_detail`
--
ALTER TABLE `majors_detail`
  ADD CONSTRAINT `majors_detail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `majors_detail_ibfk_2` FOREIGN KEY (`majors_id`) REFERENCES `majors` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`majors_id`) REFERENCES `majors` (`id`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
