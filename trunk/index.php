<?php
// page generation tracker
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

// these files are essential (yes, even the english language no matter what)
require_once("zvfpcms/functions.php");
require_once("zvfpcms/config.php");
require_once("zvfpcms/lang/en.php");

// NOW include the chosen language, so that non translated lines aren't broken
if ($cfg['lang'] != "en")
	require_once("zvfpcms/lang/".$cfg['lang'].".php");

// no json? D:
if (!function_exists("json_encode"))
	exit($txt['page_nojson']);

// TODO: CREATE A TEMPLATING SYSTEM

// start the page
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>zvfpcms dev</title>
		
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="'.$path['css'].'/lightwindow.css" />
		<link rel="stylesheet" type="text/css" href="'.$path['css'].'/default.css" />
    
		<!-- JavaScript -->
		<script type="text/javascript" src="'.$path['js'].'/prototype.js"></script>
		<script type="text/javascript" src="'.$path['js'].'/effects.js"></script>
		<script type="text/javascript" src="'.$path['js'].'/lightwindow.js"></script>
	</head>
	<body>';

// the top, you know... logo and menu...
echo '
	<div id="global_wrapper">
			<img src="'.$path['images'].'/logo.jpg" alt="" />
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
					<a href="index.php?p=admin">admin</a>
				</div>
				<div style="clear:both;"></div>
			</div>';

// and now let's have some content!
echo '
			<div id="content_wrapper">
<!-- Content start -->';
	$tehfilezors = $path['pages'].'/'.$_GET["p"].'.php';

	// home page has no short name
	if ($tehfilezors == $path['pages'].'/.php')
		$tehfilezors = $path['pages'].'/home.php';

	// admin page is special :P
	if ($_GET["p"] == "admin")
		$tehfilezors = $path['root'].'/admin.php';

	// and so we include the page...
	if (file_exists($tehfilezors))
		include($tehfilezors);
	else
		echo $txt['page_noexist'];
echo '
<!-- Content end -->
			</div>';
			
// we has a footer
echo '
			<!-- it would be appreciated if you do not remove the "powered by" part -->
			<div id="footer_wrapper">
				<a href="http://zfvpcms.sourceforge.net/">'.$txt['zvfpcms_powered'].'</a>
				| <a href="http://a2h.uni.cc/">'.$txt['zvfpcms_a2h'].'</a>';
				$mtime = explode(' ', microtime());	$totaltime = $mtime[0] + $mtime[1] - $starttime;
				printf(' | '.str_replace('[t]','%.3f',$txt['zvfpcms_generated']), $totaltime);
				?>
			</div>
		</div>
	</body>
</html>