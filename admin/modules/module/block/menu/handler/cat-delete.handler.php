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

if ( (isset($_POST['id_cat'])) && (!empty($_POST['id_cat'])) && (is_numeric($_POST['id_cat'])) ) {

	print win( $Menu -> DeleteCat ($_POST['id_cat']) );
}
else {
	$result = "error";
	$text	= "Wrong cat id.";
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>