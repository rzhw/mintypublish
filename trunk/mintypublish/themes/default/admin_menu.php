<aside id="admin">
	<div class="blocks left">
	<div class="block mode" data-type="preview">
		<img src="<?php echo $location['images']; ?>/admin_preview.png" alt="P" title="Preview Mode" />
	</div>
	<div class="block mode off" data-type="edit">
		<img src="<?php echo $location['images']; ?>/admin_edit.png" alt="E" title="Edit Mode" />
	</div>
	</div>
	<div class="blocks right">
		<div class="block button" data-type="files">
			<img src="<?php echo $location['images']; ?>/admin_files.png" alt="Files" title="Files" />
		</div>
		<div class="block button" data-type="pages">
			<img src="<?php echo $location['images']; ?>/admin_pages.png" alt="Pages" title="Pages" />
		</div>
		<div class="block button" data-type="config">
			<img src="<?php echo $location['images']; ?>/admin_config.png" alt="Config" title="Configuration" />
		</div>
		<div class="block button" data-type="profile">
			<img src="<?php echo $location['images']; ?>/admin_user.png" alt="Profile" title="Profile" />
			<span style="display:none;"><?php echo $_SESSION['uname']; ?></span>
		</div>
	</div>
</aside>