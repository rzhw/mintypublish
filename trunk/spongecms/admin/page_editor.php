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
?>
<div id="ribbon"></div>
<ul class="ribbon-extra">
	<li>
		<h2><span>Clipboard</span></h2>
		<div class="ribbon-list ribbon-list-tall">
			<div>
				<img src="<?php echo $location['ribbon']; ?>/icons/icon_paste.png" />Paste
				<ul style="display:none;width:160px !important;">
					<li id="thecontent_pastetext">Without formatting</li>
					<li id="thecontent_pasteword">With formatting</li>
				</ul>
			</div>
		</div>
		<div class="ribbon-list">
			<div><img src="<?php echo $location['ribbon']; ?>/icons/icon_small_cut.png" />Cut</div>
			<div><img src="<?php echo $location['ribbon']; ?>/icons/icon_small_copy.png" />Copy</div>
		</div>
	</li>
	<li>
		<h2><span>Font</span></h2>
		<div class="ribbon-list" style="width:208px !important;"></div>
	</li>
	<li>
		<h2><span>Paragraph</span></h2>
		<div class="ribbon-list" style="width:88px !important;"></div>
	</li>
	<li>
		<h2><span>Styles</span></h2>
		<div class="ribbon-list" style="width:96px !important;"></div>
	</li>
	<li>
		<h2><span>Insert</span></h2>
		<div id="thecontent_mediasponge">
			<img src="<?php echo $location['ribbon']; ?>/icons/icon_picture.png" /> Media
		</div>
	</li>
	<li>
		<h2><span>Advanced</span></h2>
		<div id="thecontent_code">
			<img src="<?php echo $location['ribbon']; ?>/icons/html.png" /> HTML
		</div>
	</li>
	<li>
		<h2><span>Properties</span></h2>
		<table cellpadding="0" cellspacing="4" border="0">
			<tr>
				<td style="width:96px;">
					<?php echo $txt['admin_panel_edt_srtnm']; ?>
				</td>
				<td>
					<input type="text" name="theid" value="<?php echo $pagetitlemenu; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $txt['admin_panel_edt_fllnm']; ?>
				</td>
				<td>
					<input type="text" name="thetitle" value="<?php echo $pagetitlefull; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $txt['admin_panel_edt_child']; ?>
				</td>
				<td>
					<select name="thechild">
						<option value="-1">None</option>
						<option value="-2">----------------------</option>
						<?php
						mysql_data_seek($pagequery, 0);
						while ($row = mysql_fetch_array($pagequery))
						{
							echo '<option value="'.$row['page_id'].'">'.$row['page_title_full'].'</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<!--<tr>
				<td>
					'.$txt['admin_panel_edt_hideinmenu'].'
				</td>
				<td>
					<input type="radio" name="hideinmenu" value="0"'.($hideinmenu?'':'checked="checked"').'/> No
					<input type="radio" name="hideinmenu" value="1" /> Yes
				</td>
			</tr>-->
		</table>
	</li>
</ul>

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
$.fn.ribbonEditor = function(launchRibbon) {
	if (typeof(launchRibbon) == 'undefined')
	{		
		tinyMCE.execCommand('mceAddControl', false, $(this).attr('id'));
	}
	else
	{
		// the id of the textarea
		var ta = $(this).attr('id');
		
		// set the ribbon offsets
		var rbos = {
			font: { left: 256 , top: 8 },
			paragraph: { left: 484, top: 8 },
			styles: { left: 604, top: 20 }
		};
		
		// show the ribbon
		$.ribbonAll();
		
		// fonts
		$.tinymcemove({
			textarea : ta,
			position : 'fixed',
			left : rbos.font.left,
			top : rbos.font.top,
			rowheight : 26,
			'z-index' : 2,
			elements : 'fontselect,fontsizeselect,removeformat,|,bold,italic,underline,strikethrough,sub,sup,backcolor,forecolor'
		});
		
		// paragraph
		$.tinymcemove({
			textarea : ta,
			position : 'fixed',
			left : rbos.paragraph.left,
			top : rbos.paragraph.top,
			rowheight : 26,
			'z-index' : 2,
			elements : 'outdent,indent,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull'
		});
		
		// styles
		$.tinymcemove({
			textarea : ta,
			position : 'fixed',
			left : rbos.styles.left,
			top : rbos.styles.top,
			'z-index' : 2,
			elements : 'formatselect'
		});
		
		// hide the toolbar
		$("#"+ta+"_tbl tr:first").css({'position':'fixed','top':'-99999px'});
		
		// shift the content area
		$("#"+ta+"_tbl").css({'position':'relative','top':'-32px','margin-bottom':'-64px'});
	}
	
	return this;
}
$("#thecontent").ribbonEditor();
</script>
	<?php
}
?>