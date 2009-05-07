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
	echo $txt['admin_panel_edt_src'].'<br />
	<br />
	
	'.$txt['admin_panel_edt_srtnm'].'
		<a href="javascript:alert(\''.$txt['admin_panel_edt_srtnm_dsc'].'\')"><img src="zvfpcms/img/help.png" alt="" style="width:12px;height:12px;" /></a>
		<input type="text" name="theid" value="'.$data[$_GET["pid"]]["shortname"].'" /><br />
		
	'.$txt['admin_panel_edt_fllnm'].'
		<a href="javascript:alert(\''.$txt['admin_panel_edt_fllnm_dsc'].'\')"><img src="zvfpcms/img/help.png" alt="" style="width:12px;height:12px;" /></a>
		<input type="text" name="thetitle" value="'.$data[$_GET["pid"]]["fullname"].'" /><br />
		
	'.$txt['admin_panel_edt_child'].'
		<a href="javascript:alert(\''.$txt['admin_panel_edt_child_dsc'].'\')"><img src="zvfpcms/img/help.png" alt="" style="width:12px;height:12px;" /></a>
		<input type="text" name="thechild" value="'.(isset($data[$_GET["pid"]]["subpage"]) ? $data[$_GET["pid"]]["subpage"] : '-1').'" /> <b>'.$txt['text_notimplemented'].'</b><br />
		
	<br />
	<input type="submit" /><br /><br />
	<script type="text/javascript" src="zvfpcms/js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="zvfpcms/js/tiny_mce/tiny_mce_cfg.js"></script
	
	<div style="position:relative;left:-18px;">
		<textarea id="thecontent" name="thecontent" style="width:1048px;height:512px;">';
			if ($shorttitle != null || $_GET["pid"] == "0")
			{
				if ($_GET["pid"] == "0")
					$tehcontent = file_get_contents("zvfpcms/pg/home.php");
				else
					$tehcontent = file_get_contents("zvfpcms/pg/".$shorttitle.".php");
				
				$tehcontent = str_replace("<?php", "[DO NOT EDIT AFTER HERE]", $tehcontent);
				$tehcontent = str_replace("?>", "[EDIT AFTER HERE]", $tehcontent);
				$tehcontent = str_replace('params="', 'rel="', $tehcontent);
				echo $tehcontent;
			}
	echo '</textarea>
	</div>';
}
?>