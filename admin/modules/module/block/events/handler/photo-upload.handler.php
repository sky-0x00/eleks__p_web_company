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
include_once ( $cfg['PATH']['admin_modules_path']."events/classes/Events.class.php" );

$Events = new Events();

if ( (isset($_POST['id_event'])) && (is_numeric($_POST['id_event'])) && (!empty($_POST['id_event'])) ) {	
	
	
	$filename = uploadImage($_FILES['newfile'], $Events -> path_server, true, "", 800, 600, true, 203, 152);
			
	if ($filename) {
		print $Events -> CreatePhoto($_POST['id_event'], $filename['image']);
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
