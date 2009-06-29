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
	if (!isset($_POST['subreg']))
	{
		echo '<h3>'.$txt['user_register'].'</h3>';
		
		echo '
		<form action="" method="post" id="regform" name="regform">
		<table cellpadding="4" cellspacing="0" border="0">
			<tr>
				<td>
					'.$txt['user_username'].':
				</td>
				<td>
					<input type="text" name="uname" maxlength="30" />
				</td>
			</tr>
			<tr>
				<td>
					'.$txt['user_password'].':
				</td>
				<td>
					<input type="password" id="pwd" name="pwd" maxlength="30" />
				</td>
			</tr>
			<tr>
				<td>
					'.$txt['user_password'].' ('.$txt['text_again'].'):
				</td>
				<td>
					<input type="password" id="pwd2" name="pwd2" maxlength="30" />
				</td>
			</tr>
			<tr>
				<td>
					'.$txt['user_email'].':
				</td>
				<td>
					<input type="text" id="email" name="email" maxlength="100" />
				</td>
			</tr>
			<tr>
				<td>
					'.$txt['user_email'].' ('.$txt['text_again'].'):
				</td>
				<td>
					<input type="text" id="email2" name="email2" maxlength="100" />
				</td>
			</tr>
			<tr>
				<td>
					Are you a human?
				</td>
				<td>
					<input type="text" name="australian_prime_minister_john_howard_eats_babies" maxlength="30" />
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
					<input type="submit" name="subreg" value="Login" />
				</td>
			</tr>
		</table>
		</form>';

		echo '
		<script type="text/javascript">			
			Event.observe("email", "change", emailmatch);
			Event.observe("email2", "change", emailmatch);
			Event.observe("pwd", "change", pwdmatch);
			Event.observe("pwd2", "change", pwdmatch);
			
			function emailmatch(event)
			{
				if ($F("email") != $F("email2")) { $("email2").writeAttribute({"class":"form_input_error"}); }
				else { $("email2").writeAttribute({"class":""}); }
			}
			function pwdmatch(event)
			{
				if ($F("pwd") != $F("pwd2")) { $("pwd2").writeAttribute({"class":"form_input_error"}); }
				else { $("pwd2").writeAttribute({"class":""}); }
			}
		</script>';
	}
	else
	{
		echo 'Not implemented';
	}
}
?>