-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2024 at 10:17 PM
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
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL DEFAULT 'employer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activated_employer`
--

INSERT INTO `activated_employer` (`id`, `name`, `email`, `password`, `code`, `active`, `access`) VALUES
(1, 'Employer1', 'gokieshanvy@gmail.com', '$2y$10$ejKCrt3OyJ.69VLY4O1T.OkJ1ldb..PpLEMSD6ZWTxpVXt37cNsnC', '$2y$10$PeL9isOwP23.mGmzr2Nl/u3tvFxrqmtKm8P9T.nPookkZNzu787BS', '1', 'employer');

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
  `access` varchar(255) NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activated_student`
--

INSERT INTO `activated_student` (`id`, `name`, `email`, `password`, `code`, `active`, `access`) VALUES
(1, 'Ferrguzus', 'guda.johnmichael.abanil@gmail.com', '$2y$10$FM8AbrY385Dt9YhleojZo.Vq.tML7SbaAKmDZszRRXL4.AyWdo2N.', '$2y$10$gshnzkpTKS/RNUso4B9DA.pTt5VMDv3HMmG8gXxrGRjHWDiW9td9W', '1', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `pending_employer`
--

CREATE TABLE `pending_employer` (
  `id` int(11) NOT NULL,
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
-- Indexes for dumped tables
--

--
-- Indexes for table `activated_employer`
--
ALTER TABLE `activated_employer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activated_student`
--
ALTER TABLE `activated_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_employer`
--
ALTER TABLE `pending_employer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_student`
--
ALTER TABLE `pending_student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activated_employer`
--
ALTER TABLE `activated_employer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activated_student`
--
ALTER TABLE `activated_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pending_employer`
--
ALTER TABLE `pending_employer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pending_student`
--
ALTER TABLE `pending_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
