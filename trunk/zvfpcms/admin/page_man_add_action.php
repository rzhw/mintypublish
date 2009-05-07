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
	echo '<h2>'.$txt['admin_panel_addpage_prog'].'</h2>';
	
	$file = fopen($path['pages'].'/'.$_POST["theid"].".php","w");
	
	$contenttowrite = str_replace('\"','"',$_POST["thecontent"]);
	$contenttowrite = str_replace("\'","'",$contenttowrite);
	
	echo $txt['admin_panel_addpage_savpr'].' ';
	
	if (fwrite($file,$contenttowrite) != false)
		echo '<img src="'.$path['images'].'/tick.png" alt="" /> '.$txt['text_success'];
	else
		echo '<img src="'.$path['images'].'/cross.png" alt="" /> '.$txt['text_failure'].' '.$txt['admin_panel_addpage_blnk'];
		
	echo '<br /><br />';
		
	fclose($file);
	
	$data = json_decode(file_get_contents($path['pages'].'/pages.txt'),true);
	$file2 = fopen($path['pages'].'/pages.txt',"w");
	
	// TODO: Subpage support
	$data[sizeof($data)] = array(
		"shortname" => $_POST["theid"],
		"fullname" => $_POST["thetitle"],
		"subpage" => -1
	);
	
	echo $txt['admin_panel_modmenu_prog'].' ';
	
	if (fwrite($file2,json_encode($data)) != false)
		echo '<img src="'.$path['images'].'/tick.png" alt="" /> '.$txt['text_success'];
	else
		echo '<img src="'.$path['images'].'/cross.png" alt="" /> '.$txt['text_failure'];
		
	echo '<br /><br />'.$txt['admin_panel_changepage'];
		
	fclose($file2);
}
?>