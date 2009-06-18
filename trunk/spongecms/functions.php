<?php
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
function user_pass_generate($salt,$pwd)
{
	global $user;
    return $salt.(hash('whirlpool',$user['salt'].$pwd));
}

//
function media_html($fname)
{
	global $path;
	
	$toreturn = '';
	
	$ftype = get_file_type($fname);
	
	if ($ftype != "image")
	{
		$toreturn .= '
		<a  
			 href="'.$path['media'].'/'.$fname.'"  
			 style="display:block;width:640px;height:'.($ftype == "music" ? '30' : '480').'px"  
			 id="player"> 
		</a> 

		<script type="text/javascript">
			flowplayer("player","'.$path['root'].'/flowplayer-3.1.0.swf"';
		
		if ($ftype == "music")
		{
			$toreturn .= ',{plugins:{controls:{fullscreen:false,height:30}}}';
		}
		
		$toreturn .= ');
		</script>';
	}
	else
	{
		$toreturn .= '<img src="'.$path['media'].'/'.$fname.'" alt="" />';
	}
	
	return $toreturn;
}

//
function parsebbcode($buffer)
{
	if (strchr($buffer,'<!-- noreplace -->') == false)
	{
		$find = array('/(\[media\])(.+)(\[\/media\])/');
		$replace = array(media_html('\\2'));
		$string = preg_replace($find, $replace, $buffer);
		return $string;
	}
	else
	{
		return $buffer;
	}
}

/*
 * Summary:      Checks whether a given username/password pair is in the database
 * Parameters:   $uname as string
 *               $pwd as string
 * Return:       An array with the values $hit and the salt respectively. See below
 *               for details on "hit"
 */
function isexistinguser($uname,$pwd)
{
	global $path;
	
	$result = mysql_query("SELECT * FROM users WHERE user_username = '$uname'");
	
	/* description of $hit:
	 *  -1 more than one match of the username for some reason
	 *   0 no match for both username/password
	 *   1 match for both username/password
	 *   2 match for username, no match for password
	 *   3 match for password, no match for username
	*/
	
	$hit = 0;
	$rowcounted = false;
	$salt = '';
	
	while($row = mysql_fetch_array($result))
	{
		$salt = $row['user_password_salt'];
		
		if (!$rowcounted && $hit != -1)
		{
			if ($uname == $row['user_username'])
			{
				$hit = 2;
			}
			if (user_pass_generate($row['user_password_salt'],$pwd) == $row['user_password'])
			{
				if ($hit == 2)
					$hit = 1;
				else
					$hit = 3;
			}
		}
		else
		{
			$hit = -1;
		}
		
		// this is for debugging the mysql user handling system
		//echo $hit.'<br /><br />'.user_pass_generate($row['user_password_salt'],$pwd).'<br /><br />';
	}
	
	return array($hit,$salt);
}

//
function isloggedin()
{
	// original code from http://www.evolt.org/node/60265
	
	// is the user set to remember?
	if(isset($_COOKIE['cookuname']) && isset($_COOKIE['cookpwd']))
	{
		$_SESSION['uname'] = $_COOKIE['cookuname'];
		$_SESSION['pwd'] = $_COOKIE['cookpwd'];
	}

	// user's session is still active
	if (isset($_SESSION['uname']) && isset($_SESSION['pwd']))
	{
		// but is their user/pass pair correct?
		if (isexistinguser($_SESSION['uname'], $_SESSION['pwd']) == 2)
		{
			// NO? gtfo
			unset($_SESSION['uname']);
			unset($_SESSION['pwd']);
			return false;
		}
		return true;
	}
	// user isn't active D:
	else
	{
		return false;
	}
}

//
function settopmessage($type,$message)
{
	$temp = json_encode(array(
		'type' => $type,
		'message' => $message
	));
	
	echo '
	<script type="text/javascript">
		setCookie("topmsg",\''.$temp.'\',60);
	</script>';
}

//
function gettopmessage()
{
	global $path;
	
	if (isset($_COOKIE['topmsg']))
	{
		$msg = json_decode(stripslashes($_COOKIE['topmsg']), true);
		
		$temp = '
		<div id="topmsg" class="topmsg_' . $msg['type'] . '">
			<div style="float:left;">
				<img id="topmsg_timer" src="'.$path['images'].'/timer_3.png" alt="" />
			</div>
			<div style="float:left;margin-left:8px;">
				' . $msg['message'] . '
			</div>
			<div style="clear:both;"></div>
		</div>
		
		<script type="text/javascript">
			timedisappear = 3;
			
			updatetime();
			
			function updatetime()
			{
				if (timedisappear > -1)
				{
					setTimeout(function() {
						timedisappear -= 1;
						$("topmsg_timer").writeAttribute({src:"'.$path['images'].'/timer_"+timedisappear+".png"});
						updatetime();
					}, 1000);
				}
				else
				{
					new Effect.Fade("topmsg",{duration:0.5});
				}
			}
			
			removeCookie("topmsg");
		</script>';
		
		return $temp;
	}
	else
	{
		return '';
	}
}

//
function pageredirect($url)
{
	echo '
	<script type="text/javascript">
		document.write(\'<div id="overlayall">Hang on a moment, you\\\'re being redirected...<br /><br />\');
		document.write(\'<small><small>Or click <a href="'.$url.'">here</a> if it doesn\\\'t do so</div>\');
		
		location.href=\''.$url.'\';
	</script>';
}
?>