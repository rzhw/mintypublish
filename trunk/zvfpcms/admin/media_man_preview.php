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
	echo '<h3>Preview</h3>';
	
	$ftype = get_file_type($data[$_GET["pid"]]);
	
	if ($ftype != "image")
	{
		echo '
		<a  
			 href="'.$path['media'].'/'.$data[$_GET["pid"]].'"  
			 style="display:block;width:640px;height:'.($ftype == "music" ? '30' : '480').'px"  
			 id="player"> 
		</a> 

		<script type="text/javascript">
			flowplayer("player","'.$path['root'].'/flowplayer-3.1.0.swf"';
		
		if ($ftype == "music")
		{
			echo ',{plugins:{controls:{fullscreen:false,height:30}}}';
		}
		
		echo ');
		</script>';
	}
}
?>