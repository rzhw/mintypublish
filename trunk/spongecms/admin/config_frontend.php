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