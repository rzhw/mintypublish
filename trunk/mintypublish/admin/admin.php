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

if ($zvfpcms)
{	
	if (!isloggedin())
	{
		header('Location: mintypublish');
	}
	else
	{
		// Welcome the user :3
		echo '
		<h1>'.$txt['admin_panel_title'].'</h1>
		<br />
		<b>Please note: Most of this admin panel\'s functionality has been reimplemented in the "admin bar" at the top of the screen and removed from here</b>
		<br />
		<br />
		<br />';
		
		// What subaction?
		switch ($_GET["s"])
		{
			case "logout":
				include($location['admin2'].'/user_logout.php');
				break;
			default:
				include($location['admin2'].'/config_frontend.php');
				break;
		}
	}
}
?>