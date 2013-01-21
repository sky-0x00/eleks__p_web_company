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
include_once ( $cfg['PATH']['admin_modules_path']."objects/classes/Objects.class.php" );

$Objects = new Objects();

if ((isset($_POST['id_object'])) && (!empty($_POST['id_object'])) && (is_numeric($_POST['id_object'])))	{

	print win(array2json($Objects -> GetObject($_POST['id_object'])));
}
else {
	$result = "error";
	$text	= "Неверный id.";
	
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>