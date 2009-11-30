<?php
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