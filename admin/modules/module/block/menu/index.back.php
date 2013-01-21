<?php
include_once ( $cfg['PATH']['admin_modules_path'] . "menu/classes/Menu.class.php" );

$Menu = new Menu();

$module_path = "/admin/modules/module/block/menu";

if (isset($_GET['edit']) && $_GET['edit'] != "" && is_numeric($_GET['edit'])) {

	$tpl -> assign ( "ContentTemplate",	"back-edit" );
	$tpl -> assign ( "CatName", 		$Menu -> GetCatName($_GET['edit']) );
	$tpl -> assign ( "SubCats", 		$Menu -> GetCatChildren($_GET['edit']) );
}
elseif (isset($_GET['cat']) && $_GET['cat'] != "" && is_numeric($_GET['cat'])) {
	
	$tpl -> assign ( "ContentTemplate", "back-items" );
	$tpl -> assign ( "CatName",			$Menu -> GetCatName($_GET['cat']) );
	$tpl -> assign ( "SubCats", 		$Menu -> GetCatChildren($_GET['cat']) );
	$tpl -> assign ( "ItemList",		$Menu -> GetItemsListByCat($_GET['cat'], "DESC") );
}
else {
	
	$tpl -> assign ( "ContentTemplate", "back-main" );
	$tpl -> assign ( "CatList", 		$Menu-> GetCats("ASC") );
}

if (isset($_FILES['menu'])) {
	$file = $_FILES['menu'];
	$message = $Menu -> LoadCSV ($file['tmp_name']);
}
else
	$message = "";

$tpl -> assign ( "Message",		$message );
$tpl -> assign ( "root", 		$cfg['PATH']['root'] );
$tpl -> assign ( "mod_info", 	$ModuleInfo );
$tpl -> assign ( "mod_path", 	$module_path );
$tpl -> assign ( "SESS_URL",	$sess->url () . "&" );
$tpl -> assign ( "Template",   	$tpl->fetch($cfg['PATH']['admin_modules'] . "module/block/menu/templates/back.tpl.php" ));
?>