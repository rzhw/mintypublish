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
$zvfpcms = true;
$root = '..';
require_once('../config.php');
require_once('../functions.php');

$filedir = $root . str_replace($location['root'],'',$location['files']);

if ($auth->isLoggedIn())
{
	switch ($_GET['type'])
	{
		case 'get':
			header('Content-type: application/json');
			
			// the overall array
			$output = array();
			
			// the target directory
			$targetdir = '../media'; // change to use $location!
			
			if (isset($_GET['folder']))
			{
				$targetdir .= '/' . $_GET['folder'];
			}
			
			// get the files in the target directory
			$targetdirfiles = scandir($targetdir);
			
			// prepare all the files and folders
			$tempdirs = array();
			$tempfiles = array();
			foreach ($targetdirfiles as $filename)
			{
				if ($filename != '.' && $filename != '..')
				{
					if (is_dir($targetdir . '/' . $filename))
					{
						$tempdirs[] = $filename;
					}
					else
					{
						$tempfiles[] = $filename;
					}
				}
			}
			
			// output the folders
			foreach($tempdirs as $filename)
			{
				$tempout = array(
					'data' => $filename,
					'attributes' => array(
						'rel' => 'folder'
					)
				);
				
				if (count(scandir($targetdir . '/' . $filename)) > 2) // could this code be using unnecessary amounts of mem?
				{
					$tempout['attributes']['class'] = 'closed';
				}
				
				$output[] = $tempout;
			}
			
			// output the files
			foreach($tempfiles as $filename)
			{
				$output[] = array(
					'data' => $filename,
					'attributes' => array(
						'rel' => 'file'
					)
				);
			}
			
			// take the output and go!
			echo json_encode($output);
			
			break;
		
		case 'upload':
			// the ajaxupload script uses an iframe to get the response so this can't be used
			//header('Content-type: application/json');
			
			// disallow uploading of potentially unsafe files
			// perhaps see if a check can be done for installed languages
			$disallowed = array(
				'htm', 'html', 'shtml', 'phtml', 'php', 'php3', 'php4', 'php5', 'php6', 'js', 'cgi', 'rb', 'py', 'lua', 'asp', 'aspx'
			);
			
			// work out the destination for the file (1, 1, 1, uh... 1!)
			$filename = basename($_FILES['mintyupload']['name']);
			$filedest = $filedir . '/' . $filename;
			
			// extension
			$fileext = substr(strrchr($filename, '.'), 1);
			
			if (!in_array($fileext, $disallowed))
			{			
				// success tracking
				$success = true;
				
				// incoming!
				if (!move_uploaded_file($_FILES['mintyupload']['tmp_name'], $filedest))
				{
					$success = false;
				}
				
				// message
				if ($success)
				{
					$message = $txt['files_add_success'] . ' (' . $filename . ')';
				}
				else
				{
					$message = $txt['files_add_failure'];
				}
			}
			else
			{
				$success = false;
				$message = 'File extension disallowed';
			}
			
			echo json_encode(array(
				'success' => $success,
				'message' => $message
			));
			
			break;
		
		case 'rename':
			header('Content-type: application/json');
			
			// info goes in
			$from = $filedir . '/' . escape_smart($_POST['from']);
			$to = $filedir . '/' . escape_smart($_POST['to']);
			
			// success tracking
			$success = true;
			
			// rename the file
			try
			{
				rename($from, $to);
			}
			catch (Exception $e)
			{
				$success = false;
			}
			
			// message
			if ($success)
			{
				$message = $txt['files_info_success'];
			}
			else
			{
				$message = $txt['files_info_failure'];
			}
			
			echo json_encode(array(
				'success' => $success,
				'message' => $message
			));
			
			break;
		
		case 'delete':
			header('Content-type: application/json');
			
			// info goes in
			$filename = escape_smart($_POST['filename']);
			
			// success tracking
			$success = true;
			
			// delete the file
			try
			{
				unlink($filedir . '/' . $filename);
			}
			catch (Exception $e)
			{
				$success = false;
			}
			
			// message
			if ($success)
			{
				$message = $txt['files_del_success'];
			}
			else
			{
				$message = $txt['files_del_failure'];
			}
			
			echo json_encode(array(
				'success' => $success,
				'message' => $message
			));
			
			break;
	}
}
else
{
	echo $txt['notadmin'];
}
?>