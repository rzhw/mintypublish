<?php
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

// connect to mysql
$sql_mysql_connection = mysql_connect($mysql['server'],$mysql['username'],$mysql['password']);
mysql_select_db($mysql['dbname'],$sql_mysql_connection);

// define the core stuff
define('MP_VERSION', '0.5.1-dev');
$configquery = mysql_query("SELECT * FROM config");
while($row = mysql_fetch_array($configquery))
{	
	define(
		'MP_' . strtoupper($row['config_name']),
		$row['config_value']
	);
}

// define the paths
$location = array(
	'root'      => $root,
	'admin'     => 'index.php?p=admin',
	'admin2'    => $root . '/admin',
	'files'     => $root . '/media',
	'js'        => $root . '/js',
	'themes'    => $root . '/themes',
	'theme'     => $root . '/themes/' . MP_THEME,
	'theme_nr'  => 'themes/' . MP_THEME,
	'theme_def' => $root . '/themes/default',
	'images'    => $root . '/themes/' . MP_THEME . '/img',
	'styles'    => $root . '/themes/' . MP_THEME . '/css',
	'tree'      => $root . '/themes/' . MP_THEME . '/tree'
);

// include the language files
require_once($root . '/lang/english.php');
if (MP_LANGUAGE != 'english')
{
	require_once($root . '/lang/' . MP_LANGUAGE . '.php');
}

// functions begin here

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
function filetypes($whattodo,$value='',$bool=false)
{
	global $filetypes;
	
	if (!$filetypes)
	{
		$filetypes = array(
			'img' => array(
				'name' => 'image',
				'name_plural' => 'images',
				'recognised' => array('gif','jpg','jpeg','png','apng','svg')
			),
			'vid' => array(
				'name' => 'video',
				'name_plural' => 'videos',
				'recognised' => array('flv','mp4')
			),
			'aud' => array(
				'name' => 'audio',
				'name_plural' => 'audio',
				'recognised' => array('mp3')
			),
			'doc' => array(
				'name' => 'document',
				'name_plural' => 'documents',
				'recognised' => array('pdf','htm','html','txt','doc','docx','xls','xlsx','csv','ppt','pptx','pub','pubx','adb','adbx','odt','odp','ods')
			),
			'oth' => array(
				'name' => 'other',
				'name_plural' => 'others',
				'recognised' => array()
			)
		);
	}
	
	switch ($whattodo)
	{
		case 'list':
			switch ($value)
			{
				case 'all':
					return $filetypes;
					break;
				case 'names':
					$arr = array();
					foreach ($filetypes as $filetype)
					{
						if ($bool)
						{
							$arr[] = $filetype['name_plural'];
						}
						else
						{
							$arr[] = $filetype['name'];
						}
					}
					return $arr;
					break;
			}
			break;
		case 'identify':
			foreach ($filetypes as $filetype)
			{
				if (in_array(get_file_extension($value),$filetype['recognised']))
				{
					if ($bool)
					{
						return $filetype['name_plural'];
					}
					else
					{
						return $filetype['name'];
					}
				}
			}
			if ($bool)
			{
				return $filetypes['oth']['name_plural'];
			}
			else
			{
				return $filetypes['oth']['name'];
			}
			break;
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
	return hash('whirlpool',$salt.$pwd);
}

//
function media_html($fname)
{
	global $location;
	
	$toreturn = '';
	
	$ftype = filetypes('identify', $fname);
	$fpath = $location['files'].'/'.$fname;
	
	switch ($ftype)
	{
		case 'audio':
		case 'video':
			$toreturn .= '
			<div id="video"></div>
			<script type="text/javascript">
				var videovars = {
					path: "' . ($ftype == 'video' ? '../' : '') /* bug in gsplayer forces these weird paths */ . $fpath . '",
					autoplay: true' . ($ftype == 'video' ? ',
					fullscreen: true' : '') . '
				};
				var videoparams = {
					bgcolor: "#000000",
					allowfullscreen: true
				};
				swfobject.embedSWF("' . $location['root'] . '/player.swf", "video", 800, ' . ($ftype == 'video' ? 450 : 27) . ', "9.0.0", null, videovars, videoparams);
			</script>';
			break;
		
		case 'image':
			$toreturn .= '<img src="' . $fpath . '" alt="" />';
			break;
		
		default:
			$toreturn .= 'Unrecognised filetype';
			break;
	}
	
	return $toreturn;
}

//
function parsebbcode($buffer)
{
	if (strchr($buffer,'<!-- noreplace -->') == false)
	{
		$find = array(
			'/(\[mediainline\])(.+)(\[\/mediainline\])/'
		);
		$replace = array(
			media_html('\\2')
		);
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
 * Return:       An array with the values $hit and the salt respectively.
 *               Possible $hit values:
 *                  -1 more than one match of the username for some reason
 *                   0 no match for both username/password
 *                   1 match for both username/password
 *                   2 match for username, no match for password
 *                   3 match for password, no match for username
 */
function isexistinguser($uname,$pwd,$ishash=false)
{
	global $location;
	
	$uname2 = mysql_real_escape_string($uname);
	
	$result = mysql_query("SELECT user_username,user_password,user_password_salt FROM users WHERE user_username = '$uname2'") or die(mysql_error());
	
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
			
			if (!$ishash)
			{
				$supposedpass = user_pass_generate($row['user_password_salt'],$pwd);
			}
			else
			{
				$supposedpass = $pwd;
			}
			
			if ($supposedpass == $row['user_password'])
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

/*
 * Summary:      Checks whether the current session has a logged in user
 *               Original from http://www.evolt.org/node/60265
 * Parameters:   None
 * Return:       Either true or false
 */

function isloggedin()
{
	// is the user set to remember?
	if (pisset('cookie',array('cookuname','cookpwd')))
	{
		pset('session',array('uname'=>$_COOKIE['cookuname'],'pwd'=>$_COOKIE['cookpwd']));
	}

	// user's session is still active
	if (pisset('session',array('uname','pwd')))
	{
		// but is their user/pass pair correct?
		if (isexistinguser($_SESSION['uname'], $_SESSION['pwd'], true) == 1)
		{
			// NO? gtfo
			punset('session',array('uname','pwd'));
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

/*
 * Summary:      Sets a persistent variable
 * Parameters:   $type as string - can be either 'session' or 'cookie'
 *               $variable as string OR array
 *                   If string - the name of the variable to set
 *                   If array - an array formed as $variable => $value
 *               $value as anything - the value
 *                   If $variable is an array and $type is 'session', don't set this!
 *                   If $variable is an array and $type is 'cookie', this is how long
 *                       the cookie is set for in seconds. If this isn't set then it
 *                       will be set to 3 months. DON'T INCLUDE time()!
 *               $expire as integer
 *                   If $type is 'session', don't set this!
 *                   If $variable is a string and $type is 'cookie', this is how long
 *                       the cookie is set for in seconds. If this isn't set then it
 *                       will be set to 3 months. DON'T INCLUDE time()!
 * Return:       Nothing
 */

function pset($type,$variable,$value='',$expire=7776000)
{
	if (is_string($variable))
	{
		switch ($type)
		{
			case 'session':
				$_SESSION[$variable] = $value;
				break;
			case 'cookie':
				setcookie($variable, $value, time() + $expire, "/");
				break;
		}
	}
	elseif (is_array($variable))
	{
		switch ($type)
		{
			case 'session':
				foreach($variable as $var => $val)
				{
					$_SESSION[$var] = $val;
				}
				break;
			case 'cookie':
				if ($value == '')
				{
					$expire = 7776000;
				}
				else
				{
					$expire = $value;
				}
				foreach($variable as $var => $val)
				{
					setcookie($var, $val, time() + $expire, "/");
				}
				break;
		}
	}
}

/*
 * Summary:      Gets a persistent variable
 * Parameters:   $type as string - can be either 'session' or 'cookie'
 *               $variable as string OR array
 *                   If string - the name of the variable to get
 *                   If array - an array of the variables to get
 * Return:       The value of the variable
 */

function pget($type,$variable)
{
	if (is_string($variable))
	{
		switch ($type)
		{
			case 'session': return $_SESSION[$variable]; break;
			case 'cookie' : return $_COOKIE [$variable]; break;
		}
	}
	elseif (is_array($variable))
	{
		$ret = array();
		switch ($type)
		{
			case 'session':
				foreach($variable as $var)
				{
					$ret[] = $_SESSION[$var];
				}
				break;
			case 'cookie':
				foreach($variable as $var)
				{
					$ret[] = $_COOKIE[$var];
				}
				break;
		}
		return $ret;
	}
}

/*
 * Summary:      Checks if the provided persistent variables are set
 * Parameters:   $type as string - can be either 'session' or 'cookie'
 *               $variable as string OR array
 *                   If string - the name of the variable to check
 *                   If array - an array of the variables to get
 * Return:       `true` if all variables provided are set, otherwise `false`
 */

function pisset($type,$variable)
{
	if (is_string($variable))
	{
		switch ($type)
		{
			case 'session': return isset($_SESSION[$variable]); break;
			case 'cookie' : return isset($_COOKIE [$variable]); break;
		}
	}
	elseif (is_array($variable))
	{
		$ret = true;
		switch ($type)
		{
			case 'session':
				foreach($variable as $var)
				{
					if (!isset($_SESSION[$var]))
						$ret = false;
				}
				break;
			case 'cookie':
				foreach($variable as $var)
				{
					if (!isset($_COOKIE[$var]))
						$ret = false;
				}
				break;
		}
		return $ret;
	}
}

/*
 * Summary:      Unsets some persistent values (no pun intended)
 * Parameters:   $type as string - can be either 'session' or 'cookie'
 *               $variable as string OR array
 *                   If string - the name of the variable to unset
 *                   If array - an array of the variables to unset
 * Return:       Nothing
 */

function punset($type,$variable)
{
	if (is_string($variable))
	{
		switch ($type)
		{
			case 'session': unset($_SESSION[$variable]); break;
			case 'cookie' : setcookie($variable, "", time()-60*60*24*100, "/"); break;
		}
	}
	elseif (is_array($variable))
	{
		$ret = true;
		switch ($type)
		{
			case 'session':
				foreach($variable as $var)
				{
					unset($_SESSION[$var]);
				}
				break;
			case 'cookie':
				foreach($variable as $var)
				{
					setcookie($var, "", time()-60*60*24*100, "/");
				}
				break;
		}
		return $ret;
	}
}

//
function escape_smart($value)
{
	// code from http://simon.net.nz/articles/protecting-mysql-sql-injection-attacks-using-php/
	if (get_magic_quotes_gpc())
	{
		$value = stripslashes($value);
	}
	if (!is_numeric($value))
	{
		$value = mysql_real_escape_string($value);
	}
	return $value;
}
?>