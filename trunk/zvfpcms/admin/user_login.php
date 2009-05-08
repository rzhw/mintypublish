<?php
/*
	Ze Very Flat Pancaek CMS test version
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
	if (!isset($_POST['sublogin']))
	{
		echo '<h3>Login</h3>';
		
		echo '<form action="" method="post">
		<table cellpadding="3" cellspacing="0" border="0">
		<tr><td>Username:</td><td><input type="text" name="uname" maxlength="30"></td></tr>
		<tr><td>Password:</td><td><input type="password" name="pwd" maxlength="30"></td></tr>
		<tr><td colspan="2" align="left"><input type="checkbox" name="remember">
		<font size="2">Remember me</td></tr>
		<tr><td colspan="2" align="right"><input type="submit" name="sublogin" value="Login"></td></tr>
		<tr><td colspan="2" align="left"><a href="register.php">Join</a></td></tr>
		</table>
		</form>';
	}
	else
	{
		if (isexistinguser($_POST['uname'],$_POST['pwd']) == 2)
		{
			$_SESSION['uname'] = stripslashes($_POST['uname']);
			$_SESSION['pwd'] = user_pass_generate($_POST['pwd']);
			if (isset($_POST['remember']))
			{
				setcookie("cookuname", $_SESSION['uname'], time()+60*60*24*100, "/");
				setcookie("cookpwd", $_SESSION['pwd'], time()+60*60*24*100, "/");
			}
			echo 'Login successful!<br /><br />';
		}
	}
}
?>