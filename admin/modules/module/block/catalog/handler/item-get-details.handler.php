<?php
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg['PATH']['core'] );
DirInclude ( $cfg['PATH']['admin_classes']);
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $cfg['PATH']['admin_modules_path']."catalog/classes/Catalog.class.php" );

$Catalog = new Catalog();

if (isset($_POST['id_item']) && !empty($_POST['id_item']) && is_numeric($_POST['id_item'])) {
	
	if ($text = $Catalog -> GetItem($_POST['id_item'])) {	
		$result = "success";
	}	
	else {
		$result = "error";
		$text	= "Элемент не найден.";
	}
}
else {
	$result = "error";
	$text	= "Неверные параметры.";	
}

print win(array2json(array("result" => $result, "text" => $text)));
?>