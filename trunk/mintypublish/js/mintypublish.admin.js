/**
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
 */

// this code was written for the default theme
// it needs changes to allow flexibility for other themes
// i.e. not having to use the same base html

/// ATTACH AJAX UPLOAD TO JQUERY

(function($){
	if (typeof(AjaxUpload) == 'function')
	{
		$.fn.ajaxUpload = function(options) {
			// GET is not supported by the ajax upload script, maybe should add it and send it upstream
			if (options.type.toLowerCase() == 'get')
			{
				alert('ajaxUpload: GET is not a valid parameter for this method');
			}
			else
			{
				var settings = $.extend({}, {
					action: options.url,
					name: options.name,
					data: options.data,
					autoSubmit: options.autoSubmit,
					responseType: options.dataType,
					onChange: options.select,
					onSubmit: options.beforeSend,
					onComplete: function(file, response) {
						options.success(response, file);
					}
				});
				
				new AjaxUpload(this, settings);
			}
		};
	}
})(jQuery);

/// INITIALISE TINYMCE

var pageChanged = false, pageSaved = false, pageSaving = false;
tinyMCE.init({
	mode: "none",
	theme: "advanced",
	skin: "sponge",
	plugins: "autoresize,advlink,contextmenu,filemanager,iespell,imagemanager,inlinepopups,media,mediasponge,nonbreaking,noneditable,pagebreak,paste,safari,save,searchreplace,spellchecker,style,table,visualchars,xhtmlxtras",
	theme_advanced_buttons1: "save,|,undo,redo,|,cut,copy,|,pastetext,pasteword,|,bold,italic,underline,strikethrough,sub,sup,|,link,unlink,anchor,|,tablecontrols,|,mediasponge,image,|,code",
	theme_advanced_buttons2: "formatselect,fontselect,fontsizeselect,removeformat,|,justifyleft,justifycenter,justifyright,justifyfull,|,backcolor,forecolor,|,bullist,numlist,outdent,indent,blockquote",
	theme_advanced_buttons3: "",
	theme_advanced_toolbar_location: "external",
	theme_advanced_toolbar_align: "left",
	theme_advanced_path: false,
	theme_advanced_resizing: false,
	content_css: loc['styles']+"/screen.css",
	onchange_callback: function() { pageChanged = true; }
});

$(document).ready(function() {
	/// MODE BLOCKS
	
	var curmode = 'preview';
	$("#admin .block.mode").click(function() {
		// variables
		var mode = $(this).attr('data-type');
		var ta = 'content_edit';
		var doChange = true;
		
		// don't rexecute everything
		if (mode == curmode) { return false; }
		
		// switching from edit
		if (curmode == 'edit')
		{
			if (pageChanged)
			{
				if (!confirm('You have unsaved changes. Would you like to continue switching modes? This will discard all changes.'))
				{
					doChange = false;
				}
			}
			if (doChange)
			{
				cont = tinyMCE.get(ta).getContent();
				$("#content_editing").hide();
				
				if (pageSaved)
				{
					$("#content_content").html(cont);
				}
				else
				{
					tinyMCE.get(ta).setContent($("#content_content").html());
				}
				
				tinyMCE.execCommand('mceRemoveControl', false, ta);
				$("#content_content").show();
			}
		}
		
		// switch the on/off states
		if (doChange)
		{
			$("#admin .block.mode[data-type="+curmode+"]").addClass('off');
			$(this).removeClass('off');
		}
		
		if (doChange)
		{
			switch (mode)
			{
				case 'preview':
					curmode = mode;
					break;
				
				case 'edit':
					pageSaved = false;
					
					if (!$("#"+ta).length)
					{
						$("#content").wrapInner('<div id="content_content" style="display:none;"></div>');
						$("#content").append('<form id="content_editing" onsubmit="$(this).submit();return false;"><textarea id="'+ta+'"></textarea></form>');
						/*! tinymce doesn't detect jquery .submit binds, find a better way to do this (or maybe even edit the tinymce save plugin) */
						$("#content_editing").submit(function() {
							/// PAGE SAVING
							
							if (!pageSaving)
							{
								// to kill an infinite loop that appeared after upgrading to jQuery 1.4.x :/
								pageSaving = true;
								
								// temporary form disabling method until a better solution is available
								$('<div id="'+ta+'_disabler">').appendTo("#content_editing").css({
									'position': 'absolute',
									'left': $("#"+ta+"_parent").offset().left,
									'top': $("#"+ta+"_parent").offset().top,
									'width': $("#"+ta+"_parent").width(),
									'height': $("#"+ta+"_parent").height(),
									'background': '#999',
									'opacity': 0.5
								});
								
								// off goes the data
								$.ajax({
									type: 'post',
									url: loc['admin2'] + '/pages.php?type=edit',
									data: {
										page_id: $("#pid").text(),
										content: tinyMCE.get(ta).getContent()
									},
									dataType: 'json',
									success: function(data) {
										if (!data.success)
										{
											tinyMCE.get(ta).windowManager.alert(data.message);
										}
										
										$("#"+ta+"_disabler").fadeOut(1000, function() {
											$(this).remove();
										});
										
										pageSaved = true;
										pageChanged = false;
										
										pageSaving = false;
									}
								});
							}
							
							return false;
						});
						$("#"+ta).text($("#content_content").html());
					}
					else
					{
						$("#content_content").hide();
						$("#content_editing").show();
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
		}
	});
	
	/// BUTTON BLOCKS
	
	var drop = $('<div class="drop">\
	              <div class="content"></div>\
	              <div class="status"></div>\
	              <div class="close"><a href="javascript:;" onclick="$.dropClose()">close</a></div>\
	              </div>').appendTo("#admin").hide();
	
	var listing = '<div class="list"></div>\
	               <div class="button4">\
	               <button id="admin_list_add">add</button>\
	               <button id="admin_list_view">view</button>\
	               <button id="admin_list_info">info</button>\
	               <button id="admin_list_delete">delete</button>\
	               </div>\
	               <div class="more"></div>';
	
	$.dropClose = function() {
		$(drop).slideUp(function() {
			$("#admin .block.button").removeClass('on');
		});
	}
	
	$("#admin .block.button").click(function() {
		// on/off
		$("#admin .block.button").removeClass('on');
		$(this).addClass('on');
		
		// variables
		var type = $(this).attr('data-type');
		
		// prepare the drop
		$(drop).css({
			'position': 'fixed',
			'left': $(window).width() - $(drop).width() - 16,
			'top': $("#admin").height()
		});
		
		// now what?
		switch (type)
		{
			case 'files':
				// prefix for ids
				var fidprefix = 'fid_';
				
				// create the tree
				$(drop).find(".content").html(listing).find(".list").tree({
					data: {
						type: 'json',
						async: true, // allow getting different data
						opts: {
							url: loc['admin2'] + '/files.php?' + $.param({
								'type': 'get',
								'fidprefix': fidprefix
							})
						}
					},
					callback: {
						beforedata: function(node) {
							// instead of returning the id attribute, return the name of the folder
							/*! THIS CURRENTLY ONLY GOES ONE LEVEL DEEP */
							var toreturn = {};
							if ($(node).text().replace(' ','') != '')
							{
								toreturn.folder = $(node).text().replace(/^\s*/, ''); // remove whitespace at beginning of string
							}
							return toreturn;
						}
					},
					ui : {
						animation: 250,
						theme_path: loc['tree'] + '/style.css'
					},
					types : {
						'default': {
							draggable: false
						},
						'folder': {
							deletable: false,
							renameable: false,
							max_children: -1,
							max_depth: 1
						},
						'file': {
							max_children: 0,
							icon: { image : loc['tree'] + '/file.png' }
						}
					}
				});
				
				/// FILE ADDING
				
				$("#admin_list_add").ajaxUpload({
					type: 'post',
					url: loc['admin2'] + '/files.php?type=upload',
					name: 'mintyupload',
					dataType: 'json',
					beforeSend: function(file) {
						$.tree.focused().lock(true);
						$(drop).find(".status").show().text('working...');
					},
					success: function(data) {
						$.tree.focused().lock(false);
						
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
				
				/// FILE VIEWING
				
				$("#admin_list_view").click(function() {
					id = $.tree.focused().selected;
					
					if (id)
					{
						alert('Due to a recent change in the method with which file management operates, this function is temporarily unusable. Sorry for the inconvenience.');
					}
					else
					{
						alert('You haven\'t selected anything!');
					}
				});
				
				/// FILE INFORMATION
				
				$("#admin_list_info").click(function() {
					id = $.tree.focused().selected;
					if (id)
					{
						$.tree.focused().lock(true);
						
						// don't use .get_text() because of how we formed the page nodes
						//var ft = $(id).find('a').clone().find('*').remove().end().text(); //thanks to vinse #jquery
						var ff = $.tree.focused().get_text(id);
						
						$(drop).find(".more").hide().html('\
							<p><b>File information</b></p>\
							<p>\
								<label for="file_filename">Filename:</label> <input type="text" id="file_filename" value="' + ff + '" /><br />\
							</p>\
							<p>\
								<input type="button" value="save" />\
								<input type="button" value="cancel" />\
							</p>\
						').slideDown();
						
						$(drop).find(".more input[type=button]:last").click(function() {
							$.tree.focused().lock(false);
							$(drop).find(".more").slideUp();
						});
						
						$(drop).find(".more input[type=button]:first").click(function() {
							/*$.ajax({
								type: 'post',
								url: loc['admin2'] + '/files.php?type=rename',
								data: {
									page_id: $(id).attr('id').replace(pidprefix,''),
									file_filename: $("#file_filename").attr('value'),
									file_title: $("#file_title").attr('value')
								},
								dataType: 'json',
								beforeSend: function() {
									$(drop).find(".more").slideUp();
									$(drop).find(".status").show().text('working...');
								},
								success: function(data) {
									$.tree.focused().lock(false);
									
									$(drop).find(".status").text(data.message);
									
									if (data.success)
									{
										$.tree.focused().refresh();
									}
									
									setTimeout(function() {
										$(drop).find(".status").fadeOut(2000);
									}, 1000);
								}
							});*/
							alert('Not implemented');
							$.tree.focused().lock(false);
							$(drop).find(".more").slideUp();
						});
					}
					else
					{
						alert('You haven\'t selected anything!');
					}
				});
				
				/// FILE DELETING
				
				$("#admin_list_delete").click(function() {
					id = $.tree.focused().selected;
					if (id)
					{
						$.tree.focused().lock(true);
						
						$(drop).find(".more").hide().html('\
							<p><b>Delete file</b></p>\
							<p>\
								Please confirm that you want to delete this file. It cannot be recovered after deletion.\
							</p>\
							<p>\
								<input type="button" value="delete" />\
								<input type="button" value="cancel" />\
							</p>\
						').slideDown();
						
						$(drop).find(".more input[type=button]:last").click(function() {
							$.tree.focused().lock(false);
							$(drop).find(".more").slideUp();
						});
						
						$(drop).find(".more input[type=button]:first").click(function() {
							$.ajax({
								type: 'post',
								url: loc['admin2'] + '/files.php?type=delete',
								data: {
									file_id: $(id).attr('id').replace(fidprefix,'')
								},
								dataType: 'json',
								beforeSend: function() {
									$(drop).find(".more").slideUp();
									$(drop).find(".status").show().text('working...');
								},
								success: function(data) {
									$.tree.focused().lock(false);
									
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
					}
					else
					{
						alert('You haven\'t selected anything!');
					}
				});
				
				break;
			
			case 'pages':
				// prefix for ids
				var pidprefix = 'pid_';
				
				// create the tree
				$(drop).find(".content").html(listing).find(".list").tree({
					data : { type : 'json' , opts : { url : loc['admin2'] + '/pages.php?' + $.param({'type':'get','pidprefix':pidprefix}) } },
					ui : { animation : 250, theme_path : loc['tree'] + '/style.css' },
					types : {
						'default' : {
							icon : { image : loc['tree'] + '/file.png' }
						}
					},
				
				/// PAGE REORDERING
					callback : {
						'onmove' : function(node, node_ref, movetype, tree_cur, tree_old) {
							// if the node has a parent get that instead of the whole tree
							var toget = $.tree.focused().parent(node).length ? $.tree.focused().parent(node) : false;
							
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
								data: { // using jQ 1.4 deep param, but need to be aware of change due to outcry from non php/ror devs
									nodes: tempnodes,
									parent: tempparent
								},
								dataType: 'json',
								beforeSend: function() {
									$(drop).find(".status").show().text('working...');
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
				
				/// PAGE ADDING
				
				$("#admin_list_add").click(function() {
					$(drop).find(".more").hide().html('\
						<p><b>Add a page</b></p>\
						<p>\
							<label for="page_title_full">Title (full):</label> <input type="text" id="page_title_full" /><br />\
							<label for="page_title_short">Title (short):</label> <input type="text" id="page_title_short" />\
						</p>\
						<p>\
							<input type="button" value="add" />\
							<input type="button" value="cancel" />\
						</p>\
					').slideDown();
					
					$(drop).find(".more input[type=button]:last").click(function() {
						$(drop).find(".more").slideUp();
					});
					
					$(drop).find(".more input[type=button]:first").click(function() {
						$.ajax({
							type: 'post',
							url: loc['admin2'] + '/pages.php?type=add',
							data: {
								title_full: $("#page_title_full").attr('value'),
								title_short: $("#page_title_short").attr('value')
							},
							dataType: 'json',
							beforeSend: function() {
								$(drop).find(".more").slideUp();
								$(drop).find(".status").show().text('working...');
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
				
				/// PAGE VIEWING
				
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
				
				/// PAGE EDITING
				
				$("#admin_list_info").click(function() {
					id = $.tree.focused().selected;
					if (id)
					{
						$.tree.focused().lock(true);
						
						// don't use .get_text() because of how we formed the page nodes
						var tf = $(id).find('a').clone().find('*').remove().end().text(); //thanks to vinse #jquery
						var ts = $(id).find('.subtitle').text();
						
						$(drop).find(".more").hide().html('\
							<p><b>Page information</b></p>\
							<p>\
								<label for="page_title_full">Title (full):</label> <input type="text" id="page_title_full" value="' + tf + '" /><br />\
								<label for="page_title_short">Title (short):</label> <input type="text" id="page_title_short" value="' + ts + '" />\
							</p>\
							<p>\
								<input type="button" value="save" />\
								<input type="button" value="cancel" />\
							</p>\
						').slideDown();
						
						$(drop).find(".more input[type=button]:last").click(function() {
							$.tree.focused().lock(false);
							$(drop).find(".more").slideUp();
						});
						
						$(drop).find(".more input[type=button]:first").click(function() {
							$.ajax({
								type: 'post',
								url: loc['admin2'] + '/pages.php?type=rename',
								data: {
									page_id: $(id).attr('id').replace(pidprefix,''),
									title_full: $("#page_title_full").attr('value'),
									title_short: $("#page_title_short").attr('value')
								},
								dataType: 'json',
								beforeSend: function() {
									$(drop).find(".more").slideUp();
									$(drop).find(".status").show().text('working...');
								},
								success: function(data) {
									$.tree.focused().lock(false);
									
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
					}
					else
					{
						alert('You haven\'t selected anything!');
					}
				});
				
				/// PAGE DELETING
				
				$("#admin_list_delete").click(function() {
					id = $.tree.focused().selected;
					if (id)
					{
						$.tree.focused().lock(true);
						
						$(drop).find(".more").hide().html('\
							<p><b>Delete page</b></p>\
							<p>\
								Please confirm that you want to delete this page. It cannot be recovered after deletion.\
							</p>\
							<p>\
								<input type="button" value="delete" />\
								<input type="button" value="cancel" />\
							</p>\
						').slideDown();
						
						$(drop).find(".more input[type=button]:last").click(function() {
							$.tree.focused().lock(false);
							$(drop).find(".more").slideUp();
						});
						
						$(drop).find(".more input[type=button]:first").click(function() {
							$.ajax({
								type: 'post',
								url: loc['admin2'] + '/pages.php?type=delete',
								data: {
									page_id: $(id).attr('id').replace(pidprefix,'')
								},
								dataType: 'json',
								beforeSend: function() {
									$(drop).find(".more").slideUp();
									$(drop).find(".status").show().text('working...');
								},
								success: function(data) {
									$.tree.focused().lock(false);
									
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
					}
					else
					{
						alert('You haven\'t selected anything!');
					}
				});
				
				break;
			
			case 'config':
				$(drop).find(".content").html('\
					<div class="tabs">\
						<span class="tab on" data-id="general">General</span>\
						<span class="tab off" data-id="appearance">Appearance</span>\
						<span class="tab off unimplemented">Plugins</span>\
					</div>\
					<div class="config"></div>\
				');
				$(drop).find(".config").load(loc['admin2'] + '/config.php?type=get&tab=general', function() {
					$(this).append('<input type="submit" value="save" />').wrapInner('<form id="config-form"></form>');
					
					$("#config-form").submit(function() {
						$.ajax({
							type: 'post',
							url: loc['admin2'] + '/config.php?type=set&tab=general',
							data: $("#config_form").serialize(),
							dataType: 'json',
							beforeSend: function() {
								$(drop).find(".status").show().text('working...');
							},
							success: function(data) {								
								$(drop).find(".status").text(data.message);
								
								setTimeout(function() {
									$(drop).find(".status").fadeOut(2000);
								}, 1000);
							}
						});
						return false;
					});
				});
				break;
			
			case 'profile':
				var usernameFull = $(this).find("span").text();
				var usernameShort = usernameFull.substring(0, 18) == usernameFull ? false : usernameFull.substring(0, 18);
				
				$(drop).find(".content").html('\
					<img src="' + loc['images'] + '/defaultava.png" alt="" class="left avatar" />\
					<h1 class="left"' + (usernameShort ? ' title="' + usernameFull + '"' : '') + '>\
						' + (usernameShort ? usernameShort + '...' : usernameFull) + '\
					</h1>\
					<span class="left logout"><a href="index.php?p=logout">logout</a></span>\
					<div class="clear"></div>\
					<p>Hey there, sooner or later there will be profile related options here, not yet though.</p>\
				');
				break;
		}
		
		// drop!
		$(drop).slideDown();
	});
});