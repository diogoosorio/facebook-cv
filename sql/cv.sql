-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 14, 2012 at 01:40 PM
-- Server version: 5.1.61
-- PHP Version: 5.3.6-13ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cv`
--

-- --------------------------------------------------------

--
-- Table structure for table `static`
--

CREATE TABLE IF NOT EXISTS `static` (
  `st_ID` int(11) NOT NULL AUTO_INCREMENT,
  `st_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `st_text` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`st_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `timeline`
--

CREATE TABLE IF NOT EXISTS `timeline` (
  `tl_ID` int(11) NOT NULL AUTO_INCREMENT,
  `tl_type` enum('work','education','portfolio') COLLATE utf8_bin NOT NULL,
  `tl_url` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `tl_thumb` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `tl_title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `tl_date` date DEFAULT NULL,
  `tl_end_date` date DEFAULT NULL,
  `tl_main_desc` text COLLATE utf8_bin NOT NULL,
  `tl_inner_desc` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`tl_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_fb_ID` bigint(20) unsigned NOT NULL,
  `user_fb_session` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_linkedin` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_page_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'My Facebook',
  `user_last_access` datetime DEFAULT NULL,
  `user_analytics` text COLLATE utf8_bin,
  `user_highlight_work` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_highlight_school` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_highlight_pashion` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_highlight_location` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
