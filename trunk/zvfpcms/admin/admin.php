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
	if($lolcheese = 0)
	{
		// User doesn't have permissions to access
		echo '<h1>'.$txt['admin_panel_title'].'</h1>
		'.$txt['admin_panel_noperms'];
	}
	else
	{
		// Welcome the user :3
		echo '<h1>'.$txt['admin_panel_title'].'</h1>
		'.$txt['admin_panel_welcome'].'<br />
		<br />';
		
		// Link the user to all the liddle pages...
		echo '<table cellpadding="0" cellspacing="4" border="0">
		<tr>
			<td><img src="'.$path['images'].'/admin_man_pg.png" alt="" /></td>
			<td><a href="'.$path['admin'].'&amp;s=man" class="admin_menu_link">Manage Pages</a></td>
			<td><img src="'.$path['images'].'/admin_man_res.png" alt="" /></td>
			<td><a href="'.$path['admin'].'&amp;s=med" class="admin_menu_link">Manage Media</a></td>
			<td><img src="'.$path['images'].'/admin_man_cfg.png" alt="" /></td>
			<td><a href="'.$path['admin'].'&amp;s=asdf" class="admin_menu_link">Configuration</a></td>
		</tr>
		</table>
		<!--
		<img src="'.$path['images'].'/page_add.png" alt="" /> <a href="'.$path['admin'].'&amp;s=add">'.$txt['admin_panel_addpage'].'</a>
		<img src="'.$path['images'].'/page_gear.png" alt="" /> <a href="'.$path['admin'].'&amp;s=man">'.$txt['admin_panel_manpages'].'</a>
		<img src="'.$path['images'].'/bug.png" alt="" /> <a href="'.$path['admin'].'&amp;s=reports">'.$txt['admin_panel_manbugs'].'</a>
		-->';
		
		// Add newlines! (Like a boss)
		echo '<br />';
		
		// What subaction?
		switch ($_GET["s"])
		{
			case "add":
				include("zvfpcms/admin/page_man_add_entry.php");
				break;
			case "add2":
				include("zvfpcms/admin/page_man_add_action.php");
				break;
			case "man":
				echo '<h2>'.$txt['admin_panel_manpages'].'</h2>
				<br />';
				
				$data = json_decode(file_get_contents($path['pages'].'/pages.txt'),true);
				
				if (!isset($_GET["action"]))
				{
					include("zvfpcms/admin/page_man_list.php");
				}
				else
				{
					switch ($_GET["action"])
					{
						case "edt":
							include($path['admin2'].'/page_man_edit_entry.php');
							break;
						case "edt2":
							include($path['admin2'].'/page_man_edit_action.php');
							break;
						case "del":
							include($path['admin2'].'/page_man_del_confirm.php');
							break;
						case "del2":					
							include($path['admin2'].'/page_man_del_action.php');
							break;
						case "pup":
							$direction = "up";
							include($path['admin2'].'/page_man_reorder.php');
							break;
						case "pdn":
							$direction = "down";
							include($path['admin2'].'/page_man_reorder.php');
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
				
				$data = json_decode(file_get_contents($path['media'].'/media.txt'),true);
				
				if (!isset($_GET["action"]))
				{
					include("zvfpcms/admin/media_man_list.php");
				}
				else
				{
					switch ($_GET["action"])
					{
						case "up":
							include($path['admin2'].'/media_man_upload.php');
							break;
						case "prv":
							include($path['admin2'].'/media_man_preview.php');
							break;
						default:
							echo '<h3>'.$txt['admin_panel_what'].'</h3>'.$txt['admin_panel_actn_noexist'];
							break;
					}
				}
				break;
			default:
				echo $txt['admin_panel_actn_noexist'];
		}
	}
}
?>