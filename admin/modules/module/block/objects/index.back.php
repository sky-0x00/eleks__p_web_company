<?php
include_once ( $cfg['PATH']['admin_modules_path']."objects/classes/Objects.class.php" );

$Objects = new Objects();

$module_path = "/admin/modules/module/block/objects";

$tpl -> assign ( "Objects",		$Objects -> GetObjectsList() );
$tpl -> assign ( "Types",		$Objects -> GetTypes() );
$tpl -> assign ( "root", 		$cfg['PATH']['root'] );
$tpl -> assign ( "mod_info", 	$ModuleInfo );
$tpl -> assign ( "mod_path", 	$module_path );
$tpl -> assign ( "SESS_URL",	$sess->url () . "&" );
$tpl -> assign ( "Template",   	$tpl->fetch($cfg['PATH']['admin_modules']."module/block/objects/templates/back.tpl.php" ));
?>