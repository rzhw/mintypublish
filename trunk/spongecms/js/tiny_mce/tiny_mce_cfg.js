tinyMCE.init({
	mode : "exact",
	elements : "thecontent",
	theme : "advanced",
	skin : "sponge",
	plugins : "advlink,contextmenu,filemanager,iespell,imagemanager,inlinepopups,media,mediasponge,nonbreaking,noneditable,pagebreak,paste,safari,save,searchreplace,spellchecker,style,table,visualchars,xhtmlxtras",
	theme_advanced_buttons1 : "save,|,undo,redo,|,cut,copy,|,pastetext,pasteword,|,bold,italic,underline,strikethrough,sub,sup,|,link,unlink,anchor,|,tablecontrols,|,mediasponge,|,code",
	theme_advanced_buttons2 : "formatselect,fontselect,fontsizeselect,removeformat,|,justifyleft,justifycenter,justifyright,justifyfull,|,backcolor,forecolor,|,bullist,numlist,outdent,indent,blockquote",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : false,
	content_css : "css/tinymce.css",
	template_external_list_url : "js/template_list.js",
	external_link_list_url : "js/link_list.js",
	external_image_list_url : "js/image_list.js",
	media_external_list_url : "js/media_list.js"
});