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
	
$filename = uploadImage($_FILES['newfile'], $Menu -> path_tmp, true, "tmp", 369, 322, false, 0, 0);
		
if ( is_array($filename) && (count($filename)>0) ) {

	$result = "success";
	
	$text = array();
	$text['src'] = "/images/temp/" . $filename['image'];
	$text['name'] = $filename['image'];	
}
else {
	$result = "error";
	$text	= "Ошибка. Невозможно загрузить изображение.";
}	

print array2json(array("result" => $result, "text" => $text));
?>
