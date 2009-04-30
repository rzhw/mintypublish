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

if($lolcheese = 0)
{
	echo '<h1>Administration Panel</h1>
	You do not have proper permissions to access this page.';
}
else
{
	?>
	<h1>Administration Panel</h1>
	Welcome to the administration panel.<br />
	<br />
	<div style="background:#E77471;border:1px solid #C24641;color:#fff;padding:2px;"><b>WARNING:</b> Do not change the any of the
	titles of an existing page. You must get it changed manually.</div><br />
	
	<img src="img/page_add.png" alt="" /> <a href="index.php?p=admin&amp;s=add">Add a page</a>
	<img src="img/page_gear.png" alt="" /> <a href="index.php?p=admin&amp;s=man">Manage pages</a>
	<img src="img/bug.png" alt="" /> <a href="index.php?p=admin&amp;s=reports">Manage bugs</a>
	<img src="img/help.png" alt="" /> <a href="index.php?p=admin&amp;s=help">Help and layout guidelines</a><br />
	<br />
	<?php
	if ($_GET["s"]=="add")
	{
		?>
		<h2>Add a page</h2>
		The page will be added to the end of the menu. Use the "Manage pages" section to move it.<br />
		<br />
		<form method="post" action="index.php?p=admin&amp;s=add2">
			<?php template_editor("index.php?p=admin&amp;s=add"); ?>
		</form>
		<?php
	}

	if ($_GET["s"]=="add2")
	{
		// t variable only works on windows systems
		// converts \n into \r\n
		
		echo '<h2>Adding page...</h2>';
		
		$file = fopen("content/".$_POST["theid"].".php","w");
		
		$contenttowrite = str_replace('\"','"',$_POST["thecontent"]);
		$contenttowrite = str_replace("\'","'",$contenttowrite);
		
		echo 'Adding page... ';
		
		if (fwrite($file,$contenttowrite) != false)
			echo '<img src="img/tick.png" alt="" /> Success!';
		else
			echo '<img src="img/cross.png" alt="" /> Failure! (n.b. if your page has blank content this may happen)';
			
		echo '<br /><br />';
			
		fclose($file);

		$file2 = fopen("content/pages.txt","a");
		
		$newmenuentry = '
'.sizeof(file("content/pages.txt")).'|'.$_POST["theid"].'|'.$_POST["thetitle"];
		
		echo 'Modifying menu... ';
		
		if (fwrite($file2,$newmenuentry) != false)
			echo '<img src="img/tick.png" alt="" /> Success!';
		else
			echo '<img src="img/cross.png" alt="" /> Failure!';
			
		echo '<br /><br />Go to another page to view the changes.';
			
		fclose($file2);
	}

	if ($_GET["s"]=="man")
	{
		?>
		<h2>Manage pages</h2>
		<br />
		<?php
		$pageinfo = file("content/pages.txt");

		foreach($pageinfo as $key => $val) 
		{ 
		   $data[$key] = explode("|", $val);
		}
		
		if (!isset($_GET["action"]))
		{
			echo '<h3>Pages</h3>
				This is the list of pages. Use <img src="img/arrow_up.png" alt="" />/<img src="img/arrow_down.png" alt="" /> to
				move their order in the menu. Click on <img src="img/page_edit.png" alt="" /> to edit a page.<br />
				Click on <img src="img/page_delete.png" alt="" /> to delete a page.<br /><br />';

			for($i = 0; $i < sizeof($pageinfo); $i++) 
			{
				if ($i == 0)
				{
					template_page_man_entry("index.php?p=admin&amp;s=man",$data[$i][0],$data[$i][2],1,0);
					echo '<br />';
				}
				else if ($i == (sizeof($pageinfo)-1))
				{
					template_page_man_entry("index.php?p=admin&amp;s=man",$data[$i][0],$data[$i][2],0,1);
					echo '<br />';
				}
				else
				{
					template_page_man_entry("index.php?p=admin&amp;s=man",$data[$i][0],$data[$i][2],0,0);
					echo '<br />';
				}
			}
		}
		else
		{
			switch ($_GET["action"])
			{
				case "edt":
					echo '<h3>Editing page "'.trim($data[$_GET["pid"]][2]).'"</h3>
					<form method="post" action="index.php?p=admin&amp;s=man&amp;action=edt2&amp;pid='.$_GET["pid"].'">';
						
					template_editor('index.php?p=admin&amp;s=man&amp;action=edt&amp;pid='.$_GET["pid"],trim($data[$_GET["pid"]][1]),trim($data[$_GET["pid"]][2]));
					
					echo '</form>';
					break;
				case "edt2":
					$file = fopen("content/".$_POST["theid"].".php","w");
					
					$contenttowrite = str_replace('\"','"',$_POST["thecontent"]);
					$contenttowrite = str_replace("\'","'",$contenttowrite);
					$contenttowrite = str_replace("[DO NOT EDIT AFTER HERE]","<?php",$contenttowrite);
					$contenttowrite = str_replace("[EDIT AFTER HERE]","?>",$contenttowrite);
					$contenttowrite = str_replace('rel="','params="',$contenttowrite);
					
					echo 'Saving page... ';
					
					if (fwrite($file,$contenttowrite) != false)
						echo '<img src="img/tick.png" alt="" /> Success!';
					else
						echo '<img src="img/cross.png" alt="" /> Failure!';
						
						fclose($file);
					break;
				case "del":
					$delurl = 'index.php?p=admin&amp;s=man&amp;action=del2&amp;pid='.$_GET["pid"];
					echo '<h3>Confirm deleting page "'.trim($data[$_GET["pid"]][2]).'"</h3>
					Are you <b>'.rand(100,500).'%</b> sure you want to do this?<br />
					<br />
					<img src="img/tick.png" alt="" /> <a href="'.$delurl.'">Yes</a> <img src="img/cross.png" alt="" /> <a href="javascript:history.back(1)">No</a>';
					break;
				case "del2":
					$pageinfo = file("content/pages.txt");

					foreach($pageinfo as $key => $val) 
					{ 
					   $data[$key] = explode("|", $val);
					}
					
					$textzors = '';
					
					$file2del = '';
					
					$deltd = false;
					
					for($i = 0; $i < sizeof($pageinfo); $i++) 
					{
						if ($data[$i][0] != $_GET["pid"])
						{
							if ($deltd)
								$tehid = (($data[$i][0])-1);
							else
								$tehid = $data[$i][0];
							
							$textzors .= $tehid.'|'.$data[$i][1].'|'.$data[$i][2];
						}
						else
						{
							$file2del = $data[$i][1];
							$deltd = true;
						}
					}
					
					$textzors = trim($textzors);
					
					echo '<h3>Deleting page "'.trim($data[$_GET["pid"]][2]).'"...</h3>
					<img src="img/arrow_out.png" alt="" /> Output:<br />
					<textarea rows="10" cols="50">'.$textzors.'</textarea><br />
					<br />
					Resaving new menu... ';
					
					$file = fopen("content/pages.txt","w");
					
					if (fwrite($file,$textzors) != false)
						echo '<img src="img/tick.png" alt="" /> Success!';
					else
						echo '<img src="img/cross.png" alt="" /> Failure!';
						
					fclose($file);
					
					echo '<br />
					<br />
					Deleting file... ';
					
					if (unlink("content/".$file2del.".php"))
						echo '<img src="img/tick.png" alt="" /> Success!';
					else
						echo '<img src="img/cross.png" alt="" /> Failure!';
					
					echo '<br /><br />Go to another page to view the changes.';
					
					break;
				case "pup":
					$pageinfo = file("content/pages.txt");

					foreach($pageinfo as $key => $val) 
					{ 
					   $data[$key] = explode("|", $val);
					}
					
					$textzors = '';
					
					$temptoecho = '';
					
					for($i = 0; $i < sizeof($pageinfo); $i++) 
					{
						if ($data[$i][0] == (($_GET["pid"])-1))
						{
							$temptoecho = (($data[$i][0])+1).'|'.$data[$i][1].'|'.$data[$i][2];
						}
						else if ($data[$i][0] == $_GET["pid"])
						{
							$textzors .= (($data[$i][0])-1).'|'.$data[$i][1].'|'.trim($data[$i][2]).'
';
							$textzors .= $temptoecho;
						}
						else
						{
							$textzors .= $data[$i][0].'|'.$data[$i][1].'|'.$data[$i][2];
						}
					}
					
					$textzors = trim($textzors);
					
					echo '<h3>Moving up page "'.trim($data[$_GET["pid"]][2]).'"...</h3>
					<img src="img/arrow_out.png" alt="" /> Output:<br />
					<textarea rows="10" cols="50">'.$textzors.'</textarea><br />
					<br />
					Resaving new menu... ';
					
					$file = fopen("content/pages.txt","w");
					
					if (fwrite($file,$textzors) != false)
						echo '<img src="img/tick.png" alt="" /> Success!';
					else
						echo '<img src="img/cross.png" alt="" /> Failure!';
						
					fclose($file);
					
					break;
				case "pdn":
					$pageinfo = file("content/pages.txt");

					foreach($pageinfo as $key => $val) 
					{ 
					   $data[$key] = explode("|", $val);
					}
					
					$textzors = '';
					
					$temptoecho = '';
					
					for($i = 0; $i < sizeof($pageinfo); $i++) 
					{
						if ($data[$i][0] == (($_GET["pid"])+1))
						{
							$textzors .= (($data[$i][0])-1).'|'.$data[$i][1].'|'.trim($data[$i][2]).'
';
							$textzors .= $temptoecho;
						}
						else if ($data[$i][0] == $_GET["pid"])
						{
							$temptoecho = (($data[$i][0])+1).'|'.$data[$i][1].'|'.$data[$i][2];
							
						}
						else
						{
							$textzors .= $data[$i][0].'|'.$data[$i][1].'|'.$data[$i][2];
						}
					}
					
					$textzors = trim($textzors);
					
					echo '<h3>Moving down page "'.trim($data[$_GET["pid"]][2]).'"...</h3>
					<img src="img/arrow_out.png" alt="" /> Output:<br />
					<textarea rows="10" cols="50">'.$textzors.'</textarea><br />
					<br />
					Resaving new menu... ';
					
					$file = fopen("content/pages.txt","w");
					
					if (fwrite($file,$textzors) != false)
						echo '<img src="img/tick.png" alt="" /> Success!';
					else
						echo '<img src="img/cross.png" alt="" /> Failure!';
						
					fclose($file);
					
					break;
				default:
					echo '<h3>What?</h3>
					That action doesn\'t exist or isn\'t implemented.';
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
	
	if ($_GET["s"]=="help")
	{
		?>
		<h2>Help and layout guidelines</h2>
		<h3>Videos</h3>
		To place videos on the website, you will need to ensure your video is in .flv (Adobe Flash Video) format or
		.mp4 (MPEG-4) format. For now, you will need to give such files to the Science Intranet Team, preferably
		using something such as a USB drive, as uploading and redownloading the videos would take too long and also
		use up our download limits. To convert a video to flv/mp4 format, it is recommended you visit a website such
		as www.media-convert.com - this website is brilliant. Browse to your video, scroll down and select the output
		format as either flv/mp4. mp4 is preferred for higher quality videos. You can otherwise leave the options
		as their defaults, and then click the blue "Go" button. Once conversion completes, download the video.<br />
		<br />
		<h3>Layout consistency</h3>
		<ul>
		<li>Image headers should be 1008 pixels wide and 196px pixels tall.</li>
		<li>You need to style your tables: titles should be "table_title", and every second row should be "table_rowhi"</li>
		</ul>
		<?php
	}
}
?>