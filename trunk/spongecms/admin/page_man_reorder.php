<?php
/*
 * Sponge Content Management System
 * Copyright (c) 2009 a2h - http://a2h.uni.cc/
 * http://zvfpcms.sourceforge.net/
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