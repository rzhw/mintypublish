<?php
/**
 * mintypublish Content Management System
 * Copyright (c) 2009-2010 a2h
 * http://github.com/a2h/mintypublish
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Under section 7b of the GNU General Public License you are
 * required to preserve this notice.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// if someone stumbles across here, send them back up to the root
if ($_SERVER['SCRIPT_NAME'] == $_SERVER['REQUEST_URI'])
{
	header("HTTP/1.1 307 Temporary Redirect");
	header("Location: ../");
	exit();
}

// begin the session
session_start();

// this variable is used to check if a script is being run under mintypublish, might want to make it a constant
$zvfpcms = true;

// page generation tracker
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

// page id (later make the database track the default page)
if (isset($_GET["p"]))
	$pid = $_GET["p"];
else
	$pid = 1;

// begin including things
require_once($root.'/config.php');
require_once($root.'/functions.php');
require_once($root.'/template.php');

// set the site name
$sitename = MP_SITENAME;

// get list of pages
$pagequery = mysql_query("SELECT * FROM pages ORDER BY page_orderid ASC");

$i = 0; $j = 0;
while ($row = mysql_fetch_array($pagequery))
{
	
	// menu stuff
	if ($row['page_childof'] == -1 && $row['page_hideinmenu'] == 0)
	{
		if ($row['page_id'] == $pid)
		{
			$sel = true;
			$curpgtitle = $row['page_title_full'];
		}
		else
		{
			$sel = false;
		}
		
		if ($row['page_id'] == 1)
		{
			$purl = './';
		}
		else
		{
			$purl = 'index.php?p=' . $row['page_id'];
		}
		
		$menu[] = array(
			'id' => $row['page_id'],
			'name' => $row['page_title_menu'],
			'name_short' => $row['page_title_menu'],
			'name_full' => $row['page_title_full'],
			'url' => $purl,
			'selected' => $sel
		);
	}
	
	// content stuff
	if ($row['page_id'] == $pid)
	{
		$pagecontent = '';
		
		//if ($row['page_childof'] != -1)
			//$pagecontent .= '<p><b>This page is a child page of <a href="index.php?p='.$row['page_childof'].'">this page</a>.</b></p>';
		
		$pagecontent .= $row['page_content'];
		if ($j > 0) { $pagecontent = 'wtf'; }
		$j+=1;
	}
}

// get list of media
$mediaquery = mysql_query("SELECT * FROM files");

// you need at least php 5.2.0
if (version_compare('5.2.0',PHP_VERSION,'>'))
	exit($txt['page_oldphp']);

// set up the templating system
$page = new PageBuilder();
register_shutdown_function(array($page,'outputAll'));

// and now let's have some content!
ob_start('parsebbcode');
$page->addBodyClass('page-' . preg_replace('/[^a-zA-Z0-9\s]/', '', $pid));
switch ($_GET['p'])
{
	case 'logout':
		include($location['admin2'].'/logout.php');
		break;
	case 'media':
		include($location['root'] . '/media.php');
		break;
	default:			
		if ($j == 0)
		{
			$page->setTitle($txt['text_error']);
			echo $txt['noexist'];
		}
		else
		{
			$page->setTitle($curpgtitle);
			echo $pagecontent;
		}
		break;
}
ob_end_flush();
			
// we has a footer	
$mtime = explode(' ', microtime());
$totaltime = $mtime[0] + $mtime[1] - $starttime;

$footer['copyright'] = '
	<!--
	powered by mintypublish - a project by a2h - http://a2h.uni.cc/
	page generated in '.sprintf('%.3f',$totaltime).' seconds
	please AT LEAST leave this comment in and without modifications -
	your users don\'t see it, so it\'s not much to ask!
	-->'."\n\n";
?>