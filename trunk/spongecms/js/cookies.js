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

/*
 * Summary:      Sets a cookie with the given params
 * Parameters:   cname as string - the name of the cookie
 *               newval as string - the value of the cookie
 *               expirein as int - time in seconds from the current time
 *                                 that the cookie should expire in
 * Return:       Nothing
 */
function setCookie(cname,newval,expirein)
{
	var tempdate = new Date();
	tempdate.setTime(tempdate.getTime() + expirein*1000);
	document.cookie = cname + '=' + escape(newval) + ';expires=' + tempdate.toGMTString();
}

/*
 * Summary:      Gets the value of a cookie with the given name
 * Parameters:   cname as string - the name of the cookie
 * Return:       The value of the cookie
 */
function getCookie(cname)
{
	if (document.cookie.length > 0)
	{
		cvalbegin = document.cookie.indexOf(cname + '=');
		
		if (cvalbegin != -1)
		{
			cvalbegin = cvalbegin + cname.length+1;
			cvalfinish = document.cookie.indexOf(';',cvalbegin);
			
			if (cvalfinish == -1)
			{
				cvalfinish = document.cookie.length;
			}
			
			return unescape(document.cookie.substring(cvalbegin,cvalfinish));
		}
	}
	else
	{
		return '';
	}
}

/*
 * Summary:      Removes a cookie with the given name
 * Parameters:   cname as string - the name of the cookie
 * Return:       Nothing
 */
function removeCookie(cname)
{
	var tempdate = new Date();
	document.cookie = cname + '=0;expires=' + tempdate.toGMTString();
}