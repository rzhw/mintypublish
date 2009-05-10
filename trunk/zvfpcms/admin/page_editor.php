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
	
	<table cellpadding="0" cellspacing="4" border="0" style="border:1px solid #000;width:100%;">
		<tr>
			<td>
				'.$txt['admin_panel_edt_srtnm'].'
				(<a href="javascript:alert(\''.$txt['admin_panel_edt_srtnm_dsc'].'\')">'.$txt['text_whatsthis'].'</a>)
			</td>
			<td>
				<input type="text" name="theid" value="'.$data[$_GET["pid"]]["shortname"].'" />
			</td>
		</tr>
		<tr>
			<td>
				'.$txt['admin_panel_edt_fllnm'].'
				(<a href="javascript:alert(\''.$txt['admin_panel_edt_fllnm_dsc'].'\')">'.$txt['text_whatsthis'].'</a>)
			</td>
			<td>
				<input type="text" name="thetitle" value="'.$data[$_GET["pid"]]["fullname"].'" />
			</td>
		</tr>
		<tr>
			<td>
				'.$txt['admin_panel_edt_child'].'
				(<a href="javascript:alert(\''.$txt['admin_panel_edt_child_dsc'].'\')">'.$txt['text_whatsthis'].'</a>)
			</td>
			<td>
				<input type="text" name="thechild" value="'.(isset($data[$_GET["pid"]]["subpage"]) ? $data[$_GET["pid"]]["subpage"] : '-1').'" /> <b>'.$txt['text_notimplemented'].'</b>
			</td>
		</tr>
	</table>
	<br />
	
	<div id="mediashow" style="border:1px solid #000;padding:4px;">
		<a href="javascript:void(0)" onclick="document.getElementById(\'mediabox\').style.display=\'block\';document.getElementById(\'mediashow\').style.display=\'none\'">Insert Media</a>
	</div>
	
	<div id="mediabox" style="display:none;border:1px solid #000;padding:4px;">
		Click an item in the list to insert it.<br /><br />
		
		<!-- noreplace -->
		';
			$medlist = json_decode(file_get_contents($path['media'].'/media.txt'),true);
			
			for($i = 0; $i < sizeof($medlist); $i++) 
			{
				echo '<a href="javascript:void(0)" onclick="tinyMCE.execCommand(\'mceInsertContent\',false,\'[media]'.$medlist[$i].'[/media]\');">
				'.$medlist[$i].' ('.get_file_type($medlist[$i]).')</a><br />';
			}
		echo '
	</div>
	
	<br />
		
	<br />
	<input type="submit" value="Save" /><br /><br />
	<script type="text/javascript" src="zvfpcms/js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="zvfpcms/js/tiny_mce/tiny_mce_cfg.js"></script>
	
	<div style="position:relative;left:-18px;">
		<textarea id="thecontent" name="thecontent" style="width:1048px;height:512px;">';
			if (isset($_GET["pid"]))
			{
				if ($_GET["pid"] == 0)
					$tehcontent = file_get_contents("zvfpcms/pg/home.php");
				else
					$tehcontent = file_get_contents("zvfpcms/pg/".$data[$_GET["pid"]]['shortname'].".php");
				
				$tehcontent = str_replace("<?php", "[DO NOT EDIT AFTER HERE]", $tehcontent);
				$tehcontent = str_replace("?>", "[EDIT AFTER HERE]", $tehcontent);
				$tehcontent = str_replace('params="', 'rel="', $tehcontent);
				echo $tehcontent;
			}
	echo '</textarea>
	</div>';
}
?>