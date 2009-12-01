<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{#mediasponge_dlg.title}</title>
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script type="text/javascript" src="js/dialog.js"></script>
</head>
<body>

<form onsubmit="MediaSpongeDialog.insert();return false;" action="#">
	<p>Click an item in the list to insert it.</p>
	<p>
		<?php
			include('../../../../config.php');
			include('../../../../functions.php');
			
			$mediaquery = mysql_query("SELECT * FROM media");
			while ($row = mysql_fetch_array($mediaquery))
			{
				// title
				echo $row['media_filename'].' ('.get_file_type($row['media_filename']).') - ';
				
				// is it an image?
				if (get_file_type($row['media_filename']) == 'image')
				{
					echo '<a href="javascript:void(0)" onclick="tinyMCE.execCommand(\'mceInsertContent\',false,\'<img src=\\\''.$location['media'].'/'.$row['media_filename'].'\\\' />\')">Insert inline</a>';
				}
				
				// is it an audio/video file?
				else
				{
					echo '<a href="javascript:void(0)" onclick="tinyMCE.execCommand(\'mceInsertContent\',false,\'[mediainline]'.$row['media_filename'].'[/mediainline]\');">Insert inline</a>
					| <a href="javascript:void(0)" onclick="tinyMCE.execCommand(\'mceInsertContent\',false,\'[medialink]'.$row['media_filename'].'[/medialink]\');">Insert link</a>';
				}
				
				// newline
				echo '<br />';
			}
			
			mysql_close($sql_mysql_connection);
		?>
	</p>

	<div class="mceActionPanel">
		<div style="float: right">
			<input type="button" id="cancel" name="cancel" value="{#close}" onclick="tinyMCEPopup.close();" />
		</div>
	</div>
</form>

</body>
</html>
