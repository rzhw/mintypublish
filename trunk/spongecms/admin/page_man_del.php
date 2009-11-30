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
	if (!isset($_GET['go']))
	{
		$i=0;
		while($row = mysql_fetch_array($pagequery))
		{
			if ($i > 0) { $dontcontinue = true; }
			
			if ($row['page_id'] == $_GET["pid"])
			{
				$pagetitlefull = $row['page_title_full'];
				$i+=1;
			}
		}
		
		$delurl = $location['admin'].'&amp;s=man&amp;action=del&amp;go&amp;pid='.$_GET["pid"];
		echo '<h3>Confirm deleting page "'.$pagetitlefull.'"</h3>
		'.$txt['admin_panel_confirm'].'<br />
		<br />
		<img src="'.$location['images'].'/tick.png" alt="" /> <a href="'.$delurl.'">'.$txt['text_yes'].'</a>
		<img src="'.$location['images'].'/cross.png" alt="" /> <a href="javascript:history.back(1)">'.$txt['text_no'].'</a>';
	}
	else
	{
		echo '<h3>Deleting page "'.trim($data[$_GET["pid"]]["fullname"]).'"...</h3>';
		
		$pid = mysql_real_escape_string($_GET["pid"]);
		
		$delquery = "DELETE FROM pages WHERE page_id = $pid";
		
		if (mysql_query($delquery))
		{
			settopmessage(2,'Successfully deleted page!');
		}
		else
		{
			settopmessage(0,'Could not delete page!');
		}
		
		pageredirect('index.php?p=admin&s=man');
	}
}
?>