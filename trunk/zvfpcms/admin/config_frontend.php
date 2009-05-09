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
	if (!isset($_POST['docfg']))
	{
		echo '<h3>Configuration</h3>';
		
		echo '<form action="" method="post">
		<table cellpadding="0" cellspacing="4" border="0">
			<tr>
				<td>'.$txt['admin_panel_lang'].' (en/jp):</td>
				<td><input type="text" name="lang" value="en"></td>
			</tr>
			<tr>
				<td>'.$txt['admin_panel_timezone'].' ('.$txt['text_whatsthis'].'):</td>
				<td><input type="text" name="timezone" value="Australia/Sydney"></td>
			</tr>
			<tr>
				<td colspan="2" align="right"><input type="submit" name="docfg" value="'.$txt['text_save'].'"></td>
			</tr>
		</table>
		</form>';
	}
	else
	{		
		updatecfg('$cfg[\'lang\']',$_POST['lang']);
		updatecfg('$cfg[\'timezone\']',$_POST['timezone']);
		
		echo $txt['text_pleasewait'].'<meta http-equiv="refresh" content="0;url='.$path['admin'].'&amp;s=man">';
	}
}

function updatecfg($var,$newval)
{
	// original code found at http://stackoverflow.com/questions/476892/whats-is-the-best-file-format-for-configuration-files
	
	global $path;
	
	$confln = file($path['root'].'/config.php');
	
	$filec = fopen($path['root'].'/config.php','w');
	
	for ($i=0;$i<sizeof($confln);$i++)
	{
		if (strchr($confln[$i],$var) != false)
		{
			$confln[$i] = $var.'=\''.addslashes($newval).'\';'."\n\r";
		}
	}
	
	$confstr = implode('',$confln);
	
	fwrite($filec,$confstr);
	
	fclose($filec);
}
?>