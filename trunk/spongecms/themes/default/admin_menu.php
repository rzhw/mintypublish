<aside id="admin">
	<div class="block mode" data-type="preview">
		<img src="<?php echo $location['images']; ?>/admin_preview.png" alt="P" title="Preview Mode" />
	</div>
	<div class="block mode off" data-type="edit">
		<img src="<?php echo $location['images']; ?>/admin_edit.png" alt="E" title="Edit Mode" />
	</div>
	<div style="float:right;">
		<div class="block button" data-type="files">
			<img src="<?php echo $location['images']; ?>/admin_files.png" alt="Files" />
		</div>
		<div class="block button" data-type="pages">
			<img src="<?php echo $location['images']; ?>/admin_pages.png" alt="Pages" />
		</div>
		<div class="block button" data-type="config">
			<a href="index.php?p=admin">
				<img src="<?php echo $location['images']; ?>/admin_config.png" alt="Config" />
			</a>
		</div>
		<div class="sep"></div>
		<div class="block">
			<img src="<?php echo $location['images']; ?>/admin_user.png" alt="Logged in as " />
			<span><?php echo $_SESSION['uname']; ?></span>
		</div>
	</div>

	<script type="text/javascript">
		// temporary
		$("head").append('<style type="text/css">body{margin-top:24px !important;}</style>');
	</script>
</aside>