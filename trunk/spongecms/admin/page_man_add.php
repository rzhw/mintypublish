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