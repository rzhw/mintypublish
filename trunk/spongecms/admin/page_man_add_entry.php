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
	echo '<h2>'.$txt['admin_panel_addpage'].'</h2>
	'.$txt['admin_panel_addpage_desc'].'<br />
	<br />
		  <form method="post" action="'.$path['admin'].'&amp;s=add2">';
			 include($path['admin2'].'/page_editor.php');
	echo '</form>';
}
?>