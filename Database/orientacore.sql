-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2025 at 05:25 PM
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
-- Table structure for table `career_assessments`
--

CREATE TABLE `career_assessments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `assessment_type` varchar(50) NOT NULL,
  `responses` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responses`)),
  `score` varchar(50) NOT NULL,
  `result` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `career_assessments`
--

INSERT INTO `career_assessments` (`id`, `user_id`, `assessment_type`, `responses`, `score`, `result`, `created_at`, `updated_at`) VALUES
(21, 10, 'Analytical', '{\"26\":{\"question\":\"What do you enjoy most?\",\"answer\":\"A\",\"text\":\"Solving complex problems\",\"category\":\"Analytical\"},\"27\":{\"question\":\"Which task do you prefer?\",\"answer\":\"C\",\"text\":\"Creating spreadsheets\",\"category\":\"Analytical\"},\"28\":{\"question\":\"How do you approach challenges?\",\"answer\":\"C\",\"text\":\"Test hypotheses\",\"category\":\"Analytical\"},\"29\":{\"question\":\"Do you enjoy?\",\"answer\":\"B\",\"text\":\"Logic puzzles\",\"category\":\"Analytical\"},\"30\":{\"question\":\"When making decisions, you rely on?\",\"answer\":\"C\",\"text\":\"Evidence-based research\",\"category\":\"Analytical\"},\"31\":{\"question\":\"What do you enjoy most?\",\"answer\":\"C\",\"text\":\"Planning strategies\",\"category\":\"Analytical\"},\"32\":{\"question\":\"Which task do you prefer?\",\"answer\":\"C\",\"text\":\"Creating spreadsheets\",\"category\":\"Analytical\"},\"33\":{\"question\":\"How do you approach challenges?\",\"answer\":\"C\",\"text\":\"Test hypotheses\",\"category\":\"Analytical\"},\"34\":{\"question\":\"Do you enjoy?\",\"answer\":\"C\",\"text\":\"Mathematical modeling\",\"category\":\"Analytical\"},\"35\":{\"question\":\"When making decisions, you rely on?\",\"answer\":\"C\",\"text\":\"Evidence-based research\",\"category\":\"Analytical\"}}', '0', 'Pending Analysis', '2025-09-29 17:34:50', NULL),
(22, 8, 'Practical', '{\"41\":{\"question\":\"What do you enjoy most?\",\"answer\":\"A\",\"text\":\"Fixing machines\",\"category\":\"Practical\"},\"42\":{\"question\":\"Which task do you prefer?\",\"answer\":\"B\",\"text\":\"Electrical work\",\"category\":\"Practical\"},\"43\":{\"question\":\"Do you enjoy hands-on activities like?\",\"answer\":\"C\",\"text\":\"Cooking meals\",\"category\":\"Practical\"},\"44\":{\"question\":\"When learning something new, you prefer?\",\"answer\":\"B\",\"text\":\"Step-by-step instructions\",\"category\":\"Practical\"},\"45\":{\"question\":\"Your ideal job involves?\",\"answer\":\"C\",\"text\":\"Craftsmanship\",\"category\":\"Practical\"}}', '0', 'Pending Analysis', '2025-09-29 18:23:28', NULL),
(23, 14, 'Practical', '{\"41\":{\"question\":\"What do you enjoy most?\",\"answer\":\"C\",\"text\":\"Working with tools\",\"category\":\"Practical\"},\"42\":{\"question\":\"Which task do you prefer?\",\"answer\":\"B\",\"text\":\"Electrical work\",\"category\":\"Practical\"},\"43\":{\"question\":\"Do you enjoy hands-on activities like?\",\"answer\":\"B\",\"text\":\"Constructing furniture\",\"category\":\"Practical\"},\"44\":{\"question\":\"When learning something new, you prefer?\",\"answer\":\"C\",\"text\":\"Hands-on practice\",\"category\":\"Practical\"},\"45\":{\"question\":\"Your ideal job involves?\",\"answer\":\"B\",\"text\":\"Problem-solving physically\",\"category\":\"Practical\"}}', '0', 'Pending Analysis', '2025-09-30 15:08:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `career_questions`
--

CREATE TABLE `career_questions` (
  `id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `career_questions`
--

INSERT INTO `career_questions` (`id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `category`, `created_at`) VALUES
(16, 'What do you enjoy most?', 'Building things', 'Analyzing data', 'Helping people', 'Creating art', 'Creative', '2025-09-29 16:52:38'),
(17, 'Which task do you prefer?', 'Fixing machines', 'Solving puzzles', 'Counseling others', 'Designing projects', 'Creative', '2025-09-29 16:52:38'),
(18, 'What motivates you the most?', 'Practical achievements', 'Intellectual challenges', 'Social impact', 'Creative expression', 'Creative', '2025-09-29 16:52:38'),
(19, 'How do you spend your free time?', 'Tinkering with gadgets', 'Reading scientific articles', 'Volunteering', 'Painting or crafting', 'Creative', '2025-09-29 16:52:38'),
(20, 'Which environment suits you best?', 'Workshop', 'Laboratory', 'Community center', 'Studio', 'Creative', '2025-09-29 16:52:38'),
(21, 'What type of problems do you like to solve?', 'Hands-on technical problems', 'Data analysis', 'Conflict resolution', 'Innovative design challenges', 'Creative', '2025-09-29 16:52:38'),
(22, 'What skill would you like to improve?', 'Mechanical skills', 'Logical reasoning', 'Communication', 'Artistic skills', 'Creative', '2025-09-29 16:52:38'),
(23, 'Which subject did you enjoy the most in school?', 'Physics', 'Mathematics', 'Social Studies', 'Art', 'Creative', '2025-09-29 16:52:38'),
(24, 'Which project excites you the most?', 'Building a device', 'Researching a topic', 'Organizing a social event', 'Creating a piece of artwork', 'Creative', '2025-09-29 16:52:38'),
(25, 'What type of recognition do you prefer?', 'Practical results', 'Academic achievement', 'Helping others', 'Creative innovation', 'Creative', '2025-09-29 16:52:38'),
(26, 'What do you enjoy most?', 'Solving complex problems', 'Reading technical papers', 'Planning strategies', 'Analyzing data', 'Analytical', '2025-09-29 17:20:26'),
(27, 'Which task do you prefer?', 'Writing code', 'Designing experiments', 'Creating spreadsheets', 'Interpreting results', 'Analytical', '2025-09-29 17:20:26'),
(28, 'How do you approach challenges?', 'Break them into smaller parts', 'Research all possibilities', 'Test hypotheses', 'Evaluate outcomes logically', 'Analytical', '2025-09-29 17:20:26'),
(29, 'Do you enjoy?', 'Data analysis', 'Logic puzzles', 'Mathematical modeling', 'Scientific research', 'Analytical', '2025-09-29 17:20:26'),
(30, 'When making decisions, you rely on?', 'Facts and data', 'Patterns and trends', 'Evidence-based research', 'Statistical reasoning', 'Analytical', '2025-09-29 17:20:26'),
(31, 'What do you enjoy most?', 'Solving complex problems', 'Reading technical papers', 'Planning strategies', 'Analyzing data', 'Analytical', '2025-09-29 17:20:41'),
(32, 'Which task do you prefer?', 'Writing code', 'Designing experiments', 'Creating spreadsheets', 'Interpreting results', 'Analytical', '2025-09-29 17:20:41'),
(33, 'How do you approach challenges?', 'Break them into smaller parts', 'Research all possibilities', 'Test hypotheses', 'Evaluate outcomes logically', 'Analytical', '2025-09-29 17:20:41'),
(34, 'Do you enjoy?', 'Data analysis', 'Logic puzzles', 'Mathematical modeling', 'Scientific research', 'Analytical', '2025-09-29 17:20:41'),
(35, 'When making decisions, you rely on?', 'Facts and data', 'Patterns and trends', 'Evidence-based research', 'Statistical reasoning', 'Analytical', '2025-09-29 17:20:41'),
(36, 'What motivates you most?', 'Helping people', 'Teaching others', 'Listening and advising', 'Community service', 'Social', '2025-09-29 17:21:05'),
(37, 'Which task do you prefer?', 'Mentoring peers', 'Organizing social events', 'Counseling', 'Volunteering', 'Social', '2025-09-29 17:21:05'),
(38, 'In a team, you are usually?', 'The communicator', 'The motivator', 'The mediator', 'The support person', 'Social', '2025-09-29 17:21:05'),
(39, 'How do you react to conflicts?', 'Resolve through dialogue', 'Support both sides', 'Encourage cooperation', 'Seek consensus', 'Social', '2025-09-29 17:21:05'),
(40, 'You enjoy roles that involve?', 'Teaching', 'Coaching', 'Counseling', 'Social interaction', 'Social', '2025-09-29 17:21:05'),
(41, 'What do you enjoy most?', 'Fixing machines', 'Building things', 'Working with tools', 'Creating practical solutions', 'Practical', '2025-09-29 17:21:31'),
(42, 'Which task do you prefer?', 'Carpentry', 'Electrical work', 'Cooking', 'Mechanical repairs', 'Practical', '2025-09-29 17:21:31'),
(43, 'Do you enjoy hands-on activities like?', 'Repairing gadgets', 'Constructing furniture', 'Cooking meals', 'Operating machinery', 'Practical', '2025-09-29 17:21:31'),
(44, 'When learning something new, you prefer?', 'Practical demonstration', 'Step-by-step instructions', 'Hands-on practice', 'Experiments', 'Practical', '2025-09-29 17:21:31'),
(45, 'Your ideal job involves?', 'Using your hands', 'Problem-solving physically', 'Craftsmanship', 'Technical tasks', 'Practical', '2025-09-29 17:21:31');

-- --------------------------------------------------------

--
-- Table structure for table `career_suggestions`
--

CREATE TABLE `career_suggestions` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `suggestion` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `career_suggestions`
--

INSERT INTO `career_suggestions` (`id`, `category`, `suggestion`, `created_at`) VALUES
(29, 'Creative', 'Graphic Designer', '2025-09-29 16:54:33'),
(30, 'Creative', 'Writer / Author', '2025-09-29 16:54:33'),
(31, 'Creative', 'Animator / Illustrator', '2025-09-29 16:54:33'),
(32, 'Creative', 'Fashion Designer', '2025-09-29 16:54:33'),
(33, 'Creative', 'Photographer', '2025-09-29 16:54:33'),
(34, 'Creative', 'Interior Designer', '2025-09-29 16:54:33'),
(35, 'Analytical', 'Analytical|Data Scientist', '2025-09-29 17:21:54'),
(36, 'Analytical', 'Analytical|Software Engineer', '2025-09-29 17:21:54'),
(37, 'Analytical', 'Analytical|Research Analyst', '2025-09-29 17:21:54'),
(38, 'Analytical', 'Analytical|Statistician', '2025-09-29 17:21:54'),
(39, 'Analytical', 'Analytical|Financial Analyst', '2025-09-29 17:21:54'),
(40, 'Practical', 'Practical|Mechanic / Technician', '2025-09-29 17:22:22'),
(41, 'Practical', 'Practical|Carpenter / Builder', '2025-09-29 17:22:22'),
(42, 'Practical', 'Practical|Electrician', '2025-09-29 17:22:22'),
(43, 'Practical', 'Practical|Chef / Culinary Expert', '2025-09-29 17:22:22'),
(44, 'Practical', 'Practical|Plumber', '2025-09-29 17:22:23'),
(45, 'Social', 'Social|Teacher / Educator', '2025-09-29 17:22:49'),
(46, 'Social', 'Social|Counselor / Therapist', '2025-09-29 17:22:49'),
(47, 'Social', 'Social|Social Worker', '2025-09-29 17:22:49'),
(48, 'Social', 'Social|Human Resource Manager', '2025-09-29 17:22:49'),
(49, 'Social', 'Social|Community Outreach Coordinator', '2025-09-29 17:22:49');

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
(1, 8, 9, '2025-10-03 00:00:00', 'Physical', 'counselling about peer pressure', 'monitoring', 'Pending', '2025-09-22 17:13:38', '2025-10-03 17:44:36');

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
(11, 10, 'IT', 'Jan-April', 67.00, 'Second Upper', '2025-09-22 16:46:45'),
(12, 14, 'Information Technology', 'May-August', 60.00, 'Second Upper', '2025-09-30 15:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `reg_no` varchar(50) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'student',
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `reg_no`, `name`, `email`, `profile_pic`, `password_hash`, `role`, `status`, `created_at`) VALUES
(7, 'ADM001', 'Super Admin', 'admin@example.com', NULL, '$2y$10$uScyNVYPXo/RyPFFyw7WyudpgdecJkeEVj6AArQ4LvBcNcOGRz32y', 'admin', 'active', '2025-09-22 11:17:23'),
(8, 'BIT/2024/43255', 'student', 'student@gmail.com', NULL, '$2y$10$kddZFXBKZU6yc6m0TsRvmet6EJSthNCwVXhaI4vtWqlEV7p.GneCi', 'student', 'active', '2025-09-22 11:26:50'),
(9, 'coun123', 'counsellor', 'counsellor@gmail.com', NULL, '$2y$10$7qXulWihk69F/oBSCs9CweF54DWQ49fUQRk8ZUUEy1zwFAGnY8WwK', 'counsellor', 'active', '2025-09-22 11:44:27'),
(10, 'std001', 'peter', 'peter@gmail.com', 'uploads/68dfe82b3783b.jpg', '$2y$10$SsNPkIi4h8Wi.1sLX6wlaepRJpJIFWWuTTYfSNghqADt9VrXpBfLS', 'student', 'active', '2025-09-22 15:54:06'),
(11, 'CL001', 'Dr. Isaac', 'Isaac@orientacore.ac.ke', NULL, '$2y$10$bX7onl2h1emWEOI4wR0mYOqDATiun0/AaALE8E6AKk9EQywk2js/.', 'counsellor', 'active', '2025-09-22 15:57:58'),
(13, 'std002', 'Andrew', 'andrew@orientacore.ac.ke', NULL, '$2y$10$8m3Zgv4Aj9AnM1V6uGkSQOCgzQ0Cy3sAsDdF8.prRmJuLFohKPXDm', 'student', 'active', '2025-09-22 16:49:40'),
(14, 'std1234', 'Vera MIchael', 'veramichael@orientacore.ac.ke', NULL, '$2y$10$AHCRYKTz2CaemHQsrMgHO.nPbQiP/xG/XonPeHNPdqXamm9GzuqVm', 'student', 'active', '2025-09-30 15:03:20'),
(16, 'Con1234', 'counsellor', 'cousellor@gmail.com', NULL, '$2y$10$4jq3UvmjRZq8wKAfO7on8eW6rwSVJUstgVrYJaG655kCY3QKNxDr.', 'counsellor', 'active', '2025-10-03 14:25:56');

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
-- Indexes for table `career_assessments`
--
ALTER TABLE `career_assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_career_assessments_user` (`user_id`);

--
-- Indexes for table `career_questions`
--
ALTER TABLE `career_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `career_suggestions`
--
ALTER TABLE `career_suggestions`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `career_assessments`
--
ALTER TABLE `career_assessments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `career_questions`
--
ALTER TABLE `career_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `career_suggestions`
--
ALTER TABLE `career_suggestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `career_assessments`
--
ALTER TABLE `career_assessments`
  ADD CONSTRAINT `fk_career_assessments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
