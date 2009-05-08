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
	
	http://zvfpcms.sourceforge.net/
*/

/*
 * Summary:      Returns file extension from a string
 * Parameters:   $str as string
 * Return:       Filetype
 */
function get_file_extension($str)
{
	return substr(strrchr($str,'.'),1);
}

/*
 * Summary:      Returns filetype from a string
 * Parameters:   $str as string
 * Return:       Filetype
 */
function get_file_type($str)
{
	switch (get_file_extension($str))
	{
		case "flv": return "video"; break;
		case "mp4": return "video"; break;
		case "png": return "image"; break;
		case "gif": return "image"; break;
		case "jpg": return "image"; break;
		case "mp3": return "music"; break;
		default: return "cannot be viewed via most browsers"; break;
	}
}

/*
 * Summary:      Generates a hash from a given password
 *               Original found at http://www.bigroom.co.uk/blog/php-password-security
 * Parameters:   $pwd as string - The password to generate a hash from
 * Return:       The new hash
 */
function user_pass_generate($pwd)
{
	global $user;
    return $salt.(hash('whirlpool',$user['salt'].$pwd));
}
?>