<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{#mediasponge_dlg.title}</title>
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script type="text/javascript" src="js/dialog.js"></script>
</head>
<body>

<form onsubmit="MediaSpongeDialog.insert();return false;" action="#">
	<p>Here is a list of files. Embedding is the direct insertion of a media file into a page.</p>
	<p>Embeddable filetypes are: <b>images</b> gif, jpg (with variations), png, apng, svg <b>videos</b> flv, mp4 <b>audio</b> mp3 <b>applets</b> swf</p>
	<p>If you insert a link to a file that does not support embedding, it will lead to a download page.</p>
	
	<table style="width:100%;">
		<tr>
			<th>Filename</th>
			<th style="text-align:left;">Type</th>
			<th colspan="2">Insert</th>
		</tr>
	
		<?php
			include('../../../../config.php');
			include('../../../../functions.php');
			
			$mediaquery = mysql_query("SELECT * FROM files");
			while ($row = mysql_fetch_array($mediaquery))
			{
				$filetype = filetypes('identify',$row['file_filename']);
				
				// start the row
				echo '<tr>';
				
				// title
				echo '<td>' . $row['file_filename'] . '</td>';
				
				// filetype
				echo '<td>' . filetypes('identify', $row['file_filename']) . '</td>';
				
				if (filetypes('embeddable', $row['file_filename']))
				{
					echo '<td><a href="javascript:void(0)" onclick="insertMedia(\'' . $filetype . '\', \'' . $row['file_filename'] . '\', ' . $row['file_id'] . ', true)">Embed</td>';
				}
				else
				{
					echo '<td>--</td>';
				}
				
				echo '<td><a href="javascript:void(0)" onclick="insertMedia(\'' . $filetype . '\', \'' . $row['file_filename'] . '\', ' . $row['file_id'] . ', false)">Link</td>';
				
				// end the row
				echo '</tr>';
			}
		?>
		
		<script type="text/javascript">
			function insertMedia(type, filename, id, embed)
			{
				var filedir = '<?php echo $location['files']; ?>';
				var toinsert = '';
				
				if (embed)
				{
					switch (type)
					{
						case 'image':
							toinsert = '<img src="' + filename + '" alt="' + filename + '" />';
							break;
						case 'video':
						case 'audio':
							toinsert = '[mediainline]' + filename + '[/mediainline]'; // fugly, must kill later D:<
							break;
						default:
							inline = false;
							break;
					}
				}
				
				if (!inline)
				{
					var linktext = prompt('Link text:', filename);
					if (linktext)
					{
						toinsert = '<a href="index.php?p=media&id=' + id + '">' + linktext + '</a>';
					}
					else
					{
						return false;
					}
				}
				
				tinyMCE.execCommand('mceInsertContent', false, toinsert);
			}
		</script>
		
	</table>

	<div class="mceActionPanel">
		<div style="float: right">
			<input type="button" id="cancel" name="cancel" value="{#close}" onclick="tinyMCEPopup.close();" />
		</div>
	</div>
</form>

</body>
</html>
