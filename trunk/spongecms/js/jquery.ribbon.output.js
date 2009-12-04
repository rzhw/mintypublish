$.ribbonAll = function() {
	$.ribbonCreate();
	$.ribbonExtras();
	$.ribbonShow();
}

$.ribbonCreate = function() {
	$("body").prepend('<div class="mainContainer" style="display:none;text-align:left;"></div>');
	$.ribbonReset();
}

$.ribbonReset = function() {
	$(".mainContainer").html('\
		<ul class="ribbon">\
			<li style="position:relative;z-index:2;">\
				<ul class="menu">\
					<li>\
						<a href="#home" accesskey="2">Home</a>\
						<ul id="ribbon-cat-container">\
							<li>\
								<h2><span>File</span></h2>\
								<div><img src="'+loc['ribbon']+'/icons/icon_save.png" />Save</div>\
								<div><img src="'+loc['ribbon']+'/icons/icon_exit.png" />Cancel</div>\
							</li>\
						</ul>\
					</li>\
				</ul>\
			</li>\
		</ul>\
	');
}

$.ribbonExtras = function() {
	$(".ribbon-extra li").each(function(i,elm) {
		if ($(elm).parent(".ribbon-extra").length != 0)
		{
			$("#ribbon-cat-container").append($(elm));
		}
	});
}

//

tinyMCE.init({
	mode : "none",
	theme : "advanced",
	skin : "sponge",
	plugins : "advlink,contextmenu,filemanager,iespell,imagemanager,inlinepopups,media,mediasponge,nonbreaking,noneditable,pagebreak,paste,safari,save,searchreplace,spellchecker,style,table,visualchars,xhtmlxtras",
	theme_advanced_buttons1 : "save,pastetext,pasteword,mediasponge,code,tablecontrols,cut,copy,link,unlink,anchor",
	theme_advanced_buttons2 : "bold,italic,underline,strikethrough,sub,sup,fontselect,fontsizeselect,bullist,numlist,outdent,indent,backcolor,forecolor",
	theme_advanced_buttons3 : "undo,redo,|,formatselect,removeformat,|,justifyleft,justifycenter,justifyright,justifyfull",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path : false,
	theme_advanced_resizing : false,
	content_css : loc['styles']+"/tinymce.css",
	setup : function(ed) { ed.onInit.add($.ribbonEditor) }
});

$.ribbonEditor = function(launchRibbon) {
	// the id of the textarea
	var ta = 'content_edit';
	
	// tinymce can finally take over :P
	if (typeof(launchRibbon) == 'undefined')
	{
		$("body").prepend('\
<ul class="ribbon-extra">\
	<li>\
		<h2><span>Clipboard</span></h2>\
		<div class="ribbon-list ribbon-list-tall">\
			<div>\
				<img src="'+loc['ribbon']+'/icons/icon_paste.png" />Paste\
				<ul style="display:none;width:160px !important;">\
					<li id="thecontent_pastetext">Without formatting</li>\
					<li id="thecontent_pasteword">With formatting</li>\
				</ul>\
			</div>\
		</div>\
		<div class="ribbon-list">\
			<div><img src="'+loc['ribbon']+'/icons/icon_small_cut.png" />Cut</div>\
			<div><img src="'+loc['ribbon']+'/icons/icon_small_copy.png" />Copy</div>\
		</div>\
	</li>\
	<li>\
		<h2><span>Font</span></h2>\
		<div class="ribbon-list" style="width:208px !important;"></div>\
	</li>\
	<li>\
		<h2><span>Paragraph</span></h2>\
		<div class="ribbon-list" style="width:88px !important;"></div>\
	</li>\
	<li>\
		<h2><span>Styles</span></h2>\
		<div class="ribbon-list" style="width:96px !important;"></div>\
	</li>\
	<li>\
		<h2><span>Insert</span></h2>\
		<div id="'+ta+'_mediasponge">\
			<img src="'+loc['ribbon']+'/icons/icon_picture.png" /> Media\
		</div>\
	</li>\
	<li>\
		<h2><span>Advanced</span></h2>\
		<div id="'+ta+'_code">\
			<img src="'+loc['ribbon']+'/icons/html.png" /> HTML\
		</div>\
	</li>\
</ul>');
		
		var contwidth = $("#content").width();
		var contheight = $("#content").height();
		$("#content").wrapInner('<div id="content_content" style="display:none;"></div>'); // content_content_content_content_content *headdesk*
		$("#content").append('<textarea id="'+ta+'"></textarea>');
		$("#"+ta).text($("#content_content").html());
		$("#"+ta).css({'position':'relative','left':'-21px','top':'-1px','width':$("#content").width(),'height':$("#content").height()});
		tinyMCE.execCommand('mceAddControl', false, ta);
	}
	
	// create the ribbon
	else if (typeof(launchRibbon) == 'object')
	{
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
}