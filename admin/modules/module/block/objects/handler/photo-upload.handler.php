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

if ( (isset($_POST['id_object'])) && (is_numeric($_POST['id_object'])) && (!empty($_POST['id_object'])) ) {	
	
	$filename = uploadImage($_FILES['newfile'], $Objects -> path_tmp, false, "tmp", 510, 343, true, 98, 66);
			
	if ($filename) {
		
		$response = $Objects -> CreatePhoto($_POST['id_object']);
		
		if ($response['result'] == "success") {
			
			if (!@file_exists($Objects->path_server . $_POST['id_object'] . "/")) {
				if (@mkdir($Objects->path_server . $_POST['id_object'] . "/", 0777))
					@chmod($Objects->path_server . $_POST['id_object'] . "/", 0777);
			}
			
			$namearray = explode(".", $filename['image']);
							
			$image = $Objects->path_server . $_POST['id_object'] . "/photo_" . $response['text'] . "." . $namearray[count($namearray)-1];
			
			if (@file_exists($Objects->path_tmp . $filename['image']))		
				@rename ($Objects->path_tmp . $filename['image'], $image);
				
			$thumb = $Objects -> path_server . $_POST['id_object'] . "/photo_" . $response['text'] . "_thumb." . $namearray[count($namearray)-1];
			
			if (@file_exists($Objects -> path_tmp . $filename['thumb']))
				@rename ($Objects -> path_tmp . $filename['thumb'], $thumb);
				
			$id_photo 	= $response['text'];
			$photo 		= $Objects->path_src . $_POST['id_object'] . "/photo_" . $response['text'] . "." . $namearray[count($namearray)-1];
			
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
	$text	= "Ошибка. Неверный id объекта.";
	print array2json(array("result" => $result, "text" => $text));
}
?>
