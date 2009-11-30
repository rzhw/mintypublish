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

// strings written from a2h and aren't translated (duh)
// this is australian english

// global text
$txt['text_error']                = 'Error';
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
$txt['admin_panel_edt_srtnm']     = 'Menu name';
$txt['admin_panel_edt_srtnm_dsc'] = 'The name appearing in the menu';
$txt['admin_panel_edt_fllnm']     = 'Full name';
$txt['admin_panel_edt_fllnm_dsc'] = 'The name appearing in its full version';
$txt['admin_panel_edt_child']     = 'Child page of';
$txt['admin_panel_edt_child_dsc'] = 'You can set this, but it does nothing special. Right now, at least.';
$txt['admin_panel_edt_hideinmenu']= 'Hide in menu?';

// media management in admin panel
$txt['admin_panel_manmed_recog']  = 'Recognised filetypes are:';
$txt['admin_panel_manmed_convt']  = 'To convert media between filetypes [TODO]';
$txt['admin_panel_manmed_view']   = 'Viewing media file';

// configuration frontend in admin panel
$txt['admin_panel_lang']          = 'Language';
$txt['admin_panel_timezone']      = 'Timezone';
$txt['admin_panel_cfg_sucess']    = 'Successfully saved configuration!';
$txt['admin_panel_cfg_failure']   = 'Could not save configuration!';
?>