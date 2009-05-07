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
 * Summary:      Modifies a variable in the configuration file
 * Parameters:   $var as string - the name of the variable (WITH THE PREFIX)
 *               $newval as string - the new value for the variable
 * Return:       Nothing
 */
function config_modify($var,$newval)
{
	// original code found at http://stackoverflow.com/questions/476892/whats-is-the-best-file-format-for-configuration-files
	
	$filec = fopen($path['root'].'/config.php','w+');
	
	while (!feof($filec))
	{
		$confstr .= fgets($filec);
	}
	
	$confln = explode('\n',$confstr);
	
	for ($i=0;$i<count($confln);$i++)
	{
		if (strstr($confln[$i],$var))
		{
			$confln[$i] = $var.'=\''.addslashes($newval).'\';';
		}
	}
	
	$confstr = implode("\n",$confln);
	
	fwrite($filec,$confstr);
	
	fclose($filec);
}
?>