<?php
/**
 * mintypublish Content Management System
 * Copyright (c) 2009-2010 a2h
 * http://github.com/a2h/mintypublish
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
 */

$zvfpcms = true;

session_start();
$root = '..';
require_once('../config.php');
require_once('../functions.php');

if ($auth->isLoggedIn())
{
	switch ($_GET['type'])
	{
		case 'get':
			switch ($_GET['tab'])
			{
				case 'general':
					$ret = '
						<label for="config-sitename">Site name</label>
						<input type="text" id="config-sitename" name="sitename" value="' . MP_SITENAME . '" /><br /><br />
						
						<label for="config-language">Language (incomplete)</label>
						<select id="config-language" name="language">';
							$languages = array(
								'english' => 'English',
								'japanese' => 'Japanese (Google Translate)'
							);
							foreach ($languages as $id => $name)
							{
								$ret .= '<option value="' . $id . '"' . ($id == MP_LANGUAGE ? ' selected="selected"' : '') . '>' . $name . '</option>';
							}
							$ret .= '
						</select><br /><br />
						
						<label for="config-timezone">Timezone</label>
						<select id="config-timezone" name="timezone">';
							$timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
							foreach ($timezones as $tz)
							{
								$ret .= '<option value="' . $tz . '"' . ($tz == MP_TIMEZONE ? ' selected="selected"' : '') . '>' . $tz . '</option>';
							}
							$ret .= '
						</select><br /><br />
					';
					break;
				
				case 'appearance':
					$ret = '						
						<label for="config-theme">Theme (refresh after saving)</label>
						<select id="config-theme" name="theme">';
							foreach (glob($location['themes'] . '/*', GLOB_ONLYDIR) as $themedir)
							{
								$thm = basename($themedir);
								$ret .= '<option value="' . $thm . '"' . ($thm == MP_THEME ? ' selected="selected"' : '') . '>' . $thm . '</option>';
							}
							$ret .= '
						</select><br /><br />
					';
					break;
				
				default:
					$notab = true;
					break;
			}
			
			if (!$notab)
			{
				echo str_replace(array("\r\n","\n","\t"),'',$ret);
			}
			else
			{
				echo 'That isn\'t a tab. Really, it isn\'t. No kidding.';
			}
			
			break;
		
		case 'set':
			header('Content-type: application/json');
			
			switch ($_GET['tab'])
			{
				case 'general':
					// info goes in
					$sitename = escape_smart($_POST['sitename']);
					$language = escape_smart($_POST['language']);
					$timezone = escape_smart($_POST['timezone']);
					
					// query time!
					$success = true;
					mysql_query("UPDATE config SET config_value='$sitename' WHERE config_name='sitename'") or $success = false;
					mysql_query("UPDATE config SET config_value='$language' WHERE config_name='language'") or $success = false;
					mysql_query("UPDATE config SET config_value='$timezone' WHERE config_name='timezone'") or $success = false;
					
					break;
				
				case 'appearance':
					// info goes in
					$theme = escape_smart($_POST['theme']);
					
					// query time!
					$success = true;
					mysql_query("UPDATE config SET config_value='$theme' WHERE config_name='theme'") or $success = false;
					
					break;
				
				default:
					$notab = true;
					break;
			}
			
			// message
			if ($success && !$notab)
			{
				$message = 'config saved!';
			}
			else
			{
				if ($notab)
				{
					$message = 'invalid tab';
				}
				else
				{
					$message = 'config save failed!';
				}
			}
			
			echo json_encode(array(
				'success' => $success,
				'message' => $message
			));
			
			break;
	}
}
?>