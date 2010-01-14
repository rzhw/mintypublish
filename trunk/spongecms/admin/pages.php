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
			header('Content-type: application/json');
			
			// build the list NEED TO IMPLEMENT RECOGNITION OF CHILD PAGES
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
		
		case 'add':
			header('Content-type: application/json');
			
			// info goes in [CONSIDER: string escaping]
			$titlefull = $_POST['title_full'];
			$titleshort = $_POST['title_short'];
			
			// find the largest order id
			$pageordertop = mysql_query("SELECT page_orderid FROM pages WHERE page_childof = -1 ORDER BY page_orderid DESC LIMIT 1");
			while ($page = mysql_fetch_array($pageordertop))
			{
				$orderid = $page['page_orderid'] + 1;
			}
			
			// add the page
			$success = true;
			$examplecontent = 'Here is some example content. Let\'s get editing!';
			mysql_query("INSERT INTO pages (page_orderid, page_title_full, page_title_menu, page_content) VALUES ($orderid, '$titlefull', '$titleshort', '<p>$examplecontent</p>')") or $success = false;
			
			// message
			if ($success)
			{
				$message = 'page added!';
			}
			else
			{
				$message = 'page add failed!';
			}
			
			echo json_encode(array(
				'success' => $success,
				'message' => $message
			));
			
			break;
		
		case 'delete':
			header('Content-type: application/json');
			
			// info goes in
			$pid = $_POST['page_id'];
			
			// delete the page
			$success = true;
			mysql_query("DELETE FROM pages WHERE page_id = $pid") or $success = false;
			
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
		
		case 'reorder':
			header('Content-type: application/json');
			
			// initial taking apart of the info we got
			$params = json_decode(file_get_contents("php://input"), true);
			$n = $params['nodes'];
			$c = $params['parent'];
			$s = count($n);
			
			// reorder!
			$success = true;
			for ($i=0; $i<$s; $i++)
			{
				$p = $n[$i];
				// this is probably extremely uneffecient for larger sets of data :/
				mysql_query("UPDATE pages SET page_orderid = $i, page_childof = $c WHERE page_id = $p") or $success = false;
			}
			
			// message
			if ($success)
			{
				$message = 'saved!';
			}
			else
			{
				$message = 'save failed!';
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