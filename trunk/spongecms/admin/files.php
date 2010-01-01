<?php
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