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
			
			include($path['admin2'].'/page_editor.php');
			
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