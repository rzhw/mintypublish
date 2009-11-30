<?php
/*
 * Sponge Content Management System
 * Copyright (c) 2009 a2h - http://a2h.uni.cc/
 * http://zvfpcms.sourceforge.net/
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Under section 7b of the GNU General Public License you are
 * required to preserve this notice.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
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