-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 29, 2009 at 01:27 PM
-- Server version: 5.1.33
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `spongecms`
--

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `config_name` varchar(32) NOT NULL,
  `config_value` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`config_name`, `config_value`) VALUES
('timezone', 'Australia/Sydney'),
('language', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `media_id` int(11) NOT NULL AUTO_INCREMENT,
  `media_filename` varchar(64) NOT NULL,
  PRIMARY KEY (`media_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`media_id`, `media_filename`) VALUES
(1, 'test.flv'),
(2, 'cityrail.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_orderid` int(11) NOT NULL,
  `page_title_menu` varchar(32) NOT NULL,
  `page_title_full` varchar(64) NOT NULL,
  `page_content` longtext NOT NULL,
  `page_hideinmenu` tinyint(1) NOT NULL DEFAULT '0',
  `page_childof` int(11) NOT NULL DEFAULT '-1',
  `page_dateadded` datetime NOT NULL,
  `page_dateedited` datetime NOT NULL,
  `page_editcount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `page_orderid`, `page_title_menu`, `page_title_full`, `page_content`, `page_hideinmenu`, `page_childof`, `page_dateadded`, `page_dateedited`, `page_editcount`) VALUES
(1, 0, 'home', 'Home', '<p>Hello and welcome to Sponge CMS! It''s in the late alpha stages currently.</p>\r\n<p>It is not recommended you use this script in a production environment in its current state.</p>\r\n<p>The username/password pair is currently admin/admin. Change the password if you like but currently you will need to manually write something to output a password.</p>', 0, -1, '2009-06-23 09:20:49', '2009-06-23 09:20:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_username` varchar(48) NOT NULL,
  `user_displayname` varchar(48) NOT NULL,
  `user_password` varchar(256) NOT NULL,
  `user_password_salt` varchar(256) NOT NULL,
  `user_group` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_username`, `user_displayname`, `user_password`, `user_password_salt`, `user_group`) VALUES
(1, 'admin', 'admin', 'bfcebcbf651cf279058daa3dd6c14728b52cff8a4e0839a48a52cebe1639075467e4259f80308ffb0485f74bf75ad20f6ab44a6cde5240bddebdc2c6e98726eb', '3f7fa01c03a66a42742f52b236322b09', 1);
