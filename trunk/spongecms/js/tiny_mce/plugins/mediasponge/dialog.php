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
			include('../../../../functions.php');
			
			$medlist = json_decode(file_get_contents('../../../../media/media.txt'),true);
			
			for($i = 0; $i < sizeof($medlist); $i++) 
			{
				echo '<a href="javascript:void(0)" onclick="tinyMCE.execCommand(\'mceInsertContent\',false,\'[media]'.$medlist[$i].'[/media]\');">
				'.$medlist[$i].' ('.get_file_type($medlist[$i]).')</a><br />';
			}
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
