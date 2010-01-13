<?php
/*
 * Sponge Content Management System
 * Copyright (c) 2009 a2h - http://a2h.uni.cc/
 * http://zvfpcms.sourceforge.net/
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
 *
 */

session_start();

$zvfpcms = true;

// page generation tracker
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

// page id
if (isset($_GET["p"]))
	$pid = $_GET["p"];
else
	$pid = 1;

// the config
require_once('spongecms/config.php');

// and now to include files from the spongecms folder!
require_once($location['root'].'/functions.php');
require_once($location['root'].'/template.php');
require_once($location['root'].'/lang/en.php');

// get configuration from db
$configquery = mysql_query("SELECT * FROM config");
$i=0;
while($row = mysql_fetch_array($configquery))
{
	$cfg[$i]['name'] = $row['config_name'];
	$cfg[$i]['value'] = $row['config_value'];
	
	switch ($row['config_name'])
	{
		case 'language': $cfg_language=$i; break;
		case 'timezone': $cfg_timezone=$i; break;
		case 'sitename': $cfg_sitename=$i; break;
	}
	
	$i+=1;
}

// set the site name
$sitename = $cfg[$cfg_sitename]['value'];

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
		
		$menu[] = array(
			'id' => $row['page_id'],
			'name' => $row['page_title_menu'],
			'name_short' => $row['page_title_menu'],
			'name_full' => $row['page_title_full'],
			'url' => 'index.php?p='.$row['page_id'],
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
$mediaquery = mysql_query("SELECT * FROM media");

// NOW include the chosen language, so that non translated lines aren't broken
if ($cfg[$cfg_language]['value'] != "en")
	require_once("spongecms/lang/".$cfg[$cfg_language]['value'].".php");

// you need at least php 5.2.0
if (version_compare('5.2.0',PHP_VERSION,'>'))
	exit($txt['page_oldphp']);

// set up the templating system
$page = new PageBuilder();
register_shutdown_function(array($page,'outputAll'));

// and now let's have some content!
echo gettopmessage();

ob_start('parsebbcode');
switch ($_GET["p"])
{
	case 'admin':
		$page->setTitle($txt['admin_panel_title']);
		mysql_data_seek($pagequery, 0); // reset the query to allow usage
		include($location['root'].'/admin/admin.php'); // include the admin panel
		break;
	case 'media':
		$page->setTitle($txt['admin_panel_manmed_view']);
		echo '<a href="javascript:history.go(-1)">Go back</a><br /><br />'.media_html($_GET["s"]);
		break;
	default:			
		if ($j == 0)
		{
			$page->setTitle($txt['text_error']);
			echo $txt['page_noexist'];
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
	powered by sponge cms - a project by a2h - http://a2h.uni.cc/
	page generated in '.sprintf('%.3f',$totaltime).' seconds
	please AT LEAST leave this comment in and without modifications -
	your users don\'t see it, so it\'s not much to ask!
	-->'."\n\n";
?>