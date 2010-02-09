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

class MPAuth
{	
	public function generatePassword($salt, $password)
	{
		return hash('whirlpool', $salt.$password);
	}
	
	public function loginForm()
	{
		global $txt;
		return '<form action="" method="post">
				<p>
					<label for="username">' . $txt['user_username'] . '</label>
					<input type="text" name="uname" id="username" value="" />
				</p>
				<p>
					<label for="password">' . $txt['user_password'] . '</label>
					<input type="password" name="pwd" id="password" value="" />
				</p>
				<p>
					<input type="checkbox" name="remember" id="remember" />
					<label for="remember">' . $txt['user_rememberme'] . '</label>
				</p>
				<p id="submit_wrap">
					<input type="submit" name="sublogin" value="' . $txt['user_login'] . ' &raquo;" />
				</p>
			</form>'."\n";
	}
	
	public function login($username, $password)
	{		
		$isuser = $this->isUser($username, $password);
		
		if ($isuser)
		{
			$username2 = stripslashes($username);
			$password2 = $isuser;
			
			pset('session', array('uname' => $username2,'pwd' => $password2));
			
			if (isset($_POST['remember']))
			{
				pset('cookie', array('uname' => $username2,'pwd' => $password2));
			}
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function logout()
	{
		if ($this->isLoggedIn())
		{
			if (pisset('cookie',array('cookuname','cookpwd')))
			{
				punset('cookie',array('cookuname','cookpwd'));
			}
			
			punset('session',array('uname','pwd'));
			
			$_SESSION = array();
			session_destroy();
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function isLoggedIn()
	{
		// is the user set to remember?
		if (pisset('cookie', array('cookuname','cookpwd')))
		{
			pset('session', array('uname'=>$_COOKIE['cookuname'],'pwd'=>$_COOKIE['cookpwd']));
		}

		// user's session is still active
		if (pisset('session', array('uname','pwd')))
		{
			// but is their user/pass pair correct?
			if (!$this->isUser($_SESSION['uname'], $_SESSION['pwd'], true))
			{
				// NO? gtfo
				punset('session', array('uname','pwd'));
				return false;
			}
			return true;
		}
		// user isn't active D:
		else
		{
			return false;
		}
	}
	
	public function isUser($username, $password, $passwordishash=false, $debug=false)
	{		
		$username2 = mysql_real_escape_string($username);
		
		$result = mysql_query("SELECT user_id,user_username,user_password,user_password_salt FROM users WHERE user_username = '$username2'") or die(mysql_error());
		
		$hit = 0;
		$gotone = false;
		$salt = '';
		
		$isuser = false;
		
		while ($row = mysql_fetch_array($result))
		{
			$salt = $row['user_password_salt'];
			
			if (!$gotone)
			{
				$gotone = true;
				
				// we got a match for the username
				if ($username == $row['user_username'])
				{
					$hit = 2;
				}
				
				// the password to check against needs to be generated
				if (!$passwordishash)
				{
					$supposedpass = $this->generatePassword($salt, $password);
				}
				else
				{
					$supposedpass = $password;
				}
				
				if ($supposedpass == $row['user_password'])
				{
					if ($hit == 2)
					{
						$hit = 1; // we got a match for everything!
					}
					else
					{
						$hit = 3; // we only got a match for the password...
					}
				}
			}
			else
			{
				$hit = -1; // for some reason more than one user has this username
			}
		}
		
		if (!$debug)
		{
			if ($hit === 1)
			{
				return $supposedpass; // always should be equated to true unless it's empty, which it shouldn't be
			}
			else
			{
				return false;
			}
		}
		else
		{
			// WARNING: THEREFORE WITH $debug = true THIS WILL *ALWAYS* RETURN TRUE
			return $hit;
		}
	}
}
?>