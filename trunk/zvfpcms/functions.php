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

/*
 * Summary:      Outputs the page editor
 * Parameters:   $currentpage as string - Page containing editor
 *               $shorttitle as string (optional) - Short title when editing
 *               $title as string (optional) - Full title when editing
 *               $child as string (optional) - Child page (short title) when editing
 * Return:       Nothing
 */
function template_editor($currentpage,$shorttitle = null,$title = null,$child = null)
{
	global $txt;
	
	echo $txt['admin_panel_edt_src'].'<br />
	<br />
	
	'.$txt['admin_panel_edt_srtnm'].'
		<a href="javascript:alert(\''.$txt['admin_panel_edt_srtnm_dsc'].'\')"><img src="zvfpcms/img/help.png" alt="" style="width:12px;height:12px;" /></a>
		<input type="text" name="theid" value="'.$shorttitle.'" /><br />
		
	'.$txt['admin_panel_edt_fllnm'].'
		<a href="javascript:alert(\''.$txt['admin_panel_edt_fllnm_dsc'].'\')"><img src="zvfpcms/img/help.png" alt="" style="width:12px;height:12px;" /></a>
		<input type="text" name="thetitle" value="'.$title.'" /><br />
		
	'.$txt['admin_panel_edt_child'].'
		<a href="javascript:alert(\''.$txt['admin_panel_edt_child_dsc'].'\')"><img src="zvfpcms/img/help.png" alt="" style="width:12px;height:12px;" /></a>
		<input type="text" name="thechild" value="'.(isset($child) ? $child : '-1').'" /> <b>'.$txt['text_notimplemented'].'</b><br />
		
	<br />
	<input type="submit" /><br /><br />
	<script type="text/javascript" src="zvfpcms/js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="zvfpcms/js/tiny_mce/tiny_mce_cfg.js"></script
	
	<div style="position:relative;left:-18px;">
		<textarea id="thecontent" name="thecontent" style="width:1048px;height:512px;">';
			if ($shorttitle != null || $_GET["pid"] == "0")
			{
				if ($_GET["pid"] == "0")
					$tehcontent = file_get_contents("zvfpcms/pg/home.php");
				else
					$tehcontent = file_get_contents("zvfpcms/pg/".$shorttitle.".php");
				
				$tehcontent = str_replace("<?php", "[DO NOT EDIT AFTER HERE]", $tehcontent);
				$tehcontent = str_replace("?>", "[EDIT AFTER HERE]", $tehcontent);
				$tehcontent = str_replace('params="', 'rel="', $tehcontent);
				echo $tehcontent;
			}
	echo '</textarea>
	</div>';
}

/*
 * Summary:      Outputs a page manager listing entry for a specified page
 * Parameters:   $curpage - URL of the page using this function
 *               $pid - numerical ID of the page
 *               $ptitle - text title of the page
 *               $top - whether the page is the first entry in the list
 *               $bottom - whether the page is the last entry in the list
 * Return:       Nothing
 */
function template_page_man_entry($curpage,$pid,$ptitle,$top=false,$bottom=false)
{
	
	echo '<a href="'.($top ? 'javascript:alert(\'You cannot move this page up; it already is on the top.\')' : $curpage.'&amp;action=pup&amp;pid='.$pid).'"><img src="zvfpcms/img/arrow_up'.($top ? '_off' : '').'.png" alt="" style="width:12px;height:12px;" /></a>';
	echo '<a href="'.($bottom ? 'javascript:alert(\'You cannot move this page down; it already is on the bottom.\')' : $curpage.'&amp;action=pdn&amp;pid='.$pid).'"><img src="zvfpcms/img/arrow_down'.($bottom ? '_off' : '').'.png" alt="" style="width:12px;height:12px;" /></a>';
	
	echo '
	<a href="'.$curpage.'&amp;action=edt&amp;pid='.$pid.'"><img src="zvfpcms/img/page_edit.png" alt="" style="width:12px;height:12px;" /></a>
	<a href="'.$curpage.'&amp;action=del&amp;pid='.$pid.'"><img src="zvfpcms/img/page_delete.png" alt="" style="width:12px;height:12px;" /></a>
	<a href="javascript:alert(\'This page is not a child page. Making it a child of a page is currently not implemented.\')"><img src="zvfpcms/img/page_child_off.png" alt="" style="width:12px;height:12px;" /></a>
	
	<b>'.$pid.'. '.$ptitle.'</b>';

}

/*
 * Summary:      Modifies a variable in the configuration file
 * Parameters:   $var as string - the name of the variable (WITH THE PREFIX)
 *               $newval as string - the new value for the variable
 * Return:       Nothing
 */
function config_modify($var,$newval)
{
	$filec = fopen($path['root'].'/config.php','w+');
	
	while (!feof($filec))
	{
		$confstr .= fgets($filec);
	}
	
	$confln = explode('\n',$confstr);
	
	for ($i=0;$i<count($confln);$i++)
	{
		if (strstr($confln[$i],$var))
		{
			$confln[$i] = $var.'=\''.addslashes($newval).'\';';
		}
	}
	$confstr = implode("\n",$confln);
	
	fwrite($filec,$confstr);
	
	fclose($filec);
}
?>