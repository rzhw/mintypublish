<aside id="admin">
	<div class="block mode" data-mode="preview">
		<img src="<?php echo $location['images']; ?>/admin_preview.png" alt="P" title="Preview Mode" />
	</div>
	<div class="block mode off" data-mode="edit">
		<img src="<?php echo $location['images']; ?>/admin_edit.png" alt="E" title="Edit Mode" />
	</div>
	<div class="block mode off" data-mode="structure">
		<a href="javascript:void(0)">
			<img src="<?php echo $location['images']; ?>/admin_structure.png" alt="S" title="Structure Mode" />
		</a>
	</div>
	<div id="propertiesbubble" style="top:-999px;left:-999px;">
		<table>
			<tr>
				<td style="width:86px;">Short name</td>
				<td style="width:18px;">[?]</td>
				<td><input type="text" value="<?php echo $curpg['name_short']; ?>" /></td>
			</tr>
			<tr>
				<td>Full name</td>
				<td>[?]</td>
				<td><input type="text" value="<?php echo $curpg['name_full']; ?>" /></td>
			</tr>
			<tr>
				<td>Child page of</td>
				<td>[?]</td>
				<td><input type="text" value="NOT IMPLEMENTED YET" /></td>
			</tr>
			<tr>
				<td>Show in menu</td>
				<td>[?]</td>
				<td><input type="text" value="NOT IMPLEMENTED YET" /></td>
			</tr>
			<tr>
				<td colspan="3" style="text-align:right;"><a href="javascript:void(0)">Cancel</a> | <a href="javascript:void(0)">Save</a></td>
			</tr>
		</table>
	</div>
	<div class="block" style="float:right !important;">
		<a href="index.php?p=admin">
			<img src="<?php echo $location['images']; ?>/admin_config.png" alt="admin" />
			<!--<div class="imgafter"><?php echo $_SESSION['uname']; ?></div>-->
		</a>
	</div>

	<script type="text/javascript">
		// temporary
		$("head").append('<style type="text/css">body{margin-top:24px !important;}</style>');
		/*$("#propertiesbubble").wrapInner('<div style="margin:45px 5px 5px 5px;"></div>');
		$("#propertiesbubble").css({
			'left': $("#propertiesbtn").position().left + $("#propertiesbtn").width() / 2 - $("#propertiesbubble").width() / 2,
			'opacity': 0
		});
		$("#propertiesbtn").click(function(){
			$("#propertiesbubble").stop().css('top',$(this).position().top-32).animate({'top':$(this).position().top-4,'opacity':1},400);
		});
		$("#propertiesbubble td:last a:first").click(function(){
			$("#propertiesbubble").stop().animate({'top':$("#propertiesbtn").position().top-32,'opacity':0},400);
			setTimeout(function(){$("#propertiesbubble").stop().css('top',-999)},400);
		});*/
	</script>
</aside>