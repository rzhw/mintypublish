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
	echo '<h3>Information</h3>';
	
	echo 'Recognised filetypes are: <b>VIDEO</b> flv, mp4 <b>IMAGES</b> png, gif, jpg <b>MUSIC</b> mp3<br />
	<br />
	To convert media between filetypes [filler text]<br />
	<br />
	Clicking on <img src="'.$path['images'].'/preview.png" alt="" /> will preview a file. Clicking on
	<img src="'.$path['images'].'/trash.png" alt="" /> will delete a file.<br />
	<br />
	';
	
	echo '<h3>Upload</h3>';
	
	echo '<form method="post" action="'.$path['admin'].'&amp;s=med&amp;action=up" enctype="multipart/form-data">
	<input name="uploadedfile" type="file" /><input type="submit" value="Upload" />
	<br /><br />';
	
	echo '<h3>Media</h3>';
	
	echo '<br /><br />';
	
	$i=0;
	while ($row = mysql_fetch_array($mediaquery))
	{
		entry_media($path['admin'].'&amp;s=med',$row['media_id'],$row['media_filename']);
		echo '<br />';
		$i+=1;
	}
}

/*
 * Summary:      Outputs a page manager listing entry for a specified page
 * Parameters:   $curpage - URL of the page using this function
 *               $pid - numerical ID of the page
 *               $ptitle - text title of the page
 * Return:       Nothing
 */
function entry_media($curpage,$pid,$ptitle)
{
	global $path;
	
	echo '<a href="'.$curpage.'&amp;action=prv&amp;pid='.$pid.'"><img src="'.$path['images'].'/preview.png" alt="" /></a>
	<a href="'.$curpage.'&amp;action=del&amp;pid='.$pid.'"><img src="'.$path['images'].'/trash.png" alt="" /></a>
	
	<b>'.$ptitle.' ('.get_file_type($ptitle).')</b>';
}
?>