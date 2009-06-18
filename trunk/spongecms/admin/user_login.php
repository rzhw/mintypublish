<?php
/*
	Sponge CMS test version
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
	
	http://zvfpcms.sourceforge.net/
*/
if ($zvfpcms)
{
	echo '<h3>'.$txt['user_login'].'</h3>';
	
	if (!isset($_POST['sublogin']))
	{		
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
			<tr>
				<td colspan="2" align="left">
					<a href="register.php">'.$txt['user_register'].'</a>
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