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
	
	In case you're a lazy idiot who can't even at least get a basic
	understanding of the license:
	"You must retain, in the Source form of any Derivative Works that You
	distribute, all copyright, patent, trademark, and attribution notices
	from the Source form of the Work, excluding those notices that do not
	pertain to any part of the Derivative Works"
	
	http://zvfpcms.sourceforge.net/
*/

$adminurl = 'index.php?p=_admin';

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
	
	// TODO: Fix editing titles of existing pages
	echo '<div class="msgbox_warning"><b>'.$txt['text_warning'].':</b> '.$txt['admin_panel_noedittitle'].'</div><br />';
	
	// Link the user to all the liddle pages...
	echo '<img src="img/page_add.png" alt="" /> <a href="'.$adminurl.'&amp;s=add">'.$txt['admin_panel_addpage'].'</a>
	<img src="img/page_gear.png" alt="" /> <a href="'.$adminurl.'&amp;s=man">'.$txt['admin_panel_manpages'].'</a>
	<img src="img/bug.png" alt="" /> <a href="'.$adminurl.'&amp;s=reports">'.$txt['admin_panel_manbugs'].'</a>';
	
	// Add newlines! (Like a boss)
	echo '<br />';
	
	if ($_GET["s"]=="add")
	{
		// Page add screen
		echo '<h2>'.$txt['admin_panel_addpage'].'</h2>
		'.$txt['admin_panel_addpage_desc'].'<br />
		<br />
		      <form method="post" action="'.$adminurl.'&amp;s=add2">';
			     template_editor("$adminurl&amp;s=add");
		echo '</form>';
	}

	if ($_GET["s"]=="add2")
	{
		// Add the page itself
		echo '<h2>'.$txt['admin_panel_addpage_prog'].'</h2>';
		
		$file = fopen("content/".$_POST["theid"].".php","w");
		
		$contenttowrite = str_replace('\"','"',$_POST["thecontent"]);
		$contenttowrite = str_replace("\'","'",$contenttowrite);
		
		echo $txt['admin_panel_addpage_savpr'].' ';
		
		if (fwrite($file,$contenttowrite) != false)
			echo '<img src="img/tick.png" alt="" /> '.$txt['text_success'];
		else
			echo '<img src="img/cross.png" alt="" /> '.$txt['text_failure'].' '.$txt['admin_panel_addpage_blnk'];
			
		echo '<br /><br />';
			
		fclose($file);
		
		$data = json_decode(file_get_contents("content/_pages.txt"),true);
		$file2 = fopen("content/_pages.txt","w");
		
		// TODO: Subpage support
		$data[sizeof($data)] = array(
			"shortname" => $_POST["theid"],
			"fullname" => $_POST["thetitle"],
			"subpage" => -1
		);
		
		echo $txt['admin_panel_modmenu_prog'].' ';
		
		if (fwrite($file2,json_encode($data)) != false)
			echo '<img src="img/tick.png" alt="" /> '.$txt['text_success'];
		else
			echo '<img src="img/cross.png" alt="" /> '.$txt['text_failure'];
			
		echo '<br /><br />'.$txt['admin_panel_changepage'];
			
		fclose($file2);
	}

	if ($_GET["s"]=="man")
	{
		echo '<h2>'.$txt['admin_panel_manpages'].'</h2>
		<br />';
		
		$data = json_decode(file_get_contents("content/_pages.txt"),true);
		
		if (!isset($_GET["action"]))
		{
			echo '<h3>'.$txt['admin_panel_manpages_list'].'</h3>
			'.$txt['admin_panel_manpages_desc'];
			
			// Move up/down instructions
			echo ' '.str_replace('[v]','<img src="img/arrow_down.png" alt="" />',str_replace('[^]','<img src="img/arrow_up.png" alt="" />',$txt['admin_panel_manpages_ordr']));
			
			// Edit instructions
			echo ' '.str_replace('[e]','<img src="img/page_edit.png" alt="" />',$txt['admin_panel_manpages_edit']);
			
			// Delete instructions
			echo ' '.str_replace('[d]','<img src="img/page_delete.png" alt="" />',$txt['admin_panel_manpages_delt']);
			
			echo '<br /><br />';
				
			for($i = 0; $i < sizeof($data); $i++) 
			{
				// top item in list where there is more than one item
				if ($i == 0 && sizeof($data) > 1)
				{
					template_page_man_entry("$adminurl&amp;s=man",$i,$data[$i]["fullname"],1,0);
					echo '<br />';
				}
				// the only item in the list
				else if ($i == 0)
				{
					template_page_man_entry("$adminurl&amp;s=man",$i,$data[$i]["fullname"],1,1);
					echo '<br />';
				}
				// bottom item in list where there is more than one item
				else if ($i == (sizeof($data)-1))
				{
					template_page_man_entry("$adminurl&amp;s=man",$i,$data[$i]["fullname"],0,1);
					echo '<br />';
				}
				// other items
				else
				{
					template_page_man_entry("$adminurl&amp;s=man",$i,$data[$i]["fullname"],0,0);
					echo '<br />';
				}
			}
		}
		else
		{
			switch ($_GET["action"])
			{
				case "edt":
					echo '<h3>Editing page "'.trim($data[$_GET["pid"]]["fullname"]).'"</h3>
					<form method="post" action="'.$adminurl.'&amp;s=man&amp;action=edt2&amp;pid='.$_GET["pid"].'">';
						
					template_editor("$adminurl&amp;s=man&amp;action=edt&amp;pid=".$_GET["pid"],trim($data[$_GET["pid"]]["shortname"]),trim($data[$_GET["pid"]]["fullname"]));
					
					echo '</form>';
					break;
				case "edt2":
					$file = fopen("content/".$_POST["theid"].".php","w");
					
					/*$contenttowrite = str_replace('\"','"',$_POST["thecontent"]);
					$contenttowrite = str_replace("\'","'",$contenttowrite);
					$contenttowrite = str_replace("[DO NOT EDIT AFTER HERE]","<?php",$contenttowrite);
					$contenttowrite = str_replace("[EDIT AFTER HERE]","?>",$contenttowrite);
					$contenttowrite = str_replace('rel="','params="',$contenttowrite);*/
					
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
					
					echo $txt['admin_panel_addpage_savpr'].' ';
					
					if (fwrite($file,$contenttowrite) != false)
						echo '<img src="img/tick.png" alt="" /> '.$txt['text_success'];
					else
						echo '<img src="img/cross.png" alt="" /> '.$txt['text_failure'];
						
						fclose($file);
					break;
				case "del":
					$delurl = "$adminurl&amp;s=man&amp;action=del2&amp;pid=".$_GET["pid"];
					echo '<h3>Confirm deleting page "'.trim($data[$_GET["pid"]]["fullname"]).'"</h3>
					'.$txt['admin_panel_confirm'].'<br />
					<br />
					<img src="img/tick.png" alt="" /> <a href="'.$delurl.'">'.$txt['text_yes'].'</a> <img src="img/cross.png" alt="" /> <a href="javascript:history.back(1)">'.$txt['text_no'].'</a>';
					break;
				case "del2":					
					echo '<h3>Deleting page "'.trim($data[$_GET["pid"]]["fullname"]).'"...</h3>';
					
					$file2del = $data[$_GET["pid"]]["shortname"];
					
					unset($data[$_GET["pid"]]);
					
					$data = array_values($data);
					
					echo $txt['admin_panel_modmenu_prog'].' ';
					
					$file = fopen("content/_pages.txt","w");
					
					if (fwrite($file,json_encode($data)) != false)
						echo '<img src="img/tick.png" alt="" /> '.$txt['text_success'];
					else
						echo '<img src="img/cross.png" alt="" /> '.$txt['text_failure'];
						
					fclose($file);
					
					echo '<br />
					<br />
					'.$txt['admin_panel_deleting'].' ';
					
					if (unlink("content/".$file2del.".php"))
						echo '<img src="img/tick.png" alt="" /> '.$txt['text_success'];
					else
						echo '<img src="img/cross.png" alt="" /> '.$txt['text_failure'];
					
					echo '<br /><br />'.$txt['admin_panel_changepage'];
					
					break;
				case "pup":					
					echo '<h3>Moving up page "'.trim($data[$_GET["pid"]]["fullname"]).'"...</h3>';
					
					$tempdata = $data[$_GET["pid"]];
					$data[$_GET["pid"]] = $data[$_GET["pid"]-1];
					$data[$_GET["pid"]-1] = $tempdata;
					
					echo $txt['admin_panel_modmenu_prog'].' ';
					
					$file = fopen("content/_pages.txt","w");
					
					if (fwrite($file,json_encode($data)) != false)
						echo '<img src="img/tick.png" alt="" /> '.$txt['text_success'];
					else
						echo '<img src="img/cross.png" alt="" /> '.$txt['text_failure'];
						
					fclose($file);
					
					break;
				case "pdn":					
					echo '<h3>Moving down page "'.trim($data[$_GET["pid"]]["fullname"]).'"...</h3>';
					
					$tempdata = $data[$_GET["pid"]];
					$data[$_GET["pid"]] = $data[$_GET["pid"]+1];
					$data[$_GET["pid"]+1] = $tempdata;
					
					echo $txt['admin_panel_modmenu_prog'].' ';
					
					$file = fopen("content/_pages.txt","w");
					
					if (fwrite($file,json_encode($data)) != false)
						echo '<img src="img/tick.png" alt="" /> '.$txt['text_success'];
					else
						echo '<img src="img/cross.png" alt="" /> '.$txt['text_failure'];
						
					fclose($file);
					
					break;
				default:
					echo '<h3>'.$txt['admin_panel_what'].'</h3>'.$txt['admin_panel_actn_noexist'];
					break;
			}
		}
	}

	if ($_GET["s"]=="reports")
	{
		?>
		<h2>Manage bugs</h2>
		This function currently does not exist and how this will be implemented is still pending.
		<?php
	}
}
?>