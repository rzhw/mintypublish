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

$filedir = '../' . str_replace($location['root'],'',$location['media']);

if (isloggedin())
{
	switch ($_GET['type'])
	{
		case 'get':
			header('Content-type: application/json');
			
			// the parents
			$parents = filetypes('list','names',true);
			
			// add the common stuff to the parents
			$output = array();
			$c = count($parents);
			for ($i=0;$i<$c;$i++)
			{
				$output[$i]['data'] = $parents[$i];
				$output[$i]['attributes'] = array('rel' => 'root');
			}
			
			// add the files to the parents
			$files = mysql_query("SELECT * FROM media ORDER BY media_filename ASC");
			while ($file = mysql_fetch_array($files))
			{
				$key = array_search(filetypes('identify',$file['media_filename'],true),$parents);
				$output[$key]['children'][] = array(
					'data' => $file['media_filename'],
					'attributes' => array('rel' => 'file', 'id' => $_GET['fidprefix'] . $file['media_id'])
				);
			}
			
			// finally!
			echo json_encode($output);
			
			break;
		
		case 'upload':
			// the ajaxupload script uses an iframe to get the response so this can't be used
			//header('Content-type: application/json');
			
			// work out the destination for the file (1, 1, 1, uh... 1!)
			$filename = basename($_FILES['mintyupload']['name']);
			$filedest = $filedir . '/' . $filename;
			
			// success tracking
			$success = true;
			
			// incoming!
			if (!move_uploaded_file($_FILES['mintyupload']['tmp_name'], $filedest))
			{
				$success = false;
			}
			
			// add it to the db
			mysql_query("INSERT INTO media (media_filename) VALUES('$filename')") or $success = false;
			
			// message
			if ($success)
			{
				$message = 'file upload succeeded! (' . $filename . ')';
			}
			else
			{
				$message = 'file upload failed!';
			}
			
			echo json_encode(array(
				'success' => $success,
				'message' => $message
			));
			
			break;
		
		case 'delete':
			header('Content-type: application/json');
			
			// info goes in
			$fid = $_POST['file_id'];
			
			// success tracking
			$success = true;
			
			// get the filename to delete
			$filea = mysql_query("SELECT media_filename FROM media WHERE media_id = $fid LIMIT 1");
			while ($file = mysql_fetch_array($filea))
			{
				try
				{
					unlink($filedir . '/' . $file['media_filename']);
				}
				catch (Exception $e)
				{
					$success = false;
				}
			}
			
			// delete the file
			mysql_query("DELETE FROM media WHERE media_id = $fid") or $success = false;
			
			// message
			if ($success)
			{
				$message = 'deleted!';
			}
			else
			{
				$message = 'delete failed!';
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
	echo 'You either do not have permissions or your session has expired.';
}
?>