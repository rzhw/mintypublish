<?php
/*
	Sponge CMS test version
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
		// config query in [root]/index.php		
		echo '<h3>Configuration</h3>';
		
		echo '<form action="" method="post">
		<table cellpadding="0" cellspacing="4" border="0">
			<tr>
				<td>
					'.$txt['admin_panel_lang'].':
				</td>
				<td>
					<select name="language">
					';
					$languages = array(
						array('en','English'),
						array('jp','Japanese (machine translated)')
					);
					for ($i=0;$i<sizeof($languages);$i++)
					{
						echo '<option value="' . $languages[$i][0] . '"' .
						($languages[$i][0] == $cfg[$cfg_language]['value'] ? ' selected="selected"' : '') .
						'>'.$languages[$i][1].'</option>';
					}
					echo '</select>
				</td>
			</tr>
			<tr>
				<td>
					'.$txt['admin_panel_timezone'].' ('.$txt['text_whatsthis'].'):
				</td>
				<td>
					<select name="timezone">
					';
						$timezones = DateTimeZone::listIdentifiers();
						foreach ($timezones as $timezone)
						{
							echo '<option value="' . $timezone . '"' .
							($timezone == $cfg[$cfg_timezone]['value'] ? ' selected="selected"' : '') .
							'>' . $timezone . '</option>';
						}
						echo '</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right"><input type="submit" name="docfg" value="'.$txt['text_save'].'"></td>
			</tr>
		</table>
		</form>';
	}
	else
	{
		$language = mysql_real_escape_string($_POST['language']);
		$timezone = mysql_real_escape_string($_POST['timezone']);

		$result_language = mysql_query("UPDATE config SET config_value='$language' WHERE config_name='language'");
		$result_timezone = mysql_query("UPDATE config SET config_value='$timezone' WHERE config_name='timezone'");
		
		if ($result_language && $result_timezone)
		{		
			settopmessage(2,$txt['admin_panel_cfg_sucess']);
		}
		else
		{
			settopmessage(0,$txt['admin_panel_cfg_failure']);
		}
			
		pageredirect($path['admin'].'&s=cfg');
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