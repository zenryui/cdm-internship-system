-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2024 at 05:12 AM
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
(1, 'Employer1', 'gokieshanvy@gmail.com', '$2y$10$ejKCrt3OyJ.69VLY4O1T.OkJ1ldb..PpLEMSD6ZWTxpVXt37cNsnC', '$2y$10$PeL9isOwP23.mGmzr2Nl/u3tvFxrqmtKm8P9T.nPookkZNzu787BS', '1', 'employer', '', ''),
(2, 'buratan', 'fergdoflamingo@gmail.com', '$2y$10$.vbkqPCirzxgK8QeUI4O2eWpoLxYw9abse98eGom6q2aCZ9mPqlaC', '$2y$10$y7QCEs5kK8Y1t3aDyFvJsO1s4qeFEm7QW4zgGBTXLYVfIuSEZYncW', '1', 'employer', '', ''),
(3, 'rtxrtx', 'guda.johnmichael.abanil@gmail.com', '$2y$10$WHfCmJJXPr2GQvRA/y2uEe5BFenEMLaChHB8.C1uRbF9IBAnJh.QO', '$2y$10$uCMI47iqx9fsKTljR7367OXpmBfRdpdGkr6ehf/DF3vXkavVSYJIK', '1', 'employer', '', '');

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
(1, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', '$2y$10$FM8AbrY385Dt9YhleojZo.Vq.tML7SbaAKmDZszRRXL4.AyWdo2N.', '$2y$10$gshnzkpTKS/RNUso4B9DA.pTt5VMDv3HMmG8gXxrGRjHWDiW9td9W', '1', 'student', 'Female', 'Bahay namen', 'BS Computer Engineering', '22-24745', '2000-06-07', '9322323232332'),
(2, 'ryandingle', 'gokieshanvy@gmail.com', '$2y$10$R2HEe.Px5I53YKNtHXyeGugGF993XSG7cYg/y60j80kOE0gTeopRi', '$2y$10$71Fxoe8E0e5nOm4CId4hEuIpd8nymXzb5kA6B7LP.kh98GU2RaZLO', '1', 'student', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'tangina', 'fergdoflamingo@gmail.com', '$2y$10$8A2e1M1557Iy7YjPzzoNIeLvyYN8Hfqqcoeg7wHBwquNDO/j3LPXa', '$2y$10$7v1vfMk14DQM3FRip31gOeZnB8Pw.97cglj7vuCSNNnApbPCr.SUO', '1', 'student', 'Female', 'yep', 'BS Computer Engineering', '2212345', '2024-05-02', '09691588952'),
(4, '', 'john.abanil.recover@gmail.com', '$2y$10$fXASU6loo0BmueTjL8mrO.boogk/7eFVTLCDEMM4t0mg8qe8LsZ5a', '$2y$10$3SQuXECTL3WLkedqSYcX4erzBPpJELy5/pVO0z2N0EP8kr5N2lPI6', '1', 'student', '', '', 'BS Information Technology', '', '0000-00-00', '');

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
  `resume_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internship`
--

CREATE TABLE `internship` (
  `Internship_ID` int(11) NOT NULL,
  `Requirements` text NOT NULL,
  `Duration` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Company_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internship`
--

INSERT INTO `internship` (`Internship_ID`, `Requirements`, `Duration`, `Description`, `Title`, `Company_ID`) VALUES
(2, 'Brainy\r\nKnowledge', '90 hours', 'Programmer', 'Networking', 1);

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

--
-- Dumping data for table `pending_student`
--

INSERT INTO `pending_student` (`id`, `name`, `email`, `password`, `active`, `code`, `access`) VALUES
(1, 'rtxrtx', 'iceferg28@gmail.com', '$2y$10$lbvhi8cFRM8mCQXtUHc1zez8.qkCfcmMN9PcNB1saiGJJj143RpU6', '0', '$2y$10$/j6eJYFo0ehQFVHWjqBhB.Nfwur5mMd8L.VVXNRBiX6IpERPANHTq', 'student'),
(2, 'rererere', 'skidongskidong@gmail.com', '$2y$10$MD0UWMuSG/kFC2oq3i5BQOJdfhG3GPyXYCZOh9eSxOo9Fc.Xq2MEi', '0', '$2y$10$cVFQ6mAer5oBRZMn0/nG8OxT.F.pbxZ0hMJ1e4v9qb2eXN8YRIKkC', 'student'),
(3, 'orpilla', 'programmerferg@gmail.com', '$2y$10$oHSlwpHNlSfFijH0xPsFtuPHW44K3cekQZTbv88mYBgw7f5EKla7e', '0', '$2y$10$rcnLKHwhR72w137fQ1TrteLPgKDX4pEKF63RPD0yh8ghghh6V0c36', 'student');

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
(1, 'wala hahaha', 'QC', 'Filipino', 'Roman Catholic', 'pakyu', 'Married', 'KVES', 'KVNHS', 'CDM', '2002', '2010', '2024'),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '', '', '', '', '', 'Single', '', '', '', '', '', '');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `internship_ID` (`internship_ID`);

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
  MODIFY `Company_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `activated_student`
--
ALTER TABLE `activated_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `application_internship`
--
ALTER TABLE `application_internship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internship`
--
ALTER TABLE `internship`
  MODIFY `Internship_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pending_employer`
--
ALTER TABLE `pending_employer`
  MODIFY `Company_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pending_student`
--
ALTER TABLE `pending_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application_internship`
--
ALTER TABLE `application_internship`
  ADD CONSTRAINT `application_internship_ibfk_1` FOREIGN KEY (`internship_ID`) REFERENCES `internship` (`Internship_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `internship`
--
ALTER TABLE `internship`
  ADD CONSTRAINT `internship_ibfk_1` FOREIGN KEY (`Company_ID`) REFERENCES `activated_employer` (`Company_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `table_resume`
--
ALTER TABLE `table_resume`
  ADD CONSTRAINT `table_resume_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `activated_student` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
