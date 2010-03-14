-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 14, 2010 at 06:53 PM
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
('language', 'english'),
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
  `file_iscategory` tinyint(1) NOT NULL DEFAULT '0',
  `file_childof` int(11) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `file_filename`, `file_iscategory`, `file_childof`) VALUES
(1, 'test.flv', 0, -1),
(2, 'cityrail.mp3', 0, -1);

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
  `page_haschild` tinyint(1) NOT NULL DEFAULT '0',
  `page_childof` int(11) NOT NULL DEFAULT '-1',
  `page_dateadded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `page_dateedited` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `page_editcount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `page_orderid`, `page_title_menu`, `page_title_full`, `page_content`, `page_hideinmenu`, `page_haschild`, `page_childof`, `page_dateadded`, `page_dateedited`, `page_editcount`) VALUES
(1, 0, 'home', 'Home', '<h1>Hello there!</h1>\n<p>Why hello to you too, and welcome to mintypublish! Hopefully the install''s gone smoothly, and everything that should be in place is in place! mintypublish aims to be a CMS that''s easy to use, enjoyable, and really, <em>really</em> minty*. In fact, this page was written with the inbuilt editor, TinyMCE. Without touching the HTML button at all. How''s that for minty*?</p>\n<h1>So my good friend, how does I admin?</h1>\n<p><img style="float: right; margin: -24px 12px;" src="mintypublish/help/adminaccess.png" alt="" width="353" height="135" /></p>\n<p>Good question! All you have to do is to navigate to a folder called mintypublish. How exactly? See the address bar up top? Say you have mintypublish hosted at http://www.example.com/ - simply replace anything after that bit in the URL with mintypublish. If you''re not clear on this, have a look at the image to your right. This will bring you to a login screen if you''re not logged in (the default username and password are both admin, be sure to change your password!). If you are, you''ll just be sent straight back to your website.</p>\n<h1><strong>Alright, so just what exactly can I do right now?</strong></h1>\n<p>Well, currently, mintypublish is pre-alpha, but there''s still basic functionality!</p>\n<p><img style="margin-left: 12px; margin-right: 12px; float: left;" src="mintypublish/help/editmode.png" alt="" /></p>\n<h2>Modes</h2>\n<p>On the top-left, you can switch between modes. What exactly are modes? They''re a way to change the way your page is being viewed. Currently, mintypublish offers preview and edit modes. By default, you''re in the preview mode. The preview mode shows you what your website looks like to outsiders, apart from having the bar on top. The other mode currently offered, edit mode, lets you edit the page you''re currently viewing. Modes don''t require page refreshes, so it''s seamless :)</p>\n<h2>Configuration</h2>\n<p><img style="float: right; margin: -24px 12px;" src="mintypublish/help/config.png" alt="" /></p>\n<p>You can configure your website through buttons located on the top-right. Currently, you can work with files, pages, and general options in your website. Next to these buttons is a button for managing your account and/or profile on this website (currently however, it only offers a logout feature). Each of the configuration buttons opens a small window that allows you to manage whatever it is to your liking. Files allows you to upload, view and manage files on your server. Pages allows you to add, view and manage pages... and it''s great for when your theme doesn''t have a proper menu! And of course, configuration allows you to, well, configure your site''s settings!</p>\n<h1>So, can I help out?</h1>\n<p><img style="margin-left: 12px; margin-right: 12px; float: left;" src="mintypublish/help/github.png" alt="" /></p>\n<p>Because mintypublish is licensed under the GNU General Public License 3.0 and is hosted on GitHub, you can easily help and contribute, so yes! All you need to have is the right development tools, a Git client and an account at GitHub, and you can hop over to <a href="http://github.com/a2h/mintypublish">http://github.com/a2h/mintypublish</a> and hit fork. Volia, you have your own Git repository that you can start working on, and you can send changes back up easily! If you''re a Subversion user and you''ve never tried Git, give it a go. You''ll probably like it ;)</p>\n<p>All in all, have fun with mintypublish!</p>\n<p>&nbsp;</p>\n<p><span style="font-size: x-small;">* Not clincally tested. Results may vary. Mintyness side effects may include but are not limited to: trahioperjiytunehorea, masiogeknitoblargitis, ongetrophintarkomintitis. Call your doctor if symptoms persist.</span></p>', 0, 0, -1, '2009-06-23 09:20:49', '2009-12-03 20:47:10', 0);

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
