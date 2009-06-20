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

// strings written from a2h and aren't translated (duh)
// this is australian english

// global text
$txt['text_warning']              = 'Warning';
$txt['text_success']              = 'Success!';
$txt['text_failure']              = 'Failure!';
$txt['text_yes']                  = 'Yes';
$txt['text_no']                   = 'No';
$txt['text_notimplemented']       = 'Not implemented!';
$txt['text_pleasewait']           = 'Hang on a moment...';
$txt['text_whatsthis']            = 'What\'s this?';
$txt['text_save']                 = 'Save';
$txt['text_again']                = 'again';

// footer
$txt['zvfpcms_powered']           = 'powered by sponge cms';
$txt['zvfpcms_a2h']               = 'sponge cms is another project from a2h';
$txt['zvfpcms_generated']         = 'page generated in [t] seconds';

// general errors
$txt['page_noexist']              = 'The page you requested doesn\'t exist.';
$txt['page_nojson']               = 'To use JSON as your data storage method, you need PHP 5.20 and above.';
$txt['page_nomysql']              = 'To use MySQL as your data storage method, you need it installed.';
$txt['page_oldphp']               = 'You need at least PHP 5.1.0 to run Sponge CMS.';

// user stuff
$txt['user_rememberme']           = 'Remember me when I come back';
$txt['user_register']             = 'Register';
$txt['user_login']                = 'Login'; // this is used as both a noun/verb
$txt['user_logout']               = 'Logout';
$txt['user_username']             = 'Username';
$txt['user_password']             = 'Password';
$txt['user_email']                = 'Email';

// admin panel menu
$txt['admin_panel_manpages']      = 'Manage Pages';
$txt['admin_panel_manmedia']      = 'Manage Media';
$txt['admin_panel_config']        = 'Configuration';

// general admin panel
$txt['admin_panel_title']         = 'Administration Panel';
$txt['admin_panel_noperms']       = 'You do not have proper permissions to access this page.';
$txt['admin_panel_welcome']       = 'Welcome to the administration panel.';
$txt['admin_panel_noedittitle']   = 'Do not change the any of the titles of an existing page. You must get it changed manually.';
$txt['admin_panel_changepage']    = 'Go to another page to view the changes.';
$txt['admin_panel_actn_noexist']  = 'That action doesn\'t exist or isn\'t implemented.';
$txt['admin_panel_what']          = 'What?';
$txt['admin_panel_confirm']       = 'Are you sure you want to do this?';
$txt['admin_panel_deleting']      = 'Deleting file...';

// page management in admin panel
$txt['admin_panel_addpage']       = 'Add a page';
$txt['admin_panel_addpage_prog']  = 'Adding page...';
$txt['admin_panel_addpage_savpr'] = 'Saving page...';
$txt['admin_panel_addpage_desc']  = 'The page will be added to the end of the menu. Use the "Manage pages" section to move it.';
$txt['admin_panel_addpage_blnk']  = '(n.b. if your page has blank content this may not be true)';
$txt['admin_panel_manpages_list'] = 'Pages';
$txt['admin_panel_manpages_desc'] = 'This is the list of pages.';
$txt['admin_panel_manpages_ordr'] = 'Use [^]/[v] to move their order in the menu.';
$txt['admin_panel_manpages_edit'] = 'Click on [e] to edit a page.';
$txt['admin_panel_manpages_delt'] = 'Click on [d] to delete a page.';
$txt['admin_panel_manbugs']       = 'Manage bugs';
$txt['admin_panel_modmenu_prog']  = 'Modifying menu...';
$txt['admin_panel_edt_src']       = 'If you want to edit the source click the "HTML" button.';
$txt['admin_panel_edt_srtnm']     = 'Short name';
$txt['admin_panel_edt_srtnm_dsc'] = 'No spaces, no capitals. e.g. use \'testpg1\' instead of \'test page 1\'. ENGLISH LETTERS / NUMBERS ONLY.';
$txt['admin_panel_edt_fllnm']     = 'Full name';
$txt['admin_panel_edt_fllnm_dsc'] = 'Full name to appear as both title and menu name';
$txt['admin_panel_edt_child']     = 'Child page of';
$txt['admin_panel_edt_child_dsc'] = 'Type in the short title of the page you wish to set this page as the child of. If you do not wish to set this as a child of a page, leave this as -1.';

// media management in admin panel
$txt['admin_panel_manmed_recog']  = 'Recognised filetypes are:';
$txt['admin_panel_manmed_convt']  = 'To convert media between filetypes [TODO]';

// configuration frontend in admin panel
$txt['admin_panel_lang']          = 'Language';
$txt['admin_panel_timezone']      = 'Timezone';
$txt['admin_panel_cfg_sucess']    = 'Successfully saved configuration!';
$txt['admin_panel_cfg_failure']   = 'Could not save configuration!';
?>