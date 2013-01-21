<?php
session_start();
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

if (isset($_POST['items']) && !empty($_POST['items'])) {
	
	$result = "success";
	
	$items = explode(",", $_POST['items']);
	
	if ($items) {
	
		for ($i=0; $i<count($items); $i++) {			
		
			unset($_SESSION['CART'][$items[$i]]);
		}
	}
	
	$text = $Catalog -> GetCartWeight($_SESSION['CART']);
}
else {
	$result = "error";
	$text	= "Неверные параметры.";
}

print win(array2json(array("result" => $result, "text" => $text)));

?>