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
	<script type="text/javascript" src="'.$location['js'].'/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="'.$location['js'].'/tiny_mce/tiny_mce_cfg.js"></script>
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