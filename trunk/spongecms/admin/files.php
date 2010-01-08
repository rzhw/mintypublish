<?php
/*
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
 *
 */

session_start();
require_once('../config.php');
require_once('../functions.php');

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
			$files = mysql_query("SELECT media_filename FROM media ORDER BY media_filename ASC");
			while ($file = mysql_fetch_array($files))
			{
				$key = array_search(filetypes('identify',$file['media_filename'],true),$parents);
				$output[$key]['children'][] = array('data' => $file['media_filename'], 'attributes' => array('rel' => 'file'));
			}
			
			// finally!
			echo json_encode($output);
			
			break;
	}
}
else
{
	echo 'You either do not have permissions or your session has expired.';
}
?>