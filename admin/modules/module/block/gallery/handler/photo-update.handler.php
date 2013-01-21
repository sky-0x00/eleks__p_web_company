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
include_once ( $cfg['PATH']['admin_modules_path']."gallery/classes/Gallery.class.php" );

$Gallery = new Gallery();

if (isset($_POST['id_photo']) && !empty($_POST['id_photo']) && is_numeric($_POST['id_photo']) && isset($_POST['descr'] )) {

	print win($Gallery -> UpdatePhoto($_POST['id_photo'], utf8($_POST['name']), utf8($_POST['descr'])));
}
else {
	$result = "error";
	$text	= "Неверный список параметров.";
	
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>