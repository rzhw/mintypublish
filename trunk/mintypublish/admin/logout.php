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

if (!isloggedin())
{
	echo 'Congratulations, you have just created a paradox. A black hole is currently being formed behind you.';
}
else
{
	// kill ze cookies
	if (pisset('cookie',array('cookuname','cookpwd')))
		punset('cookie',array('cookuname','cookpwd'));
	
	// kill ze session vars
	punset('session',array('uname','pwd'));
	
	// kill ze session
	$_SESSION = array();
	session_destroy();
	
	// congraulations, you have helped destroy ze vorld!
	settopmessage(2,'Successfully logged out!');
	header('Location: ./');
}
?>