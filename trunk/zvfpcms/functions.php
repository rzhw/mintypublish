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
	// original code found at http://stackoverflow.com/questions/476892/whats-is-the-best-file-format-for-configuration-files
	
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