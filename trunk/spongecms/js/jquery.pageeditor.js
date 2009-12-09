tinyMCE.init({
	mode : "none",
	theme : "advanced",
	skin : "sponge",
	plugins : "advlink,contextmenu,filemanager,iespell,imagemanager,inlinepopups,media,mediasponge,nonbreaking,noneditable,pagebreak,paste,safari,save,searchreplace,spellchecker,style,table,visualchars,xhtmlxtras",
	plugins : "advlink,contextmenu,filemanager,iespell,imagemanager,inlinepopups,media,mediasponge,nonbreaking,noneditable,pagebreak,paste,safari,save,searchreplace,spellchecker,style,table,visualchars,xhtmlxtras",
	theme_advanced_buttons1 : "save,|,undo,redo,|,cut,copy,|,pastetext,pasteword,|,bold,italic,underline,strikethrough,sub,sup,|,link,unlink,anchor,|,tablecontrols,|,mediasponge,|,code",
	theme_advanced_buttons2 : "formatselect,fontselect,fontsizeselect,removeformat,|,justifyleft,justifycenter,justifyright,justifyfull,|,backcolor,forecolor,|,bullist,numlist,outdent,indent,blockquote",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path : false,
	theme_advanced_resizing : false,
	content_css : loc['styles']+"/tinymce.css"
});

$.pageEditor = function() {
	// the id of the textarea
	var ta = 'content_edit';
	
	// stuff
	var contwidth = $("#content").width();
	var contheight = $("#content").height();
	$("#content").wrapInner('<div id="content_content" style="display:none;"></div>'); // content_content_content_content_content *headdesk*
	$("#content").append('<textarea id="'+ta+'"></textarea>');
	$("#"+ta).text($("#content_content").html());
	$("#"+ta).css({'position':'relative','left':'-21px','top':'-1px','width':$("#content").width(),'height':$("#content").height()});
	tinyMCE.execCommand('mceAddControl', false, ta);
}