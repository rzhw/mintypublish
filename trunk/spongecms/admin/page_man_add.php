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
	if (!isset($_POST['subadd']))
	{
		echo '<h2>'.$txt['admin_panel_addpage'].'</h2>
		'.$txt['admin_panel_addpage_desc'].'<br />
		<br />
			  <form method="post" action="">
			  <input type="hidden" name="subadd" />';
				 include($path['admin2'].'/page_editor.php');
		echo '</form>';
	}
	else
	{
		echo '<h2>'.$txt['admin_panel_addpage_prog'].'</h2>';
		
		// set the content to write
		$find = array(
			'\"',
			"\'"
		);
		$replace = array(
			'"',
			"'"
		);
		$contenttowrite = str_replace($find,$replace,$_POST["thecontent"]);
		$contenttowrite = mysql_real_escape_string($contenttowrite);
		
		// set the new order id
		$largestorder = -1;
		while ($row = mysql_fetch_array($pagequery))
		{
			if ($row['page_orderid'] > $largestorder)
			{
				$largestorder = $row['page_orderid'];
			}
		}
		$orderid = $largestorder + 1;
		
		// get the titles
		$title_menu = mysql_real_escape_string($_POST['theid']);
		$title_full = mysql_real_escape_string($_POST['thetitle']);
		
		// child
		$childof = mysql_real_escape_string($_POST['thechild']);
		
		// hide in menu
		$hideinmenu = mysql_real_escape_string($_POST['hideinmenu']);
		
		$addquery = "INSERT INTO pages(page_orderid,page_title_menu,page_title_full,page_content,page_hideinmenu,page_childof,page_dateadded,page_dateedited)".
					" VALUES($orderid,'$title_menu','$title_full','$contenttowrite',$hideinmenu,$childof,NOW(),NOW())";
		
		echo $addquery;
		
		if (mysql_query($addquery))
		{
			settopmessage(2,'Successfully added page!');
		}
		else
		{
			settopmessage(0,'Could not add page!');
		}
		
		pageredirect('index.php?p=admin&s=man');
	}
}
?>