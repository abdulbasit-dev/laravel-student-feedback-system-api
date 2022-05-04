-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 02, 2022 at 02:16 AM
-- Server version: 5.6.51
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `academic_qa`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_titles`
--

CREATE TABLE `academic_titles` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `title_abbr` varchar(32) NOT NULL,
  `title_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `academic_titles`
--

INSERT INTO `academic_titles` (`id`, `title`, `title_abbr`, `title_desc`) VALUES
(1, 'Assistant lecturer', 'Assistant-Lectr.', 'Assistant Lecturer'),
(2, 'Lecturer', 'Lecturer', 'Lecturer'),
(3, 'Assistant professor', 'Assistant Prof.', 'Assistant professor'),
(4, 'Professor', 'Professor', 'Professor'),
(5, 'Senior Lecturer', 'Senior Lect.', 'Senior Lecturer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_titles`
--
ALTER TABLE `academic_titles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_titles`
--
ALTER TABLE `academic_titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
