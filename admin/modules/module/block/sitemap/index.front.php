<?php
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
////////////////////////////////////////////////////////////////////////////////
include_once ( $cfg['PATH']['admin_modules_path']."sitemap/classes/Sitemap.class.php" );

$Sitemap = new Sitemap();

$array = array();

$Sitemap -> GetTree($array, 1, 0);

//print_r($array);

$tpl -> assign ( "MainMenu",			$array );
//$tpl -> assign ( "cms_module_sitemap", 	$tpl->fetch($cfg['PATH']['admin_modules_path']."sitemap/templates/front.tpl.php"));
////////////////////////////////////////////////////////////////////////////////
?>