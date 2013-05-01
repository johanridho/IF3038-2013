-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 23, 2013 at 03:58 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `progin_439_13510011`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignees`
--

CREATE TABLE IF NOT EXISTS `assignees` (
  `member` int(11) NOT NULL,
  `task` int(11) NOT NULL,
  `finished` int(11) NOT NULL,
  PRIMARY KEY (`member`,`task`),
  KEY `task` (`task`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignees`
--

INSERT INTO `assignees` (`member`, `task`, `finished`) VALUES
(1, 1, 1),
(1, 6, 0),
(2, 1, 0),
(2, 6, 1),
(2, 7, 0),
(2, 14, 0),
(2, 15, 0),
(2, 16, 0),
(3, 6, 0),
(3, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(256) NOT NULL,
  `filetype` varchar(5) NOT NULL,
  `task` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `task` (`task`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `path`, `filetype`, `task`) VALUES
(1, 'uploads/TUBES I.pdf', 'file', 1),
(2, 'uploads/gajah.png', 'image', 1),
(3, 'uploads/movie.ogg', 'video', 1),
(4, 'uploads/Tugas_Kelompok_-_Persiapan_Ujicoba_-Task_List_and_Questionnaire.docx', 'file', 5),
(5, 'uploads/Tubes II.pdf', 'file', 6),
(6, 'uploads/FMIPA - Himastron.jpg', 'image', 7),
(7, 'uploads/FMIPA - Himastron.jpg', 'image', 7),
(13, 'uploads/b.jpg', 'image', 14),
(14, 'uploads/SIM C belakang.jpg', 'image', 15),
(15, 'uploads/Format Surat Ijin.pdf', 'file', 16);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `creator` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `creator`) VALUES
(1, 'Pemrograman Internet', 1),
(2, 'Date', 1),
(3, 'Makan Siang', 2),
(5, 'IMK', 3),
(7, 'Jalan jalan', 2),
(8, 'dummy1', 2),
(9, 'dummy2', 2),
(10, 'dummy3', 2),
(11, 'dummy4', 2),
(12, 'dummy5', 2),
(13, 'dummy6', 2),
(14, 'dummy7', 2),
(15, 'dummy8', 2),
(16, 'dummy9', 2),
(17, 'dummy10', 2),
(18, 'dummy11', 2);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member` int(11) NOT NULL,
  `task` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `member` (`member`),
  KEY `task` (`task`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `member`, `task`, `timestamp`, `comment`) VALUES
(2, 1, 1, '2013-03-12 13:56:47', 'Yes, it does'),
(3, 2, 1, '2013-03-20 12:44:25', 'up'),
(4, 1, 1, '2013-03-20 12:48:24', 'down'),
(5, 2, 1, '2013-03-23 14:37:19', 'coba ajax'),
(6, 1, 1, '2013-03-23 14:39:04', 'berhasil'),
(13, 2, 1, '2013-03-23 18:09:55', 'lolwut'),
(15, 2, 6, '2013-03-23 18:46:36', '5 jam lagi deadline'),
(16, 1, 1, '2013-03-23 20:50:51', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `editors`
--

CREATE TABLE IF NOT EXISTS `editors` (
  `member` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  PRIMARY KEY (`member`,`category`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `editors`
--

INSERT INTO `editors` (`member`, `category`) VALUES
(1, 1),
(2, 1),
(2, 3),
(1, 5),
(2, 5),
(3, 5),
(1, 7),
(2, 7),
(1, 8),
(2, 8),
(3, 8),
(1, 9),
(2, 9),
(3, 9),
(1, 10),
(2, 10),
(3, 10),
(1, 11),
(2, 11),
(3, 11),
(1, 12),
(2, 12),
(3, 12),
(1, 13),
(2, 13),
(3, 13),
(1, 14),
(2, 14),
(3, 14),
(1, 15),
(2, 15),
(3, 15),
(1, 16),
(2, 16),
(3, 16),
(1, 17),
(2, 17),
(3, 17),
(1, 18),
(2, 18),
(3, 18);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `avatar` varchar(50) NOT NULL,
  `gender` char(1) NOT NULL,
  `about` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`, `fullname`, `birthdate`, `email`, `avatar`, `gender`, `about`) VALUES
(1, 'enjellan', 'de4ab6e26db462b930510ba83e9f80b7db2bef88', 'Enjella Melissa Nababan', '1991-03-03', 'enjellamelissan@yahoo.com', 'avatars/enjella.JPG', 'F', ''),
(2, 'danny', '0c258ac8c40b49eea99ecbd24e31b1d72aa42772', 'Danny Andrianto', '1992-09-11', 'danny_andrianto@hotmail.com', 'avatars/danny.jpg', 'M', 'about'),
(3, 'arya', '4a82ada5286fe66c040d9593e3e5b68939cca0f1', 'Arya Rezavidi', '1994-03-17', 'arya@gmail.com', 'avatars/arya.jpg', 'M', 'aku ganteng yah'),
(4, 'dummy', '9827b4c03497c80a8a217d1d6646c9b0f88bb2bb', 'Dummy Ajah', '2012-03-04', 'dum@dum.dum', 'avatars/dummy.jpg', 'M', 'lolwut');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `name` varchar(50) NOT NULL,
  `tagged` int(11) NOT NULL,
  PRIMARY KEY (`name`,`tagged`),
  KEY `tagged` (`tagged`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`name`, `tagged`) VALUES
('css', 1),
('html', 1),
('javascript', 1),
('', 3),
('imk', 5),
('lol', 5),
('ajax', 6),
('php', 6),
(' dua', 7),
('satu', 7),
('oke', 14),
('ko', 15),
('', 16);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `creator` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `deadline` datetime NOT NULL,
  `category` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `creator` (`creator`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `creator`, `timestamp`, `deadline`, `category`) VALUES
(1, 'Tubes 1', 1, '2013-02-20 10:50:49', '2013-02-25 22:00:00', 1),
(3, 'Kencan dengan si "dia"', 1, '2013-02-20 21:21:53', '2013-02-24 20:00:00', 2),
(5, 'Tugasgakjelaslah', 2, '2013-03-23 10:30:33', '2012-03-03 12:59:00', 5),
(6, 'Tubes2', 2, '2013-03-23 10:33:01', '2013-03-23 23:00:00', 1),
(7, 'asdsad', 1, '2013-03-23 03:29:37', '2012-03-03 00:00:00', 1),
(8, 'asdsad', 1, '2013-03-23 03:30:00', '2012-03-03 00:00:00', 1),
(10, 'coba bikin', 1, '2013-03-23 03:32:09', '2012-03-03 00:00:00', 1),
(11, 'coba bikin', 1, '2013-03-23 03:34:04', '2012-03-03 00:00:00', 1),
(14, 'coba ah', 2, '2013-03-23 03:50:46', '2013-12-23 12:00:00', 8),
(15, 'coba lagi ah', 2, '2013-03-23 03:51:43', '2012-03-03 00:39:00', 11),
(16, 'asdsadsad', 2, '2013-03-23 03:53:01', '2012-03-03 00:00:00', 10);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignees`
--
ALTER TABLE `assignees`
  ADD CONSTRAINT `assignees_ibfk_1` FOREIGN KEY (`member`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assignees_ibfk_2` FOREIGN KEY (`task`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_ibfk_1` FOREIGN KEY (`task`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`member`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`task`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `editors`
--
ALTER TABLE `editors`
  ADD CONSTRAINT `editors_ibfk_1` FOREIGN KEY (`member`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `editors_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`tagged`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
