-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 22, 2020 at 11:45 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bms`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

DROP TABLE IF EXISTS `bookmark`;
CREATE TABLE IF NOT EXISTS `bookmark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `title` varchar(256) COLLATE utf8mb4_turkish_ci NOT NULL,
  `url` varchar(512) COLLATE utf8mb4_turkish_ci NOT NULL,
  `note` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `owner` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`id`, `category`, `title`, `url`, `note`, `owner`, `created`) VALUES
(74, 'CategoryB', 'PHP Reference Page', 'http://www.php.net', 'This site is the main page for php functions.', 74, '2020-05-06 15:52:26'),
(75, 'CategoryC', 'Learn about Material Design and our Project Team', 'https://materializecss.com/preloader.html', 'Created and designed by Google, Material Design is a design language that combines the classic principles of successful design along with innovation and technology. Google\'s goal is to develop a system of design that allows for a unified user experience across all their products on any platform.', 74, '2020-05-06 15:53:23'),
(76, 'CategoryB', 'The new way to improve your programming skills while having fun and getting noticed', 'https://www.codingame.com/start', 'At CodinGame, our goal is to let programmers keep on improving their coding skills by solving the World\'s most challenging problems, learn new concepts, and get inspired by the best developers.', 74, '2020-05-06 15:54:50'),
(107, 'CategoryA', 'Edit title', 'Edit Url', 'Edit notes', 74, '2020-05-16 20:04:44'),
(114, 'CategoryA', 'Google title', 'www.google.com', 'Google Notes', 74, '2020-05-18 21:38:46'),
(115, 'CategoryA', 'Amazon', 'www.amazon.com', 'Amazon Notes', 74, '2020-05-18 21:39:10'),
(116, 'CategoryA', 'Facebook', 'www.facebook.com', 'Facebook Notes', 74, '2020-05-18 21:39:27'),
(117, 'CategoryC', 'Sahibinden', 'www.sahibinden.com', 'Sahibinden notes', 74, '2020-05-18 21:40:35'),
(118, 'CategoryB', 'Bilkent', 'www.bilkent.edu.tr', 'Bikent web site', 74, '2020-05-18 21:41:19'),
(119, 'CategoryB', 'Haberler', 'www.haberler.com', 'Haberler notes', 74, '2020-05-18 21:41:44'),
(120, 'CategoryA', 'Furkan Kılıç', 'ewrw', 'werw', 74, '2020-05-19 11:12:58'),
(125, 'werwer', 'ddd', 'dddd', 'ddddd', 74, '2020-05-20 22:45:58'),
(126, 'CategoryA', 'Learn about Material Design and our Project Team', 'https://materializecss.com/preloader.html', 'Created and designed by Google, Material Design is a design language that combines the classic principles of successful design along with innovation and technology. Google\'s goal is to develop a system of design that allows for a unified user experience across all their products on any platform.', 75, '2020-05-22 14:05:14'),
(127, 'CategoryB', 'PHP Reference Page', 'http://www.php.net', 'This site is the main page for php functions.', 75, '2020-05-22 14:06:21'),
(128, 'CategoryB', 'bilkent mail', 'https://webmail.bilkent.edu.tr/', 'bilkent mail website', 75, '2020-05-22 14:07:36'),
(129, 'CategoryB', 'bilkent mail', 'https://webmail.bilkent.edu.tr/', 'bilkent mail website', 74, '2020-05-22 17:05:17'),
(130, 'CategoryC', 'bilkent mail', 'https://webmail.bilkent.edu.tr/', 'bilkent mail website', 74, '2020-05-22 17:05:48');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categoryname` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`categoryname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryname`) VALUES
('CategoryA'),
('CategoryB'),
('CategoryC');

-- --------------------------------------------------------

--
-- Table structure for table `share`
--

DROP TABLE IF EXISTS `share`;
CREATE TABLE IF NOT EXISTS `share` (
  `bookmarkid` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `seen` int(11) NOT NULL,
  UNIQUE KEY `bookmarkid` (`bookmarkid`,`receiver_id`),
  UNIQUE KEY `bookmarkid_2` (`bookmarkid`,`receiver_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `share`
--

INSERT INTO `share` (`bookmarkid`, `sender_id`, `receiver_id`, `seen`) VALUES
(75, 74, 75, 0),
(74, 74, 75, 0),
(128, 75, 74, 1),
(127, 75, 74, 1),
(126, 75, 74, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8mb4_turkish_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_turkish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `bday` date DEFAULT NULL,
  `profile` varchar(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `bday`, `profile`) VALUES
(72, 'Mustafa Kurnaz', 'mkurnaz@gmail.com', '$2y$10$Z/7F3o4vNOmx2y/pwtDFwuV2f2QmGBSc.I7qPpM6kzVfL.i/XfnoW', NULL, NULL),
(73, 'Özge Canlı', 'canli@one.com', '$2y$10$hlYrJq3Beaaks3ZrwogfHuwLyjLDhZsdJDNghhLsTRs97E1BlVGim', NULL, NULL),
(74, 'John Vue', 'john@one.com', '$2y$10$RhvPadaHOU20zTpVRQBRBOV9GraCYmgpCiVQ.X6NZbvlCyow.fV1y', NULL, '86006300836bff3e3b936a2d1aa3bcff8e5f0da4_6bed534a2ca457a97b55ec0b52f08c40c5e73997_p1.jpg'),
(75, 'Furkan Kılıç', 'furkan_klc@hotmail.com', '$2y$10$dNZD0VUuaGxQoT6yHsau0uMHTZXr4.PPVyWU6V6v.AzvDN2iRPVKK', NULL, 'd975a11a1272d44fe70eb82be3da298026a3049d_p1.jpg');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
