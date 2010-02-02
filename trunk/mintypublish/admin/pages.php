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
$root = '..';
require_once('../config.php');
require_once('../functions.php');

if ($auth->isLoggedIn())
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
			
			// info goes in
			$titlefull = escape_smart($_POST['title_full']);
			$titleshort = escape_smart($_POST['title_short']);
			
			// find the largest order id
			$pageordertop = mysql_query("SELECT page_orderid FROM pages WHERE page_childof = -1 ORDER BY page_orderid DESC LIMIT 1");
			while ($page = mysql_fetch_array($pageordertop))
			{
				$orderid = $page['page_orderid'] + 1;
			}
			
			// add the page
			$success = true;
			$examplecontent = str_replace("'","\'",'Here is some example content. Let\'s get editing!');
			mysql_query("INSERT INTO pages (page_orderid, page_title_full, page_title_menu, page_content) VALUES ($orderid, '$titlefull', '$titleshort', '<p>$examplecontent</p>')") or $success = false;
			
			// message
			if ($success)
			{
				$message = $txt['pages_add_success'];
			}
			else
			{
				$message = $txt['pages_add_failure'];
			}
			
			echo json_encode(array(
				'success' => $success,
				'message' => $message
			));
			
			break;
		
		case 'edit':
			header('Content-type: application/json');
			
			// info goes in
			$i = escape_smart($_POST['page_id']);
			$c = escape_smart($_POST['content']);
			
			// edit time!
			$success = true;
			mysql_query("UPDATE pages SET page_content = '$c' WHERE page_id = $i") or $success = false;
			
			// message (and we have more room!)
			if ($success)
			{
				$message = '';
			}
			else
			{
				$message = $txt['pages_edit_failure'] . "\n" . mysql_error();
			}
			
			echo json_encode(array(
				'success' => $success,
				'message' => $message
			));
			
			break;
		
		case 'rename':
			header('Content-type: application/json');
			
			// info goes in
			$id = escape_smart($_POST['page_id']);
			$tf = escape_smart($_POST['title_full']);
			$ts = escape_smart($_POST['title_short']);
			
			// rename time!
			$success = true;
			mysql_query("UPDATE pages SET page_title_full = '$tf', page_title_menu = '$ts' WHERE page_id = $id") or $success = false;
			
			// message
			if ($success)
			{
				$message = $txt['pages_info_success'];
			}
			else
			{
				$message = $txt['pages_info_failure'];
			}
			
			echo json_encode(array(
				'success' => $success,
				'message' => $message
			));
			
			break;
		
		case 'delete':
			header('Content-type: application/json');
			
			// info goes in
			$pid = escape_smart($_POST['page_id']);
			
			// delete the page
			$success = true;
			mysql_query("DELETE FROM pages WHERE page_id = $pid") or $success = false;
			
			// message
			if ($success)
			{
				$message = $txt['pages_del_success'];
			}
			else
			{
				$message = $txt['pages_del_failure'];
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
				$message = $txt['pages_order_success'];
			}
			else
			{
				$message = $txt['pages_order_failure'];
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