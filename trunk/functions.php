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

/// FUNCTION:
/// template_editor
/// DESCRIPTION:
/// Echoes editor
/// ARGUMENTS:
/// $currentpage as str - Page containing editor
/// $title as str - Title
/// RETURNS
/// Nothing
function template_editor($currentpage,$shorttitle = null,$title = null,$child = null)
{
	echo $txt['admin_panel_edt_src'].'<br />
	<br />
	
	'.$txt['admin_panel_edt_srtnm'].'
		<a href="javascript:alert(\''.$txt['admin_panel_edt_srtnm_dsc'].'\')"><img src="img/help.png" alt="" style="width:12px;height:12px;" /></a>
		<input type="text" name="theid" value="'.$shorttitle.'" /><br />
		
	'.$txt['admin_panel_edt_fllnm'].'
		<a href="javascript:alert(\''.$txt['admin_panel_edt_fllnm_dsc'].'\')"><img src="img/help.png" alt="" style="width:12px;height:12px;" /></a>
		<input type="text" name="thetitle" value="'.$title.'" /><br />
		
	'.$txt['admin_panel_edt_child'].'
		<a href="javascript:alert(\''.$txt['admin_panel_edt_child_dsc'].'\')"><img src="img/help.png" alt="" style="width:12px;height:12px;" /></a>
		<input type="text" name="thechild" value="'.(isset($child) ? $child : '-1').'" /> <b>'.$txt['text_notimplemented'].'</b><br />
		
	<br />
	<input type="submit" /><br /><br />
	<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="js/tiny_mce/tiny_mce_cfg.js"></script
	
	<div style="position:relative;left:-18px;">
		<textarea id="thecontent" name="thecontent" style="width:1048px;height:512px;">';
			if ($shorttitle != null || $_GET["pid"] == "0")
			{
				if ($_GET["pid"] == "0")
					$tehcontent = file_get_contents("content/home.php");
				else
					$tehcontent = file_get_contents("content/".$shorttitle.".php");
				
				$tehcontent = str_replace("<?php", "[DO NOT EDIT AFTER HERE]", $tehcontent);
				$tehcontent = str_replace("?>", "[EDIT AFTER HERE]", $tehcontent);
				$tehcontent = str_replace('params="', 'rel="', $tehcontent);
				echo $tehcontent;
			}
	echo '</textarea>
	</div>';
}

/// FUNCTION:
/// template_page_man_entry
/// DESCRIPTION:
/// Echoes page manager entry for a specified page
/// ARGUMENTS:
/// $curpage - URL of the page using this function
/// $pid - numerical ID of the page
/// $ptitle - text title of the page
/// $top - whether the page is the first entry in the list
/// $bottom - whether the page is the last entry in the list
/// RETURNS
/// Nothing
function template_page_man_entry($curpage,$pid,$ptitle,$top=false,$bottom=false)
{
	
	echo '<a href="'.($top ? 'javascript:alert(\'You cannot move this page up; it already is on the top.\')' : $curpage.'&amp;action=pup&amp;pid='.$pid).'"><img src="img/arrow_up'.($top ? '_off' : '').'.png" alt="" style="width:12px;height:12px;" /></a>';
	echo '<a href="'.($bottom ? 'javascript:alert(\'You cannot move this page down; it already is on the bottom.\')' : $curpage.'&amp;action=pdn&amp;pid='.$pid).'"><img src="img/arrow_down'.($bottom ? '_off' : '').'.png" alt="" style="width:12px;height:12px;" /></a>';
	
	echo '
	<a href="'.$curpage.'&amp;action=edt&amp;pid='.$pid.'"><img src="img/page_edit.png" alt="" style="width:12px;height:12px;" /></a>
	<a href="'.$curpage.'&amp;action=del&amp;pid='.$pid.'"><img src="img/page_delete.png" alt="" style="width:12px;height:12px;" /></a>
	<a href="javascript:alert(\'This page is not a child page. Making it a child of a page is currently not implemented.\')"><img src="img/page_child_off.png" alt="" style="width:12px;height:12px;" /></a>
	
	<b>'.$pid.'. '.$ptitle.'</b>';

}

/// FUNCTION:
/// get_first_sentence
function get_first_sentence($thestring)
{
    $pos[0] = strpos($thestring,'.');
	$pos[1] = strpos($thestring,'?');
	$pos[2] = strpos($thestring,'!');
       
    if($pos[0] === false && $pos[1] === false && $pos[2] === false)
	{
        return $thestring;
    }
    else
	{
		$tehpos = min($pos)+1;
		echo $tehpos;
		return substr($thestring, 0, $tehpos+1);
    }
}
?>