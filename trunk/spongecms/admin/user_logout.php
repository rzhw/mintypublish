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
	if (!isloggedin())
	{
		echo 'Congratulations, you have just created a paradox. A black hole is currently being formed behind you.';
	}
	else
	{
		// kill ze cookies
		if (isset($_COOKIE['cookuname']) && isset($_COOKIE['cookpwd']))
		{
		   setcookie("cookuname", "", time()-60*60*24*100, "/");
		   setcookie("cookpwd", "", time()-60*60*24*100, "/");
		}
		// kill ze session vars
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		// kill ze session
		$_SESSION = array();
		session_destroy();
		// congraulations, you have helped destroy ze vorld!
		settopmessage(2,'Successfully logged out!');
		pageredirect('index.php?p=admin');
	}
}
?>