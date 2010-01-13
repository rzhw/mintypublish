/*
 * mintypublish Content Management System
 * Copyright (c) 2009-2010 a2h
 * http://github.com/a2h/mintypublish
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
		$("#admin .block.mode[data-type="+curmode+"]").addClass('off');
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
	var drop = $('<div class="drop">\
	              <div class="content"></div>\
	              <div class="status"></div>\
	              <div class="close"><a href="javascript:void(0)" onclick="$(this).parent().parent().hide()">close</a></div>\
	              </div>').appendTo("#admin").hide();
	
	var listing = '<div class="list"></div>\
	               <div class="button4">\
	               <button id="admin_list_add">add</button>\
	               <button id="admin_list_view">view</button>\
	               <button id="admin_list_info">info</button>\
	               <button id="admin_list_delete">delete</button>\
	               </div>\
	               <div class="more"></div>';
	
	$("#admin .block.button").click(function() {
		// variables
		var type = $(this).attr('data-type');
		
		// using drop
		if (type == 'files' || type == 'pages')
		{
			$(drop).show().css({
				'position': 'fixed',
				'left': $(this).position().left + $(this).width() + 8 - $(drop).width(),
				'top': $("#admin").height()
			});
		}
		
		// now what?
		switch (type)
		{
			case 'files':
				// create the tree
				$(drop).find(".content").html(listing).find(".list").tree({
					data : { type : 'json' , opts : { url : loc['admin2'] + '/files.php?type=get' } },
					ui : { animation : 250, theme_path : loc['tree'] + '/style.css' },
					types : {
						'default' : {
							draggable : false
						},
						'root' : {
							deletable : false,
							renameable : false,
							max_children : -1,
							max_depth : 1
						},
						'file' : {
							max_children: 0,
							icon : { image : loc['tree'] + '/file.png' }
						}
					}
				});
				
				// give the buttons appropriate actions
				$("#admin_list_add").click(function() {
					// make this use the .more div instead of the inbuilt func for consistency
					$.tree.focused().create(false,-1);
				});
				
				$("#admin_list_view").click(function() {
					id = $.tree.focused().selected;
					if (id)
					{
						// remember that this depends on the old admin panel functionality!
						location.href = loc['admin'] + '&s=med&action=prv&pid=' + $(id).attr('data-id');
					}
					else
					{
						alert('You haven\'t selected anything!');
					}
				});
				break;
			
			case 'pages':
				// prefix for ids
				var pidprefix = 'id_';
				
				// create the tree
				$(drop).find(".content").html(listing).find(".list").tree({
					data : { type : 'json' , opts : { url : loc['admin2'] + '/pages.php?type=get&pidprefix=' + pidprefix } },
					ui : { animation : 250, theme_path : loc['tree'] + '/style.css' },
					types : {
						'default' : {
							icon : { image : loc['tree'] + '/file.png' }
						}
					},
					callback : {
						'onmove' : function(node, node_ref, movetype, tree_cur, tree_old) {
							// if the node has a parent get that instead of the whole tree
							var toget = $.tree.focused().parent(node).length > 0 ? $.tree.focused().parent(node) : false;
							
							// we only want to send the ids of each page, that's it. nothing more.
							var tempnodes = [];
							var tempparent = -1;
							if (movetype != 'inside')
							{
								$.each($.tree.focused().get(toget), function() {
									tempnodes[tempnodes.length] = this.attributes.id.replace(pidprefix,'');
								});
							}
							else
							{
								// 'inside' has the .get() function detailing the parent in the first 2 values
								// with (as an example), {"id":"id_7"}, then {"state":"open","title":"Home"},
								// then an array with the children
								
								$.each($.tree.focused().get(toget), function(i) {
									if (i == 'attributes')
									{
										tempparent = this.id.replace(pidprefix,'');
									}
									else if (i == 'children')
									{
										$.each(this, function() {
											tempnodes[tempnodes.length] = this.attributes.id.replace(pidprefix,'');
										});
									}
								});
							}
							
							// now send the data
							$.ajax({
								type: 'post',
								url: loc['admin2'] + '/pages.php?type=reorder',
								data: $.toJSON({
									nodes: tempnodes,
									parent: tempparent
								}),
								dataType: 'json',
								beforeSend: function() {
									$(drop).find(".status").show().text('saving...');
								},
								success: function(data) {
									$(drop).find(".status").text(data.message);
									setTimeout(function() {
										$(drop).find(".status").fadeOut(2000);
									}, 1000);
								}
							});
						}
					}
				});
				
				// give the buttons appropriate actions
				$("#admin_list_add").click(function() {
					$(drop).find(".more").hide().html('\
						<p><b>Add a page</b></p>\
						<p>\
							<label for="page_title_full">Title (full):</label> <input type="text" id="page_title_full" /><br />\
							<label for="page_title_short">Title (short):</label> <input type="text" id="page_title_short" />\
						</p>\
						<p>\
							<input type="button" value="Go!" />\
						</p>\
					').slideDown();
					
					$(drop).find(".more input[type=button]").click(function() {
						$.ajax({
							type: 'post',
							url: loc['admin2'] + '/pages.php?type=add',
							data: {
								title_full: $("#page_title_full").attr('value'),
								title_short: $("#page_title_short").attr('value')
							},
							dataType: 'json',
							beforeSend: function() {
								$(drop).find(".status").show().text('saving...');
							},
							success: function(data) {
								$(drop).find(".status").text(data.message);
								
								if (data.success)
								{
									$.tree.focused().refresh();
								}
								
								setTimeout(function() {
									$(drop).find(".status").fadeOut(2000);
								}, 1000);
							}
						});
					});
				});
				
				$("#admin_list_view").click(function() {
					id = $.tree.focused().selected;
					if (id)
					{
						location.href = 'index.php?p=' + $(id).attr('id').replace(pidprefix,'');
					}
					else
					{
						alert('You haven\'t selected anything!');
					}
				});
				break;
			
			case 'config':
				location.href = loc['admin'];
				break;
		}
	});
});