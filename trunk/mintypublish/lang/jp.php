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

// translated by a2h with google translate to test the language support
// I DO NOT UNDERSTAND JAPANESE except for some basic things like yes/no etc
// if you want to fix some strings please, do so.

// page_nojson partly rewritten by majicrater

// global text
$txt['text_warning']              = '警告';
$txt['text_success']              = '成功!';
$txt['text_failure']              = '故障!';
$txt['text_yes']                  = 'はい';
$txt['text_no']                   = 'いいえ';
$txt['text_notimplemented']       = '実装されていません！';
$txt['text_pleasewait']           = 'ちょっと待って...';
$txt['text_whatsthis']            = '何これ？';
$txt['text_save']                 = '保存する';

// general errors
$txt['page_noexist']              = 'あなたが存在しない場合は、リクエストされたページをご覧ください。';
$txt['page_nojson']               = 'すみません,でもJSONのサッポトZVFPCMSを実行する必要があります。これはPHP 5.20以降に付属する必要があります。';

// user stuff
$txt['user_rememberme']           = 'Remember me when I come back';
$txt['user_register']             = 'Register';
$txt['user_login']                = 'Login'; // this is used as both a noun/verb
$txt['user_logout']               = 'Logout';
$txt['user_username']             = 'Username';
$txt['user_password']             = 'Password';

// admin panel menu
$txt['admin_panel_manpages']      = '管理ページ';
$txt['admin_panel_manmedia']      = 'メディア管理';
$txt['admin_panel_config']        = '設定';

// general admin panel
$txt['admin_panel_title']         = '管理者のパネル';
$txt['admin_panel_noperms']       = 'このページにアクセスするために適切な権限がありません。';
$txt['admin_panel_welcome']       = '管理者パネルへようこそ。';
$txt['admin_panel_noedittitle']   = 'て、任意の既存のページのタイトルを変更しないでください。あなたはそれを手動で変更を取得する必要があります。';
$txt['admin_panel_changepage']    = 'は、別のページに移動、変更を表示するには。';
$txt['admin_panel_actn_noexist']  = 'その操作が存在しないか、実装されていません。';
$txt['admin_panel_what']          = '何？';
$txt['admin_panel_confirm']       = 'あなたがこれを実行してもよろしいですか？';
$txt['admin_panel_deleting']      = 'ファイルを削除する...';

// page management in admin panel
$txt['admin_panel_addpage']       = 'ページを追加';
$txt['admin_panel_addpage_prog']  = 'ページを追加...';
$txt['admin_panel_addpage_savpr'] = '保存ページ...';
$txt['admin_panel_addpage_desc']  = 'このページでは、メニューの最後に追加されます。 セクションには、 "管理ページ"を使用して移動します';
$txt['admin_panel_addpage_blnk']  = '（注：お使いのページこの情報が正しいことができない空白のコンテンツが）';
$txt['admin_panel_manpages_list'] = 'ページ';
$txt['admin_panel_manpages_desc'] = 'このページの一覧です。';
$txt['admin_panel_manpages_ordr'] = '使用[^]/[v]の順にメニューを移動します。';
$txt['admin_panel_manpages_edit'] = 'をクリックして[e]は、ページを編集してください。';
$txt['admin_panel_manpages_delt'] = 'をクリックして[d]のページを削除してください。';
$txt['admin_panel_manbugs']       = 'バグ管理';
$txt['admin_panel_modmenu_prog']  = 'メニューの変更...';
$txt['admin_panel_edt_src']       = '場合は、ソースをクリックして" HTML "のボタンを編集したい。';
$txt['admin_panel_edt_srtnm']     = '短い名前';
$txt['admin_panel_edt_srtnm_dsc'] = 'ただし、空白、首都。例えば \\\'testpg1\\\' を使用する代わりに \\\'test page 1\\\' 。英語の手紙/数字だけ。';
$txt['admin_panel_edt_fllnm']     = '完全な名前';
$txt['admin_panel_edt_fllnm_dsc'] = '完全名の両方のタイトルやメニュー名として表示される';
$txt['admin_panel_edt_child']     = '子ページの';
$txt['admin_panel_edt_child_dsc'] = 'あなたの子供のように、このページを設定したいページの短いタイトルを入力します。場合は、ページの子として、 -1 、このままこのセットを希望していません。';

// media management in admin panel
$txt['admin_panel_manmed_recog']  = 'ファイル形式を認識している：';
$txt['admin_panel_manmed_convt']  = 'ファイル形式との間でメディア変換するには[プレースホルダ]';

// configuration frontend in admin panel
$txt['admin_panel_lang']          = '言語';
$txt['admin_panel_timezone']      = 'タイムゾーン';
$txt['admin_panel_cfg_sucess']    = '正常に設定を保存しました！';
$txt['admin_panel_cfg_failure']   = '設定を保存できませんでした！';
?>