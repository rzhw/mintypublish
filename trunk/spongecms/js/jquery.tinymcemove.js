/*
 * TinyMCEmove 0.2
 * Copyright (c) 2009 a2h - http://a2h.uni.cc/
 * 
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

(function($){
	$.tinymcemove = function(options) {
		settings = options;
		
		if (typeof(settings.textarea) == 'undefined' || typeof(settings.position) == 'undefined' ||
			typeof(settings.left) == 'undefined' || typeof(settings.top) == 'undefined' ||
			typeof(settings.elements) == 'undefined')
		{
			alert('TinyMCEmove error: Have you defined `textarea`, `position`, `left`, `top` and `elements`?');
		}
		else
		{
			var rows = settings.elements.split(',|,');
			var elements = [];
			var curx = 0;
			var cury = 0;
			var curelmid = '';
			var lastwdh = 0;
			var zindexconflict = false;
			$.each(rows,function(i,row) {
				if (i > 0 && typeof(settings.rowheight) == 'undefined')
				{
					alert('TinyMCEmove error: Have you defined `rowheight`?');
				}
				else
				{
					if (typeof(settings.rowheight) == 'undefined')
					{
						settings.rowheight = 0;
					}
					curx = settings.left;
					cury = settings.top + settings.rowheight * i;
					lastwdh = 0;
					elements[i] = row.split(',');
					$.each(elements[i],function(j,element) {
						curx = curx + lastwdh;
						curelmid = '#'+settings.textarea+'_'+element;
						lastwdh = $(curelmid).width();
						$(curelmid).css({
							position : settings.position,
							left : curx - parseInt($(curelmid).css('margin-left')),
							top: cury
						});
						if (typeof(settings.zIndex) != 'undefined')
						{
							$(curelmid).css('z-index',settings.zIndex);
							zindexconflict = true;
						}
						if (typeof(settings['z-index']) != 'undefined')
						{
							if (!zindexconflict)
							{
								$(curelmid).css('z-index',settings['z-index']);
							}
							else
							{
								alert('TinyMCEmove error: Either set zIndex or z-index, but not both.');
							}
						}
					});
				}
			});
		}
	};
})(jQuery);