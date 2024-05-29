-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 03:24 AM
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

--
-- Dumping data for table `activated_employer`
--

INSERT INTO `activated_employer` (`Company_ID`, `name`, `email`, `password`, `code`, `active`, `access`, `Contact_No`, `Location`) VALUES
(14, 'IntelligenSHIA', 'guda.johnmichael.abanil@gmail.com', '$2y$10$BaLxrfP3tbHXeb7RhV6C1upG7Cpn/FUbkUTaeaL1nNpn7Leq70eue', '$2y$10$G0pYE1jaFqAvPwiPcT/vHOBY35jdDS1nOQUEyve2HjQsphEryzoSW', '1', 'employer', '09691588952', 'Makati City'),
(18, 'Joe Bartolozzi', 'iceferg28@gmail.com', '$2a$11$e0j6RsY.o94lCOy/Wd8ISOmjvEyPSmPrB1MTKCW08VnQ.fs2qh/6i', '', '1', 'employer', '', '');

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

--
-- Dumping data for table `activated_student`
--

INSERT INTO `activated_student` (`id`, `name`, `email`, `password`, `code`, `active`, `access`, `sex`, `address`, `course`, `studentID`, `birthday`, `contact_no`) VALUES
(16, 'Ferg', 'skidongskidong@gmail.com', '$2y$10$HrXSdYtYpTa40p8WG/Wj1OPoq6VBBzig9igLDTf2YN94XSs5ix40K', '$2y$10$WAuCn/XkIG6.ap4HevcCIuZ./0l3RJO/NzsZuIJtCaxoeBHpNFkLO', '1', 'student', 'Male', '1K1 kasiglahan vill., rodriguez, rizal', 'BS Computer Engineering', '22-00406', '2024-05-16', '09452147153'),
(19, 'John Michael', 'gokieshanvy@gmail.com', '$2y$10$ybUDkWrLD0/bwPpuP9vsaurbmeZpN/pyPiMHOu3yAylwxTEi/quJK', '$2y$10$i5rWyo0kBqHUgN1nofwKiu16RCIpTG1BHQnePtR8PCMA20mlDPJtS', '1', 'student', 'Male', 'QWWE', 'BS Computer Engineering', '22-00406', '2024-05-21', '9897978967'),
(23, 'John Micahel Abanil', 'programmerferg@gmail.com', '$2y$10$TTLv241oS1qbqB7dsCIuMOGgQLbEB.FW8JwwSCiCG0UVH08FR4XKS', '$2y$10$g0l1IxcgoocnJ9jSlkPJa.lf71rnlIWjrX/PbG9HuLfDuTSalVmWa', '1', 'student', 'Male', 'Rodriguez, Rizal', 'BS Information Technology', '22-00000', '2024-05-07', '09123456789');

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
('Administrator', '$2a$11$6MqqrliwkdtjLeFBaBH1terNZrNGKfYlvW2ScqMLBkPhf58oCza1.');

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

--
-- Dumping data for table `application_internship`
--

INSERT INTO `application_internship` (`id`, `student_name`, `student_email`, `student_course`, `internship_ID`, `title`, `company_ID`, `company_name`, `status`, `resume_path`, `application_date`) VALUES
(97, 'John Micahel Abanil', 'programmerferg@gmail.com', 'BS Information Technology', 42, 'Mobile Dev', 14, 'IntelligenSHIA', 'Cancelled', '../students/uploads/John Micahel Abanil_resume (3).pdf', '2024-05-29 07:36:29'),
(98, 'John Micahel Abanil', 'programmerferg@gmail.com', 'BS Information Technology', 42, 'Mobile Dev', 14, 'IntelligenSHIA', 'Approved', '../students/uploads/John Micahel Abanil_resume (3).pdf', '2024-05-29 07:36:44');

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

--
-- Dumping data for table `internship`
--

INSERT INTO `internship` (`Internship_ID`, `Title`, `Description`, `Requirements`, `Duration`, `Company_ID`, `Status`, `posted_date`, `availability`) VALUES
(42, 'Mobile Dev', 'Develop Barangay Mobile App', 'Flutter', '90 Hours', 14, 'Posted', '2024-05-29 07:32:42', 0);

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
-- Dumping data for table `table_resume`
--

INSERT INTO `table_resume` (`user_id`, `objective`, `birthplace`, `citizenship`, `religion`, `languages_spoken`, `civil_status`, `primary_education`, `secondary_education`, `tertiary_education`, `primary_year`, `secondary_year`, `tertiary_year`) VALUES
(23, 'To upgrade my skills in Data Science', 'QC', 'Filipino', 'Roman Catholic', 'Filipino', 'Single', 'KVES', 'KVNHS', 'CDM', '2010 - 2016', '2016 - 2022', '2022 on going');

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
  MODIFY `Company_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `activated_student`
--
ALTER TABLE `activated_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `application_internship`
--
ALTER TABLE `application_internship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `internship`
--
ALTER TABLE `internship`
  MODIFY `Internship_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `pending_employer`
--
ALTER TABLE `pending_employer`
  MODIFY `Company_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pending_student`
--
ALTER TABLE `pending_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
