-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2024 at 08:34 PM
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
-- Table structure for table `activated_employer`
--

CREATE TABLE `activated_employer` (
  `Company_ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL DEFAULT 'employer',
  `Contact_No` varchar(255) NOT NULL,
  `Location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- --------------------------------------------------------

--
-- Table structure for table `activated_student`
--

CREATE TABLE `activated_student` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL DEFAULT 'student',
  `sex` varchar(10) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `studentID` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_username`, `admin_password`) VALUES
('Administrator', '$2a$11$xez0dF/v3X0BuffybnKIB.hV0oP6j0DvM42.F2gm4A9rY6HJUwEhC');

-- --------------------------------------------------------

--
-- Table structure for table `application_internship`
--

CREATE TABLE `application_internship` (
  `id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_email` varchar(255) NOT NULL,
  `student_course` varchar(255) NOT NULL,
  `internship_ID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `company_ID` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `resume_path` varchar(255) NOT NULL,
  `application_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- --------------------------------------------------------

--
-- Table structure for table `internship`
--

CREATE TABLE `internship` (
  `Internship_ID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `Requirements` text DEFAULT NULL,
  `Duration` varchar(50) DEFAULT NULL,
  `Company_ID` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'pending',
  `posted_date` datetime NOT NULL DEFAULT current_timestamp(),
  `availability` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `pending_employer`
--

CREATE TABLE `pending_employer` (
  `Company_ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL DEFAULT 'employer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_student`
--

CREATE TABLE `pending_student` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `access` varchar(255) NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_resume`
--

CREATE TABLE `table_resume` (
  `user_id` int(11) NOT NULL,
  `objective` text NOT NULL,
  `birthplace` varchar(255) NOT NULL,
  `citizenship` varchar(255) NOT NULL,
  `religion` varchar(255) NOT NULL,
  `languages_spoken` text NOT NULL,
  `civil_status` varchar(255) NOT NULL,
  `primary_education` varchar(255) NOT NULL,
  `secondary_education` varchar(255) NOT NULL,
  `tertiary_education` varchar(255) NOT NULL,
  `primary_year` varchar(255) NOT NULL,
  `secondary_year` varchar(255) NOT NULL,
  `tertiary_year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;





--
-- Indexes for dumped tables
--

--
-- Indexes for table `activated_employer`
--
ALTER TABLE `activated_employer`
  ADD PRIMARY KEY (`Company_ID`);

--
-- Indexes for table `activated_student`
--
ALTER TABLE `activated_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_internship`
--
ALTER TABLE `application_internship`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `internship`
--
ALTER TABLE `internship`
  ADD PRIMARY KEY (`Internship_ID`),
  ADD KEY `Company_ID` (`Company_ID`);

--
-- Indexes for table `pending_employer`
--
ALTER TABLE `pending_employer`
  ADD PRIMARY KEY (`Company_ID`);

--
-- Indexes for table `pending_student`
--
ALTER TABLE `pending_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_resume`
--
ALTER TABLE `table_resume`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activated_employer`
--
ALTER TABLE `activated_employer`
  MODIFY `Company_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `activated_student`
--
ALTER TABLE `activated_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `application_internship`
--
ALTER TABLE `application_internship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `internship`
--
ALTER TABLE `internship`
  MODIFY `Internship_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `pending_employer`
--
ALTER TABLE `pending_employer`
  MODIFY `Company_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pending_student`
--
ALTER TABLE `pending_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `internship`
--
ALTER TABLE `internship`
  ADD CONSTRAINT `internship_ibfk_1` FOREIGN KEY (`Company_ID`) REFERENCES `activated_employer` (`Company_ID`);

--
-- Constraints for table `table_resume`
--
ALTER TABLE `table_resume`
  ADD CONSTRAINT `table_resume_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `activated_student` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
