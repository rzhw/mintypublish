<?php
/////////////////
// main config //
/////////////////

$cfg['lang']='en';
$cfg['timezone']='Australia/Sydney';
$cfg['theme']='default';

///////////
// paths //
///////////

$path['root']='spongecms';
$path['admin2']=$path['root'].'/admin';
$path['theme_root']=$path['root'].'/themes/'.$cfg['theme'];
$path['images']=$path['root'].'/themes/'.$cfg['theme'].'/img';
$path['css']=$path['root'].'/themes/'.$cfg['theme'];
$path['js']=$path['root'].'/js';
$path['media']=$path['root'].'/media';
$path['help']=$path['root'].'/help';
$path['admin']='index.php?p=admin';
?>