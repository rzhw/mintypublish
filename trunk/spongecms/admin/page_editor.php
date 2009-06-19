<?php
/*
	Sponge CMS test version
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
	
	<table cellpadding="0" cellspacing="4" border="0" style="width:100%;">
		<tr>
			<td style="width:128px;">
				'.$txt['admin_panel_edt_srtnm'].'
			</td>
			<td>
				<input type="text" name="theid" value="'.$data[$_GET["pid"]]["shortname"].'" /><br />
				<small>'.$txt['admin_panel_edt_srtnm_dsc'].'</small>
			</td>
		</tr>
		<tr>
			<td>
				'.$txt['admin_panel_edt_fllnm'].'
			</td>
			<td>
				<input type="text" name="thetitle" value="'.$data[$_GET["pid"]]["fullname"].'" /><br />
				<small>'.$txt['admin_panel_edt_fllnm_dsc'].'</small>
			</td>
		</tr>
		<tr>
			<td>
				'.$txt['admin_panel_edt_child'].'
			</td>
			<td>
				<input type="text" name="thechild" value="'.(isset($data[$_GET["pid"]]["subpage"]) ? $data[$_GET["pid"]]["subpage"] : '-1').'" /><br />
				<small>'.$txt['admin_panel_edt_child_dsc'].' <b>'.$txt['text_notimplemented'].'</b></small>
			</td>
		</tr>
	</table>
	
	<!--<input type="submit" value="Save" />--><br /><br />
	<script type="text/javascript" src="'.$path['js'].'/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="'.$path['js'].'/tiny_mce/tiny_mce_cfg.js"></script>
	<textarea id="thecontent" name="thecontent" style="width:100%;height:480px;">';
			if (isset($_GET["pid"]))
			{
				if ($_GET["pid"] == 0)
					$tehcontent = file_get_contents($path['pages'].'/home.php');
				else
					$tehcontent = file_get_contents($path['pages'].'/'.$data[$_GET["pid"]]['shortname'].".php");
				
				$tehcontent = str_replace("<?php", "[DO NOT EDIT AFTER HERE]", $tehcontent);
				$tehcontent = str_replace("?>", "[EDIT AFTER HERE]", $tehcontent);
				$tehcontent = str_replace('params="', 'rel="', $tehcontent);
				echo $tehcontent;
			}
	echo '</textarea>';
}
?>