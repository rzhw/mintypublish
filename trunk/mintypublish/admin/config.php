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

session_start();
require_once('../config.php');
require_once('../functions.php');

if (isloggedin())
{
	switch ($_GET['type'])
	{
		case 'get':
			$ret = '
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
							$ret .= '<option value="' . $languages[$i][0] . '"' .
							($languages[$i][0] == MP_LANGUAGE ? ' selected="selected"' : '') .
							'>'.$languages[$i][1].'</option>';
						}
						$ret .= '</select>
					</td>
				</tr>
				<tr>
					<td>
						'.$txt['admin_panel_timezone'].':
					</td>
					<td>
						<select name="timezone">
						';
							$timezones = DateTimeZone::listIdentifiers();
							foreach ($timezones as $timezone)
							{
								$ret .= '<option value="' . $timezone . '"' .
								($timezone == MP_TIMEZONE ? ' selected="selected"' : '') .
								'>' . $timezone . '</option>';
							}
							$ret .= '</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="right"><input type="submit" name="docfg" value="'.$txt['text_save'].'"></td>
				</tr>
			</table>';
			
			echo str_replace(array("\r\n","\n","\t"),'',$ret);
			
			break;
		
		case 'set':
			header('Content-type: application/json');
			
			// info goes in
			$language = escape_smart($_POST['language']);
			$timezone = escape_smart($_POST['timezone']);

			// query time!
			$success = true;
			
			$result_language = mysql_query("UPDATE config SET config_value='$language' WHERE config_name='language'") or $success = false;
			$result_timezone = mysql_query("UPDATE config SET config_value='$timezone' WHERE config_name='timezone'") or $success = false;
			
			// message
			if ($success)
			{
				$message = 'page info saved!';
			}
			else
			{
				$message = 'page info save failed!';
			}
			
			echo json_encode(array(
				'success' => $success,
				'message' => $message
			));
			
			break;
	}
}
?>