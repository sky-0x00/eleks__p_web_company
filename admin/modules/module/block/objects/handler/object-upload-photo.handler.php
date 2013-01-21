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

if (!@file_exists($Objects -> path_tmp)) {
	if (@mkdir($Objects -> path_tmp, 0777))
		@chmod($Objects -> path_tmp, 0777);
}
	
$namearray = explode(".", basename($_FILES['newfile']['name']));

$filename = "tmp." . $namearray[count($namearray)-1];

if (move_uploaded_file($_FILES['newfile']['tmp_name'], $Objects->path_tmp . $filename)) {

	$result = "success";
	
	$text = array();
	$text['src'] = "/images/temp/" . $filename;
	$text['name'] = $filename;	
}
else {
	$result = "error";
	$text	= "Ошибка. Невозможно загрузить изображение.";
}	

print array2json(array("result" => $result, "text" => $text));
?>
