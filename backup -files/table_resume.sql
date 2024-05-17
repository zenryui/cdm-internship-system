-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 10:02 PM
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
-- Database: `cdm-internship-database`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_resume`
--

CREATE TABLE `table_resume` (
  `user_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `professional_summary` text DEFAULT NULL,
  `school_name` varchar(255) NOT NULL,
  `skills` text DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `projects` text DEFAULT NULL,
  `certifications` text DEFAULT NULL,
  `honors_awards` text DEFAULT NULL,
  `extracurricular_activities` text DEFAULT NULL,
  `portfolio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_resume`
--

INSERT INTO `table_resume` (`user_id`, `address`, `professional_summary`, `school_name`, `skills`, `experience`, `projects`, `certifications`, `honors_awards`, `extracurricular_activities`, `portfolio`) VALUES
(1, 'Kasiglahan Village National High School\r\nKasiglahan Village Senior High School\r\nColegio De Montalban', 'Graphic Designer 2020\r\nPC Enthusiast 2023\r\nBackend Developer 2023\r\nFullstack Develoepr 2024', 'CDM', 'PHP\r\nJavascript\r\nMySql', 'Backend Developer', 'CDM Event Registration\r\nPC Part Picker\r\nFergTech E-Commerce\r\nICS Internship', 'Full Course PHP', 'Senior High w/ Honors', '(None)', 'Github: zenryui\r\nGithub: ferguzus'),
(3, 'yep', 'dsdd', 'Kasig', 'dsdd', 'dsdd', 'dsdd', 'dsdd', 'dsdd', 'dsdd', 'gago');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_resume`
--
ALTER TABLE `table_resume`
  ADD PRIMARY KEY (`user_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_resume`
--
ALTER TABLE `table_resume`
  ADD CONSTRAINT `table_resume_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `activated_student` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
