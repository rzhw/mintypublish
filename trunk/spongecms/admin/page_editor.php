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
	echo $txt['admin_panel_edt_src'].'<br />
	<br />
	
	<table cellpadding="0" cellspacing="4" border="0" style="width:100%;">
		<tr>
			<td style="width:128px;">
				'.$txt['admin_panel_edt_srtnm'].'
			</td>
			<td>
				<input type="text" name="theid" value="'.$pagetitlemenu.'" /><br />
				<small>'.$txt['admin_panel_edt_srtnm_dsc'].'</small>
			</td>
		</tr>
		<tr>
			<td>
				'.$txt['admin_panel_edt_fllnm'].'
			</td>
			<td>
				<input type="text" name="thetitle" value="'.$pagetitlefull.'" /><br />
				<small>'.$txt['admin_panel_edt_fllnm_dsc'].'</small>
			</td>
		</tr>
		<tr>
			<td>
				'.$txt['admin_panel_edt_child'].'
			</td>
			<td>
				<select name="thechild">
					<option value="-1">None</option>
					<option value="-2">----------------------</option>';
					mysql_data_seek($pagequery, 0);
					while ($row = mysql_fetch_array($pagequery))
					{
						echo '<option value="'.$row['page_id'].'">'.$row['page_title_full'].'</option>';
					}
				echo '
				</select><br />
				<small>'.$txt['admin_panel_edt_child_dsc'].'</small>
			</td>
		</tr>
		<tr>
			<td>
				'.$txt['admin_panel_edt_hideinmenu'].'
			</td>
			<td>
				<input type="radio" name="hideinmenu" value="0"'.($hideinmenu?'':'checked="checked"').'/> No
				<input type="radio" name="hideinmenu" value="1" /> Yes
			</td>
		</tr>
	</table>
	
	<!--<input type="submit" value="Save" />--><br /><br />
	<script type="text/javascript" src="'.$path['js'].'/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="'.$path['js'].'/tiny_mce/tiny_mce_cfg.js"></script>
	<textarea id="thecontent" name="thecontent" style="width:100%;height:480px;">';
			if (isset($_GET["pid"]))
			{
				// find a better way to do this
				$pagecontent = str_replace("<?php", "[DO NOT EDIT AFTER HERE]", $pagecontent);
				$pagecontent = str_replace("?>", "[EDIT AFTER HERE]", $pagecontent);
				$pagecontent = str_replace('params="', 'rel="', $pagecontent);
				echo $pagecontent;
			}
	echo '</textarea>';
}
?>