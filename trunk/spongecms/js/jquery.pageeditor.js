/*
 * Sponge Content Management System
 * Copyright (c) 2009 a2h - http://a2h.uni.cc/
 * http://zvfpcms.sourceforge.net/
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Under section 7b of the GNU General Public License you are
 * required to preserve this notice.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

// this code was written for the default theme
// it needs changes to allow flexibility for other themes
// i.e. not having to use the same base html

tinyMCE.init({
	mode : "none",
	theme : "advanced",
	skin : "sponge",
	plugins : "autoresize,advlink,contextmenu,filemanager,iespell,imagemanager,inlinepopups,media,mediasponge,nonbreaking,noneditable,pagebreak,paste,safari,save,searchreplace,spellchecker,style,table,visualchars,xhtmlxtras",
	theme_advanced_buttons1 : "save,|,undo,redo,|,cut,copy,|,pastetext,pasteword,|,bold,italic,underline,strikethrough,sub,sup,|,link,unlink,anchor,|,tablecontrols,|,mediasponge,image,|,code",
	theme_advanced_buttons2 : "formatselect,fontselect,fontsizeselect,removeformat,|,justifyleft,justifycenter,justifyright,justifyfull,|,backcolor,forecolor,|,bullist,numlist,outdent,indent,blockquote",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "external",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path : false,
	theme_advanced_resizing : false,
	content_css : loc['styles']+"/tinymce.css"
});

$(document).ready(function() {
	/// mode blocks
	var curmode = 'preview';
	$("#admin .block.mode").click(function() {
		// variables
		var mode = $(this).attr('data-type');
		var ta = 'content_edit';
		
		// don't rexecute everything
		if (mode == curmode) { return false; }
		
		// switch the on/off states
		$("#admin .block.mode[data-mode="+curmode+"]").addClass('off');
		$(this).removeClass('off');
		
		// switching from edit
		if (curmode == 'edit')
		{
			cont = tinyMCE.get(ta).getContent();
			tinyMCE.execCommand('mceRemoveControl', false, ta);
			$("#"+ta).hide();
			$("#content_content").html(cont).show();
		}
		
		switch (mode)
		{
			case 'preview':
				curmode = mode;
				break;
			
			case 'edit':
				if ($("#"+ta).length == 0)
				{
					$("#content").wrapInner('<div id="content_content" style="display:none;"></div>');
					$("#content").append('<textarea id="'+ta+'"></textarea>');
					$("#"+ta).text($("#content_content").html());
				}
				else
				{
					$("#content_content").hide();
					$("#"+ta).show();
				}
				var contwidth = $("#content").width();
				var contheight = $("#content").height();
				$("#"+ta).css({'width':contwidth});
				tinyMCE.execCommand('mceAddControl', false, ta);
				curmode = mode;
				break;
			
			case 'structure':
				alert('Structure mode has not been implemented yet.');
				curmode = mode;
				break;
		}
	});
	
	/// button blocks
	$("#admin .block.button").click(function() {
		alert('Hello world');
	});
});