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
		if ($_GET['s'] == 'register')
			include($location['admin2'].'/user_register.php');
		else
			include($location['admin2'].'/user_login.php');
	}
	else
	{
		// Welcome the user :3
		echo '
		<h1>'.$txt['admin_panel_title'].'</h1>
		<b>Please note: This admin panel\'s functionality is being phased out in favour of the "admin bar" you can see above.
		As functions here are made redundant they will be removed</b>
		<br />
		<br />';
		
		// Show the menu
		echo '
		<nav id="admin_menu">
			<ul>
				<li onclick="location.href=\''.$location['admin'].'&amp;s=man\'">
					<img src="'.$location['images'].'/admin_man_pg.png" alt="" /> Pages
				</li>
				<li onclick="location.href=\''.$location['admin'].'&amp;s=cfg\'">
					<img src="'.$location['images'].'/admin_man_cfg.png" alt="" /> Config
				</li>
				<li onclick="location.href=\''.$location['admin'].'&amp;s=logout\'">
					<img src="'.$location['images'].'/admin_man_logout.png" alt="" /> Logout
				</li>
			</ul>
		</nav>
		<div style="clear:both;"></div>';
		
		// What subaction?
		switch ($_GET["s"])
		{
			case "add":
				include($location['admin2'].'/page_man_add.php');
				break;
			case "man":
				echo '<h2>'.$txt['admin_panel_manpages'].'</h2>
				<br />';
				
				if (!isset($_GET["action"]))
				{
					include($location['admin2'].'/page_man_list.php');
				}
				else
				{
					switch ($_GET["action"])
					{
						case "edt":
							include($location['admin2'].'/page_man_edit.php');
							break;
						case "del":
							include($location['admin2'].'/page_man_del.php');
							break;
						case "pup":
							$direction = "up";
							include($location['admin2'].'/page_man_reorder.php');
							break;
						case "pdn":
							$direction = "down";
							include($location['admin2'].'/page_man_reorder.php');
							break;
						default:
							echo '<h3>'.$txt['admin_panel_what'].'</h3>'.$txt['admin_panel_actn_noexist'];
							break;
					}
				}
				break;
			case "med":
				echo '<h2>Manage Media</h2>
				<br />';
				
				if (!isset($_GET["action"]))
				{
					include($location['admin2'].'/media_man_list.php');
				}
				else
				{
					switch ($_GET["action"])
					{
						case "up":
							include($location['admin2'].'/media_man_upload.php');
							break;
						case "prv":
							include($location['admin2'].'/media_man_preview.php');
							break;
						default:
							echo '<h3>'.$txt['admin_panel_what'].'</h3>'.$txt['admin_panel_actn_noexist'];
							break;
					}
				}
				break;
			case "cfg":
				include($location['admin2'].'/config_frontend.php');
				break;
			case "logout":
				include($location['admin2'].'/user_logout.php');
				break;
			case "help":
				include($location['admin2'].'/help.php');
				break;
			default:
				if (isset($_GET["s"]))
				{
					echo $txt['admin_panel_actn_noexist'];
				}
				else
				{
					echo '<h2>Dashboard</h2>';
					
					echo 'Hello! There is no dashboard right now. The menu items are along the left. Enjoy!';
				}
				break;
		}
	}
}
?>