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
	echo '<h3>Deleting page "'.trim($data[$_GET["pid"]]["fullname"]).'"...</h3>';
	
	$file2del = $data[$_GET["pid"]]["shortname"];
	
	unset($data[$_GET["pid"]]);
	
	$data = array_values($data);
	
	echo $txt['admin_panel_modmenu_prog'].' ';
	
	$file = fopen($path['pages'].'/pages.txt',"w");
	
	if (fwrite($file,json_encode($data)) != false)
		echo '<img src="'.$path['images'].'/tick.png" alt="" /> '.$txt['text_success'];
	else
		echo '<img src="'.$path['images'].'/cross.png" alt="" /> '.$txt['text_failure'];
		
	fclose($file);
	
	echo '<br />
	<br />
	'.$txt['admin_panel_deleting'].' ';
	
	if (unlink($path['pages'].'/'.$file2del.'.php'))
		echo '<img src="'.$path['images'].'/tick.png" alt="" /> '.$txt['text_success'];
	else
		echo '<img src="'.$path['images'].'/cross.png" alt="" /> '.$txt['text_failure'];
	
	echo '<br /><br />'.$txt['admin_panel_changepage'];
}
?>