<?php
include_once ( $cfg['PATH']['admin_modules_path']."news/classes/Article.class.php" );

$Article = new Article();

$module_path = "/admin/modules/module/block/news";

$tpl -> assign ( "YearList",	$Article -> GetYearList("DESC") );

$tpl -> assign ( "root", 		$cfg['PATH']['root'] );
$tpl -> assign ( "mod_info", 	$ModuleInfo );
$tpl -> assign ( "mod_path", 	$module_path );
$tpl -> assign ( "SESS_URL",	$sess->url () . "&" );
$tpl -> assign ( "Template",   	$tpl->fetch($cfg['PATH']['admin_modules']."module/block/news/templates/back.tpl.php" ));
?>