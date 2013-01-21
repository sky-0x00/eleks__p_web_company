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
	
if (!@file_exists($Catalog -> path_tmp)) {
	if (@mkdir($Catalog -> path_tmp, 0777))
		@chmod($Catalog -> path_tmp, 0777);
}
	
$filename = uploadImage($_FILES['newfile'], $Catalog -> path_tmp, false, "tmp", 437, 293, true, 71, 47);
		
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
