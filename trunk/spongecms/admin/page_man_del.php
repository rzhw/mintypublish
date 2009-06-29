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
		
		$delurl = $path['admin'].'&amp;s=man&amp;action=del&amp;go&amp;pid='.$_GET["pid"];
		echo '<h3>Confirm deleting page "'.$pagetitlefull.'"</h3>
		'.$txt['admin_panel_confirm'].'<br />
		<br />
		<img src="'.$path['images'].'/tick.png" alt="" /> <a href="'.$delurl.'">'.$txt['text_yes'].'</a>
		<img src="'.$path['images'].'/cross.png" alt="" /> <a href="javascript:history.back(1)">'.$txt['text_no'].'</a>';
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