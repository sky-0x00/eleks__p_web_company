<?php
include_once ( $cfg['PATH']['admin_modules_path']."events/classes/Events.class.php" );

$Events = new Events();

$module_path = "/admin/modules/module/block/events";

$tpl -> assign ( "YearList",	$Events -> GetYearList("DESC") );

$tpl -> assign ( "root", 		$cfg['PATH']['root'] );
$tpl -> assign ( "mod_info", 	$ModuleInfo );
$tpl -> assign ( "mod_path", 	$module_path );
$tpl -> assign ( "SESS_URL",	$sess->url () . "&" );
$tpl -> assign ( "Template",   	$tpl->fetch($cfg['PATH']['admin_modules']."module/block/events/templates/back.tpl.php" ));
?>