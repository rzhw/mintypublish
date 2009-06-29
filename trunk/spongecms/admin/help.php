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
	echo '<h2>Media</h2>';
	
	echo '<h3>Uploading</h3>
	Click the browse button, select your file and click upload.
	<h3>Inserting</h3>
	To insert media into a page, click the button that looks like the one circled below when adding or editing a page.<br />
	<img src="'.$path['help'].'/insertmedia.png" alt="" /><br />
	<br />';
	
	echo '<h3>Inserting links</h3>
	Simply write some text, and highlight it. The link button should activate as a result:<br />
	<img src="'.$path['help'].'/insertlink.png" alt="" /><br />
	<br />
	When you click on the link button, you can insert either an external or internal link. If you wish
	to create an external link, simply copy the full URL of the page you wish to link to and paste
	it into the URL box. If you wish to create an internal link, there is a small box below the URL box
	that allows you to select from a list of pages. The window looks like this:<br />
	<img src="'.$path['help'].'/insertlink_window.png" alt="" />
	';
}
?>