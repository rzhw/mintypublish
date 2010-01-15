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

session_start();
require_once('config.php');
require_once('functions.php');

if (!isloggedin())
{

$showscreen = true;

if (isset($_POST['sublogin']))
{
	$isuser = isexistinguser($_POST['uname'],$_POST['pwd']);
	
	if ($isuser[0] == 1)
	{
		$username = stripslashes($_POST['uname']);
		$password = user_pass_generate($isuser[1],$_POST['pwd']);
		
		pset('session',array('uname' => $username,'pwd' => $password));
		
		if (isset($_POST['remember']))
		{
			pset('cookie',array('uname' => $username,'pwd' => $password));
		}
		
		settopmessage(2,'Successfully logged in!');
		
		header('Location: ../');
		
		$showscreen = false;
	}
	else
	{
		$error = true;
	}
}

if ($showscreen)
{
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>mintypublish</title>
		<style type="text/css">
			body
			{
				background:url('themes/default/img/bg.png');
				font-family:verdana;
				font-size:12px;
			}
			table
			{
				border-spacing:0px;
			}
			td
			{
				border:0px;
				padding:0px;
			}
			#darken
			{
				position:absolute;
				left:0px;
				top:0px;
				width:100%;
				height:100%;
				background:#000;
				opacity:0.4;
				filter:alpha(opacity=40);
				z-index:-1;
			}
			#area
			{
				width:388px;
				height:436px;
				margin:5% auto 0px auto;
				background:url('login.png');
				color:#ddd;
				text-align:center;
			}
			#instruction
			{
				padding-top:96px;
			}
			form
			{
				margin:48px auto 0px auto;
				padding:0px 32px;
				text-align:left;
			}
			label
			{
				font-size:11px;
			}
			input[type=text], input[type=password]
			{
				width:304px;
				margin:4px 0px 8px 0px;
				border-radius:2px;
				-moz-border-radius:2px;
				-webkit-border-radius:2px;
				background:#111;
				border:1px solid #444;
				color:#888;
				font-family:verdana;
				font-size:16px;
				padding:8px;
				opacity:0.5;
				filter:alpha(opacity=50);
			}
			input[type=submit]
			{
				border-radius:2px;
				-moz-border-radius:2px;
				-webkit-border-radius:2px;
				background:#111;
				border:1px solid #444;
				color:#555;
				font-family:verdana;
				font-size:12px;
				padding:4px;
			}
			#submit_wrap
			{
				text-align:right;
			}
		</style>
	</head>
	<body>
		<div id="darken"></div>
		<div id="area">
			<p id="instruction">Login to access the administration tools</p>
			<form action="" method="post">
				<p>
					<label for="username">Username</label>
					<input type="text" name="uname" id="username" value="" />
				</p>
				<p>
					<label for="password">Password</label>
					<input type="password" name="pwd" id="password" value="" />
				</p>
				<p>
					<input type="checkbox" name="remember" id="remember" />
					<label for="remember">Remember me</label>
				</p>
				<p id="submit_wrap">
					<input type="submit" name="sublogin" value="Login &raquo;" />
				</p>
			</form>
		</div>
	</body>
</html>

<?php
}

}
else
{
	// redirect the user back
	header('Location: ../');
}

?>