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
	echo '<h3>Editing page "'.trim($data[$_GET["pid"]]["fullname"]).'"</h3>';
	
	// TODO: Fix editing titles of existing pages
	echo '<br /><div class="msgbox_warning"><b>'.$txt['text_warning'].':</b> '.$txt['admin_panel_noedittitle'].'</div><br />';
	
	echo '<form method="post" action="'.$path['admin'].'&amp;s=man&amp;action=edt2&amp;pid='.$_GET["pid"].'">';
		
	template_editor($path['admin'].'&amp;s=man&amp;action=edt&amp;pid='.$_GET["pid"],trim($data[$_GET["pid"]]["shortname"]),trim($data[$_GET["pid"]]["fullname"]));
	
	echo '</form>';
}
?>