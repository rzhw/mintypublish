<?php
/*
	Ze Very Flat Pancaek CMS test version
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
	
	http://zvfpcms.sourceforge.net/
*/
if ($zvfpcms)
{
	switch ($direction)
	{
		case "up":		
			$tempdata = $data[$_GET["pid"]];
			$data[$_GET["pid"]] = $data[$_GET["pid"]-1];
			$data[$_GET["pid"]-1] = $tempdata;
			
			$file = fopen($path['pages'].'/pages.txt',"w");
			
			fwrite($file,json_encode($data));
				
			fclose($file);
			
			echo $txt['text_pleasewait'].'<meta http-equiv="refresh" content="0;url='.$path['admin'].'&amp;s=man">';
			
			break;
		case "down":			
			$tempdata = $data[$_GET["pid"]];
			$data[$_GET["pid"]] = $data[$_GET["pid"]+1];
			$data[$_GET["pid"]+1] = $tempdata;
			
			$file = fopen($path['pages'].'/pages.txt',"w");
			
			fwrite($file,json_encode($data));
				
			fclose($file);
			
			echo $txt['text_pleasewait'].'<meta http-equiv="refresh" content="0;url='.$path['admin'].'&amp;s=man">';
			
			break;
	}
}
?>