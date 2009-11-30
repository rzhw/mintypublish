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
	if (!isset($_POST['subedit']))
	{
		$i=0;
		while($row = mysql_fetch_array($pagequery))
		{			
			if ($row['page_id'] == $_GET["pid"])
			{
				$pagecontent = $row['page_content'];
				$pagetitlefull = $row['page_title_full'];
				$pagetitlemenu = $row['page_title_menu'];
				$i+=1;
			}
			
			if ($i == 2) { $dontcontinue = true; }
		}
		
		if ($dontcontinue)
		{
			echo 'There appears to be more than one page in the database with the same ID...';
		}
		else
		{
			echo '<h3>Editing page "'.$pagetitlefull.'"</h3>';

			echo '<br /><div class="msgbox_warning"><b>'.$txt['text_warning'].':</b> '.$txt['admin_panel_noedittitle'].'</div><br />';
			
			echo '<form method="post" action="">
			<input type="hidden" name="subedit" />';
			
			include($location['admin2'].'/page_editor.php');
			
			echo '</form>';
		}
	}
	else
	{		
		$find = array(
			'\"',
			"\'",
			"[DO NOT EDIT AFTER HERE]",
			"[EDIT AFTER HERE]",
			'rel="'
		);
		$replace = array(
			'"',
			"'",
			"<?php",
			"?>",
			'params="'
		);
		
		$contenttowrite = str_replace($find,$replace,$_POST["thecontent"]);
		$contenttowrite = mysql_real_escape_string($contenttowrite);
		
		// get the titles (not implemented in query yet)
		$title_menu = mysql_real_escape_string($_POST['theid']);
		$title_full = mysql_real_escape_string($_POST['thetitle']);
		
		// child
		$childof = mysql_real_escape_string($_POST['thechild']);
		
		// hide in menu
		$hideinmenu = mysql_real_escape_string($_POST['hideinmenu']);
		
		$pid = mysql_real_escape_string($_GET["pid"]);
		
		echo $txt['admin_panel_addpage_savpr'].' ';
		
		$updatequery = "UPDATE pages SET page_content = '$contenttowrite',".
						" page_childof = $childof, page_hideinmenu = $hideinmenu, page_dateedited = NOW()".
						" WHERE page_id = $pid";
		
		if (mysql_query($updatequery))
		{
			settopmessage(2,'Successfully saved edited page!');
		}
		else
		{
			settopmessage(0,'Could not save edited page!');
		}
		
		pageredirect('index.php?p=admin&s=man');
	}
}
?>