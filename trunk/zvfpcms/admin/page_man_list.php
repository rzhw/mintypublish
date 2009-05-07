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
	echo '<h3>'.$txt['admin_panel_manpages_list'].'</h3>';
	
	echo '<input type="button" value="'.$txt['admin_panel_addpage'].'" onclick="javascript:location.href=\''.$path['admin'].'&amp;s=add\'" /><br /><br />';
	
	echo $txt['admin_panel_manpages_desc'];
	
	// Move up/down instructions
	echo ' '.str_replace('[v]','<img src="'.$path['images'].'/arrow_down.png" alt="" />',str_replace('[^]','<img src="'.$path['images'].'/arrow_up.png" alt="" />',$txt['admin_panel_manpages_ordr']));
	
	// Edit instructions
	echo ' '.str_replace('[e]','<img src="'.$path['images'].'/page_edit.png" alt="" />',$txt['admin_panel_manpages_edit']);
	
	// Delete instructions
	echo ' '.str_replace('[d]','<img src="'.$path['images'].'/page_delete.png" alt="" />',$txt['admin_panel_manpages_delt']);
	
	echo '<br /><br />';
		
	for($i = 0; $i < sizeof($data); $i++) 
	{
		// top item in list where there is more than one item
		if ($i == 0 && sizeof($data) > 1)
		{
			template_page_man_entry($path['admin'].'&amp;s=man',$i,$data[$i]["fullname"],1,0);
			echo '<br />';
		}
		// the only item in the list
		else if ($i == 0)
		{
			template_page_man_entry($path['admin'].'&amp;s=man',$i,$data[$i]["fullname"],1,1);
			echo '<br />';
		}
		// bottom item in list where there is more than one item
		else if ($i == (sizeof($data)-1))
		{
			template_page_man_entry($path['admin'].'&amp;s=man',$i,$data[$i]["fullname"],0,1);
			echo '<br />';
		}
		// other items
		else
		{
			template_page_man_entry($path['admin'].'&amp;s=man',$i,$data[$i]["fullname"],0,0);
			echo '<br />';
		}
	}
}
?>