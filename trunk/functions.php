<?php
/*
	Ze Very Flat Pancaek CMS test version
	Copyright 2009 a2h - http://a2h.uni.cc/

	Licensed under the Apache License, Version 2.0 (the "License");
	you may not use this file except in compliance with the License.
	You may obtain a copy of the License at

		http://www.apache.org/licenses/LICENSE-2.0

	Unless required by applicable law or agreed to in writing, software
	distributed under the License is distributed on an "AS IS" BASIS,
	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	See the License for the specific language governing permissions and
	limitations under the License.
	
	In case you're a lazy idiot who can't even at least get a basic
	understanding of the license:
	"You must retain, in the Source form of any Derivative Works that You
	distribute, all copyright, patent, trademark, and attribution notices
	from the Source form of the Work, excluding those notices that do not
	pertain to any part of the Derivative Works"
	
	http://zvfpcms.sourceforge.net/
*/

/// FUNCTION:
/// template_editor
/// DESCRIPTION:
/// Echoes editor
/// ARGUMENTS:
/// $currentpage as str - Page containing editor
/// $title as str - Title
/// RETURNS
/// Nothing
function template_editor($currentpage,$shorttitle = null,$title = null)
{
	?>
	If you want to edit the source click the "HTML" button.<br />
	<br />
	Short title <a href="javascript:void(0)" onclick="javascript:alert('no spaces, no capitals nothing eg testpg1 instead of test page 1')"><img src="img/help.png" alt="" style="width:12px;height:12px;" /></a> <input type="text" name="theid" value="<?php echo $shorttitle; ?>" /><br />
	Long title <a href="javascript:void(0)" onclick="javascript:alert('full name to appear as both title and menu name')"><img src="img/help.png" alt="" style="width:12px;height:12px;" /></a> <input type="text" name="thetitle" value="<?php echo $title; ?>" /><br />
	<br />
	<input type="submit" /><br /><br />
	<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
	// O2k7 skin
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "thecontent",
		theme : "advanced",
		skin : "o2k7",
		plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,attribs,styleprops,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,media,advhr,|,fullscreen,|,template,blockquote,pagebreak,|,insertfile,insertimage",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,

		// Example content CSS (should be your site CSS)
		content_css : "css/tinymce.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "js/template_list.js",
		external_link_list_url : "js/link_list.js",
		external_image_list_url : "js/image_list.js",
		media_external_list_url : "js/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
	</script>
	
	<div style="position:relative;left:-18px;">
		<textarea id="thecontent" name="thecontent" style="width:1048px;height:512px;">
			<?php
			if ($shorttitle != null || $_GET["pid"] == "0")
			{
				if ($_GET["pid"] == "0")
					$tehcontent = file_get_contents("content/home.php");
				else
					$tehcontent = file_get_contents("content/".$shorttitle.".php");
				
				$tehcontent = str_replace("<?php", "[DO NOT EDIT AFTER HERE]", $tehcontent);
				$tehcontent = str_replace("?>", "[EDIT AFTER HERE]", $tehcontent);
				$tehcontent = str_replace('params="', 'rel="', $tehcontent);
				echo $tehcontent;
			}
			?>
		</textarea>
	</div>
	<?php
}

/// FUNCTION:
/// template_page_man_entry
/// DESCRIPTION:
/// Echoes page manager entry for a specified page
/// ARGUMENTS:
/// $curpage - URL of the page using this function
/// $pid - numerical ID of the page
/// $ptitle - text title of the page
/// $top - whether the page is the first entry in the list
/// $bottom - whether the page is the last entry in the list
/// RETURNS
/// Nothing
function template_page_man_entry($curpage,$pid,$ptitle,$top=false,$bottom=false)
{
	if (!$top)
		echo '<a href="'.$curpage.'&amp;action=pup&amp;pid='.$pid.'"><img src="img/arrow_up.png" alt="" style="width:12px;height:12px;" /></a>';
	else
		echo '<img src="img/blank-16.png" alt="" style="width:12px;height:12px;" />';
	if (!$bottom)
		echo '<a href="'.$curpage.'&amp;action=pdn&amp;pid='.$pid.'"><img src="img/arrow_down.png" alt="" style="width:12px;height:12px;" /></a>';
	else
		echo '<img src="img/blank-16.png" alt="" style="width:12px;height:12px;" />';
	
	echo '
	<a href="'.$curpage.'&amp;action=edt&amp;pid='.$pid.'"><img src="img/page_edit.png" alt="" style="width:12px;height:12px;" /></a>
	<a href="'.$curpage.'&amp;action=del&amp;pid='.$pid.'"><img src="img/page_delete.png" alt="" style="width:12px;height:12px;" /></a>
	<b>'.$ptitle.'</b>';

}

/// FUNCTION:
/// get_first_sentence
function get_first_sentence($thestring)
{
    $pos[0] = strpos($thestring,'.');
	$pos[1] = strpos($thestring,'?');
	$pos[2] = strpos($thestring,'!');
       
    if($pos[0] === false && $pos[1] === false && $pos[2] === false)
	{
        return $thestring;
    }
    else
	{
		$tehpos = min($pos)+1;
		echo $tehpos;
		return substr($thestring, 0, $tehpos+1);
    }
}
?>