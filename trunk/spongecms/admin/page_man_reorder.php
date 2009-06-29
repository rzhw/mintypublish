<?php
/*
	Sponge CMS
	Copyright 2009 a2h - http://a2h.uni.cc/

	Licensed under the Apache License, Version 2.0 (the "License");
	you may not use this file except in compliance with the License.
	You may obtain a copy of the License at

		http://www.apache.org/licenses/LICENSE-2.0

	Unless required by applicable law or agreed to in writing, software
	distributed under the License is distributed on an "AS IS" BASIS,
	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	See the License for the specific language governing permissions and
	limitations under the License.
	
	http://a2h.github.com/Sponge-CMS/
*/
if ($zvfpcms)
{
	$i=0;
	while($row = mysql_fetch_array($pagequery))
	{			
		if ($row['page_id'] == $_GET["pid"])
		{
			$pageorderid_orig = $row['page_orderid'];
			$i+=1;
		}
		
		if ($i == 2) { $dontcontinue = true; }
	}
	
	$pid = mysql_real_escape_string($_GET["pid"]);
	
	if (!$dontcontinue)
	{
		$success = false;
		
		switch ($direction)
		{
			case "up":
				$pageorderid_new = $pageorderid_orig - 1;
				
				$query1 = "UPDATE pages SET page_orderid = $pageorderid_orig WHERE page_orderid = $pageorderid_new";
				$query2 = "UPDATE pages SET page_orderid = $pageorderid_new WHERE page_id = $pid";
				
				if (mysql_query($query1) && mysql_query($query2))
				{
					$success = true;
				}
				break;
			case "down":
				$pageorderid_new = $pageorderid_orig + 1;
				
				$query1 = "UPDATE pages SET page_orderid = $pageorderid_orig WHERE page_orderid = $pageorderid_new";
				$query2 = "UPDATE pages SET page_orderid = $pageorderid_new WHERE page_id = $pid";
				
				if (mysql_query($query1) && mysql_query($query2))
				{
					$success = true;
				}
				break;
		}
		
		if ($success)
		{
			settopmessage(2,'Reorder successful!');
		}
		else
		{
			settopmessage(0,'Reorder unsuccessful!');
		}
		
		echo $query1.'<br />'.$query2;
		
		pageredirect('index.php?p=admin&s=man');
	}
}
?>