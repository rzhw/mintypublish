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
	$file = fopen($path['pages'].'/'.$_POST["theid"].".php","w");
	
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
		echo '<img src="'.$path['images'].'/tick.png" alt="" /> '.$txt['text_success'];
	else
		echo '<img src="'.$path['images'].'/cross.png" alt="" /> '.$txt['text_failure'];
		
	fclose($file);
}
?>