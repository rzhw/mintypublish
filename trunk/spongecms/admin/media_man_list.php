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
	echo '<h3>Information</h3>';
	
	echo 'Recognised filetypes are: <b>VIDEO</b> flv, mp4, ogg <b>IMAGES</b> png, gif, jpg <b>MUSIC</b> mp3<br />
	<br />
	To convert media between filetypes [filler text]<br />
	<br />
	Clicking on <img src="zvfpcms/img/preview.png" alt="" /> will preview a file. Clicking on
	<img src="zvfpcms/img/trash.png" alt="" /> will delete a file.<br />
	<br />';
	
	echo '<h3>Upload</h3>';
	
	echo '<form method="post" action="'.$path['admin'].'&amp;s=med&amp;action=up" enctype="multipart/form-data">
	<input name="uploadedfile" type="file" /><input type="submit" value="Upload" />
	<br /><br />';
	
	echo '<h3>Media</h3>';
	
	echo '<br /><br />';
		
	for($i = 0; $i < sizeof($data); $i++) 
	{
		entry_media($path['admin'].'&amp;s=med',$i,$data[$i]);
		echo '<br />';
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
	
	echo '<a href="'.$curpage.'&amp;action=prv&amp;pid='.$pid.'"><img src="zvfpcms/img/preview.png" alt="" /></a>
	<a href="'.$curpage.'&amp;action=del&amp;pid='.$pid.'"><img src="zvfpcms/img/trash.png" alt="" /></a>
	
	<b>'.$ptitle.' ('.get_file_type($ptitle).')</b>';
}
?>