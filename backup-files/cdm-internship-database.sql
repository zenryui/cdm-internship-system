-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2024 at 06:35 AM
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
(1, 'orpilla', 'john.abanil.recover@gmail.com', '$2y$10$v8JHJlphFMlGONbtJFhEeupyZnZBGiZsOfR/IY89i35GXa0crUMJG', '$2y$10$Kqx7Uhl.8DCnEJGEh0dUQuVISs9NP.rjO94BK29Luv51EqoUVhrZW', '1', 'employer', '', 'Bahay'),
(2, 'sfsfdsfsdfsf', 'programmerferg@gmail.com', '$2y$10$WSl6nWb6H05QhsuKOA6tNuhwAHzdwVfUhE7rr8463CMik/LW6I/kO', '$2y$10$0IRExeqSZSYLLSTzlfh.lueLS30Gwgj9YcjuigwMiPnLSj5vjocZS', '1', 'employer', '', ''),
(3, 'iceicebaby', 'gokieshanvy@gmail.com', '$2y$10$ycZlUmdfnQNG5DKYaoVdi.AP53rpQv4tq3z1hYa7peHbeKX9xqV7a', '$2y$10$C.FDkTlfEqsoSs1WFx941ueZ5afzAV9TN.LahONGd4JCVaxg7EIJ6', '1', 'employer', '', ''),
(4, 'JQuery', 'skidongskidong@gmail.com', '$2y$10$2hMrOtcR5jt2u0mtzbkaDOVv9g1F2uM0yun.lYwnL.EPkfrkOdxI2', '$2y$10$izL5kxkDOlRzN/xHrYiYAu4IDTIy08G.VKNXYO2KQsNxxVhZnPNb.', '1', 'employer', '2474', 'Bahay'),
(5, 'John Michael', 'guda.johnmichael.abanil@gmail.com', '$2y$10$bR28e5JW6SaD.HDp/NyweuYQwXnXda/L/zbJ0NdjuIqtC0gJXsvma', '$2y$10$KlhCOH.szI35j4PHDlO77uMXpGuiYUA3koAFsmy9smK/rxgtPdVsm', '1', 'employer', 'GTX', 'RTX'),
(7, '', 'steambyferguzus43@gmail.com', '$2a$11$QcqtIUocK5.VM3xvV.CIBOogVREbLpi1H0FirDMh54F2ZArFCKSru', '', '1', 'employer', '', ''),
(9, '', 'abanil.johnmichaelguda@gmail.com', '$2y$10$I9SiDobZVXqNeUfnzaD13.wE5FBRIDaM8TJ9/CaS4fCPezn/Xs6Di', '', '1', 'employer', '', '');

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
(1, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', '$2y$10$FM8AbrY385Dt9YhleojZo.Vq.tML7SbaAKmDZszRRXL4.AyWdo2N.', '$2y$10$r3JZnsnfPBCJ0kaU5wjZ8eO7S2lGIyfAcc2xD2i5RK6.bONU7kYUC', '1', 'student', 'Female', 'Bahay namen', 'BS Computer Engineering', '22-24745', '2000-06-07', '9322323232332'),
(2, 'ryandingle', 'gokieshanvy@gmail.com', '$2y$10$R2HEe.Px5I53YKNtHXyeGugGF993XSG7cYg/y60j80kOE0gTeopRi', '$2y$10$71Fxoe8E0e5nOm4CId4hEuIpd8nymXzb5kA6B7LP.kh98GU2RaZLO', '1', 'student', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'tangina', 'fergdoflamingo@gmail.com', '$2y$10$8A2e1M1557Iy7YjPzzoNIeLvyYN8Hfqqcoeg7wHBwquNDO/j3LPXa', '$2y$10$7v1vfMk14DQM3FRip31gOeZnB8Pw.97cglj7vuCSNNnApbPCr.SUO', '1', 'student', 'Female', 'yep', 'BS Computer Engineering', '2212345', '2024-05-02', '09691588952'),
(4, 'Tanggol', 'john.abanil.recover@gmail.com', '$2y$10$wdPC9nyabTEfEt9kcAw7wuyHFKlYoESyJKiTaoIaqJXwCnc.nT1.S', '$2y$10$H5c5MXBUgRH8Bg.iGXPxpuSC.689BU/yJp25LWAlEQu5COTycmAqe', '1', 'student', 'Male', '', 'BS Computer Engineering', '22-00406', '0000-00-00', '09691588952'),
(5, 'Nigga', 'skidongskidong@gmail.com', '$2y$10$BHp2NzWp2kuvfZfc2hSIP.WhTU28324JKWwMO1l4y8P5H3T6bXxm6', '$2y$10$sdlQanWbuDcR.ycqg3S.N.gn.nHjXi8/d1o4CC6JWn55XTTGmgWNG', '1', 'student', 'Male', 'GTX', 'BS Information Technology', '22-24743', '2024-05-26', '092333222333'),
(6, 'Michael Tedoso', 'steambyferguzus43@gmail.com', '$2y$10$Tm9OuPPNmswwXYuRkzOhrewTEU3HQdth4KHWfU38HhEx4hvF3XBjq', '$2y$10$n8KlDPp5DiByuhm7IrvQyuakZsqM4I227sfraJApTZzJXSU63cLTG', '1', 'student', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'gtx', 'gtx', '$2a$11$A.aEmxp8zW49JolRKclvvuaUsx/JXXylhajjNJfmV1zpwnFPmn3IW', '', '1', 'student', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Dylan', 'Dylan', '$2a$11$Rcr3SNoOur13mxNWs0qaP.xAYkTmUwEWE126k9G7yGgrlSnSZ.5bO', '', '1', 'student', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Dylan', 'banpo', '$2a$11$I2eJnSHNYjyCMeLKoAB2WOWajioXvnEiHRXKCKMCbuXGVFaHbBFIO', '', '1', 'student', NULL, NULL, NULL, NULL, NULL, NULL);

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

--
-- Dumping data for table `application_internship`
--

INSERT INTO `application_internship` (`id`, `student_name`, `student_email`, `student_course`, `internship_ID`, `title`, `company_ID`, `company_name`, `status`, `resume_path`, `application_date`) VALUES
(1, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 1, 'Backend Developer', 4, 'JQuery', 'Cancelled', 'uploads/log.php', '2024-05-23 09:13:04'),
(2, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 1, 'Backend Developer', 4, 'JQuery', 'Cancelled', 'uploads/log.php', '2024-05-23 09:13:27'),
(3, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 2, 'Front-End Developer', 1, 'orpilla', 'Cancelled', '../uploads/log.php', '2024-05-23 09:18:00'),
(4, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 2, 'Front-End Developer', 1, 'orpilla', 'Cancelled', 'uploads/Capture1.PNG', '2024-05-23 09:18:29'),
(5, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 2, 'Front-End Developer', 1, 'orpilla', 'Cancelled', 'uploads/log.php', '2024-05-23 09:18:50'),
(6, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 2, 'Front-End Developer', 1, 'orpilla', 'Cancelled', 'uploads/log.php', '2024-05-23 09:19:08'),
(7, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 2, 'Front-End Developer', 1, 'orpilla', 'Cancelled', 'uploads/log.php', '2024-05-23 09:19:25'),
(8, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 1, 'Backend Developer', 4, 'JQuery', 'Cancelled', 'uploads/dashingboard.PNG', '2024-05-23 09:46:15'),
(9, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 1, 'Backend Developer', 4, 'JQuery', 'Cancelled', 'uploads/log.php', '2024-05-23 09:46:39'),
(10, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 2, 'Front-End Developer', 1, 'orpilla', 'Cancelled', 'uploads/dashingboard.PNG', '2024-05-23 11:56:43'),
(11, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 3, 'PC', 4, 'JQuery', 'Cancelled', 'uploads/pogiako.pdf', '2024-05-23 12:05:33'),
(12, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 3, 'PC', 4, 'JQuery', 'Cancelled', 'uploads/internship.sql', '2024-05-23 12:06:49'),
(13, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 3, 'PC', 4, 'JQuery', 'Cancelled', 'uploads/log.php', '2024-05-23 12:34:19'),
(14, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 1, 'Backend Developer', 4, 'JQuery', 'Rejected', 'uploads/log.php', '2024-05-23 12:55:52'),
(15, 'Pogi ako', 'guda.johnmichael.abanil@gmail.com', 'BS Computer Engineering', 2, 'Front-End Developer', 1, 'orpilla', 'Cancelled', 'uploads/log.php', '2024-05-23 12:56:14'),
(16, '', 'guda.johnmichael.abanil@gmail.com', '', 3, 'PC', 4, '0', 'Cancelled', '../students/uploads/internship.sql', '2024-05-23 14:13:17'),
(17, '', 'guda.johnmichael.abanil@gmail.com', '', 3, 'PC', 4, '0', 'Cancelled', '../students/uploads/activated_employer.sql', '2024-05-23 14:13:31'),
(18, '', 'guda.johnmichael.abanil@gmail.com', '', 2, 'Front-End Developer', 1, '0', 'Cancelled', '../students/uploads/log.php', '2024-05-23 14:33:29'),
(19, '', 'guda.johnmichael.abanil@gmail.com', '', 4, 'Gago', 4, '0', 'Cancelled', '../students/uploads/applications.PNG', '2024-05-23 15:45:32'),
(20, '', 'guda.johnmichael.abanil@gmail.com', '', 4, 'Gago', 4, '0', 'Cancelled', '../students/uploads/applications.PNG', '2024-05-23 15:46:49'),
(21, '', 'guda.johnmichael.abanil@gmail.com', '', 4, 'Gago', 4, '0', 'Cancelled', '../students/uploads/dashingboard.PNG', '2024-05-23 15:47:04'),
(23, '', 'guda.johnmichael.abanil@gmail.com', '', 5, 'Bangag', 4, '0', 'Cancelled', '../students/uploads/log.php', '2024-05-23 15:53:33'),
(24, '', 'guda.johnmichael.abanil@gmail.com', '', 5, 'Bangag', 4, '0', 'Rejected', '../students/uploads/applications.PNG', '2024-05-23 15:54:25'),
(25, '', 'guda.johnmichael.abanil@gmail.com', '', 6, 'Japan', 4, '0', 'Rejected', '../students/uploads/log.php', '2024-05-23 15:55:08'),
(26, '', 'guda.johnmichael.abanil@gmail.com', '', 7, 'Jwalk', 4, '0', 'Approved', '../students/uploads/applications.PNG', '2024-05-23 15:56:18'),
(27, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, '0', 'Cancelled', '../students/uploads/log.php', '2024-05-23 16:24:22'),
(28, '', 'guda.johnmichael.abanil@gmail.com', '', 6, 'Japan', 4, '0', 'Cancelled', '../students/uploads/log.php', '2024-05-24 01:05:27'),
(29, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, 'JQuery', 'Cancelled', '../uploads/log.php', '2024-05-24 01:28:03'),
(30, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, 'JQuery', 'Cancelled', '../uploads/log.php', '2024-05-24 01:28:05'),
(31, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, 'JQuery', 'Cancelled', '../uploads/log.php', '2024-05-24 01:28:07'),
(32, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, 'JQuery', 'Cancelled', '../uploads/log.php', '2024-05-24 01:28:09'),
(33, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, 'JQuery', 'Cancelled', '../uploads/Capture1.PNG', '2024-05-24 01:28:44'),
(34, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, 'JQuery', 'Cancelled', '../uploads/Capture1.PNG', '2024-05-24 01:28:55'),
(35, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, 'JQuery', 'Cancelled', '../uploads/application_internship.sql', '2024-05-24 01:32:47'),
(36, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, 'JQuery', 'Cancelled', '../uploads/css-table-17.jpg', '2024-05-24 01:33:34'),
(37, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, 'JQuery', 'Cancelled', '../uploads/applications.PNG', '2024-05-24 01:34:00'),
(38, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, '0', 'Cancelled', '../students/uploads/Capture1.PNG', '2024-05-24 01:37:30'),
(39, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, '0', 'Cancelled', '../students/uploads/Capture1.PNG', '2024-05-24 01:37:50'),
(40, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, '0', 'Cancelled', '../students/uploads/log.php', '2024-05-24 01:38:12'),
(41, '', 'guda.johnmichael.abanil@gmail.com', '', 9, 'Yari', 4, '0', 'Cancelled', '../students/uploads/applications.PNG', '2024-05-24 01:53:08'),
(42, '', 'guda.johnmichael.abanil@gmail.com', '', 9, 'Yari', 4, '0', 'Approved', '../students/uploads/log.php', '2024-05-24 01:57:48'),
(43, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, '0', 'Cancelled', '../students/uploads/log.php', '2024-05-24 02:06:38'),
(44, '', 'guda.johnmichael.abanil@gmail.com', '', 8, 'shopee', 4, '0', 'Cancelled', '../students/uploads/log.php', '2024-05-24 02:06:47'),
(45, '', 'guda.johnmichael.abanil@gmail.com', '', 10, 'burat', 4, '0', 'Cancelled', '../students/uploads/dashingboard.PNG', '2024-05-24 02:09:29'),
(46, '', 'guda.johnmichael.abanil@gmail.com', '', 11, 'Computer Repair', 4, '0', 'Cancelled', '../students/uploads/resume (1).pdf', '2024-05-24 02:56:12'),
(47, '', 'guda.johnmichael.abanil@gmail.com', '', 12, 'tae', 4, '0', 'Cancelled', '../students/uploads/log.php', '2024-05-24 02:59:30'),
(48, '', 'guda.johnmichael.abanil@gmail.com', '', 13, 'tae', 4, '0', 'Cancelled', '../students/uploads/pogiako.pdf', '2024-05-24 03:01:40'),
(49, '', 'guda.johnmichael.abanil@gmail.com', '', 14, 'reetrtre', 4, '0', 'Cancelled', '../students/uploads/css-table-17.jpg', '2024-05-24 03:03:16'),
(50, '', 'guda.johnmichael.abanil@gmail.com', '', 15, 'tangina', 4, '0', 'Cancelled', '../students/uploads/css-table-templates.jpg', '2024-05-24 03:14:35'),
(51, '', 'guda.johnmichael.abanil@gmail.com', '', 15, 'tangina', 4, '0', 'Cancelled', '../students/uploads/css-table-templates.jpg', '2024-05-24 03:14:47'),
(52, '', 'guda.johnmichael.abanil@gmail.com', '', 15, 'tangina', 4, '0', 'Cancelled', '../students/uploads/sidebar_reference.PNG', '2024-05-24 03:15:03'),
(53, '', 'guda.johnmichael.abanil@gmail.com', '', 15, 'tangina', 4, '0', 'Cancelled', '../students/uploads/CSS-Responsive-Table-Layout.jpg', '2024-05-24 03:15:17'),
(54, '', 'skidongskidong@gmail.com', '', 15, 'tangina', 4, '0', 'Cancelled', '../students/uploads/SNIPPP.PNG', '2024-05-24 03:26:43'),
(55, '', 'skidongskidong@gmail.com', '', 15, 'tangina', 4, '0', 'Approved', '../students/uploads/2222.PNG', '2024-05-24 03:27:06'),
(56, '', 'skidongskidong@gmail.com', '', 2, 'Front-End Developer', 1, '0', 'Cancelled', '../students/uploads/icon dashboard.PNG', '2024-05-24 03:41:55'),
(57, '', 'skidongskidong@gmail.com', '', 1, 'Backend Developer', 4, '0', 'Approved', '../students/uploads/jssss.PNG', '2024-05-24 03:43:54'),
(58, '', 'skidongskidong@gmail.com', '', 14, 'reetrtre', 4, '0', 'Approved', '../students/uploads/Capture.PNG', '2024-05-24 04:09:11'),
(59, '', 'skidongskidong@gmail.com', '', 13, 'tae', 4, '0', 'Approved', '../students/uploads/Capture.PNG', '2024-05-24 04:09:29'),
(60, '', 'skidongskidong@gmail.com', '', 8, 'shopee', 4, '0', 'Cancelled', '../students/uploads/log.php for student backup.txt', '2024-05-25 06:29:25'),
(61, '', 'skidongskidong@gmail.com', '', 5, 'Bangag', 4, '0', 'Cancelled', '../students/uploads/css-table-templates.jpg', '2024-05-25 06:43:44'),
(62, '', 'skidongskidong@gmail.com', '', 4, 'Banger', 4, '0', 'Rejected', '../students/uploads/log.php for student backup.txt', '2024-05-25 06:44:11'),
(63, '', 'skidongskidong@gmail.com', '', 7, 'Jwalk', 4, '0', 'Approved', '../students/uploads/css-table-templates.jpg', '2024-05-25 06:44:21'),
(64, '', 'skidongskidong@gmail.com', '', 6, 'Japan', 4, '0', 'Approved', '../students/uploads/css-table-templates.jpg', '2024-05-25 06:44:30'),
(65, '', 'skidongskidong@gmail.com', '', 9, 'Yari', 4, '0', 'Approved', '../students/uploads/css-table-17.jpg', '2024-05-25 06:47:55'),
(66, '', 'skidongskidong@gmail.com', '', 3, 'Tagaluto Pancit', 4, '0', 'Approved', '../students/uploads/Capture1.PNG', '2024-05-25 14:15:21'),
(67, '', 'skidongskidong@gmail.com', '', 17, 'Lazada', 4, '0', 'Approved', '../students/uploads/Capture1.PNG', '2024-05-25 14:40:22'),
(68, '', 'john.abanil.recover@gmail.com', '', 24, 'Php Dev', 1, '0', 'Approved', '../students/uploads/resume (1).pdf', '2024-05-25 18:30:52'),
(69, '', 'john.abanil.recover@gmail.com', '', 25, 'Javascript', 1, '0', 'Approved', '../students/uploads/log.php', '2024-05-25 18:38:55'),
(70, '', 'skidongskidong@gmail.com', '', 28, 'Vaper', 4, '0', 'Approved', '../students/uploads/Desktop.txt', '2024-05-27 04:32:06'),
(71, '', 'john.abanil.recover@gmail.com', '', 2, 'Front-End Developer', 1, '0', 'Pending', '../students/uploads/landing_page.PNG', '2024-05-27 04:41:09'),
(72, '', 'skidongskidong@gmail.com', '', 24, 'Php Dev', 1, '0', 'Pending', '../students/uploads/tata.PNG', '2024-05-27 05:03:40');

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
(1, 'Devin AI', 'RTX', '4090ti', '90', 4, 'Declined', '2024-05-23 09:10:45', 4),
(2, 'Front-End Developer', 'Radeon', 'RX 6600', '80', 1, 'Posted', '2024-05-23 09:12:20', 6),
(3, 'Tagaluto Pancit', 'Pancit Canton', 'Bachelors of Science in Pancit Canton', '2 minutes', 4, 'Declined', '2024-05-23 12:05:02', 1),
(4, 'Banger', 'Katarantaduhan', 'Bobo', 'haha', 4, 'Declined', '2024-05-23 15:44:58', 0),
(5, 'Bangag', 'Kawawa', 'Bobo', 'Tanga', 4, 'Posted', '2024-05-23 15:52:30', 0),
(6, 'Japan', 'Bold', 'Ni', 'Wally', 4, 'Posted', '2024-05-23 15:54:58', 0),
(7, 'Jwalk', 'Ryan', 'Rems', 'KAKASHI', 4, 'Pending', '2024-05-23 15:56:07', 0),
(8, 'shopee', 'shopee', 'shopee', 'shopee', 4, 'Pending', '2024-05-23 16:13:15', 0),
(9, 'Yari', 'N', 'a', 'ako', 4, 'Posted', '2024-05-24 01:50:39', 0),
(10, 'burat', 'burat', 'burat', 'burat', 4, 'Pending', '2024-05-24 02:09:16', 0),
(11, 'Computer Repair', 'Hello Kitty', 'Motherboard', '75 Hours', 4, 'Pending', '2024-05-24 02:40:05', 0),
(12, 'tae', 'burat', 'bobo', 'haha', 4, 'Pending', '2024-05-24 02:59:21', 0),
(13, 'tae', 'tae', 'tae', 'tae', 4, 'Pending', '2024-05-24 03:01:30', 0),
(17, 'Lazada', 'Tiktok', 'Shopee', 'Temu', 4, 'Posted', '2024-05-25 03:10:27', 0),
(18, 'Adam', 'Love', 'Kennedy', 'Eba', 4, 'Pending', '2024-05-25 03:45:07', 0),
(23, 'Casper', 'Ivan', 'Xplit', 'Gobyerno', 4, 'Pending', '2024-05-25 11:53:26', 0),
(24, 'Php Dev', 'Backend', 'API', '90', 1, 'Posted', '2024-05-25 18:29:33', 0),
(25, 'Javascript', 'CSS', 'HTML', 'Bootstrap', 1, 'Declined', '2024-05-25 18:38:07', 0),
(26, 'Cherry Dublin', 'Shaina Jasmin', 'Orpilla', 'Dublined', 7, 'Posted', '2024-05-26 07:16:15', 0),
(27, 'Cherry', 'Dublin', 'Shaina', 'Orpilla', 4, 'Posted', '2024-05-26 07:19:54', 0),
(28, 'Vaper', 'Vapers', 'Vaperos', '4090', 4, 'Posted', '2024-05-26 07:27:03', 0);

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
(1, 'wala hahaha', 'QC', 'Filipino', 'Roman Catholic', 'pakyu', 'Married', 'KVES', 'KVNHS', 'CDM', '2002', '2010', '2024'),
(3, '', '', '', '', '', '', '', '', '', '', '', ''),
(4, 'Astig ako', 'Quezon Memorial Hospital', 'Filipino', 'Roman Catholic', '123', 'Single', 'Kasiglahan Village Elementary School', 'Kasiglahan Village Senior High School', 'Colegio De Montalban', '2008 - 2015', '2020 - 2022', '2022 - ongoing'),
(5, 'sa farm po', 'GTX', 'RTX', 'Roman Catholic', 'ewan ko boi hahaha', 'Single', 'Ewan po', 'Diko po alam', 'RTX', '2002', '2005', '2002');

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
  MODIFY `Company_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `activated_student`
--
ALTER TABLE `activated_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `application_internship`
--
ALTER TABLE `application_internship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `internship`
--
ALTER TABLE `internship`
  MODIFY `Internship_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `pending_employer`
--
ALTER TABLE `pending_employer`
  MODIFY `Company_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pending_student`
--
ALTER TABLE `pending_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
