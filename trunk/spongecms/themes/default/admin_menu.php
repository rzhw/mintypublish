<div style="float:right;">
	<?php if ($_GET['p'] != 'admin'): echo "\n"; ?>
	<div class="adminblock" id="propertiesbtn">
		<a href="javascript:void(0)">
			<img src="<?php echo $location['images']; ?>/admin_properties.png" alt="properties" />
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

	<div class="adminblock">
		<a href="javascript:$.pageEditor()">
			<img src="<?php echo $location['images']; ?>/admin_edit.png" alt="edit" />
		</a>
	</div>
	<?php echo "\n";endif; ?>
	<div class="adminblock">
		<a href="index.php?p=admin">
			<img src="<?php echo $location['images']; ?>/admin_icon.png" alt="admin" />
			<div class="imgafter"><?php echo $_SESSION['uname']; ?></div>
		</a>
	</div>

	<script type="text/javascript">
		// temporary
		$(".adminblock").wrapInner('<div class="middle"></div>').prepend('<div class="left"></div>').append('<div class="right"></div>');
		$("#propertiesbubble").wrapInner('<div style="margin:45px 5px 5px 5px;"></div>');
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
		});
	</script>
</div>