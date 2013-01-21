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

if ((isset($_POST['id_cat'])) && (!empty($_POST['id_cat'])) && (is_numeric($_POST['id_cat'])) && 
	(isset($_POST['type'])) && (!empty($_POST['type'])) &&
	(isset($_POST['name'])) && (!empty($_POST['name'])) && 
	(isset($_POST['title'])) && (!empty($_POST['title']))) {

	print win( $Catalog -> AddNewField ($_POST['id_cat'], utf8($_POST['name']), utf8($_POST['title']), $_POST['type'], utf8($_POST['options']), $_POST['empty']) );
}
else {
	$result = "error";
	$text	= "Wrong params.";
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>