/*
	Sponge CMS test version
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
	
	http://zvfpcms.sourceforge.net/
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