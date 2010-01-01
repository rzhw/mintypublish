<?php
switch ($_GET['type'])
{
	case 'get':
		header('Content-type: application/json');
		
		// sample children
		$children = array(
			array('data' => 'Test 1'),
			array('data' => 'Test 2'),
			array('data' => 'Test 3'),
			array('data' => 'Test 4'),
			array('data' => 'Test 5')
		);
		
		// add the attributes to the children
		$c = count($children);
		for ($i=0;$i<$c;$i++)
		{
			$children[$i]['attributes'] = array( 'rel' => 'file' );
		}
		
		// the parents
		$parents = array('Images','Video','Audio','Documents','Other');
		
		// add the required stuff to the parents
		$output = array();
		$c = count($parents);
		for ($i=0;$i<$c;$i++)
		{
			$output[$i]['data'] = $parents[$i];
			$output[$i]['attributes'] = array( 'rel' => 'root' );
			$output[$i]['children'] = $children;
		}
		
		echo json_encode($output);
		break;
}
?>