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

if ( (isset($_POST['id_item'])) && (is_numeric($_POST['id_item'])) && (!empty($_POST['id_item'])) ) {	
	
	$filename = uploadImage($_FILES['newfile'], $Catalog -> path_tmp, false, "tmp", 437, 293, true, 71, 47);
			
	if ($filename) {
		
		$response = $Catalog -> CreatePhoto($_POST['id_item']);
		
		if ($response['result'] == "success") {
			
			if (!@file_exists($Catalog->path_server . $_POST['id_item'] . "/")) {
				if (@mkdir($Catalog->path_server . $_POST['id_item'] . "/", 0777))
					@chmod($Catalog->path_server . $_POST['id_item'] . "/", 0777);
			}
			
			$namearray = explode(".", $filename['image']);
							
			$image = $Catalog->path_server . $_POST['id_item'] . "/photo_" . $response['text'] . "." . $namearray[count($namearray)-1];
			
			if (@file_exists($Catalog->path_tmp . $filename['image']))		
				@rename ($Catalog->path_tmp . $filename['image'], $image);
				
			$thumb = $Catalog -> path_server . $_POST['id_item'] . "/photo_" . $response['text'] . "_thumb." . $namearray[count($namearray)-1];
			
			if (@file_exists($Catalog -> path_tmp . $filename['thumb']))
				@rename ($Catalog -> path_tmp . $filename['thumb'], $thumb);
				
			$id_photo 	= $response['text'];
			$photo 		= $Catalog->path_src . $_POST['id_item'] . "/photo_" . $response['text'] . "." . $namearray[count($namearray)-1];
			
			$response['text'] = array();
			
			$response['text']['id_photo'] 	= $id_photo;
			$response['text']['photo'] 		= $photo;
		}
		
		print array2json($response);
	}
	else {
		$result = "error";
		$text	= "Ошибка. Невозможно загрузить изображение.";
		print array2json(array("result" => $result, "text" => $text));
	}	
}
else {
	$result = "error";
	$text	= "Ошибка. Неверный id элемента.";
	print array2json(array("result" => $result, "text" => $text));
}
?>
