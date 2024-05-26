-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 12:01 AM
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
(1, 'orpilla', 'john.abanil.recover@gmail.com', '$2y$10$v8JHJlphFMlGONbtJFhEeupyZnZBGiZsOfR/IY89i35GXa0crUMJG', '$2y$10$Kqx7Uhl.8DCnEJGEh0dUQuVISs9NP.rjO94BK29Luv51EqoUVhrZW', '1', 'employer', '', ''),
(2, 'sfsfdsfsdfsf', 'programmerferg@gmail.com', '$2y$10$WSl6nWb6H05QhsuKOA6tNuhwAHzdwVfUhE7rr8463CMik/LW6I/kO', '$2y$10$0IRExeqSZSYLLSTzlfh.lueLS30Gwgj9YcjuigwMiPnLSj5vjocZS', '1', 'employer', '', ''),
(3, 'iceicebaby', 'gokieshanvy@gmail.com', '$2y$10$ycZlUmdfnQNG5DKYaoVdi.AP53rpQv4tq3z1hYa7peHbeKX9xqV7a', '$2y$10$C.FDkTlfEqsoSs1WFx941ueZ5afzAV9TN.LahONGd4JCVaxg7EIJ6', '1', 'employer', '', ''),
(4, 'JQuery', 'skidongskidong@gmail.com', '$2y$10$/qJrr4gF3nWgep1Q.rJUVOUbfbmZJpMS8mFqZ98xzu7E4QDtVCc3K', '$2y$10$uaxNF2aEJvr5EMfQAlOZKehYgp64BlaGkfOphx.aoy0gxbGa.xMn6', '1', 'employer', '2474', 'Bahay');

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
(4, 'Tanggol', 'john.abanil.recover@gmail.com', '$2y$10$wdPC9nyabTEfEt9kcAw7wuyHFKlYoESyJKiTaoIaqJXwCnc.nT1.S', '$2y$10$JhxPbfOvmk1K4JWfLywZ8el6ovx1n9YW6qcCOkjGLfdVlEXJ.QFB2', '1', 'student', 'Male', '', 'BS Information Technology', '22-00406', '0000-00-00', '09691588952'),
(5, 'skididong', 'skidongskidong@gmail.com', '$2y$10$4XR7RyI4loyVLBSUvHKsMueSqSep9DxF1MIfrbdZbDsrqkHjghARC', '$2y$10$htUhg1veBo44DsIYnyFtROpPbJl3LJUGvmMcTHrLHx5DRlbBn/L3S', '1', 'student', '', '', 'BS Computer Engineering', '', '0000-00-00', '');

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
(1, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 14, 'maron', 3, '0', 'Pending', 'uploads/pogiako.pdf', '2024-05-23 05:59:32'),
(2, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 14, 'maron', 3, '0', 'Pending', 'uploads/pogiako.pdf', '2024-05-23 05:59:32'),
(3, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 14, 'maron', 3, 'iceicebaby', 'Pending', 'uploads/error_notfix.sql', '2024-05-23 05:59:32'),
(4, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 1, 'fgdgdfgdg', 1, 'orpilla', 'Approved', 'uploads/pogiako.pdf', '2024-05-23 05:59:32'),
(5, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 15, 'Construction', 3, 'iceicebaby', 'Pending', 'uploads/cdm-internship-database.sql', '2024-05-23 05:59:32'),
(6, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 16, 'Ryan', 4, 'skididong', 'Approved', 'uploads/cdm-internship-database.sql', '2024-05-23 05:59:32'),
(7, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 17, 'Hinarot', 4, 'skididong', 'Pending', 'uploads/cdm-internship-database.sql', '2024-05-23 05:59:32'),
(8, 'Tanggol', 'john.abanil.recover@gmail.com', 'BS Information Technology', 17, 'Hinarot', 4, 'skididong', 'Cancelled', 'uploads/cdm-internship-database.sql', '2024-05-23 05:59:32'),
(11, 'Tanggol', 'john.abanil.recover@gmail.com', 'BS Information Technology', 16, 'Ryan', 4, 'skididong', 'Approved', 'uploads/cdm-internship-database.sql', '2024-05-23 05:59:32'),
(12, 'Tanggol', 'john.abanil.recover@gmail.com', 'BS Information Technology', 17, 'Hinarot', 4, 'JQuery', 'Pending', 'uploads/snip.PNG', '2024-05-23 05:59:32'),
(13, 'Tanggol', 'john.abanil.recover@gmail.com', 'BS Information Technology', 16, 'Ryan', 4, 'JQuery', 'Pending', 'uploads/resume.pdf', '2024-05-23 05:59:32');

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
  `posted_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internship`
--

INSERT INTO `internship` (`Internship_ID`, `Title`, `Description`, `Requirements`, `Duration`, `Company_ID`, `Status`, `posted_date`) VALUES
(1, 'fgdgdfgdg', 'gdgdgdfg', 'gdfgdg', 'dgfgdg', 1, 'pending', '2024-05-23 05:55:07'),
(4, 'fssfsd', 'sdfsfsdfsdf', 'sfsdfsdf', 'fsfsdfsd', 1, 'pending', '2024-05-23 05:55:07'),
(10, 'GFDGDGDFGD', 'GDGDGDG', 'DFGDFGDG', 'DFGFDFG', 1, 'pending', '2024-05-23 05:55:07'),
(11, 'GHFGHFFGH', 'FFHFHFGH', 'FGHFFGFGHFG', 'FGHFGHFGH', 2, 'pending', '2024-05-23 05:55:07'),
(13, 'Loid', 'Anya', 'Yor', 'Forger', 1, 'pending', '2024-05-23 05:55:07'),
(14, 'maron', 'nani', 'duday', 'trudis', 3, 'pending', '2024-05-23 05:55:07'),
(15, 'Construction', 'Tagabuhos', 'Taga walis', 'Taga banlaw', 3, 'pending', '2024-05-23 05:55:07'),
(16, 'Front-End Developer', 'Tailwind and SASS CSS', 'HTML, JS, CSS', '80 Hours', 4, 'pending', '2024-05-23 05:55:07'),
(18, 'Cherry', 'Dublin', 'Albert', 'Goblin', 4, 'Pending', '2024-05-23 05:55:07'),
(19, 'Backend Developer', 'Maintenance', 'Knowledge about Programming Languages\r\nPhp, Next.js', '90', 4, 'Pending', '2024-05-23 05:55:07');

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

--
-- Dumping data for table `pending_employer`
--

INSERT INTO `pending_employer` (`Company_ID`, `name`, `email`, `password`, `code`, `active`, `access`) VALUES
(2, 'steamdeck', 'steambyferguzus43@gmail.com', '$2y$10$M0/WySUdFrp4HwderfwGg.P1PzPzQVU6hthz0C6Br1MwN56KOJr3O', '$2y$10$cD2Z8LtOQaFjWucOEEeF/u65ZoeSjgH6rCi3NVXwJjOvffjEfoJJS', '0', 'student'),
(3, 'tangina', 'iceferg28@gmail.com', '$2y$10$EU5g2IHGiDDzXC0Jvf062uIrocFAk7c3qqE1N1AE/LKDTMnOKGTYC', '$2y$10$Yuo72RbmBPPOIRFS1/P.5eMWwuh5gjGuwYevidT3bAImJ.txncIGO', '0', 'student'),
(6, 'ferg', 'guda.johnmichael.abanil@gmail.com', '$2y$10$egOT64Bh641kiyqj1YchvukPZVRfWujZpqqnXw/EoYeKbb1XVnkSW', '$2y$10$VWZCHJBTiSY4xXtBx8/HY.4dmpztmhpVC/q5PHR0UWRtAROZgXU2a', '0', 'student');

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
(4, '', 'Quezon Memorial Hospital', 'Filipino', 'Roman Catholic', '', 'Single', 'Kasiglahan Village Elementary School', 'Kasiglahan Village Seinor High School', 'Colegio De Montalban', '2008 - 2015', '2020 - 2022', '2022 - on going'),
(5, '', '', '', 'Roman Catholic', '', 'Single', '', '', '', '', '', '');

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
  MODIFY `Company_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `activated_student`
--
ALTER TABLE `activated_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `application_internship`
--
ALTER TABLE `application_internship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `internship`
--
ALTER TABLE `internship`
  MODIFY `Internship_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pending_employer`
--
ALTER TABLE `pending_employer`
  MODIFY `Company_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pending_student`
--
ALTER TABLE `pending_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
