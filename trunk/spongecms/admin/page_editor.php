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
	
	<script type="text/javascript" src="'.$location['js'].'/tiny_mce/tiny_mce.js"></script>';
	
	?>

<textarea id="thecontent" name="thecontent" style="width:100%;height:480px;">
<?php
	if (isset($_GET["pid"]))
	{
		// find a better way to do this
		$pagecontent = str_replace("<?php", "[DO NOT EDIT AFTER HERE]", $pagecontent);
		$pagecontent = str_replace("?>", "[EDIT AFTER HERE]", $pagecontent);
		$pagecontent = str_replace('params="', 'rel="', $pagecontent);
		echo $pagecontent;
	}
?>
</textarea>

<script type="text/javascript">
tinyMCE.init({
	mode : "exact",
	elements : "thecontent",
	theme : "advanced",
	skin : "sponge",
	plugins : "advlink,contextmenu,filemanager,iespell,imagemanager,inlinepopups,media,mediasponge,nonbreaking,noneditable,pagebreak,paste,safari,save,searchreplace,spellchecker,style,table,visualchars,xhtmlxtras",
	theme_advanced_buttons1 : "save,pastetext,pasteword,mediasponge,code,tablecontrols,cut,copy,link,unlink,anchor",
	theme_advanced_buttons2 : "bold,italic,underline,strikethrough,sub,sup,fontselect,fontsizeselect,bullist,numlist,outdent,indent,backcolor,forecolor",
	theme_advanced_buttons3 : "undo,redo,|,formatselect,removeformat,|,justifyleft,justifycenter,justifyright,justifyfull",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	content_css : "css/tinymce.css",
	setup : function(ed) { ed.onInit.add(function(ed) {
		// show the ribbon
		$.ribbonToggle();
		
		// fonts
		$.tinymcemove({
			textarea : 'thecontent',
			position : 'fixed',
			left : ribbonoffsets.font.left,
			top : ribbonoffsets.font.top,
			rowheight : 26,
			elements : 'fontselect,fontsizeselect,removeformat,|,bold,italic,underline,strikethrough,sub,sup,backcolor,forecolor'
		});
		
		// paragraph
		$.tinymcemove({
			textarea : 'thecontent',
			position : 'fixed',
			left : ribbonoffsets.paragraph.left,
			top : ribbonoffsets.paragraph.top,
			rowheight : 26,
			elements : 'outdent,indent,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull'
		});

		// hide redirected elements
		$("#thecontent_toolbar1").hide();
	})}
});
</script>

	<?php
}
?>