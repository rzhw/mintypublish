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
			
			// build the list
			$output = array();
			$pages = mysql_query("SELECT * FROM pages ORDER BY page_orderid ASC");
			while ($page = mysql_fetch_array($pages))
			{
				$output[] = array(
					'data' => $page['page_title_full'] . '<small class="subtitle">' . $page['page_title_menu'] . '</small>',
					'attributes' => array('id' => $_GET['pidprefix'] . $page['page_id'])
				);
			}
			
			// and output it!
			echo json_encode($output);
			
			break;
		
		case 'reorder':
			header('Content-type: application/json');
			
			// initial taking apart of the info we got
			$params = json_decode(file_get_contents("php://input"), true);
			$nodes = $params['nodes'];
			
			$temp = '';
			
			//
			foreach ($nodes as $node)
			{
				$temp .= $node . '   ';
			}
			
			echo json_encode(array('success'=>$temp));
			break;
	}
}
else
{
	echo 'You either do not have permissions or your session has expired.';
}
?>