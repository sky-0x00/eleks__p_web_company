<?php
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/modules/auth/handler/auth-check.handler.php" );
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg['PATH']['core'] );
DirInclude ( $cfg['PATH']['admin_classes']);
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $cfg['PATH']['admin_modules_path'] . "menu/classes/Menu.class.php" );

$Menu = new Menu();

if ( (isset($_POST['id_item'])) && (is_numeric($_POST['id_item'])) && (!empty($_POST['id_item'])) ) {	
	
	
	$filename = uploadImage($_FILES['newfile'], $Menu -> path_server, true, "", 510, 790, true, 170, 230);
			
	if ($filename) {
		print $Menu -> CreatePhoto($_POST['id_item'], $filename['image']);
	}
	else {
		$result = "error";
		$text	= "Ошибка. Невозможно загрузить изображение.";
		print array2json(array("result" => $result, "text" => $text));
	}	
}
else {
	$result = "error";
	$text	= "Ошибка. Неверный id объекта.";
	print array2json(array("result" => $result, "text" => $text));
}
?>
