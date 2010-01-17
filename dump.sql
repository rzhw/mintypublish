-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 16, 2010 at 07:57 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `mintypublish`
--

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `config_name` varchar(32) NOT NULL,
  `config_value` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`config_name`, `config_value`) VALUES
('timezone', 'Australia/Sydney'),
('language', 'en'),
('sitename', 'My Unnamed Website'),
('disabled', 'false'),
('theme', 'default');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_filename` varchar(64) NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `file_filename`) VALUES
(1, 'test.flv'),
(2, 'cityrail.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_orderid` int(11) NOT NULL,
  `page_title_menu` varchar(32) NOT NULL,
  `page_title_full` varchar(64) NOT NULL,
  `page_content` longtext NOT NULL,
  `page_hideinmenu` tinyint(1) NOT NULL DEFAULT '0',
  `page_haschild` tinyint(1) NOT NULL,
  `page_childof` int(11) NOT NULL DEFAULT '-1',
  `page_dateadded` datetime NOT NULL,
  `page_dateedited` datetime NOT NULL,
  `page_editcount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `page_orderid`, `page_title_menu`, `page_title_full`, `page_content`, `page_hideinmenu`, `page_haschild`, `page_childof`, `page_dateadded`, `page_dateedited`, `page_editcount`) VALUES
(1, 0, 'home', 'Home', '<p>Hello and welcome to your mintypublish installation!</p>\n<p>Please note that it is not recommended you use this script in a production environment in its current state.</p>\n<p>The username/password pair is currently admin/admin. Change the password if you like but currently you will need to manually write something to output a password.</p>', 0, 0, -1, '2009-06-23 09:20:49', '2009-12-03 20:47:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_username` varchar(48) NOT NULL,
  `user_displayname` varchar(48) NOT NULL,
  `user_password` varchar(256) NOT NULL,
  `user_password_salt` varchar(256) NOT NULL,
  `user_group` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_username`, `user_displayname`, `user_password`, `user_password_salt`, `user_group`) VALUES
(1, 'admin', 'admin', 'bfcebcbf651cf279058daa3dd6c14728b52cff8a4e0839a48a52cebe1639075467e4259f80308ffb0485f74bf75ad20f6ab44a6cde5240bddebdc2c6e98726eb', '3f7fa01c03a66a42742f52b236322b09', 1);
