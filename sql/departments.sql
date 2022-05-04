-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 02, 2022 at 02:17 AM
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
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `college_id` int(11) NOT NULL,
  `weight` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `college_id`, `weight`) VALUES
(1, 'Department of Biology', 1, 1),
(2, 'Department of Earth Sciences and Petroleum', 1, 2),
(3, 'Department of Chemistry', 1, 3),
(4, 'Department of Computer Science and Information Technology', 1, 4),
(5, 'Department of Environmental Science and Health', 1, 5),
(6, 'Department of Mathematics', 1, 6),
(7, 'Department of Physics', 1, 7),
(8, 'Department of Architecture Engineering', 2, 8),
(9, 'Department of Civil Engineering', 2, 9),
(10, 'Department of Software and Informatics Engineering', 2, 10),
(11, 'Department of Electrical Engineering', 2, 11),
(12, 'Department of Geomatics (Surveying) Engineering', 2, 12),
(13, 'Department of Mechanical Engineering', 2, 13),
(14, 'Department of Water Resources Engineering', 2, 14),
(15, 'Department of Chemical and Petrochemical Engineering', 2, 15),
(16, 'Department of Animal Resources', 3, 17),
(17, 'Department of Soil and water', 3, 18),
(18, 'Department of Food technology', 3, 19),
(19, 'Department of Forestry', 3, 20),
(20, 'Department of Plant Protection', 3, 21),
(21, 'Department of Horticulture', 3, 22),
(22, 'Department of Field crops', 3, 23),
(23, 'Department of Fish Resources and Aquatic Animals', 3, 24),
(24, 'Department of Biology', 4, 25),
(25, 'Department of Chemistry', 4, 26),
(26, 'Department of Physics', 4, 27),
(27, 'Department of Mathematics', 4, 28),
(28, 'Department of English', 4, 29),
(29, 'Department of Arabic', 4, 30),
(30, 'Department of Kurdish', 4, 31),
(31, 'Department of Archaeology', 5, 35),
(32, 'Department of Geography', 5, 36),
(33, 'Department of History', 5, 37),
(34, 'Department of Media', 5, 38),
(35, 'Department of Philosophy', 5, 39),
(36, 'Department of Psychology', 5, 40),
(37, 'Department of Psychology and Educational Sciences', 4, 32),
(38, 'Department of Social Work', 5, 41),
(39, 'Department of Sociology', 5, 42),
(40, 'Department of English', 6, 43),
(41, 'Department of German', 6, 44),
(42, 'Department of French', 6, 45),
(43, 'Department of Kurdish', 6, 46),
(44, 'Department of Arabic', 6, 47),
(45, 'Department of Turkish', 6, 48),
(46, 'Department of Persian', 6, 49),
(47, 'Department of Accounting', 7, 51),
(48, 'Department of Administration', 7, 52),
(49, 'Department of Economics', 7, 53),
(50, 'Department of Finance and Banking', 7, 54),
(51, 'Department of Statistics', 7, 55),
(52, 'Department of Tourism Organizations Administration', 7, 56),
(53, 'Department of Law', 8, 57),
(54, 'Department of Political Systems and Public Policy', 15, 58),
(55, 'Department of General Science', 9, 60),
(56, 'Department of Mathematics', 9, 61),
(57, 'Department of English Language', 9, 62),
(58, 'Department of Kurdish Language', 9, 63),
(59, 'Department of Social Sciences', 9, 64),
(60, 'Department of Kindergarten', 9, 65),
(61, 'Department of Physical Education & Sport Sciences', 10, 67),
(63, 'Department of Religious Education', 12, 68),
(64, 'Department of Music Arts', 11, 69),
(65, 'Department of Cinema and Theater Arts', 11, 70),
(66, 'Department of Plastic Arts', 11, 71),
(67, 'Department of Islamic studies', 12, 72),
(68, 'Department of Principle of religion', 12, 73),
(69, 'Department of Arabic', 13, 75),
(70, 'Department of Kurdish', 13, 76),
(71, 'Department of Biology', 14, 77),
(72, 'Department of Physics', 14, 78),
(73, 'Department of Arabic', 14, 79),
(74, 'Department of Kurdish', 14, 80),
(75, 'Department of Arabic', 9, 66),
(76, 'Department of Sharia', 12, 74),
(77, 'Department of Special Education', 4, 33),
(78, 'Department of Syriac', 4, 34),
(81, 'Department of Physical Education', 14, 81),
(82, 'Department of Chinese', 6, 50),
(83, 'Department of International Relations & Diplomacy', 15, 59),
(84, 'Website', 16, 0),
(85, 'Sport Activity', 17, 0),
(86, 'Research Centre', 22, 0),
(87, 'Department of Aviation Engineering ', 2, 16),
(88, 'Research Center', 38, 83),
(89, 'Research Center-1', 39, 0),
(90, 'Language Center', 40, 0),
(91, 'Language Center-1', 41, 0),
(92, 'Language Center', 42, 84),
(94, 'Department of English', 14, 82),
(95, 'Retired and Honored Staff', 43, 85);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
