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

if ($zvfpcms)
{	
	if (!isset($_POST['sublogin']))
	{
		echo '<h3>'.$txt['user_login'].'</h3>';
		
		echo '
		<form action="" method="post">
		<table cellpadding="4" cellspacing="0" border="0">
			<tr>
				<td>
					'.$txt['user_username'].':
				</td>
				<td>
					<input type="text" name="uname" maxlength="30">
				</td>
			</tr>
			<tr>
				<td>
					'.$txt['user_password'].':
				</td>
				<td>
					<input type="password" name="pwd" maxlength="30">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="left">
					<input type="checkbox" name="remember" />
					'.$txt['user_rememberme'].'
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
					<input type="submit" name="sublogin" value="Login" />
				</td>
			</tr>
		</table>
		</form>';
	}
	else
	{
		$isuser = isexistinguser($_POST['uname'],$_POST['pwd']);
		
		if ($isuser[0] == 1)
		{
			$_SESSION['uname'] = stripslashes($_POST['uname']);
			$_SESSION['pwd'] = user_pass_generate($isuser[1],$_POST['pwd']);
			
			if (isset($_POST['remember']))
			{
				setcookie("cookuname", $_SESSION['uname'], time()+60*60*24*100, "/");
				setcookie("cookpwd", $_SESSION['pwd'], time()+60*60*24*100, "/");
			}
			
			settopmessage(2,'Successfully logged in!');
			
			pageredirect('index.php?p=admin');
		}
		else
		{
			settopmessage(0,'Login failed!');
			
			pageredirect('index.php?p=admin');
		}
	}
}
?>