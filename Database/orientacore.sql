-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2025 at 07:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orientacore`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `logged_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `assessment_type` varchar(100) NOT NULL,
  `score` decimal(5,2) DEFAULT NULL,
  `taken_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `metric` varchar(100) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `recorded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `counsellor_id` int(10) UNSIGNED NOT NULL,
  `session_date` datetime NOT NULL,
  `mode` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `action_plan` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `student_id`, `counsellor_id`, `session_date`, `mode`, `notes`, `action_plan`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 9, '2025-10-18 10:00:00', 'In-Person', 'counselling about peer pressure', 'monitoring', 'Pending', '2025-09-22 17:13:38', '2025-09-22 17:13:38');

-- --------------------------------------------------------

--
-- Table structure for table `student_performance`
--

CREATE TABLE `student_performance` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `course_name` varchar(150) NOT NULL,
  `semester` enum('Jan-April','May-August','September-December') NOT NULL,
  `gpa` decimal(5,2) NOT NULL,
  `status` enum('First Class','Second Upper','Second Lower','Pass','Fail') NOT NULL DEFAULT 'Pass',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_performance`
--

INSERT INTO `student_performance` (`id`, `student_id`, `course_name`, `semester`, `gpa`, `status`, `created_at`) VALUES
(1, 8, 'Information Technology', 'Jan-April', 60.00, 'Second Upper', '2025-09-22 12:19:37'),
(5, 8, 'Information Technology', 'May-August', 70.00, 'First Class', '2025-09-22 14:39:07'),
(11, 10, 'IT', 'Jan-April', 67.00, 'Second Upper', '2025-09-22 16:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `reg_no` varchar(50) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'student',
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `reg_no`, `name`, `email`, `password_hash`, `role`, `status`, `created_at`) VALUES
(7, 'ADM001', 'Super Admin', 'admin@example.com', '$2y$10$uScyNVYPXo/RyPFFyw7WyudpgdecJkeEVj6AArQ4LvBcNcOGRz32y', 'admin', 'active', '2025-09-22 11:17:23'),
(8, 'BIT/2024/43255', 'student', 'student@gmail.com', '$2y$10$kddZFXBKZU6yc6m0TsRvmet6EJSthNCwVXhaI4vtWqlEV7p.GneCi', 'student', 'active', '2025-09-22 11:26:50'),
(9, 'coun123', 'counsellor', 'counsellor@gmail.com', '$2y$10$7qXulWihk69F/oBSCs9CweF54DWQ49fUQRk8ZUUEy1zwFAGnY8WwK', 'counsellor', 'active', '2025-09-22 11:44:27'),
(10, 'std001', 'peter', 'peter@gmail.com', '$2y$10$SsNPkIi4h8Wi.1sLX6wlaepRJpJIFWWuTTYfSNghqADt9VrXpBfLS', 'student', 'active', '2025-09-22 15:54:06'),
(11, 'CL001', 'Dr. Isaac', 'Isaac@orientacore.ac.ke', '$2y$10$bX7onl2h1emWEOI4wR0mYOqDATiun0/AaALE8E6AKk9EQywk2js/.', 'counsellor', 'active', '2025-09-22 15:57:58'),
(13, 'std002', 'Andrew', 'andrew@orientacore.ac.ke', '$2y$10$8m3Zgv4Aj9AnM1V6uGkSQOCgzQ0Cy3sAsDdF8.prRmJuLFohKPXDm', 'student', 'inactive', '2025-09-22 16:49:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sessions_student` (`student_id`),
  ADD KEY `fk_sessions_counsellor` (`counsellor_id`);

--
-- Indexes for table `student_performance`
--
ALTER TABLE `student_performance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_semester` (`student_id`,`semester`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `reg_no` (`reg_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_performance`
--
ALTER TABLE `student_performance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessments`
--
ALTER TABLE `assessments`
  ADD CONSTRAINT `assessments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `fk_sessions_counsellor` FOREIGN KEY (`counsellor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_sessions_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_performance`
--
ALTER TABLE `student_performance`
  ADD CONSTRAINT `student_performance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
