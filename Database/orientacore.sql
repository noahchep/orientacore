-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2025 at 02:53 PM
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
-- Table structure for table `behavior_questions`
--

CREATE TABLE `behavior_questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `behavior_questions`
--

INSERT INTO `behavior_questions` (`id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `category`, `created_at`) VALUES
(1, 'I take initiative in group activities.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Leadership & Responsibility', '2025-11-10 12:44:27'),
(2, 'I can make decisions under pressure.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Leadership & Responsibility', '2025-11-10 12:44:27'),
(3, 'I am comfortable leading a team.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Leadership & Responsibility', '2025-11-10 12:44:27'),
(4, 'I hold myself accountable for my actions.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Leadership & Responsibility', '2025-11-10 12:44:27'),
(5, 'I take responsibility for achieving group goals.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Leadership & Responsibility', '2025-11-10 12:44:27'),
(6, 'I come up with new ideas frequently.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Creativity & Innovation', '2025-11-10 12:44:46'),
(7, 'I enjoy finding unique solutions to problems.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Creativity & Innovation', '2025-11-10 12:44:46'),
(8, 'I am comfortable thinking outside the box.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Creativity & Innovation', '2025-11-10 12:44:46'),
(9, 'I experiment with new approaches in my work.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Creativity & Innovation', '2025-11-10 12:44:46'),
(10, 'I adapt creative ideas into practical solutions.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Creativity & Innovation', '2025-11-10 12:44:46'),
(11, 'I work well in team settings.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Teamwork & Collaboration', '2025-11-10 12:45:07'),
(12, 'I support my teammates to achieve goals.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Teamwork & Collaboration', '2025-11-10 12:45:07'),
(13, 'I communicate effectively with team members.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Teamwork & Collaboration', '2025-11-10 12:45:07'),
(14, 'I handle conflicts in teams constructively.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Teamwork & Collaboration', '2025-11-10 12:45:07'),
(15, 'I value diverse perspectives in a team.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Teamwork & Collaboration', '2025-11-10 12:45:07'),
(16, 'I express my ideas clearly.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Communication Skills', '2025-11-10 12:45:30'),
(17, 'I listen carefully to others.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Communication Skills', '2025-11-10 12:45:30'),
(18, 'I adapt my communication to different audiences.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Communication Skills', '2025-11-10 12:45:30'),
(19, 'I provide constructive feedback.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Communication Skills', '2025-11-10 12:45:30'),
(20, 'I can persuade or influence others effectively.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Communication Skills', '2025-11-10 12:45:30'),
(21, 'I analyze problems before taking action.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Problem Solving & Critical Thinking', '2025-11-10 12:45:58'),
(22, 'I consider multiple solutions to problems.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Problem Solving & Critical Thinking', '2025-11-10 12:45:58'),
(23, 'I make logical decisions under uncertainty.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Problem Solving & Critical Thinking', '2025-11-10 12:45:58'),
(24, 'I learn from mistakes to improve outcomes.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Problem Solving & Critical Thinking', '2025-11-10 12:45:58'),
(25, 'I apply critical thinking in daily tasks.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Problem Solving & Critical Thinking', '2025-11-10 12:45:58'),
(26, 'I adjust easily to changes.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Adaptability & Flexibility', '2025-11-10 12:46:18'),
(27, 'I remain calm under unexpected situations.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Adaptability & Flexibility', '2025-11-10 12:46:18'),
(28, 'I can switch between tasks efficiently.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Adaptability & Flexibility', '2025-11-10 12:46:18'),
(29, 'I accept constructive criticism.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Adaptability & Flexibility', '2025-11-10 12:46:18'),
(30, 'I thrive in dynamic environments.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Adaptability & Flexibility', '2025-11-10 12:46:18'),
(31, 'I complete tasks on time.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Work Ethic & Motivation', '2025-11-10 12:46:40'),
(32, 'I stay focused on long-term goals.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Work Ethic & Motivation', '2025-11-10 12:46:40'),
(33, 'I take pride in my work quality.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Work Ethic & Motivation', '2025-11-10 12:46:40'),
(34, 'I persevere even when tasks are challenging.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Work Ethic & Motivation', '2025-11-10 12:46:40'),
(35, 'I am self-motivated without supervision.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Work Ethic & Motivation', '2025-11-10 12:46:40'),
(36, 'I understand the emotions of others.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Emotional Intelligence & Empathy', '2025-11-10 12:46:59'),
(37, 'I manage my own emotions effectively.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Emotional Intelligence & Empathy', '2025-11-10 12:46:59'),
(38, 'I respond appropriately to others’ feelings.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Emotional Intelligence & Empathy', '2025-11-10 12:46:59'),
(39, 'I remain patient and calm in difficult situations.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Emotional Intelligence & Empathy', '2025-11-10 12:46:59'),
(40, 'I build positive relationships easily.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Emotional Intelligence & Empathy', '2025-11-10 12:46:59'),
(41, 'I plan my day effectively.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Organization & Time Management', '2025-11-10 12:47:21'),
(42, 'I prioritize tasks based on importance.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Organization & Time Management', '2025-11-10 12:47:21'),
(43, 'I meet deadlines consistently.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Organization & Time Management', '2025-11-10 12:47:21'),
(44, 'I keep my workspace organized.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Organization & Time Management', '2025-11-10 12:47:21'),
(45, 'I avoid procrastination.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Organization & Time Management', '2025-11-10 12:47:21'),
(46, 'I am confident in my abilities.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Self-Confidence & Initiative', '2025-11-10 12:48:15'),
(47, 'I take action without being told.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Self-Confidence & Initiative', '2025-11-10 12:48:15'),
(48, 'I am comfortable making independent decisions.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Self-Confidence & Initiative', '2025-11-10 12:48:15'),
(49, 'I express my opinions confidently.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Self-Confidence & Initiative', '2025-11-10 12:48:15'),
(50, 'I embrace challenges as opportunities.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Self-Confidence & Initiative', '2025-11-10 12:48:15');

-- --------------------------------------------------------

--
-- Table structure for table `behavior_responses`
--

CREATE TABLE `behavior_responses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `score` tinyint(4) NOT NULL COMMENT '1-5 rating',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `behavior_responses`
--

INSERT INTO `behavior_responses` (`id`, `user_id`, `question_id`, `score`, `created_at`) VALUES
(71, 10, 1, 1, '2025-11-10 13:46:25'),
(72, 10, 2, 5, '2025-11-10 13:46:25'),
(73, 10, 3, 2, '2025-11-10 13:46:25'),
(74, 10, 4, 2, '2025-11-10 13:46:25'),
(75, 10, 5, 5, '2025-11-10 13:46:25'),
(76, 10, 1, 1, '2025-11-10 13:46:58'),
(77, 10, 2, 5, '2025-11-10 13:46:58'),
(78, 10, 3, 2, '2025-11-10 13:46:58'),
(79, 10, 4, 5, '2025-11-10 13:46:58'),
(80, 10, 5, 5, '2025-11-10 13:46:58'),
(81, 10, 36, 5, '2025-11-10 13:48:15'),
(82, 10, 37, 5, '2025-11-10 13:48:16'),
(83, 10, 38, 5, '2025-11-10 13:48:16'),
(84, 10, 39, 5, '2025-11-10 13:48:16'),
(85, 10, 40, 5, '2025-11-10 13:48:16'),
(86, 10, 36, 1, '2025-11-10 13:48:47'),
(87, 10, 37, 1, '2025-11-10 13:48:47'),
(88, 10, 38, 1, '2025-11-10 13:48:47'),
(89, 10, 39, 1, '2025-11-10 13:48:47'),
(90, 10, 40, 1, '2025-11-10 13:48:47');

-- --------------------------------------------------------

--
-- Table structure for table `behavior_suggestions`
--

CREATE TABLE `behavior_suggestions` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(100) NOT NULL,
  `min_score` int(11) NOT NULL,
  `max_score` int(11) NOT NULL,
  `recommended_careers` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `behavior_suggestions`
--

INSERT INTO `behavior_suggestions` (`id`, `category`, `min_score`, `max_score`, `recommended_careers`, `created_at`) VALUES
(1, 'Leadership & Responsibility', 0, 5, 'Participate in small leadership tasks; seek guidance.', '2025-11-10 13:26:31'),
(2, 'Leadership & Responsibility', 6, 10, 'Take initiative in group activities; build confidence.', '2025-11-10 13:26:31'),
(3, 'Leadership & Responsibility', 11, 15, 'Lead team projects and mentor peers.', '2025-11-10 13:26:31'),
(4, 'Leadership & Responsibility', 16, 20, 'Assume major leadership roles and inspire others.', '2025-11-10 13:26:31'),
(5, 'Creativity & Innovation', 0, 5, 'Engage in basic creative exercises; practice brainstorming.', '2025-11-10 13:26:31'),
(6, 'Creativity & Innovation', 6, 10, 'Participate in creative projects; explore new ideas.', '2025-11-10 13:26:31'),
(7, 'Creativity & Innovation', 11, 15, 'Lead innovative projects; collaborate on creative solutions.', '2025-11-10 13:26:31'),
(8, 'Creativity & Innovation', 16, 20, 'Pursue advanced creative roles; consider entrepreneurship.', '2025-11-10 13:26:31'),
(9, 'Teamwork & Collaboration', 0, 5, 'Practice working in small groups; improve communication.', '2025-11-10 13:26:31'),
(10, 'Teamwork & Collaboration', 6, 10, 'Participate actively in team projects; listen to others.', '2025-11-10 13:26:31'),
(11, 'Teamwork & Collaboration', 11, 15, 'Facilitate teamwork; resolve conflicts effectively.', '2025-11-10 13:26:31'),
(12, 'Teamwork & Collaboration', 16, 20, 'Lead collaborative initiatives and mentor teams.', '2025-11-10 13:26:31'),
(13, 'Communication Skills', 0, 5, 'Practice basic speaking and writing skills.', '2025-11-10 13:26:31'),
(14, 'Communication Skills', 6, 10, 'Engage in presentations; improve clarity and tone.', '2025-11-10 13:26:31'),
(15, 'Communication Skills', 11, 15, 'Communicate effectively in complex settings.', '2025-11-10 13:26:31'),
(16, 'Communication Skills', 16, 20, 'Lead discussions; mentor others on communication skills.', '2025-11-10 13:26:31'),
(17, 'Problem Solving & Critical Thinking', 0, 5, 'Solve simple problems; learn to analyze situations.', '2025-11-10 13:26:31'),
(18, 'Problem Solving & Critical Thinking', 6, 10, 'Work on structured problem-solving exercises.', '2025-11-10 13:26:31'),
(19, 'Problem Solving & Critical Thinking', 11, 15, 'Take initiative in solving complex problems.', '2025-11-10 13:26:31'),
(20, 'Problem Solving & Critical Thinking', 16, 20, 'Lead problem-solving projects; innovate solutions.', '2025-11-10 13:26:31'),
(21, 'Adaptability & Flexibility', 0, 5, 'Practice adjusting to small changes; be open to feedback.', '2025-11-10 13:26:31'),
(22, 'Adaptability & Flexibility', 6, 10, 'Handle moderate changes effectively; stay flexible.', '2025-11-10 13:26:31'),
(23, 'Adaptability & Flexibility', 11, 15, 'Adapt quickly to new situations; mentor peers.', '2025-11-10 13:26:31'),
(24, 'Adaptability & Flexibility', 16, 20, 'Excel in dynamic environments; lead change initiatives.', '2025-11-10 13:26:31'),
(25, 'Work Ethic & Motivation', 0, 5, 'Focus on completing tasks; develop consistency.', '2025-11-10 13:26:31'),
(26, 'Work Ethic & Motivation', 6, 10, 'Set goals; work diligently with minimal supervision.', '2025-11-10 13:26:31'),
(27, 'Work Ethic & Motivation', 11, 15, 'Take ownership of projects; inspire peers.', '2025-11-10 13:26:31'),
(28, 'Work Ethic & Motivation', 16, 20, 'Exhibit exceptional work ethic; lead by example.', '2025-11-10 13:26:31'),
(29, 'Emotional Intelligence & Empathy', 0, 5, 'Practice recognizing emotions; understand others’ perspectives.', '2025-11-10 13:26:31'),
(30, 'Emotional Intelligence & Empathy', 6, 10, 'Improve interpersonal skills; provide support.', '2025-11-10 13:26:31'),
(31, 'Emotional Intelligence & Empathy', 11, 15, 'Demonstrate empathy in complex scenarios; mentor others.', '2025-11-10 13:26:31'),
(32, 'Emotional Intelligence & Empathy', 16, 20, 'Lead emotionally intelligent teams; resolve conflicts.', '2025-11-10 13:26:31'),
(33, 'Organization & Time Management', 0, 5, 'Practice basic organization; plan small tasks.', '2025-11-10 13:26:31'),
(34, 'Organization & Time Management', 6, 10, 'Manage multiple tasks; prioritize effectively.', '2025-11-10 13:26:31'),
(35, 'Organization & Time Management', 11, 15, 'Coordinate projects efficiently; mentor peers.', '2025-11-10 13:26:31'),
(36, 'Organization & Time Management', 16, 20, 'Lead complex projects; optimize team productivity.', '2025-11-10 13:26:31'),
(37, 'Self-Confidence & Initiative', 0, 5, 'Participate in small tasks; take minor initiatives.', '2025-11-10 13:26:31'),
(38, 'Self-Confidence & Initiative', 6, 10, 'Take on visible roles; practice decision-making.', '2025-11-10 13:26:31'),
(39, 'Self-Confidence & Initiative', 11, 15, 'Lead initiatives confidently; encourage others.', '2025-11-10 13:26:31'),
(40, 'Self-Confidence & Initiative', 16, 20, 'Excel in leadership and independent projects; mentor others.', '2025-11-10 13:26:31');

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

-- --------------------------------------------------------

--
-- Table structure for table `career_category_scores`
--

CREATE TABLE `career_category_scores` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `score` decimal(6,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `career_category_scores`
--

INSERT INTO `career_category_scores` (`id`, `student_id`, `category`, `score`, `created_at`) VALUES
(1, 10, 'Personality', 20.00, '2025-10-25 13:58:59'),
(6, 10, 'Interests', 36.00, '2025-10-25 13:21:46'),
(8, 10, 'Agriculture & Natural Resources', 13.00, '2025-11-10 16:29:35'),
(9, 10, 'Research & Data Analytics', 19.00, '2025-10-25 15:56:51'),
(18, 10, 'Finance & Accounting', 10.00, '2025-10-26 20:00:33'),
(19, 10, 'Hospitality & Tourism', 19.00, '2025-10-26 19:56:47'),
(23, 10, 'Architecture & Construction', 14.00, '2025-11-10 16:01:51');

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
(131, 'Do you enjoy working outdoors in nature?', 'Yes, always', 'Sometimes', 'Rarely', 'Never', 'Agriculture & Natural Resources', '2025-10-25 11:56:45'),
(132, 'Are you interested in plant and animal sciences?', 'Very interested', 'Somewhat interested', 'Not much', 'Not at all', 'Agriculture & Natural Resources', '2025-10-25 11:56:45'),
(133, 'Would you enjoy managing a farm or agricultural project?', 'Yes', 'Maybe', 'Not sure', 'No', 'Agriculture & Natural Resources', '2025-10-25 11:56:45'),
(134, 'Do you like solving environmental or ecological problems?', 'Yes, a lot', 'Sometimes', 'Rarely', 'Not at all', 'Agriculture & Natural Resources', '2025-10-25 11:56:45'),
(135, 'Are you interested in sustainable farming or forestry?', 'Yes', 'A little', 'Not really', 'No', 'Agriculture & Natural Resources', '2025-10-25 11:56:45'),
(136, 'Do you enjoy designing buildings or structures?', 'Yes, very much', 'Somewhat', 'Not really', 'No', 'Architecture & Construction', '2025-10-25 11:56:45'),
(137, 'Are you good at visualizing spaces and layouts?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Architecture & Construction', '2025-10-25 11:56:45'),
(138, 'Do you enjoy working with construction materials or tools?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Architecture & Construction', '2025-10-25 11:56:45'),
(139, 'Do you like planning and managing construction projects?', 'Yes', 'Maybe', 'Not sure', 'No', 'Architecture & Construction', '2025-10-25 11:56:45'),
(140, 'Are you interested in civil engineering or urban planning?', 'Yes', 'Somewhat', 'Not really', 'No', 'Architecture & Construction', '2025-10-25 11:56:45'),
(141, 'Do you enjoy creating visual art or graphic designs?', 'Yes, always', 'Sometimes', 'Rarely', 'Never', 'Arts, Design, Entertainment & Media', '2025-10-25 11:56:46'),
(142, 'Are you interested in music, film, or performing arts?', 'Yes, very much', 'Somewhat', 'Not really', 'No', 'Arts, Design, Entertainment & Media', '2025-10-25 11:56:46'),
(143, 'Do you like writing stories, articles, or scripts?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Arts, Design, Entertainment & Media', '2025-10-25 11:56:46'),
(144, 'Do you enjoy experimenting with new creative techniques?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Arts, Design, Entertainment & Media', '2025-10-25 11:56:46'),
(145, 'Do you follow trends in media and entertainment?', 'Yes, closely', 'Somewhat', 'Not much', 'No', 'Arts, Design, Entertainment & Media', '2025-10-25 11:56:46'),
(146, 'Do you like organizing and managing tasks efficiently?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Business Management & Administration', '2025-10-25 11:56:46'),
(147, 'Are you interested in leading teams and projects?', 'Yes', 'Somewhat', 'Not really', 'No', 'Business Management & Administration', '2025-10-25 11:56:46'),
(148, 'Do you enjoy analyzing business performance data?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Business Management & Administration', '2025-10-25 11:56:46'),
(149, 'Do you like planning strategies to improve productivity?', 'Yes', 'Maybe', 'Not sure', 'No', 'Business Management & Administration', '2025-10-25 11:56:46'),
(150, 'Are you comfortable making decisions that affect a group?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Business Management & Administration', '2025-10-25 11:56:46'),
(151, 'Do you enjoy teaching or explaining concepts to others?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Education & Training', '2025-10-25 11:56:46'),
(152, 'Are you patient and understanding when helping learners?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Education & Training', '2025-10-25 11:56:46'),
(153, 'Do you like developing lesson plans or training materials?', 'Yes', 'Somewhat', 'Not really', 'No', 'Education & Training', '2025-10-25 11:56:46'),
(154, 'Do you enjoy evaluating and improving student performance?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Education & Training', '2025-10-25 11:56:46'),
(155, 'Are you interested in curriculum development or educational research?', 'Yes', 'Somewhat', 'Not really', 'No', 'Education & Training', '2025-10-25 11:56:46'),
(156, 'Do you enjoy working with numbers and calculations?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Finance & Accounting', '2025-10-25 11:56:47'),
(157, 'Are you interested in budgeting or financial planning?', 'Yes', 'Somewhat', 'Not really', 'No', 'Finance & Accounting', '2025-10-25 11:56:47'),
(158, 'Do you like analyzing financial statements and reports?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Finance & Accounting', '2025-10-25 11:56:47'),
(159, 'Do you enjoy auditing or reviewing accounts?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Finance & Accounting', '2025-10-25 11:56:47'),
(160, 'Are you interested in investments and stock market analysis?', 'Yes', 'Somewhat', 'Not really', 'No', 'Finance & Accounting', '2025-10-25 11:56:47'),
(161, 'Do you enjoy studying laws, policies, or governance?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Government, Public Administration & Policy', '2025-10-25 11:56:48'),
(162, 'Are you interested in public service and helping communities?', 'Yes', 'Somewhat', 'Not really', 'No', 'Government, Public Administration & Policy', '2025-10-25 11:56:48'),
(163, 'Do you like analyzing political or economic issues?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Government, Public Administration & Policy', '2025-10-25 11:56:48'),
(164, 'Do you enjoy planning or managing public projects?', 'Yes', 'Maybe', 'Not sure', 'No', 'Government, Public Administration & Policy', '2025-10-25 11:56:48'),
(165, 'Are you interested in policy research or diplomacy?', 'Yes', 'Somewhat', 'Not really', 'No', 'Government, Public Administration & Policy', '2025-10-25 11:56:48'),
(166, 'Do you enjoy caring for people and improving their health?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Health Science & Allied Professions', '2025-10-25 11:56:48'),
(167, 'Are you interested in biology or medical sciences?', 'Yes', 'Somewhat', 'Not really', 'No', 'Health Science & Allied Professions', '2025-10-25 11:56:48'),
(168, 'Do you like working in hospitals or clinical settings?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Health Science & Allied Professions', '2025-10-25 11:56:48'),
(169, 'Do you enjoy diagnosing or treating patients?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Health Science & Allied Professions', '2025-10-25 11:56:48'),
(170, 'Are you interested in nutrition, therapy, or pharmacy?', 'Yes', 'Somewhat', 'Not really', 'No', 'Health Science & Allied Professions', '2025-10-25 11:56:48'),
(171, 'Do you enjoy meeting and helping new people?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Hospitality & Tourism', '2025-10-25 11:56:48'),
(172, 'Are you interested in managing hotels, restaurants, or travel?', 'Yes', 'Somewhat', 'Not really', 'No', 'Hospitality & Tourism', '2025-10-25 11:56:48'),
(173, 'Do you like organizing events or tours?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Hospitality & Tourism', '2025-10-25 11:56:48'),
(174, 'Do you enjoy cooking or working in the culinary arts?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Hospitality & Tourism', '2025-10-25 11:56:48'),
(175, 'Are you comfortable with customer service roles?', 'Yes', 'Somewhat', 'Not really', 'No', 'Hospitality & Tourism', '2025-10-25 11:56:48'),
(176, 'Do you enjoy helping others solve personal problems?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Human Services / Community & Social Services', '2025-10-25 11:56:49'),
(177, 'Are you interested in counseling or social work?', 'Yes', 'Somewhat', 'Not really', 'No', 'Human Services / Community & Social Services', '2025-10-25 11:56:49'),
(178, 'Do you like volunteering or community service?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Human Services / Community & Social Services', '2025-10-25 11:56:49'),
(179, 'Do you enjoy teaching life skills or mentoring?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Human Services / Community & Social Services', '2025-10-25 11:56:49'),
(180, 'Are you interested in nonprofit management or advocacy?', 'Yes', 'Somewhat', 'Not really', 'No', 'Human Services / Community & Social Services', '2025-10-25 11:56:49'),
(181, 'Do you enjoy programming or software development?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Information Technology & Computer Science', '2025-10-25 11:56:49'),
(182, 'Are you interested in cybersecurity or networks?', 'Yes', 'Somewhat', 'Not really', 'No', 'Information Technology & Computer Science', '2025-10-25 11:56:49'),
(183, 'Do you like working with databases or data analysis?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Information Technology & Computer Science', '2025-10-25 11:56:49'),
(184, 'Do you enjoy creating apps, websites, or digital tools?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Information Technology & Computer Science', '2025-10-25 11:56:49'),
(185, 'Are you interested in IT support or system administration?', 'Yes', 'Somewhat', 'Not really', 'No', 'Information Technology & Computer Science', '2025-10-25 11:56:49'),
(186, 'Do you enjoy learning about laws and legal systems?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Law, Public Safety, Corrections & Security', '2025-10-25 12:02:37'),
(187, 'Are you interested in maintaining public safety or security?', 'Yes', 'Somewhat', 'Not really', 'No', 'Law, Public Safety, Corrections & Security', '2025-10-25 12:02:37'),
(188, 'Do you like solving disputes or mediating conflicts?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Law, Public Safety, Corrections & Security', '2025-10-25 12:02:37'),
(189, 'Do you enjoy investigative work or forensic analysis?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Law, Public Safety, Corrections & Security', '2025-10-25 12:02:37'),
(190, 'Are you comfortable enforcing rules or regulations?', 'Yes', 'Somewhat', 'Not really', 'No', 'Law, Public Safety, Corrections & Security', '2025-10-25 12:02:37'),
(191, 'Do you enjoy working with machinery or production tools?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Manufacturing & Production', '2025-10-25 12:02:37'),
(192, 'Are you interested in improving production efficiency?', 'Yes', 'Somewhat', 'Not really', 'No', 'Manufacturing & Production', '2025-10-25 12:02:37'),
(193, 'Do you like quality control and ensuring standards?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Manufacturing & Production', '2025-10-25 12:02:37'),
(194, 'Do you enjoy assembling or constructing products?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Manufacturing & Production', '2025-10-25 12:02:37'),
(195, 'Are you interested in mechanical or industrial engineering?', 'Yes', 'Somewhat', 'Not really', 'No', 'Manufacturing & Production', '2025-10-25 12:02:37'),
(196, 'Do you enjoy promoting products or services?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Marketing, Sales & Retail', '2025-10-25 12:02:39'),
(197, 'Are you interested in analyzing market trends?', 'Yes', 'Somewhat', 'Not really', 'No', 'Marketing, Sales & Retail', '2025-10-25 12:02:39'),
(198, 'Do you like communicating with clients or customers?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Marketing, Sales & Retail', '2025-10-25 12:02:39'),
(199, 'Do you enjoy creating advertisements or campaigns?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Marketing, Sales & Retail', '2025-10-25 12:02:39'),
(200, 'Are you comfortable negotiating deals or sales?', 'Yes', 'Somewhat', 'Not really', 'No', 'Marketing, Sales & Retail', '2025-10-25 12:02:39'),
(201, 'Do you enjoy solving scientific or technical problems?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Science, Technology, Engineering & Mathematics (STEM)', '2025-10-25 12:02:39'),
(202, 'Are you interested in mathematics or physics?', 'Yes', 'Somewhat', 'Not really', 'No', 'Science, Technology, Engineering & Mathematics (STEM)', '2025-10-25 12:02:39'),
(203, 'Do you like conducting experiments or research?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Science, Technology, Engineering & Mathematics (STEM)', '2025-10-25 12:02:39'),
(204, 'Do you enjoy designing or building technical projects?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Science, Technology, Engineering & Mathematics (STEM)', '2025-10-25 12:02:39'),
(205, 'Are you interested in engineering or applied sciences?', 'Yes', 'Somewhat', 'Not really', 'No', 'Science, Technology, Engineering & Mathematics (STEM)', '2025-10-25 12:02:39'),
(206, 'Do you enjoy planning transportation or delivery systems?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Transportation, Distribution & Logistics', '2025-10-25 12:02:40'),
(207, 'Are you interested in driving or operating vehicles professionally?', 'Yes', 'Somewhat', 'Not really', 'No', 'Transportation, Distribution & Logistics', '2025-10-25 12:02:40'),
(208, 'Do you like managing supply chains or logistics?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Transportation, Distribution & Logistics', '2025-10-25 12:02:40'),
(209, 'Do you enjoy coordinating shipments and deliveries?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Transportation, Distribution & Logistics', '2025-10-25 12:02:40'),
(210, 'Are you comfortable working in warehouse or distribution settings?', 'Yes', 'Somewhat', 'Not really', 'No', 'Transportation, Distribution & Logistics', '2025-10-25 12:02:40'),
(211, 'Do you enjoy repairing or fixing equipment?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Skilled Trades & Vocational Work', '2025-10-25 12:02:40'),
(212, 'Are you interested in carpentry, plumbing, or electrical work?', 'Yes', 'Somewhat', 'Not really', 'No', 'Skilled Trades & Vocational Work', '2025-10-25 12:02:40'),
(213, 'Do you like working with your hands?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Skilled Trades & Vocational Work', '2025-10-25 12:02:40'),
(214, 'Do you enjoy learning practical technical skills?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Skilled Trades & Vocational Work', '2025-10-25 12:02:40'),
(215, 'Are you interested in operating machinery or tools?', 'Yes', 'Somewhat', 'Not really', 'No', 'Skilled Trades & Vocational Work', '2025-10-25 12:02:40'),
(216, 'Do you enjoy performing music, dance, or theater?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Creative & Performing Arts', '2025-10-25 12:02:41'),
(217, 'Are you interested in visual arts or creative expression?', 'Yes', 'Somewhat', 'Not really', 'No', 'Creative & Performing Arts', '2025-10-25 12:02:41'),
(218, 'Do you like writing scripts, poetry, or stories?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Creative & Performing Arts', '2025-10-25 12:02:41'),
(219, 'Do you enjoy directing or producing creative projects?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Creative & Performing Arts', '2025-10-25 12:02:41'),
(220, 'Are you comfortable performing in front of an audience?', 'Yes', 'Somewhat', 'Not really', 'No', 'Creative & Performing Arts', '2025-10-25 12:02:41'),
(221, 'Do you enjoy starting new projects or businesses?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Entrepreneurship & Start-ups', '2025-10-25 12:02:42'),
(222, 'Are you interested in innovation and creative problem-solving?', 'Yes', 'Somewhat', 'Not really', 'No', 'Entrepreneurship & Start-ups', '2025-10-25 12:02:42'),
(223, 'Do you like taking calculated risks in business?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Entrepreneurship & Start-ups', '2025-10-25 12:02:42'),
(224, 'Do you enjoy managing people and resources?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Entrepreneurship & Start-ups', '2025-10-25 12:02:42'),
(225, 'Are you interested in designing products or services?', 'Yes', 'Somewhat', 'Not really', 'No', 'Entrepreneurship & Start-ups', '2025-10-25 12:02:42'),
(226, 'Do you enjoy collecting and analyzing data?', 'Yes, very much', 'Sometimes', 'Rarely', 'No', 'Research & Data Analytics', '2025-10-25 12:02:42'),
(227, 'Are you interested in research projects and experiments?', 'Yes', 'Somewhat', 'Not really', 'No', 'Research & Data Analytics', '2025-10-25 12:02:42'),
(228, 'Do you like interpreting trends and statistics?', 'Yes', 'Occasionally', 'Rarely', 'No', 'Research & Data Analytics', '2025-10-25 12:02:42'),
(229, 'Do you enjoy writing reports or academic papers?', 'Yes', 'Sometimes', 'Rarely', 'No', 'Research & Data Analytics', '2025-10-25 12:02:42'),
(230, 'Are you interested in evaluating policies or business strategies?', 'Yes', 'Somewhat', 'Not really', 'No', 'Research & Data Analytics', '2025-10-25 12:02:42');

-- --------------------------------------------------------

--
-- Table structure for table `career_recommendations`
--

CREATE TABLE `career_recommendations` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `min_score` int(11) NOT NULL,
  `max_score` int(11) NOT NULL,
  `recommended_careers` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `career_recommendations`
--

INSERT INTO `career_recommendations` (`id`, `category`, `min_score`, `max_score`, `recommended_careers`, `created_at`) VALUES
(121, 'Agriculture & Natural Resources', 0, 5, 'Farm Assistant, Agricultural Technician', '2025-10-25 15:40:32'),
(122, 'Agriculture & Natural Resources', 6, 10, 'Horticulturist, Field Officer', '2025-10-25 15:40:32'),
(123, 'Agriculture & Natural Resources', 11, 15, 'Environmental Scientist, Farm Manager', '2025-10-25 15:40:32'),
(124, 'Agriculture & Natural Resources', 16, 20, 'Agricultural Engineer, Forestry Specialist', '2025-10-25 15:40:32'),
(125, 'Architecture & Construction', 0, 5, 'Construction Assistant, Draftsman', '2025-10-25 15:40:33'),
(126, 'Architecture & Construction', 6, 10, 'Surveyor, Civil Technician', '2025-10-25 15:40:33'),
(127, 'Architecture & Construction', 11, 15, 'Construction Manager, Urban Planner', '2025-10-25 15:40:33'),
(128, 'Architecture & Construction', 16, 20, 'Architect, Civil Engineer', '2025-10-25 15:40:33'),
(129, 'Arts, Design, Entertainment & Media', 0, 5, 'Photography Assistant, Junior Animator', '2025-10-25 15:40:34'),
(130, 'Arts, Design, Entertainment & Media', 6, 10, 'Graphic Designer, Videographer', '2025-10-25 15:40:34'),
(131, 'Arts, Design, Entertainment & Media', 11, 15, 'Animator, Journalist', '2025-10-25 15:40:34'),
(132, 'Arts, Design, Entertainment & Media', 16, 20, 'Film Director, Music Producer', '2025-10-25 15:40:34'),
(133, 'Business Management & Administration', 0, 5, 'Office Clerk, Assistant Coordinator', '2025-10-25 15:40:35'),
(134, 'Business Management & Administration', 6, 10, 'HR Assistant, Junior Manager', '2025-10-25 15:40:35'),
(135, 'Business Management & Administration', 11, 15, 'Operations Manager, Project Coordinator', '2025-10-25 15:40:35'),
(136, 'Business Management & Administration', 16, 20, 'Business Analyst, Executive Manager', '2025-10-25 15:40:35'),
(137, 'Education & Training', 0, 5, 'Teacher Assistant, Tutor', '2025-10-25 15:40:36'),
(138, 'Education & Training', 6, 10, 'Trainer, Curriculum Assistant', '2025-10-25 15:40:36'),
(139, 'Education & Training', 11, 15, 'Teacher, Education Consultant', '2025-10-25 15:40:36'),
(140, 'Education & Training', 16, 20, 'Lecturer, Curriculum Developer', '2025-10-25 15:40:36'),
(141, 'Finance & Accounting', 0, 5, 'Accounts Clerk, Bookkeeper', '2025-10-25 15:40:36'),
(142, 'Finance & Accounting', 6, 10, 'Junior Accountant, Financial Assistant', '2025-10-25 15:40:36'),
(143, 'Finance & Accounting', 11, 15, 'Accountant, Financial Analyst', '2025-10-25 15:40:36'),
(144, 'Finance & Accounting', 16, 20, 'Investment Banker, Auditor', '2025-10-25 15:40:36'),
(145, 'Government, Public Administration & Policy', 0, 5, 'Administrative Assistant, Policy Clerk', '2025-10-25 15:40:37'),
(146, 'Government, Public Administration & Policy', 6, 10, 'Policy Officer, Civil Clerk', '2025-10-25 15:40:37'),
(147, 'Government, Public Administration & Policy', 11, 15, 'Policy Analyst, Public Administrator', '2025-10-25 15:40:37'),
(148, 'Government, Public Administration & Policy', 16, 20, 'Diplomat, Urban Policy Advisor', '2025-10-25 15:40:37'),
(149, 'Health Science & Allied Professions', 0, 5, 'Nursing Assistant, Lab Assistant', '2025-10-25 15:40:37'),
(150, 'Health Science & Allied Professions', 6, 10, 'Physiotherapist Assistant, Nutrition Aide', '2025-10-25 15:40:37'),
(151, 'Health Science & Allied Professions', 11, 15, 'Nurse, Pharmacist', '2025-10-25 15:40:37'),
(152, 'Health Science & Allied Professions', 16, 20, 'Doctor, Laboratory Technologist', '2025-10-25 15:40:37'),
(153, 'Hospitality & Tourism', 0, 5, 'Kitchen Assistant, Front Desk Clerk', '2025-10-25 15:40:39'),
(154, 'Hospitality & Tourism', 6, 10, 'Tour Guide, Event Assistant', '2025-10-25 15:40:39'),
(155, 'Hospitality & Tourism', 11, 15, 'Event Planner, Travel Consultant', '2025-10-25 15:40:39'),
(156, 'Hospitality & Tourism', 16, 20, 'Hotel Manager, Executive Chef', '2025-10-25 15:40:39'),
(157, 'Human Services / Community & Social Services', 0, 5, 'Community Volunteer, Assistant Counselor', '2025-10-25 15:40:43'),
(158, 'Human Services / Community & Social Services', 6, 10, 'Social Worker, NGO Assistant', '2025-10-25 15:40:43'),
(159, 'Human Services / Community & Social Services', 11, 15, 'Counselor, Life Coach', '2025-10-25 15:40:43'),
(160, 'Human Services / Community & Social Services', 16, 20, 'Psychologist, Nonprofit Manager', '2025-10-25 15:40:43'),
(161, 'Information Technology & Computer Science', 0, 5, 'IT Support, Junior Technician', '2025-10-25 15:40:45'),
(162, 'Information Technology & Computer Science', 6, 10, 'Network Administrator, Web Developer', '2025-10-25 15:40:45'),
(163, 'Information Technology & Computer Science', 11, 15, 'Software Developer, Data Analyst', '2025-10-25 15:40:45'),
(164, 'Information Technology & Computer Science', 16, 20, 'Data Scientist, Systems Engineer', '2025-10-25 15:40:45'),
(165, 'Law, Public Safety, Corrections & Security', 0, 5, 'Security Guard, Court Clerk', '2025-10-25 15:42:13'),
(166, 'Law, Public Safety, Corrections & Security', 6, 10, 'Police Officer, Legal Assistant', '2025-10-25 15:42:13'),
(167, 'Law, Public Safety, Corrections & Security', 11, 15, 'Forensic Investigator, Public Safety Officer', '2025-10-25 15:42:13'),
(168, 'Law, Public Safety, Corrections & Security', 16, 20, 'Lawyer, Judge', '2025-10-25 15:42:13'),
(169, 'Manufacturing & Production', 0, 5, 'Assembly Line Worker, Machine Operator', '2025-10-25 15:42:14'),
(170, 'Manufacturing & Production', 6, 10, 'Quality Control Technician, Production Assistant', '2025-10-25 15:42:14'),
(171, 'Manufacturing & Production', 11, 15, 'Production Supervisor, Mechanical Technician', '2025-10-25 15:42:14'),
(172, 'Manufacturing & Production', 16, 20, 'Mechanical Engineer, Plant Manager', '2025-10-25 15:42:14'),
(173, 'Marketing, Sales & Retail', 0, 5, 'Sales Assistant, Marketing Intern', '2025-10-25 15:42:16'),
(174, 'Marketing, Sales & Retail', 6, 10, 'Brand Associate, Retail Manager', '2025-10-25 15:42:16'),
(175, 'Marketing, Sales & Retail', 11, 15, 'Marketing Manager, Market Research Analyst', '2025-10-25 15:42:16'),
(176, 'Marketing, Sales & Retail', 16, 20, 'Sales Director, Brand Strategist', '2025-10-25 15:42:16'),
(177, 'Science, Technology, Engineering & Mathematics (STEM)', 0, 5, 'Lab Assistant, Research Intern', '2025-10-25 15:42:17'),
(178, 'Science, Technology, Engineering & Mathematics (STEM)', 6, 10, 'Technician, Junior Researcher', '2025-10-25 15:42:17'),
(179, 'Science, Technology, Engineering & Mathematics (STEM)', 11, 15, 'Engineer, Biologist, Mathematician', '2025-10-25 15:42:17'),
(180, 'Science, Technology, Engineering & Mathematics (STEM)', 16, 20, 'Research Scientist, Physicist, Chemist', '2025-10-25 15:42:17'),
(181, 'Transportation, Distribution & Logistics', 0, 5, 'Driver Assistant, Warehouse Clerk', '2025-10-25 15:42:17'),
(182, 'Transportation, Distribution & Logistics', 6, 10, 'Logistics Coordinator, Dispatcher', '2025-10-25 15:42:17'),
(183, 'Transportation, Distribution & Logistics', 11, 15, 'Supply Chain Analyst, Transport Officer', '2025-10-25 15:42:17'),
(184, 'Transportation, Distribution & Logistics', 16, 20, 'Transport Manager, Pilot', '2025-10-25 15:42:17'),
(185, 'Skilled Trades & Vocational Work', 0, 5, 'Apprentice Electrician, Junior Mechanic', '2025-10-25 15:42:17'),
(186, 'Skilled Trades & Vocational Work', 6, 10, 'Plumber, Carpenter', '2025-10-25 15:42:17'),
(187, 'Skilled Trades & Vocational Work', 11, 15, 'Mechanic, Electrician', '2025-10-25 15:42:17'),
(188, 'Skilled Trades & Vocational Work', 16, 20, 'Master Welder, Senior Technician', '2025-10-25 15:42:17'),
(189, 'Creative & Performing Arts', 0, 5, 'Art Assistant, Music Student', '2025-10-25 15:42:18'),
(190, 'Creative & Performing Arts', 6, 10, 'Visual Artist, Junior Actor', '2025-10-25 15:42:18'),
(191, 'Creative & Performing Arts', 11, 15, 'Musician, Dancer, Scriptwriter', '2025-10-25 15:42:18'),
(192, 'Creative & Performing Arts', 16, 20, 'Art Director, Professional Actor, Music Producer', '2025-10-25 15:42:18'),
(193, 'Entrepreneurship & Start-ups', 0, 5, 'Business Intern, Product Assistant', '2025-10-25 15:42:18'),
(194, 'Entrepreneurship & Start-ups', 6, 10, 'Business Consultant, Junior Founder', '2025-10-25 15:42:18'),
(195, 'Entrepreneurship & Start-ups', 11, 15, 'Product Designer, Start-up Manager', '2025-10-25 15:42:18'),
(196, 'Entrepreneurship & Start-ups', 16, 20, 'Business Founder, Innovation Manager', '2025-10-25 15:42:18'),
(197, 'Research & Data Analytics', 0, 5, 'Research Assistant, Data Entry Clerk', '2025-10-25 15:42:18'),
(198, 'Research & Data Analytics', 6, 10, 'Data Analyst, Junior Statistician', '2025-10-25 15:42:18'),
(199, 'Research & Data Analytics', 11, 15, 'Policy Researcher, Research Scientist', '2025-10-25 15:42:18'),
(200, 'Research & Data Analytics', 16, 20, 'Senior Data Scientist, Academic Researcher', '2025-10-25 15:42:18');

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

-- --------------------------------------------------------

--
-- Table structure for table `career_traits_map`
--

CREATE TABLE `career_traits_map` (
  `id` int(11) NOT NULL,
  `trait` varchar(50) DEFAULT NULL,
  `recommended_careers` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `career_traits_map`
--

INSERT INTO `career_traits_map` (`id`, `trait`, `recommended_careers`) VALUES
(1, 'Analytical', 'Data Analyst, Software Engineer, Scientist, Financial Analyst'),
(2, 'Creative', 'Graphic Designer, UX Designer, Architect, Writer'),
(3, 'Social', 'Teacher, Counselor, Human Resource Manager'),
(4, 'Organized', 'Project Manager, Administrator, Event Planner'),
(5, 'Technical', 'Technician, Mechanic, IT Support, Engineer'),
(6, 'Teamwork', 'Operations Manager, HR Specialist, Team Coordinator'),
(7, 'Communication', 'Public Relations Officer, Journalist, Marketer'),
(8, 'Emotional Control', 'Police Officer, Nurse, Psychologist');

-- --------------------------------------------------------

--
-- Table structure for table `counselor_reports`
--

CREATE TABLE `counselor_reports` (
  `id` int(11) NOT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `session_date` date DEFAULT NULL,
  `session_topic` varchar(150) DEFAULT NULL,
  `issues_discussed` text DEFAULT NULL,
  `counselor_remarks` text DEFAULT NULL,
  `recommendations` text DEFAULT NULL,
  `next_session` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `counselor_reports`
--

INSERT INTO `counselor_reports` (`id`, `student_name`, `session_date`, `session_topic`, `issues_discussed`, `counselor_remarks`, `recommendations`, `next_session`, `created_at`) VALUES
(1, 'jfhjefd', '2025-12-12', 'fkldjghg', 'sdnjshfj', 'dfhsjf', 'sfshfj', '0000-00-00', '2025-10-24 20:40:58'),
(2, 'student', '2025-12-12', 'career', 'unable to make a career decision', 'to be followed up', 'coperating', '2025-12-23', '2025-10-24 20:59:19'),
(3, 'peter', '2025-12-12', 'career', 'making right career choice', 'progressing well', 'make a right career choice', '2025-12-17', '2025-10-24 21:10:32'),
(4, 'student', '2025-02-12', 'dfdk', 'fdkfhkd', 'djhfskjf', 'sdjshdkj', '1222-12-12', '2025-10-24 21:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_type` enum('student','admin') NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `user_type`, `message`, `is_read`, `created_at`) VALUES
(2, 7, 'admin', 'A counselling session for student (ID 8) has been approved.', 0, '2025-10-14 19:23:34'),
(3, 10, 'student', 'Your counselling session request has been Declined by the counsellor.', 0, '2025-10-14 19:26:50'),
(4, 7, 'admin', 'A counselling session for student (ID 10) has been declined.', 0, '2025-10-14 19:26:50'),
(5, 9, '', 'New counselling session requested by student for Oct 18, 2025 01:00 PM.', 0, '2025-10-14 20:18:03'),
(6, 7, 'admin', 'New counselling session requested by student (session ID: 3).', 0, '2025-10-14 20:18:03'),
(7, 9, '', 'New counselling session requested by student for Oct 10, 2025 12:00 PM.', 0, '2025-10-15 05:31:18'),
(8, 7, 'admin', 'New counselling session requested by student (session ID: 4).', 0, '2025-10-15 05:31:18'),
(10, 7, 'admin', 'A counselling session for student (ID 8) has been approved.', 0, '2025-10-24 20:43:44'),
(12, 7, 'admin', 'A counselling session for student (ID 8) has been approved.', 0, '2025-10-24 20:43:46'),
(13, 9, '', 'New counselling session requested by peter for Dec 12, 2025 10:00 AM.', 0, '2025-10-24 21:08:58'),
(14, 7, 'admin', 'New counselling session requested by peter (session ID: 5).', 0, '2025-10-24 21:08:58'),
(15, 10, 'student', 'Your counselling session request has been Approved by the counsellor.', 0, '2025-10-24 21:09:24'),
(16, 7, 'admin', 'A counselling session for student (ID 10) has been approved.', 0, '2025-10-24 21:09:24'),
(17, 16, '', 'New counselling session requested by peter for Jun 12, 2025 12:00 PM.', 0, '2025-10-31 13:02:55'),
(18, 7, 'admin', 'New counselling session requested by peter (session ID: 6).', 0, '2025-10-31 13:02:56'),
(19, 9, '', 'New counselling session requested by peter for Dec 12, 2025 12:00 PM.', 0, '2025-10-31 13:04:45'),
(20, 7, 'admin', 'New counselling session requested by peter (session ID: 7).', 0, '2025-10-31 13:04:45'),
(21, 10, 'student', 'Your counselling session request has been Approved by the counsellor.', 0, '2025-11-02 18:52:08'),
(22, 7, 'admin', 'A counselling session for student (ID 10) has been approved.', 0, '2025-11-02 18:52:09'),
(23, 9, '', 'New counselling session requested by Vera MIchael for Nov 07, 2025 12:00 PM.', 0, '2025-11-02 19:22:38'),
(24, 7, 'admin', 'New counselling session requested by Vera MIchael (session ID: 8).', 0, '2025-11-02 19:22:38'),
(26, 7, 'admin', 'A counselling session for student (ID 14) has been approved.', 0, '2025-11-02 19:23:02'),
(27, 9, '', 'New counselling session requested by Noah Chepkonga for Nov 07, 2025 12:00 PM.', 0, '2025-11-02 19:44:44'),
(28, 7, 'admin', 'New counselling session requested by Noah Chepkonga (session ID: 9).', 0, '2025-11-02 19:44:44'),
(29, 18, 'student', 'Your counselling session request has been Approved by the counsellor.', 0, '2025-11-02 19:45:10'),
(30, 7, 'admin', 'A counselling session for student (ID 18) has been approved.', 0, '2025-11-02 19:45:10'),
(31, 9, '', 'New counselling session requested by Noah Chepkonga for Nov 12, 2025 12:00 PM.', 0, '2025-11-02 20:00:41'),
(32, 7, 'admin', 'New counselling session requested by Noah Chepkonga (session ID: 10).', 0, '2025-11-02 20:00:41'),
(33, 18, 'student', 'Your counselling session request has been Approved by the counsellor.', 0, '2025-11-02 20:01:07'),
(34, 7, 'admin', 'A counselling session for student (ID 18) has been approved.', 0, '2025-11-02 20:01:07'),
(35, 9, '', 'New counselling session requested by Noah Chepkonga for Nov 12, 2025 12:00 PM.', 0, '2025-11-02 20:07:18'),
(36, 7, 'admin', 'New counselling session requested by Noah Chepkonga (session ID: 11).', 0, '2025-11-02 20:07:18'),
(37, 9, '', 'New counselling session requested by Noah Chepkonga for Nov 12, 2025 12:00 PM.', 0, '2025-11-02 20:15:12'),
(38, 7, 'admin', 'New counselling session requested by Noah Chepkonga (session ID: 12).', 0, '2025-11-02 20:15:12'),
(39, 9, '', 'New counselling session requested by Noah Chepkonga for Nov 12, 2025 11:00 AM.', 0, '2025-11-02 20:22:44'),
(40, 7, 'admin', 'New counselling session requested by Noah Chepkonga (session ID: 13).', 0, '2025-11-02 20:22:44'),
(41, 9, '', 'New counselling session requested by Noah Chepkonga for Nov 12, 2025 12:00 PM.', 0, '2025-11-03 11:05:22'),
(42, 7, 'admin', 'New counselling session requested by Noah Chepkonga (session ID: 14).', 0, '2025-11-03 11:05:22'),
(43, 9, '', 'New counselling session requested by Noah Chepkonga for Nov 12, 2025 12:00 PM.', 0, '2025-11-03 11:05:22'),
(44, 7, 'admin', 'New counselling session requested by Noah Chepkonga (session ID: 15).', 0, '2025-11-03 11:05:22'),
(45, 9, '', 'New counselling session requested by VERA MICHAEL for Nov 07, 2025 03:00 PM.', 0, '2025-11-03 11:18:45'),
(46, 7, 'admin', 'New counselling session requested by VERA MICHAEL (session ID: 16).', 0, '2025-11-03 11:18:46');

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
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `session_mode` varchar(50) DEFAULT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `meeting_link` varchar(255) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `whatsapp_link` varchar(255) DEFAULT NULL,
  `additional_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `student_id`, `counsellor_id`, `session_date`, `mode`, `notes`, `action_plan`, `status`, `created_at`, `updated_at`, `session_mode`, `venue`, `meeting_link`, `phone_number`, `whatsapp_link`, `additional_info`) VALUES
(12, 18, 9, '2025-11-12 12:00:00', 'Online', 'aas', 'aasasasa', 'approved', '2025-11-02 23:15:11', '2025-11-02 23:15:54', 'Online', '', 'https://us05web.zoom.us/j/84117395070?pwd=vQgfBpb7p7JvCpbfobQm2cTqTXO8ro.1', '', '', ''),
(13, 18, 9, '2025-11-12 11:00:00', 'Online', 'zxzxz', 'sdfgdc', 'approved', '2025-11-02 23:22:43', '2025-11-02 23:23:24', 'Online', '', 'https://us05web.zoom.us/j/84117395070?pwd=vQgfBpb7p7JvCpbfobQm2cTqTXO8ro.1', '', '', 'bvjh'),
(14, 18, 9, '2025-11-12 12:00:00', 'Online', 'career decision', 'To make the right career choice', 'approved', '2025-11-03 14:05:22', '2025-11-03 14:06:56', 'Online', '', 'https://us05web.zoom.us/j/84117395070?pwd=vQgfBpb7p7JvCpbfobQm2cTqTXO8ro.1', '', '', ''),
(15, 18, 9, '2025-11-12 12:00:00', 'Online', 'career decision', 'To make the right career choice', 'pending', '2025-11-03 14:05:22', '2025-11-03 14:05:22', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 19, 9, '2025-11-07 15:00:00', 'Online', 'Performance issue', 'To improve my Grades', 'approved', '2025-11-03 14:18:45', '2025-11-03 14:21:35', 'WhatsApp', '', '', '', 'https://wa.me/+254759768770', '');

-- --------------------------------------------------------

--
-- Table structure for table `student_career_results`
--

CREATE TABLE `student_career_results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `total_score` int(11) NOT NULL,
  `recommendation` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_career_results`
--

INSERT INTO `student_career_results` (`id`, `student_id`, `category`, `total_score`, `recommendation`, `created_at`) VALUES
(10, 10, 'Interests', 36, 'Technician, Customer Service Representative, Office Administrator', '2025-10-25 13:24:02'),
(13, 10, 'Personality', 20, 'Security Guard, Manual Laborer, Machine Operator', '2025-10-25 13:59:00'),
(15, 10, 'Agriculture & Natural Resources', 13, 'Environmental Scientist, Farm Manager', '2025-11-10 16:29:35'),
(16, 10, 'Research & Data Analytics', 19, 'Senior Data Scientist, Academic Researcher', '2025-10-25 15:56:51'),
(37, 10, 'Finance & Accounting', 10, 'Junior Accountant, Financial Assistant', '2025-10-26 20:00:33'),
(38, 10, 'Hospitality & Tourism', 19, 'Hotel Manager, Executive Chef', '2025-10-26 19:56:48'),
(42, 10, 'Architecture & Construction', 14, 'Construction Manager, Urban Planner', '2025-11-10 16:01:51');

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
(11, 10, 'IT', 'Jan-April', 67.00, 'Second Upper', '2025-09-22 16:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `student_responses`
--

CREATE TABLE `student_responses` (
  `id` int(11) NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_option` char(1) NOT NULL,
  `category` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_responses`
--

INSERT INTO `student_responses` (`id`, `student_id`, `question_id`, `selected_option`, `category`, `created_at`) VALUES
(399, 10, 226, 'A', 'Research & Data Analytics', '2025-10-25 12:44:19'),
(400, 10, 227, 'A', 'Research & Data Analytics', '2025-10-25 12:44:19'),
(401, 10, 228, 'A', 'Research & Data Analytics', '2025-10-25 12:44:19'),
(402, 10, 229, 'B', 'Research & Data Analytics', '2025-10-25 12:44:19'),
(403, 10, 230, 'A', 'Research & Data Analytics', '2025-10-25 12:44:19'),
(404, 10, 226, 'A', 'Research & Data Analytics', '2025-10-25 12:45:10'),
(405, 10, 227, 'A', 'Research & Data Analytics', '2025-10-25 12:45:10'),
(406, 10, 228, 'A', 'Research & Data Analytics', '2025-10-25 12:45:10'),
(407, 10, 229, 'B', 'Research & Data Analytics', '2025-10-25 12:45:10'),
(408, 10, 230, 'A', 'Research & Data Analytics', '2025-10-25 12:45:10'),
(409, 10, 226, 'A', 'Research & Data Analytics', '2025-10-25 12:46:37'),
(410, 10, 227, 'A', 'Research & Data Analytics', '2025-10-25 12:46:37'),
(411, 10, 228, 'A', 'Research & Data Analytics', '2025-10-25 12:46:37'),
(412, 10, 229, 'B', 'Research & Data Analytics', '2025-10-25 12:46:37'),
(413, 10, 230, 'A', 'Research & Data Analytics', '2025-10-25 12:46:37'),
(414, 10, 226, 'A', 'Research & Data Analytics', '2025-10-25 12:56:51'),
(415, 10, 227, 'A', 'Research & Data Analytics', '2025-10-25 12:56:51'),
(416, 10, 228, 'A', 'Research & Data Analytics', '2025-10-25 12:56:51'),
(417, 10, 229, 'B', 'Research & Data Analytics', '2025-10-25 12:56:51'),
(418, 10, 230, 'A', 'Research & Data Analytics', '2025-10-25 12:56:51'),
(419, 10, 156, 'A', 'Finance & Accounting', '2025-10-25 12:57:16'),
(420, 10, 157, 'A', 'Finance & Accounting', '2025-10-25 12:57:16'),
(421, 10, 158, 'A', 'Finance & Accounting', '2025-10-25 12:57:16'),
(422, 10, 159, 'A', 'Finance & Accounting', '2025-10-25 12:57:16'),
(423, 10, 160, 'A', 'Finance & Accounting', '2025-10-25 12:57:16'),
(424, 10, 171, 'A', 'Hospitality & Tourism', '2025-10-26 16:56:47'),
(425, 10, 172, 'B', 'Hospitality & Tourism', '2025-10-26 16:56:47'),
(426, 10, 173, 'A', 'Hospitality & Tourism', '2025-10-26 16:56:47'),
(427, 10, 174, 'A', 'Hospitality & Tourism', '2025-10-26 16:56:47'),
(428, 10, 175, 'A', 'Hospitality & Tourism', '2025-10-26 16:56:47'),
(429, 10, 156, 'A', 'Finance & Accounting', '2025-10-26 16:58:04'),
(430, 10, 157, 'A', 'Finance & Accounting', '2025-10-26 16:58:04'),
(431, 10, 158, 'A', 'Finance & Accounting', '2025-10-26 16:58:04'),
(432, 10, 159, 'A', 'Finance & Accounting', '2025-10-26 16:58:04'),
(433, 10, 160, 'A', 'Finance & Accounting', '2025-10-26 16:58:04'),
(434, 10, 156, 'D', 'Finance & Accounting', '2025-10-26 16:58:54'),
(435, 10, 157, 'D', 'Finance & Accounting', '2025-10-26 16:58:54'),
(436, 10, 158, 'D', 'Finance & Accounting', '2025-10-26 16:58:54'),
(437, 10, 159, 'D', 'Finance & Accounting', '2025-10-26 16:58:54'),
(438, 10, 160, 'D', 'Finance & Accounting', '2025-10-26 16:58:54'),
(439, 10, 156, 'C', 'Finance & Accounting', '2025-10-26 17:00:33'),
(440, 10, 157, 'C', 'Finance & Accounting', '2025-10-26 17:00:33'),
(441, 10, 158, 'C', 'Finance & Accounting', '2025-10-26 17:00:33'),
(442, 10, 159, 'C', 'Finance & Accounting', '2025-10-26 17:00:33'),
(443, 10, 160, 'C', 'Finance & Accounting', '2025-10-26 17:00:33'),
(444, 10, 136, 'A', 'Architecture & Construction', '2025-11-10 13:01:51'),
(445, 10, 137, 'B', 'Architecture & Construction', '2025-11-10 13:01:51'),
(446, 10, 138, 'C', 'Architecture & Construction', '2025-11-10 13:01:51'),
(447, 10, 139, 'C', 'Architecture & Construction', '2025-11-10 13:01:51'),
(448, 10, 140, 'B', 'Architecture & Construction', '2025-11-10 13:01:51'),
(449, 10, 131, 'B', 'Agriculture & Natural Resources', '2025-11-10 13:29:35'),
(450, 10, 132, 'B', 'Agriculture & Natural Resources', '2025-11-10 13:29:35'),
(451, 10, 133, 'B', 'Agriculture & Natural Resources', '2025-11-10 13:29:35'),
(452, 10, 134, 'C', 'Agriculture & Natural Resources', '2025-11-10 13:29:35'),
(453, 10, 135, 'C', 'Agriculture & Natural Resources', '2025-11-10 13:29:35');

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
(9, 'coun123', 'counsellor', 'counsellor@gmail.com', NULL, '$2y$10$7qXulWihk69F/oBSCs9CweF54DWQ49fUQRk8ZUUEy1zwFAGnY8WwK', 'counsellor', 'active', '2025-09-22 11:44:27'),
(10, 'std001', 'peter', 'peter@gmail.com', 'uploads/68dfe82b3783b.jpg', '$2y$10$SsNPkIi4h8Wi.1sLX6wlaepRJpJIFWWuTTYfSNghqADt9VrXpBfLS', 'student', 'active', '2025-09-22 15:54:06'),
(11, 'CL001', 'Dr. Isaac', 'Isaac@orientacore.ac.ke', NULL, '$2y$10$bX7onl2h1emWEOI4wR0mYOqDATiun0/AaALE8E6AKk9EQywk2js/.', 'counsellor', 'active', '2025-09-22 15:57:58'),
(13, 'std002', 'Andrew', 'andrew@orientacore.ac.ke', NULL, '$2y$10$8m3Zgv4Aj9AnM1V6uGkSQOCgzQ0Cy3sAsDdF8.prRmJuLFohKPXDm', 'student', 'active', '2025-09-22 16:49:40'),
(16, 'Con1234', 'counsellor', 'cousellor@gmail.com', NULL, '$2y$10$4jq3UvmjRZq8wKAfO7on8eW6rwSVJUstgVrYJaG655kCY3QKNxDr.', 'counsellor', 'active', '2025-10-03 14:25:56'),
(18, 'BIT/2024/43255', 'Noah Chepkonga', 'noahchep1@gmail.com', NULL, '$2y$10$EyefJwceCAc8asAd31CBxuSEGBA58bCQan63lOcEi9zdzNKoNQOTi', 'student', 'active', '2025-11-02 19:31:18'),
(19, 'BIT/2024/46612', 'VERA MICHAEL', 'veramichael678@gmail.com', NULL, '$2y$10$SiPMN4RhNlrcEvsGCWE3W.qnw/dF0lQWu3wDh9okVHFXSgQSZHt6C', 'student', 'active', '2025-11-03 11:11:57');

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
-- Indexes for table `behavior_questions`
--
ALTER TABLE `behavior_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `behavior_responses`
--
ALTER TABLE `behavior_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `behavior_suggestions`
--
ALTER TABLE `behavior_suggestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `career_assessments`
--
ALTER TABLE `career_assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_career_assessments_user` (`user_id`);

--
-- Indexes for table `career_category_scores`
--
ALTER TABLE `career_category_scores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_category` (`student_id`,`category`);

--
-- Indexes for table `career_questions`
--
ALTER TABLE `career_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `career_recommendations`
--
ALTER TABLE `career_recommendations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `career_suggestions`
--
ALTER TABLE `career_suggestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `career_traits_map`
--
ALTER TABLE `career_traits_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `counselor_reports`
--
ALTER TABLE `counselor_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sessions_student` (`student_id`),
  ADD KEY `fk_sessions_counsellor` (`counsellor_id`);

--
-- Indexes for table `student_career_results`
--
ALTER TABLE `student_career_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`category`);

--
-- Indexes for table `student_performance`
--
ALTER TABLE `student_performance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_semester` (`student_id`,`semester`);

--
-- Indexes for table `student_responses`
--
ALTER TABLE `student_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `question_id` (`question_id`);

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
-- AUTO_INCREMENT for table `behavior_questions`
--
ALTER TABLE `behavior_questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `behavior_responses`
--
ALTER TABLE `behavior_responses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `behavior_suggestions`
--
ALTER TABLE `behavior_suggestions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `career_assessments`
--
ALTER TABLE `career_assessments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `career_category_scores`
--
ALTER TABLE `career_category_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `career_questions`
--
ALTER TABLE `career_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `career_recommendations`
--
ALTER TABLE `career_recommendations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `career_suggestions`
--
ALTER TABLE `career_suggestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `career_traits_map`
--
ALTER TABLE `career_traits_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `counselor_reports`
--
ALTER TABLE `counselor_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `student_career_results`
--
ALTER TABLE `student_career_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `student_performance`
--
ALTER TABLE `student_performance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `student_responses`
--
ALTER TABLE `student_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=454;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `behavior_responses`
--
ALTER TABLE `behavior_responses`
  ADD CONSTRAINT `behavior_responses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `behavior_responses_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `behavior_questions` (`id`);

--
-- Constraints for table `career_assessments`
--
ALTER TABLE `career_assessments`
  ADD CONSTRAINT `fk_career_assessments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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

--
-- Constraints for table `student_responses`
--
ALTER TABLE `student_responses`
  ADD CONSTRAINT `student_responses_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_responses_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `career_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
