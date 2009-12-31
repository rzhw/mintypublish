<aside id="admin">
	<div class="block mode" data-mode="preview">
		<img src="<?php echo $location['images']; ?>/admin_preview.png" alt="P" title="Preview Mode" />
	</div>
	<div class="block mode off" data-mode="edit">
		<img src="<?php echo $location['images']; ?>/admin_edit.png" alt="E" title="Edit Mode" />
	</div>
	<div class="block mode off" data-mode="structure">
		<img src="<?php echo $location['images']; ?>/admin_structure.png" alt="S" title="Structure Mode" />
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
	</script>
</aside>