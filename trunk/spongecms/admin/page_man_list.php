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
	echo '<h3>'.$txt['admin_panel_manpages_list'].'</h3>';
	
	echo $txt['admin_panel_manpages_desc'];
	
	// Move up/down instructions
	echo ' '.str_replace('[v]','<img src="'.$location['images'].'/arrow_down.png" alt="" />',str_replace('[^]','<img src="'.$location['images'].'/arrow_up.png" alt="" />',$txt['admin_panel_manpages_ordr']));
	
	// Edit instructions
	echo ' '.str_replace('[e]','<img src="'.$location['images'].'/page_edit.png" alt="" />',$txt['admin_panel_manpages_edit']);
	
	// Delete instructions
	echo ' '.str_replace('[d]','<img src="'.$location['images'].'/trash.png" alt="" />',$txt['admin_panel_manpages_delt']);
	
	echo '<br /><br />';
	
	// add new page
	echo '<button onclick="location.href=\''.$location['admin'].'&amp;s=add\'">Add a page</button><br /><br />';

	// get the largest order id
	$largestorder = -1;
	while ($row = mysql_fetch_array($pagequery))
	{
		if ($row['page_orderid'] > $largestorder)
		{
			$largestorder = $row['page_orderid'];
		}
	}
	
	mysql_data_seek($pagequery, 0);
	
	while($row = mysql_fetch_array($pagequery))
	{
		$i = $row['page_orderid'];
		
		// top item in list where there is more than one item
		if ($i == 0 && $i < $largestorder)
		{
			template_page_man_entry($location['admin'].'&amp;s=man',$row['page_id'],$row['page_childof'],$row['page_title_full'],1,0);
			echo '<br />';
		}
		// the only item in the list
		else if ($i == 0)
		{
			template_page_man_entry($location['admin'].'&amp;s=man',$row['page_id'],$row['page_childof'],$row['page_title_full'],1,1);
			echo '<br />';
		}
		// bottom item in list where there is more than one item
		else if ($i == $largestorder)
		{
			template_page_man_entry($location['admin'].'&amp;s=man',$row['page_id'],$row['page_childof'],$row['page_title_full'],0,1);
			echo '<br />';
		}
		// other items
		else
		{
			template_page_man_entry($location['admin'].'&amp;s=man',$row['page_id'],$row['page_childof'],$row['page_title_full'],0,0);
			echo '<br />';
		}
		
		//template_page_man_entry($location['admin'].'&amp;s=man',$row['page_id'],$row['page_childof'],$row['page_title_full'],0,0);
	}
}

/*
 * Summary:      Outputs a page manager listing entry for a specified page
 * Parameters:   $curpage - URL of the page using this function
 *               $pid - numerical ID of the page
 *               $ptitle - text title of the page
 *               $top - whether the page is the first entry in the list
 *               $bottom - whether the page is the last entry in the list
 * Return:       Nothing
 */
function template_page_man_entry($curpage,$pid,$childof,$ptitle,$top=false,$bottom=false)
{
	global $location;
	
	// move page up
	echo '
	<a href="'.($top ? 'javascript:void(0)' : $curpage.'&amp;action=pup&amp;pid='.$pid).'"'.($top ? ' onclick="alert(\'You cannot move this page up; it already is on the top.\')"' : '').'>
		<img src="'.$location['images'].'/arrow_up'.($top ? '_off' : '').'.png" alt="" style="width:12px;height:12px;" />
	</a>';
	
	// move page down
	echo '
	<a href="'.($bottom ? 'javascript:alert(\'You cannot move this page down; it already is on the bottom.\')' : $curpage.'&amp;action=pdn&amp;pid='.$pid).'">
		<img src="'.$location['images'].'/arrow_down'.($bottom ? '_off' : '').'.png" alt="" style="width:12px;height:12px;" />
	</a>';
	
	echo '
	<a href="'.$curpage.'&amp;action=edt&amp;pid='.$pid.'"><img src="'.$location['images'].'/page_edit.png" alt="" /></a>
	<a href="'.$curpage.'&amp;action=del&amp;pid='.$pid.'"><img src="'.$location['images'].'/trash.png" alt="" /></a>
	<a href="javascript:void(0)" onclick="'.($childof==-1?'javascript:alert(\'This page is not a child of anything\')':'javascript:alert(\'This page is the child of page ID '.$childof.'\')').'"><img src="'.$location['images'].'/page_child_'.($childof==-1?'off':'on').'.png" alt="" /></a>
	
	<b>'.$ptitle.'</b>';
}
?>