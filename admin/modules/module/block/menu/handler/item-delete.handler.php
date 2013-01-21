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

if ((isset($_POST['id_item'])) && (!empty($_POST['id_item'])) && (is_numeric($_POST['id_item'])) &&
	(isset($_POST['pid'])) && (!empty($_POST['pid'])) && (is_numeric($_POST['pid']))) {
	
	print win( $Menu -> DeleteItem ($_POST['pid'], $_POST['id_item']) );
}
else {
	$result = "error";
	$text	= "Неверный список параметров.";
	
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>