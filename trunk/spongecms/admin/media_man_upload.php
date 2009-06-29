<?php
/*
	Sponge CMS
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
	
	http://a2h.github.com/Sponge-CMS/
*/
if ($zvfpcms)
{
	$target_path = $path['media'].'/'.basename($_FILES['uploadedfile']['name']); 
	
	$success = false;
	
	if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path))
	{
		$filename = mysql_real_escape_string(basename($_FILES['uploadedfile']['name']));
		
		if (mysql_query("INSERT INTO media (media_filename) VALUES('$filename')"))
		{
			$success = true;
		}
	}
	
	if ($success)
	{
		settopmessage(2,'Successfully uploaded the file!');
	}
	else
	{
		settopmessage(0,'Could not upload the file!');
	}
}
?>