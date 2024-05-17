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
(1, 'John Michael Abanil', 'guda.johnmichael.abanil@gmail.com', '$2y$10$FM8AbrY385Dt9YhleojZo.Vq.tML7SbaAKmDZszRRXL4.AyWdo2N.', '$2y$10$gshnzkpTKS/RNUso4B9DA.pTt5VMDv3HMmG8gXxrGRjHWDiW9td9W', '1', 'student', 'Male', 'Kasiglahan Village National High School\r\nKasiglahan Village Senior High School\r\nColegio De Montalban', 'BS Information Technology', '22-00406', '2002-06-28', '09691588952'),
(2, 'ryandingle', 'gokieshanvy@gmail.com', '$2y$10$R2HEe.Px5I53YKNtHXyeGugGF993XSG7cYg/y60j80kOE0gTeopRi', '$2y$10$71Fxoe8E0e5nOm4CId4hEuIpd8nymXzb5kA6B7LP.kh98GU2RaZLO', '1', 'student', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'tangina', 'fergdoflamingo@gmail.com', '$2y$10$8A2e1M1557Iy7YjPzzoNIeLvyYN8Hfqqcoeg7wHBwquNDO/j3LPXa', '$2y$10$7v1vfMk14DQM3FRip31gOeZnB8Pw.97cglj7vuCSNNnApbPCr.SUO', '1', 'student', 'Female', 'yep', 'BS Computer Engineering', '2212345', '2024-05-02', '09691588952');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activated_student`
--
ALTER TABLE `activated_student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activated_student`
--
ALTER TABLE `activated_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
