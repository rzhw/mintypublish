<?php
if (!function_exists("json_encode"))
{
	exit("Sorry, but JSON support is required to run ZVFPCMS. It should be included with PHP 5.20 and above.");
}

$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

require_once("zvfpcms/functions.php");
require_once("zvfpcms/lang/en.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>zvfpcms dev</title>
		
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="zvfpcms/css/lightwindow.css" />
		<link rel="stylesheet" type="text/css" href="zvfpcms/css/default.css" />
    
		<!-- JavaScript -->
		<script type="text/javascript" src="zvfpcms/js/prototype.js"></script>
		<script type="text/javascript" src="zvfpcms/js/effects.js"></script>
		<script type="text/javascript" src="zvfpcms/js/lightwindow.js"></script>
	</head>
	<body>
		<div id="global_wrapper">
			<img src="zvfpcms/img/logo.jpg" alt="" />
			<div id="menu_wrapper">
				<div style="float:left;">
					<?php
						$data = json_decode(file_get_contents("zvfpcms/pg/pages.txt"),true);
						
						for($i=0;$i<sizeof($data);$i++)
						{
							echo '<a href="index.php'.($data[$i]["shortname"]==null ? '' : '?p='.$data[$i]["shortname"]).'"'.($_GET["p"]==$data[$i]["shortname"] ? ' class="menu_current"' : '').'>'.$data[$i]["fullname"].'</a>';
							
							if ($i < (sizeof($data)-1))
								echo ' | ';
						}
					?>
				</div>
				<div style="float:right;overflow:hidden;">
					<a href="index.php?p=admin">admin</a>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div id="content_wrapper">
<!-- Content start -->
<?php
$tehfilezors = "zvfpcms/pg/".$_GET["p"].".php";

// home page has no short name
if ($tehfilezors == "zvfpcms/pg/.php")
	$tehfilezors = "zvfpcms/pg/home.php";

// admin page is special :P
if ($_GET["p"] == "admin")
	$tehfilezors = "zvfpcms/admin.php";

// and so we include the page...
if (file_exists($tehfilezors))
	include($tehfilezors);
else
	echo 'This page does not exist.';
?>

<!-- Content end -->
			</div>
			<div id="footer_wrapper">
				<a href="http://a2h.uni.cc/">another creation from the strange mind of a2h</a>
				| <a href="http://zfvpcms.sourceforge.net/">powered by zvfp cms</a>
				<?php
					$mtime = explode(' ', microtime());
					$totaltime = $mtime[0] + $mtime[1] - $starttime;
					printf(' | page generated in %.3f seconds', $totaltime);
				?>
			</div>
		</div>
	</body>
</html>