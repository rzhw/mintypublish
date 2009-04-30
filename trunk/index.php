<?php
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

require_once("functions.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>zvfpcms dev</title>
		
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="css/lightwindow.css" />
		<link rel="stylesheet" type="text/css" href="css/default.css" />
    
		<!-- JavaScript -->
		<script type="text/javascript" src="js/prototype.js"></script>
		<script type="text/javascript" src="js/effects.js"></script>
		<script type="text/javascript" src="js/lightwindow.js"></script>
	</head>
	<body>
		<div id="global_wrapper">
			<img src="img/logo.jpg" alt="" />
			<div id="menu_wrapper">
				<div style="float:left;">
					<?php
						$pageinfo = file("content/pages.txt");

						foreach($pageinfo as $key => $val) 
						{ 
						   $data[$key] = explode("|", $val);
						}
						
						for($i = 0; $i < sizeof($pageinfo); $i++) 
						{
							echo '<a href="index.php'.($data[$i][1]==null ? '' : '?p='.$data[$i][1]).'"'.($_GET["p"]==$data[$i][1] ? ' class="menu_current"' : '').'>'.$data[$i][2].'</a>';
							
							if (!($i == (sizeof($pageinfo)-1)))
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
$tehfilezors = "content/".$_GET["p"].".php";

if ($tehfilezors == "content/.php")
	$tehfilezors = "content/home.php";

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