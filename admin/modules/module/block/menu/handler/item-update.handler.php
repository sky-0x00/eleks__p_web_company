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

if ((isset($_POST['pid'])) && (!empty($_POST['pid'])) && (is_numeric($_POST['pid'])) &&
	(isset($_POST['id_item'])) && (!empty($_POST['id_item'])) && (is_numeric($_POST['id_item'])) &&
	(isset($_POST['id_cat'])) && (!empty($_POST['id_cat'])) && (is_numeric($_POST['id_cat'])) &&
	(isset($_POST['name'])) && (!empty($_POST['name'])) && 
	(isset($_POST['annot'])) && (!empty($_POST['annot'])) && 
	(isset($_POST['portion'])) && (!empty($_POST['portion'])) && 
	(isset($_POST['price'])) && (!empty($_POST['price'])) && 
	( ((isset($_POST['recipe']) && ($_POST['recipe'])) && 
	(isset($_POST['description'])) && (!empty($_POST['description'])) && (isset($_POST['picture']))) || 
	((!isset($_POST['recipe']) || (!$_POST['recipe'])) ))) {
	
	if (!isset($_POST['description']))
		$_POST['description'] = "";
	if (!isset($_POST['picture']))
		$_POST['picture'] = "";
	
	if (@file_exists($Menu -> path_tmp . $_POST['picture'])) {		
		@rename ($Menu -> path_tmp . $_POST['picture'], $Menu -> path_server . $_POST['picture']);
	}
	
	print win( $Menu -> UpdateItem ($_POST['pid'], $_POST['id_item'], $_POST['id_cat'], utf8($_POST['name']), utf8($_POST['annot']), utf8($_POST['portion']), $_POST['price'], $_POST['recipe'], utf8($_POST['description']), utf8($_POST['picture'])) );
}
else {
	$result = "error";
	$text	= "Неверный список параметров.";
	
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>