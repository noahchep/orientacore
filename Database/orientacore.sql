-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2025 at 12:26 AM
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
(24, 10, 'Career Fit Test', '{\"16\":{\"question_id\":\"16\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"17\":{\"question_id\":\"17\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"18\":{\"question_id\":\"18\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"19\":{\"question_id\":\"19\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"20\":{\"question_id\":\"20\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"21\":{\"question_id\":\"21\",\"answer\":\"D\",\"category\":\"Creative\",\"score\":1},\"22\":{\"question_id\":\"22\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"23\":{\"question_id\":\"23\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"24\":{\"question_id\":\"24\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"25\":{\"question_id\":\"25\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"26\":{\"question_id\":\"26\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"27\":{\"question_id\":\"27\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"28\":{\"question_id\":\"28\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"29\":{\"question_id\":\"29\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"30\":{\"question_id\":\"30\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"31\":{\"question_id\":\"31\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"32\":{\"question_id\":\"32\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"33\":{\"question_id\":\"33\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"34\":{\"question_id\":\"34\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"35\":{\"question_id\":\"35\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"36\":{\"question_id\":\"36\",\"answer\":\"D\",\"category\":\"Social\",\"score\":1},\"37\":{\"question_id\":\"37\",\"answer\":\"D\",\"category\":\"Social\",\"score\":1},\"38\":{\"question_id\":\"38\",\"answer\":\"C\",\"category\":\"Social\",\"score\":2},\"39\":{\"question_id\":\"39\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"40\":{\"question_id\":\"40\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"41\":{\"question_id\":\"41\",\"answer\":\"C\",\"category\":\"Practical\",\"score\":2},\"42\":{\"question_id\":\"42\",\"answer\":\"A\",\"category\":\"Practical\",\"score\":4},\"43\":{\"question_id\":\"43\",\"answer\":\"A\",\"category\":\"Practical\",\"score\":4},\"44\":{\"question_id\":\"44\",\"answer\":\"C\",\"category\":\"Practical\",\"score\":2},\"45\":{\"question_id\":\"45\",\"answer\":\"B\",\"category\":\"Practical\",\"score\":3}}', '67', 'Graphic Designer', '2025-10-10 08:30:04', NULL),
(25, 10, 'Career Fit Test', '{\"16\":{\"question_id\":\"16\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"17\":{\"question_id\":\"17\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"18\":{\"question_id\":\"18\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"19\":{\"question_id\":\"19\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"20\":{\"question_id\":\"20\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"21\":{\"question_id\":\"21\",\"answer\":\"D\",\"category\":\"Creative\",\"score\":1},\"22\":{\"question_id\":\"22\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"23\":{\"question_id\":\"23\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"24\":{\"question_id\":\"24\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"25\":{\"question_id\":\"25\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"26\":{\"question_id\":\"26\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"27\":{\"question_id\":\"27\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"28\":{\"question_id\":\"28\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"29\":{\"question_id\":\"29\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"30\":{\"question_id\":\"30\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"31\":{\"question_id\":\"31\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"32\":{\"question_id\":\"32\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"33\":{\"question_id\":\"33\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"34\":{\"question_id\":\"34\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"35\":{\"question_id\":\"35\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"36\":{\"question_id\":\"36\",\"answer\":\"D\",\"category\":\"Social\",\"score\":1},\"37\":{\"question_id\":\"37\",\"answer\":\"D\",\"category\":\"Social\",\"score\":1},\"38\":{\"question_id\":\"38\",\"answer\":\"C\",\"category\":\"Social\",\"score\":2},\"39\":{\"question_id\":\"39\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"40\":{\"question_id\":\"40\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"41\":{\"question_id\":\"41\",\"answer\":\"C\",\"category\":\"Practical\",\"score\":2},\"42\":{\"question_id\":\"42\",\"answer\":\"A\",\"category\":\"Practical\",\"score\":4},\"43\":{\"question_id\":\"43\",\"answer\":\"A\",\"category\":\"Practical\",\"score\":4},\"44\":{\"question_id\":\"44\",\"answer\":\"C\",\"category\":\"Practical\",\"score\":2},\"45\":{\"question_id\":\"45\",\"answer\":\"B\",\"category\":\"Practical\",\"score\":3}}', '67', 'Graphic Designer', '2025-10-10 08:31:42', NULL),
(26, 10, 'Career Fit Test', '{\"16\":{\"question_id\":\"16\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"17\":{\"question_id\":\"17\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"18\":{\"question_id\":\"18\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"19\":{\"question_id\":\"19\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"20\":{\"question_id\":\"20\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"21\":{\"question_id\":\"21\",\"answer\":\"D\",\"category\":\"Creative\",\"score\":1},\"22\":{\"question_id\":\"22\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"23\":{\"question_id\":\"23\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"24\":{\"question_id\":\"24\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"25\":{\"question_id\":\"25\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"26\":{\"question_id\":\"26\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"27\":{\"question_id\":\"27\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"28\":{\"question_id\":\"28\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"29\":{\"question_id\":\"29\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"30\":{\"question_id\":\"30\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"31\":{\"question_id\":\"31\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"32\":{\"question_id\":\"32\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"33\":{\"question_id\":\"33\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"34\":{\"question_id\":\"34\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"35\":{\"question_id\":\"35\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"36\":{\"question_id\":\"36\",\"answer\":\"D\",\"category\":\"Social\",\"score\":1},\"37\":{\"question_id\":\"37\",\"answer\":\"D\",\"category\":\"Social\",\"score\":1},\"38\":{\"question_id\":\"38\",\"answer\":\"C\",\"category\":\"Social\",\"score\":2},\"39\":{\"question_id\":\"39\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"40\":{\"question_id\":\"40\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"41\":{\"question_id\":\"41\",\"answer\":\"C\",\"category\":\"Practical\",\"score\":2},\"42\":{\"question_id\":\"42\",\"answer\":\"A\",\"category\":\"Practical\",\"score\":4},\"43\":{\"question_id\":\"43\",\"answer\":\"A\",\"category\":\"Practical\",\"score\":4},\"44\":{\"question_id\":\"44\",\"answer\":\"C\",\"category\":\"Practical\",\"score\":2},\"45\":{\"question_id\":\"45\",\"answer\":\"B\",\"category\":\"Practical\",\"score\":3}}', '67', 'Graphic Designer', '2025-10-10 08:32:14', NULL),
(27, 10, 'Career Fit Test', '{\"16\":{\"question_id\":\"16\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"17\":{\"question_id\":\"17\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"18\":{\"question_id\":\"18\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"19\":{\"question_id\":\"19\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"20\":{\"question_id\":\"20\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"21\":{\"question_id\":\"21\",\"answer\":\"D\",\"category\":\"Creative\",\"score\":1},\"22\":{\"question_id\":\"22\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"23\":{\"question_id\":\"23\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"24\":{\"question_id\":\"24\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"25\":{\"question_id\":\"25\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"26\":{\"question_id\":\"26\",\"answer\":\"D\",\"category\":\"Analytical\",\"score\":1},\"27\":{\"question_id\":\"27\",\"answer\":\"A\",\"category\":\"Analytical\",\"score\":4},\"28\":{\"question_id\":\"28\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"29\":{\"question_id\":\"29\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"30\":{\"question_id\":\"30\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"31\":{\"question_id\":\"31\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"32\":{\"question_id\":\"32\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"33\":{\"question_id\":\"33\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"34\":{\"question_id\":\"34\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"35\":{\"question_id\":\"35\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"36\":{\"question_id\":\"36\",\"answer\":\"C\",\"category\":\"Social\",\"score\":2},\"37\":{\"question_id\":\"37\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"38\":{\"question_id\":\"38\",\"answer\":\"C\",\"category\":\"Social\",\"score\":2},\"39\":{\"question_id\":\"39\",\"answer\":\"C\",\"category\":\"Social\",\"score\":2},\"40\":{\"question_id\":\"40\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"41\":{\"question_id\":\"41\",\"answer\":\"B\",\"category\":\"Practical\",\"score\":3},\"42\":{\"question_id\":\"42\",\"answer\":\"C\",\"category\":\"Practical\",\"score\":2},\"43\":{\"question_id\":\"43\",\"answer\":\"C\",\"category\":\"Practical\",\"score\":2},\"44\":{\"question_id\":\"44\",\"answer\":\"C\",\"category\":\"Practical\",\"score\":2},\"45\":{\"question_id\":\"45\",\"answer\":\"D\",\"category\":\"Practical\",\"score\":1}}', '70', 'Analytical|Data Scientist', '2025-10-10 08:34:54', NULL),
(28, 10, 'Career Fit Test', '{\"16\":{\"question_id\":\"16\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"17\":{\"question_id\":\"17\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"18\":{\"question_id\":\"18\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"19\":{\"question_id\":\"19\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"20\":{\"question_id\":\"20\",\"answer\":\"D\",\"category\":\"Creative\",\"score\":1},\"21\":{\"question_id\":\"21\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"22\":{\"question_id\":\"22\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"23\":{\"question_id\":\"23\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"24\":{\"question_id\":\"24\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"26\":{\"question_id\":\"26\",\"answer\":\"A\",\"category\":\"Analytical\",\"score\":4},\"27\":{\"question_id\":\"27\",\"answer\":\"A\",\"category\":\"Analytical\",\"score\":4},\"28\":{\"question_id\":\"28\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"29\":{\"question_id\":\"29\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"30\":{\"question_id\":\"30\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"31\":{\"question_id\":\"31\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"32\":{\"question_id\":\"32\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"33\":{\"question_id\":\"33\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"34\":{\"question_id\":\"34\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"35\":{\"question_id\":\"35\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"36\":{\"question_id\":\"36\",\"answer\":\"C\",\"category\":\"Social\",\"score\":2},\"37\":{\"question_id\":\"37\",\"answer\":\"C\",\"category\":\"Social\",\"score\":2},\"38\":{\"question_id\":\"38\",\"answer\":\"C\",\"category\":\"Social\",\"score\":2},\"39\":{\"question_id\":\"39\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"40\":{\"question_id\":\"40\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"42\":{\"question_id\":\"42\",\"answer\":\"B\",\"category\":\"Practical\",\"score\":3},\"43\":{\"question_id\":\"43\",\"answer\":\"B\",\"category\":\"Practical\",\"score\":3},\"44\":{\"question_id\":\"44\",\"answer\":\"B\",\"category\":\"Practical\",\"score\":3},\"45\":{\"question_id\":\"45\",\"answer\":\"C\",\"category\":\"Practical\",\"score\":2}}', '70', 'Analytical|Data Scientist', '2025-10-10 10:21:37', NULL),
(29, 10, 'Career Fit Test', '{\"16\":{\"question_id\":\"16\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"17\":{\"question_id\":\"17\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"18\":{\"question_id\":\"18\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"19\":{\"question_id\":\"19\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"20\":{\"question_id\":\"20\",\"answer\":\"D\",\"category\":\"Creative\",\"score\":1},\"21\":{\"question_id\":\"21\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"22\":{\"question_id\":\"22\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"23\":{\"question_id\":\"23\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"24\":{\"question_id\":\"24\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"26\":{\"question_id\":\"26\",\"answer\":\"A\",\"category\":\"Analytical\",\"score\":4},\"27\":{\"question_id\":\"27\",\"answer\":\"A\",\"category\":\"Analytical\",\"score\":4},\"28\":{\"question_id\":\"28\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"29\":{\"question_id\":\"29\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"30\":{\"question_id\":\"30\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"31\":{\"question_id\":\"31\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"32\":{\"question_id\":\"32\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"33\":{\"question_id\":\"33\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"34\":{\"question_id\":\"34\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"35\":{\"question_id\":\"35\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"36\":{\"question_id\":\"36\",\"answer\":\"C\",\"category\":\"Social\",\"score\":2},\"37\":{\"question_id\":\"37\",\"answer\":\"C\",\"category\":\"Social\",\"score\":2},\"38\":{\"question_id\":\"38\",\"answer\":\"C\",\"category\":\"Social\",\"score\":2},\"39\":{\"question_id\":\"39\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"40\":{\"question_id\":\"40\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"42\":{\"question_id\":\"42\",\"answer\":\"B\",\"category\":\"Practical\",\"score\":3},\"43\":{\"question_id\":\"43\",\"answer\":\"B\",\"category\":\"Practical\",\"score\":3},\"44\":{\"question_id\":\"44\",\"answer\":\"B\",\"category\":\"Practical\",\"score\":3},\"45\":{\"question_id\":\"45\",\"answer\":\"C\",\"category\":\"Practical\",\"score\":2}}', '70', 'Analytical|Data Scientist', '2025-10-10 10:28:26', NULL),
(30, 8, 'Career Fit Test', '{\"16\":{\"question_id\":\"16\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"17\":{\"question_id\":\"17\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"18\":{\"question_id\":\"18\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"19\":{\"question_id\":\"19\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"20\":{\"question_id\":\"20\",\"answer\":\"A\",\"category\":\"Creative\",\"score\":4},\"21\":{\"question_id\":\"21\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"22\":{\"question_id\":\"22\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"23\":{\"question_id\":\"23\",\"answer\":\"B\",\"category\":\"Creative\",\"score\":3},\"24\":{\"question_id\":\"24\",\"answer\":\"C\",\"category\":\"Creative\",\"score\":2},\"26\":{\"question_id\":\"26\",\"answer\":\"A\",\"category\":\"Analytical\",\"score\":4},\"27\":{\"question_id\":\"27\",\"answer\":\"A\",\"category\":\"Analytical\",\"score\":4},\"28\":{\"question_id\":\"28\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"29\":{\"question_id\":\"29\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"30\":{\"question_id\":\"30\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"31\":{\"question_id\":\"31\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"32\":{\"question_id\":\"32\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"33\":{\"question_id\":\"33\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"34\":{\"question_id\":\"34\",\"answer\":\"B\",\"category\":\"Analytical\",\"score\":3},\"35\":{\"question_id\":\"35\",\"answer\":\"C\",\"category\":\"Analytical\",\"score\":2},\"36\":{\"question_id\":\"36\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"37\":{\"question_id\":\"37\",\"answer\":\"A\",\"category\":\"Social\",\"score\":4},\"38\":{\"question_id\":\"38\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"39\":{\"question_id\":\"39\",\"answer\":\"B\",\"category\":\"Social\",\"score\":3},\"40\":{\"question_id\":\"40\",\"answer\":\"C\",\"category\":\"Social\",\"score\":2},\"42\":{\"question_id\":\"42\",\"answer\":\"C\",\"category\":\"Practical\",\"score\":2},\"43\":{\"question_id\":\"43\",\"answer\":\"C\",\"category\":\"Practical\",\"score\":2},\"44\":{\"question_id\":\"44\",\"answer\":\"B\",\"category\":\"Practical\",\"score\":3},\"45\":{\"question_id\":\"45\",\"answer\":\"B\",\"category\":\"Practical\",\"score\":3}}', '80', 'Analytical|Data Scientist', '2025-10-10 11:29:08', NULL),
(31, 10, 'Career Fit Test', '{\"56\":{\"question_id\":\"56\",\"answer\":\"B\",\"category\":\"Interests\",\"score\":3},\"57\":{\"question_id\":\"57\",\"answer\":\"A\",\"category\":\"Interests\",\"score\":4},\"58\":{\"question_id\":\"58\",\"answer\":\"A\",\"category\":\"Interests\",\"score\":4},\"59\":{\"question_id\":\"59\",\"answer\":\"D\",\"category\":\"Interests\",\"score\":1},\"60\":{\"question_id\":\"60\",\"answer\":\"C\",\"category\":\"Interests\",\"score\":2},\"61\":{\"question_id\":\"61\",\"answer\":\"C\",\"category\":\"Interests\",\"score\":2},\"62\":{\"question_id\":\"62\",\"answer\":\"C\",\"category\":\"Interests\",\"score\":2},\"63\":{\"question_id\":\"63\",\"answer\":\"C\",\"category\":\"Interests\",\"score\":2},\"64\":{\"question_id\":\"64\",\"answer\":\"D\",\"category\":\"Interests\",\"score\":1},\"65\":{\"question_id\":\"65\",\"answer\":\"C\",\"category\":\"Interests\",\"score\":2}}', '23', 'No suggestion available.', '2025-10-10 11:40:39', NULL),
(32, 10, 'Career Fit Test', '{\"56\":{\"question_id\":\"56\",\"answer\":\"C\",\"category\":\"Interests\",\"score\":2},\"57\":{\"question_id\":\"57\",\"answer\":\"B\",\"category\":\"Interests\",\"score\":3},\"58\":{\"question_id\":\"58\",\"answer\":\"B\",\"category\":\"Interests\",\"score\":3},\"59\":{\"question_id\":\"59\",\"answer\":\"C\",\"category\":\"Interests\",\"score\":2},\"60\":{\"question_id\":\"60\",\"answer\":\"C\",\"category\":\"Interests\",\"score\":2},\"61\":{\"question_id\":\"61\",\"answer\":\"C\",\"category\":\"Interests\",\"score\":2},\"62\":{\"question_id\":\"62\",\"answer\":\"C\",\"category\":\"Interests\",\"score\":2},\"63\":{\"question_id\":\"63\",\"answer\":\"C\",\"category\":\"Interests\",\"score\":2},\"64\":{\"question_id\":\"64\",\"answer\":\"C\",\"category\":\"Interests\",\"score\":2},\"65\":{\"question_id\":\"65\",\"answer\":\"C\",\"category\":\"Interests\",\"score\":2},\"66\":{\"question_id\":\"66\",\"answer\":\"C\",\"category\":\"Personality\",\"score\":2},\"67\":{\"question_id\":\"67\",\"answer\":\"C\",\"category\":\"Personality\",\"score\":2},\"68\":{\"question_id\":\"68\",\"answer\":\"C\",\"category\":\"Personality\",\"score\":2},\"69\":{\"question_id\":\"69\",\"answer\":\"C\",\"category\":\"Personality\",\"score\":2},\"70\":{\"question_id\":\"70\",\"answer\":\"C\",\"category\":\"Personality\",\"score\":2},\"71\":{\"question_id\":\"71\",\"answer\":\"C\",\"category\":\"Skills\",\"score\":2},\"72\":{\"question_id\":\"72\",\"answer\":\"C\",\"category\":\"Skills\",\"score\":2},\"73\":{\"question_id\":\"73\",\"answer\":\"C\",\"category\":\"Skills\",\"score\":2},\"74\":{\"question_id\":\"74\",\"answer\":\"C\",\"category\":\"Skills\",\"score\":2},\"75\":{\"question_id\":\"75\",\"answer\":\"C\",\"category\":\"Skills\",\"score\":2},\"76\":{\"question_id\":\"76\",\"answer\":\"A\",\"category\":\"Work Preference\",\"score\":4},\"77\":{\"question_id\":\"77\",\"answer\":\"C\",\"category\":\"Work Preference\",\"score\":2},\"78\":{\"question_id\":\"78\",\"answer\":\"D\",\"category\":\"Work Preference\",\"score\":1},\"79\":{\"question_id\":\"79\",\"answer\":\"B\",\"category\":\"Work Preference\",\"score\":3},\"80\":{\"question_id\":\"80\",\"answer\":\"B\",\"category\":\"Work Preference\",\"score\":3}}', '55', 'No suggestion available.', '2025-10-10 12:19:36', NULL),
(33, 10, 'Career Fit Test', '{\"76\":{\"question_id\":\"76\",\"answer\":\"A\",\"category\":\"Work Preference\",\"score\":4},\"77\":{\"question_id\":\"77\",\"answer\":\"B\",\"category\":\"Work Preference\",\"score\":3},\"78\":{\"question_id\":\"78\",\"answer\":\"D\",\"category\":\"Work Preference\",\"score\":1},\"79\":{\"question_id\":\"79\",\"answer\":\"D\",\"category\":\"Work Preference\",\"score\":1},\"80\":{\"question_id\":\"80\",\"answer\":\"B\",\"category\":\"Work Preference\",\"score\":3}}', '12', 'No suggestion available.', '2025-10-10 12:26:47', NULL),
(34, 10, 'Career Fit Test', '{\"76\":{\"question_id\":\"76\",\"answer\":\"A\",\"category\":\"Work Preference\",\"score\":4},\"77\":{\"question_id\":\"77\",\"answer\":\"A\",\"category\":\"Work Preference\",\"score\":4},\"78\":{\"question_id\":\"78\",\"answer\":\"A\",\"category\":\"Work Preference\",\"score\":4},\"79\":{\"question_id\":\"79\",\"answer\":\"A\",\"category\":\"Work Preference\",\"score\":4},\"80\":{\"question_id\":\"80\",\"answer\":\"A\",\"category\":\"Work Preference\",\"score\":4}}', '20', 'No suggestion available.', '2025-10-10 12:27:12', NULL),
(35, 10, 'Career Fit Test', '{\"76\":{\"question_id\":\"76\",\"answer\":\"D\",\"category\":\"Work Preference\",\"score\":1},\"77\":{\"question_id\":\"77\",\"answer\":\"D\",\"category\":\"Work Preference\",\"score\":1},\"78\":{\"question_id\":\"78\",\"answer\":\"D\",\"category\":\"Work Preference\",\"score\":1},\"79\":{\"question_id\":\"79\",\"answer\":\"D\",\"category\":\"Work Preference\",\"score\":1},\"80\":{\"question_id\":\"80\",\"answer\":\"D\",\"category\":\"Work Preference\",\"score\":1}}', '5', 'No suggestion available.', '2025-10-10 12:27:32', NULL),
(36, 8, 'Career Fit Test', '{\"66\":{\"question_id\":\"66\",\"answer\":\"B\",\"category\":\"Personality\",\"score\":3},\"67\":{\"question_id\":\"67\",\"answer\":\"C\",\"category\":\"Personality\",\"score\":2},\"68\":{\"question_id\":\"68\",\"answer\":\"B\",\"category\":\"Personality\",\"score\":3},\"69\":{\"question_id\":\"69\",\"answer\":\"B\",\"category\":\"Personality\",\"score\":3},\"70\":{\"question_id\":\"70\",\"answer\":\"B\",\"category\":\"Personality\",\"score\":3}}', '14', 'No suggestion available.', '2025-10-10 12:47:27', NULL),
(37, 8, 'Career Fit Test', '{\"66\":{\"question_id\":\"66\",\"answer\":\"B\",\"category\":\"Personality\",\"score\":3},\"67\":{\"question_id\":\"67\",\"answer\":\"C\",\"category\":\"Personality\",\"score\":2},\"68\":{\"question_id\":\"68\",\"answer\":\"B\",\"category\":\"Personality\",\"score\":3},\"69\":{\"question_id\":\"69\",\"answer\":\"B\",\"category\":\"Personality\",\"score\":3},\"70\":{\"question_id\":\"70\",\"answer\":\"B\",\"category\":\"Personality\",\"score\":3}}', '14', 'No suggestion available.', '2025-10-10 12:47:58', NULL),
(38, 8, 'Personality Assessment', '[{\"question_id\":\"66\",\"question\":\"I prefer to plan ahead rather than act spontaneously.\",\"answer\":\"B\",\"category\":\"Personality\",\"score\":3},{\"question_id\":\"67\",\"question\":\"I enjoy taking initiative and leading group projects.\",\"answer\":\"C\",\"category\":\"Personality\",\"score\":2},{\"question_id\":\"68\",\"question\":\"I stay calm and composed even under pressure.\",\"answer\":\"B\",\"category\":\"Personality\",\"score\":3},{\"question_id\":\"69\",\"question\":\"I like meeting new people and socializing frequently.\",\"answer\":\"B\",\"category\":\"Personality\",\"score\":3},{\"question_id\":\"70\",\"question\":\"I adapt quickly to new situations and changes.\",\"answer\":\"B\",\"category\":\"Personality\",\"score\":3}]', '14', 'No suggestion available.', '2025-10-10 12:53:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `career_category_scores`
--

CREATE TABLE `career_category_scores` (
  `id` int(11) NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `category` varchar(50) NOT NULL,
  `score` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `career_category_scores`
--

INSERT INTO `career_category_scores` (`id`, `student_id`, `category`, `score`, `created_at`) VALUES
(15, 8, 'Skills', 10, '2025-10-10 16:07:21'),
(16, 8, 'Personality', 13, '2025-10-15 08:08:20'),
(17, 8, 'Work Preference', 9, '2025-10-14 15:47:41');

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
(56, 'I enjoy analyzing problems and finding logical solutions.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Interests', '2025-10-10 11:39:43'),
(57, 'I enjoy expressing myself through art, design, or other creative projects.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Interests', '2025-10-10 11:39:43'),
(58, 'I enjoy helping others or working in roles where I can support people.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Interests', '2025-10-10 11:39:43'),
(59, 'I enjoy organizing tasks, events, or projects and making sure everything runs smoothly.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Interests', '2025-10-10 11:39:43'),
(60, 'I enjoy using technology, gadgets, or working with tools and equipment.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Interests', '2025-10-10 11:39:43'),
(61, 'I prefer working in a team rather than alone.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Interests', '2025-10-10 11:39:43'),
(62, 'I stay calm and focused when facing challenges.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Interests', '2025-10-10 11:39:43'),
(63, 'I am confident in my ability to communicate ideas clearly to others.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Interests', '2025-10-10 11:39:43'),
(64, 'I enjoy tasks that require creativity and coming up with new ideas.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Interests', '2025-10-10 11:39:43'),
(66, 'I prefer to plan ahead rather than act spontaneously.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Personality', '2025-10-10 11:43:25'),
(67, 'I enjoy taking initiative and leading group projects.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Personality', '2025-10-10 11:43:25'),
(68, 'I stay calm and composed even under pressure.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Personality', '2025-10-10 11:43:25'),
(69, 'I like meeting new people and socializing frequently.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Personality', '2025-10-10 11:43:25'),
(70, 'I adapt quickly to new situations and changes.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Personality', '2025-10-10 11:43:25'),
(71, 'I am confident in solving complex problems independently.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Skills', '2025-10-10 11:43:44'),
(72, 'I can communicate my ideas clearly in writing and verbally.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Skills', '2025-10-10 11:43:44'),
(73, 'I can analyze data and draw meaningful conclusions.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Skills', '2025-10-10 11:43:44'),
(74, 'I have good organizational and time-management skills.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Skills', '2025-10-10 11:43:44'),
(75, 'I can quickly learn and use new tools, software, or equipment.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Skills', '2025-10-10 11:43:44'),
(76, 'I prefer working independently rather than in a team.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Work Preference', '2025-10-10 11:43:59'),
(77, 'I enjoy tasks that require creativity and innovation.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Work Preference', '2025-10-10 11:43:59'),
(78, 'I prefer structured work with clear rules and procedures.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Work Preference', '2025-10-10 11:43:59'),
(79, 'I enjoy roles where I can interact with people frequently.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Work Preference', '2025-10-10 11:43:59'),
(80, 'I prefer flexible work schedules over rigid routines.', 'Strongly Agree', 'Agree', 'Disagree', 'Strongly Disagree', 'Work Preference', '2025-10-10 11:43:59');

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
(1, 8, 'student', 'Your counselling session request has been Approved by the counsellor.', 0, '2025-10-14 19:23:34'),
(2, 7, 'admin', 'A counselling session for student (ID 8) has been approved.', 0, '2025-10-14 19:23:34'),
(3, 10, 'student', 'Your counselling session request has been Declined by the counsellor.', 0, '2025-10-14 19:26:50'),
(4, 7, 'admin', 'A counselling session for student (ID 10) has been declined.', 0, '2025-10-14 19:26:50'),
(5, 9, '', 'New counselling session requested by student for Oct 18, 2025 01:00 PM.', 0, '2025-10-14 20:18:03'),
(6, 7, 'admin', 'New counselling session requested by student (session ID: 3).', 0, '2025-10-14 20:18:03'),
(7, 9, '', 'New counselling session requested by student for Oct 10, 2025 12:00 PM.', 0, '2025-10-15 05:31:18'),
(8, 7, 'admin', 'New counselling session requested by student (session ID: 4).', 0, '2025-10-15 05:31:18'),
(9, 8, 'student', 'Your counselling session request has been Approved by the counsellor.', 0, '2025-10-24 20:43:44'),
(10, 7, 'admin', 'A counselling session for student (ID 8) has been approved.', 0, '2025-10-24 20:43:44'),
(11, 8, 'student', 'Your counselling session request has been Approved by the counsellor.', 0, '2025-10-24 20:43:46'),
(12, 7, 'admin', 'A counselling session for student (ID 8) has been approved.', 0, '2025-10-24 20:43:46'),
(13, 9, '', 'New counselling session requested by peter for Dec 12, 2025 10:00 AM.', 0, '2025-10-24 21:08:58'),
(14, 7, 'admin', 'New counselling session requested by peter (session ID: 5).', 0, '2025-10-24 21:08:58'),
(15, 10, 'student', 'Your counselling session request has been Approved by the counsellor.', 0, '2025-10-24 21:09:24'),
(16, 7, 'admin', 'A counselling session for student (ID 10) has been approved.', 0, '2025-10-24 21:09:24');

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
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `student_id`, `counsellor_id`, `session_date`, `mode`, `notes`, `action_plan`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 9, '2025-10-03 00:00:00', 'Physical', 'counselling about peer pressure', 'monitoring', 'approved', '2025-09-22 17:13:38', '2025-10-14 22:23:34'),
(2, 10, 9, '2025-10-18 14:00:00', 'In-Person', 'ggh', 'fggf', 'declined', '2025-10-14 22:25:51', '2025-10-14 22:26:49'),
(3, 8, 9, '2025-10-18 13:00:00', 'Physical', 'personal', 'nothing much', 'approved', '2025-10-14 23:18:03', '2025-10-24 23:43:45'),
(4, 8, 9, '2025-10-10 12:00:00', 'Physical', 'fgfga', 'dgagef', 'approved', '2025-10-15 08:31:18', '2025-10-24 23:43:44'),
(5, 10, 9, '2025-12-12 10:00:00', 'Physical', 'career', 'make right career choice', 'approved', '2025-10-25 00:08:57', '2025-10-25 00:09:23');

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
(260, 8, 71, 'C', 'Skills', '2025-10-10 13:07:21'),
(261, 8, 72, 'D', 'Skills', '2025-10-10 13:07:21'),
(262, 8, 73, 'C', 'Skills', '2025-10-10 13:07:21'),
(263, 8, 74, 'C', 'Skills', '2025-10-10 13:07:21'),
(264, 8, 75, 'B', 'Skills', '2025-10-10 13:07:21'),
(265, 8, 66, 'C', 'Personality', '2025-10-10 13:13:04'),
(266, 8, 67, 'C', 'Personality', '2025-10-10 13:13:04'),
(267, 8, 68, 'B', 'Personality', '2025-10-10 13:13:04'),
(268, 8, 69, 'C', 'Personality', '2025-10-10 13:13:05'),
(269, 8, 70, 'B', 'Personality', '2025-10-10 13:13:05'),
(270, 8, 76, 'C', 'Work Preference', '2025-10-14 12:47:41'),
(271, 8, 77, 'C', 'Work Preference', '2025-10-14 12:47:41'),
(272, 8, 78, 'D', 'Work Preference', '2025-10-14 12:47:41'),
(273, 8, 79, 'C', 'Work Preference', '2025-10-14 12:47:41'),
(274, 8, 80, 'C', 'Work Preference', '2025-10-14 12:47:41'),
(275, 8, 66, 'A', 'Personality', '2025-10-15 05:08:19'),
(276, 8, 67, 'B', 'Personality', '2025-10-15 05:08:19'),
(277, 8, 68, 'C', 'Personality', '2025-10-15 05:08:19'),
(278, 8, 69, 'C', 'Personality', '2025-10-15 05:08:19'),
(279, 8, 70, 'C', 'Personality', '2025-10-15 05:08:19');

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
(8, 'BIT/2024/43255', 'student', 'student@gmail.com', 'uploads/68eeacfbe441a.jpg', '$2y$10$kddZFXBKZU6yc6m0TsRvmet6EJSthNCwVXhaI4vtWqlEV7p.GneCi', 'student', 'active', '2025-09-22 11:26:50'),
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
-- Indexes for table `career_category_scores`
--
ALTER TABLE `career_category_scores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_category` (`student_id`,`category`);

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
-- AUTO_INCREMENT for table `career_assessments`
--
ALTER TABLE `career_assessments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `career_category_scores`
--
ALTER TABLE `career_category_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `career_questions`
--
ALTER TABLE `career_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `career_suggestions`
--
ALTER TABLE `career_suggestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `counselor_reports`
--
ALTER TABLE `counselor_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_performance`
--
ALTER TABLE `student_performance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `student_responses`
--
ALTER TABLE `student_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=280;

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
-- Constraints for table `career_category_scores`
--
ALTER TABLE `career_category_scores`
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
