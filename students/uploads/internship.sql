-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2024 at 08:57 PM
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
(2, 'Brainy\r\nKnowledge', '90 hours', 'Programmer', 'Networking', 1),
(3, '18 Years Old and Above', '24/7', 'No Description', 'PC Builder', 1),
(9, 'RERE', 'ERE', 'RRERE', 'REE', 1),
(10, 'bobo', 'tanga', 'gago', 'kantutan', 1),
(11, 'fdfdf', 'fddffdf', 'ffddffddf', 'fdffd', 1),
(12, '4555', '45545', '45555', '45545', 4),
(13, 'rttrtt', 'rtr', 'rttrt', 'trtr', 4),
(14, '565656', '656', '56655656', '565656', 4),
(15, '565665', '6566', '565565', '566', 4),
(16, 'rtt', 'rttt', 'trtr', 'trtrt', 4),
(17, 'tarantado', 'gago', 'ayokio na', 'gago', 4),
(18, 'gago', 'tae', 'hello', 'hi', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `internship`
--
ALTER TABLE `internship`
  ADD PRIMARY KEY (`Internship_ID`),
  ADD KEY `Company_ID` (`Company_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `internship`
--
ALTER TABLE `internship`
  MODIFY `Internship_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `internship`
--
ALTER TABLE `internship`
  ADD CONSTRAINT `internship_ibfk_1` FOREIGN KEY (`Company_ID`) REFERENCES `activated_employer` (`Company_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
