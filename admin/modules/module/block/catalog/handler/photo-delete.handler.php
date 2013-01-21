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

if ( (isset($_POST['id_photo'])) && (!empty($_POST['id_photo'])) && (is_numeric($_POST['id_photo'])) ) {
	
	print win( $Catalog -> DeletePhoto($_POST['id_photo']) );
}
else {
	$result = "error";
	$text	= "Неверный id фотографии.";
	
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>