<?php
/*
	Sponge CMS
	Copyright 2009 a2h - http://a2h.uni.cc/

	Licensed under the Apache License, Version 2.0 (the "License");
	you may not use this file except in compliance with the License.
	You may obtain a copy of the License at

		http://www.apache.org/licenses/LICENSE-2.0

	Unless required by applicable law or agreed to in writing, software
	distributed under the License is distributed on an "AS IS" BASIS,
	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	See the License for the specific language governing permissions and
	limitations under the License.
	
	http://a2h.github.com/Sponge-CMS/
*/
session_start();

$zvfpcms = true;

// page generation tracker
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

// the config
require_once('spongecfg.php');

// and now to include files from the spongecms folder!
require_once($path['root'].'/functions.php');
require_once($path['root'].'/lang/en.php');

// connect to mysql
$sql_mysql_connection = mysql_connect('localhost','root','');
mysql_select_db('spongecms',$sql_mysql_connection);

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
	}
	
	$i+=1;
}

// get list of pages
$pagequery = mysql_query("SELECT * FROM pages ORDER BY page_orderid ASC");

$i = 0; $j = 0;
while ($row = mysql_fetch_array($pagequery))
{
	// page id
	if (isset($_GET["p"]))
		$pid = $_GET["p"];
	else
		$pid = 1;
	
	// menu stuff
	if ($row['page_childof'] == -1 && $row['page_hideinmenu'] == 0)
	{
		if ($i > 0) { $menucontent .= ' | '; }
		$menucontent .= '<a href="index.php?p='.$row['page_id'].'"'.
		($row['page_id']==$pid?' class="menu_current"':'').'">'.$row['page_title_menu'].'</a>';
		$i+=1;
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

// you need at least php 5.1.0
if (version_compare('5.1.0',PHP_VERSION,'>'))
	exit($txt['page_oldphp']);

// incoming header!
include($path['theme_root'] . '/header.php');

// menu start
echo '
			<div id="menu_wrapper">
				<div style="float:left;">'.$menucontent.'</div>
				<div style="float:right;overflow:hidden;">
					';
					
					if (isloggedin())
					{
						echo '<b>Logged in as: '.$_SESSION['uname'].'</b>
						(<a href="index.php?p=admin">admin</a> |
						<a href="'.$path['admin'].'&amp;s=logout">logout</a>)';
					}
					else
					{
						echo '<b>Not logged in</b>
						(<a href="index.php?p=admin">login</a> |
						<a href="'.$path['admin'].'&amp;s=register">register</a>)';
					}
					
					echo '
				</div>
				<div style="clear:both;"></div>
			</div>';
// menu end

// and now let's have some content!
echo '
<!-- Content start -->
			<div id="content_wrapper">
';
	echo gettopmessage();

	ob_start('parsebbcode');
	switch ($_GET["p"])
	{
		case 'admin':
			mysql_data_seek($pagequery, 0); // reset the query to allow usage
			include($path['root'].'/admin/admin.php'); // include the admin panel
			break;
		case 'media':
			echo '<a href="javascript:history.go(-1)">Go back</a><br /><br />'.media_html($_GET["s"]);
			break;
		default:			
			if ($i == 0)
				echo $txt['page_noexist'];
			else
				echo $pagecontent;
			break;
	}
	ob_end_flush();
	
echo '
			</div>
<!-- Content end -->
';
			
// we has a footer
$footer_copyright = '
	<!--
	it would be appreciated if you do not remove the "powered by" part
	if you must remove it, at least keep this comment here
	
	powered by sponge cms - a project by a2h - http://a2h.uni.cc/
	-->
	<a href="http://zfvpcms.sourceforge.net/">'.$txt['zvfpcms_powered'].'</a>
	| <a href="http://a2h.uni.cc/">'.$txt['zvfpcms_a2h'].'</a>';
	
$mtime = explode(' ', microtime());
$totaltime = $mtime[0] + $mtime[1] - $starttime;
$footer_generated = sprintf('%.3f',$totaltime);

include($path['theme_root'] . '/footer.php');

// end mysql
mysql_close($sql_mysql_connection);

?>