-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 10:16 PM
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
  `objective` text DEFAULT NULL,
  `birthplace` varchar(255) DEFAULT NULL,
  `citizenship` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `languages_spoken` text DEFAULT NULL,
  `civil_status` varchar(255) DEFAULT NULL,
  `primary_education` varchar(255) DEFAULT NULL,
  `secondary_education` varchar(255) DEFAULT NULL,
  `tertiary_education` varchar(255) DEFAULT NULL,
  `primary_year` varchar(255) DEFAULT NULL,
  `secondary_year` varchar(255) DEFAULT NULL,
  `tertiary_year` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_resume`
--

INSERT INTO `table_resume` (`user_id`, `objective`, `birthplace`, `citizenship`, `religion`, `languages_spoken`, `civil_status`, `primary_education`, `secondary_education`, `tertiary_education`, `primary_year`, `secondary_year`, `tertiary_year`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
