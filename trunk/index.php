<?php
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
				<div style="float:left;">';
					$data = json_decode(file_get_contents($path['pages'].'/pages.txt'),true);
					
					for($i=0;$i<sizeof($data);$i++)
					{
						echo '<a href="index.php'.($data[$i]["shortname"]==null ? '' : '?p='.$data[$i]["shortname"]).'"'.($_GET["p"]==$data[$i]["shortname"] ? ' class="menu_current"' : '').'>'.$data[$i]["fullname"].'</a>';
						
						if ($i < (sizeof($data)-1))
							echo ' | ';
					}
echo '
				</div>
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

	$tehfilezors = $path['pages'].'/'.$_GET["p"].'.php';

	// home page has no short name
	if ($tehfilezors == $path['pages'].'/.php')
		$tehfilezors = $path['pages'].'/home.php';

	// admin page is special :P
	if ($_GET["p"] == "admin")
		$tehfilezors = $path['root'].'/admin/admin.php';

	// and so we include the page...
	ob_start('parsebbcode');
	
	if (file_exists($tehfilezors))
		include($tehfilezors);
	else
		echo $txt['page_noexist'];
		
	ob_end_flush();
echo '
			</div>
<!-- Content end -->
';
			
// we has a footer
echo '
			<!--
			it would be appreciated if you do not remove the "powered by" part
			if you must remove it, at least keep this comment here
			
			powered by sponge cms - a project by a2h - http://a2h.uni.cc/
			-->
			<div id="footer_wrapper">
				<a href="http://zfvpcms.sourceforge.net/">'.$txt['zvfpcms_powered'].'</a>
				| <a href="http://a2h.uni.cc/">'.$txt['zvfpcms_a2h'].'</a>';
				$mtime = explode(' ', microtime());	$totaltime = $mtime[0] + $mtime[1] - $starttime;
				printf(' | '.str_replace('[t]','%.3f',$txt['zvfpcms_generated']), $totaltime);
				echo '
			</div>';
include($path['theme_root'] . '/footer.php');

// end mysql
mysql_close($sql_mysql_connection);

?>