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

$location['root']='spongecms';
$location['admin2']=$location['root'].'/admin';
$location['theme']=$location['root'].'/themes/'.$cfg['theme'];
$location['theme_nr']='themes/'.$cfg['theme'];
$location['images']=$location['root'].'/themes/'.$cfg['theme'].'/img';
$location['styles']=$location['root'].'/themes/'.$cfg['theme'].'/css';
$location['js']=$location['root'].'/js';
$location['media']=$location['root'].'/media';
$location['help']=$location['root'].'/help';
$location['admin']='index.php?p=admin';
?>