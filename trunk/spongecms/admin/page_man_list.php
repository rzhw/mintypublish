<?php
/*
	Sponge CMS
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
	
	http://a2h.github.com/Sponge-CMS/
*/
if ($zvfpcms)
{	
	echo '<h3>'.$txt['admin_panel_manpages_list'].'</h3>';
	
	echo $txt['admin_panel_manpages_desc'];
	
	// Move up/down instructions
	echo ' '.str_replace('[v]','<img src="'.$path['images'].'/arrow_down.png" alt="" />',str_replace('[^]','<img src="'.$path['images'].'/arrow_up.png" alt="" />',$txt['admin_panel_manpages_ordr']));
	
	// Edit instructions
	echo ' '.str_replace('[e]','<img src="'.$path['images'].'/page_edit.png" alt="" />',$txt['admin_panel_manpages_edit']);
	
	// Delete instructions
	echo ' '.str_replace('[d]','<img src="'.$path['images'].'/trash.png" alt="" />',$txt['admin_panel_manpages_delt']);
	
	echo '<br /><br />';

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
			template_page_man_entry($path['admin'].'&amp;s=man',$row['page_id'],$row['page_childof'],$row['page_title_full'],1,0);
			echo '<br />';
		}
		// the only item in the list
		else if ($i == 0)
		{
			template_page_man_entry($path['admin'].'&amp;s=man',$row['page_id'],$row['page_childof'],$row['page_title_full'],1,1);
			echo '<br />';
		}
		// bottom item in list where there is more than one item
		else if ($i == $largestorder)
		{
			template_page_man_entry($path['admin'].'&amp;s=man',$row['page_id'],$row['page_childof'],$row['page_title_full'],0,1);
			echo '<br />';
		}
		// other items
		else
		{
			template_page_man_entry($path['admin'].'&amp;s=man',$row['page_id'],$row['page_childof'],$row['page_title_full'],0,0);
			echo '<br />';
		}
		
		//template_page_man_entry($path['admin'].'&amp;s=man',$row['page_id'],$row['page_childof'],$row['page_title_full'],0,0);
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
	global $path;
	
	// move page up
	echo '
	<a href="'.($top ? 'javascript:void(0)' : $curpage.'&amp;action=pup&amp;pid='.$pid).'"'.($top ? ' onclick="alert(\'You cannot move this page up; it already is on the top.\')"' : '').'>
		<img src="'.$path['images'].'/arrow_up'.($top ? '_off' : '').'.png" alt="" style="width:12px;height:12px;" />
	</a>';
	
	// move page down
	echo '
	<a href="'.($bottom ? 'javascript:alert(\'You cannot move this page down; it already is on the bottom.\')' : $curpage.'&amp;action=pdn&amp;pid='.$pid).'">
		<img src="'.$path['images'].'/arrow_down'.($bottom ? '_off' : '').'.png" alt="" style="width:12px;height:12px;" />
	</a>';
	
	echo '
	<a href="'.$curpage.'&amp;action=edt&amp;pid='.$pid.'"><img src="'.$path['images'].'/page_edit.png" alt="" /></a>
	<a href="'.$curpage.'&amp;action=del&amp;pid='.$pid.'"><img src="'.$path['images'].'/trash.png" alt="" /></a>
	<a href="javascript:void(0)" onclick="'.($childof==-1?'javascript:alert(\'This page is not a child of anything\')':'javascript:alert(\'This page is the child of page ID '.$childof.'\')').'"><img src="'.$path['images'].'/page_child_'.($childof==-1?'off':'on').'.png" alt="" /></a>
	
	<b>'.$ptitle.'</b>';
}
?>