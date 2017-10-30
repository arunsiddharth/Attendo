-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2017 at 07:23 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `attendo`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendence`
--

CREATE TABLE IF NOT EXISTS `attendence` (
  `did` int(11) NOT NULL,
  `sid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendence`
--

INSERT INTO `attendence` (`did`, `sid`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(20) NOT NULL,
  `tid` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`cid`, `class_name`, `tid`, `count`) VALUES
(1, 'PHP', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `dates`
--

CREATE TABLE IF NOT EXISTS `dates` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(50) NOT NULL,
  `cid` int(11) NOT NULL,
  `present` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`did`),
  UNIQUE KEY `cid` (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `dates`
--

INSERT INTO `dates` (`did`, `date`, `cid`, `present`, `image`) VALUES
(1, '30-10-2017', 1, 2, 'img/PHP/IMG-20170722-WA0002.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'teacher id',
  `name` varchar(50) NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `subject_id` varchar(50) NOT NULL,
  `cid` int(10) NOT NULL,
  `attendence` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`sid`, `name`, `img_path`, `subject_id`, `cid`, `attendence`) VALUES
(1, 'Joydip Sarkar', 'img/PHP/IMG_20171029_211145_822.jpg', 'Joydip-Sarkar', 1, 1),
(2, 'ARUN SIDDHARTH', 'img/PHP/2.jpg', 'ARUN-SIDDHARTH', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `tid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`tid`),
  UNIQUE KEY `email_id` (`email_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`tid`, `name`, `email_id`, `password`) VALUES
(1, 'Arun Siddharth', 'arunaaa099@gmail.com', '$2y$10$UPAImOFPk3VroNl2usrIXuoAD6kZjzHO1EWKw4n8Vc81S25tDjoQW');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
