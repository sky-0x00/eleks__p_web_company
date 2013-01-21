<?php
$cfg['PATH']['root']				= $_SERVER['DOCUMENT_ROOT'] ."/";
$cfg['PATH']['www_root'] 			= "http://" . $_SERVER['HTTP_HOST'] ."/";
$cfg['PATH']['www_admin'] 			= $cfg['PATH']['www_root'] ."admin/";

$cfg['PATH']['core']    			= $cfg['PATH']['root'] ."admin/core/";
$cfg['PATH']['classes'] 			= $cfg['PATH']['root'] ."includes/classes/";
$cfg['PATH']['admin_modules']		= $cfg['PATH']['root'] ."admin/modules/";
$cfg['PATH']['admin_modules_path']	= $cfg['PATH']['root'] ."admin/modules/module/block/";

$cfg['PATH']['modules'] 			= $cfg['PATH']['root'] ."includes/modules/";
$cfg['PATH']['modules_default'] 	= $cfg['PATH']['root'] ."includes/modules/default/";
$cfg['PATH']['admin_classes'] 		= $cfg['PATH']['root'] ."admin/classes/";

$cfg['PATH']['cache']     			= $cfg['PATH']['root']     ."cache/";
$cfg['PATH']['www_cache'] 			= $cfg['PATH']['www_root'] ."cache/";
$cfg['PATH']['files']     			= $cfg['PATH']['root']     ."files/";
$cfg['PATH']['www_files'] 			= $cfg['PATH']['www_root'] ."files/";
$cfg['PATH']['skins']['root']     	= $cfg['PATH']['root'];
$cfg['PATH']['skins']['www_root'] 	= $cfg['PATH']['www_root'] ."admin/";
$cfg['PATH']['skins']['folder']     = $cfg['PATH']['skins']['root'];
$cfg['PATH']['skins']['www_folder'] = $cfg['PATH']['skins']['www_root'];

$cfg['PATH']['skins']['tpl']        = $cfg['PATH']['skins']['folder'] ."templates/";
$cfg['PATH']['error']['tpl']        = $cfg['PATH']['skins']['folder'] ."templates/errors/";


$cfg['PATH']['css']    = $cfg['PATH']['skins']['css']    = $cfg['PATH']['skins']['www_root'] ."css/";
$cfg['PATH']['js']     = $cfg['PATH']['skins']['js']     = $cfg['PATH']['skins']['www_root'] ."js/";
$cfg['PATH']['images'] = $cfg['PATH']['skins']['images'] = $cfg['PATH']['skins']['www_root'] ."images/";
$cfg['PATH']['flash']  = $cfg['PATH']['skins']['flash']  = $cfg['PATH']['skins']['www_root'] ."flash/";

$cfg['PATH']['GARBAGE'] = $cfg['PATH']['root'] ."garbage/";
?>