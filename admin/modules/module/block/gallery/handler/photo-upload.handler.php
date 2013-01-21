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

if (!@file_exists($Gallery -> path_tmp)) {
	if (@mkdir($Gallery -> path_tmp, 0777))
		@chmod($Gallery -> path_tmp, 0777);
}

if ( (isset($_POST['id_album'])) && (is_numeric($_POST['id_album'])) && (!empty($_POST['id_album'])) ) {	
	
	$filename = uploadImage($_FILES['newfile'], $Gallery -> path_tmp, false, "tmp", 291, 409, true, 79, 106);
			
	if ($filename) {
		
		$response = $Gallery -> CreatePhoto($_POST['id_album']);
		
		if ($response['result'] == "success") {
			
			if (!@file_exists($Gallery->path_server . $_POST['id_album'] . "/")) {
				if (@mkdir($Gallery->path_server . $_POST['id_album'] . "/", 0777))
					@chmod($Gallery->path_server . $_POST['id_album'] . "/", 0777);
			}
			
			$namearray = explode(".", $filename['image']);
							
			$image = $Gallery->path_server . $_POST['id_album'] . "/" . $response['text'] . "." . $namearray[count($namearray)-1];
			
			if (@file_exists($Gallery->path_tmp . $filename['image']))		
				@rename ($Gallery->path_tmp . $filename['image'], $image);
				
			$thumb = $Gallery -> path_server . $_POST['id_album'] . "/" . $response['text'] . "_thumb." . $namearray[count($namearray)-1];
			
			if (@file_exists($Gallery -> path_tmp . $filename['thumb']))
				@rename ($Gallery -> path_tmp . $filename['thumb'], $thumb);
				
			$id_photo 	= $response['text'];
			$photo 		= $Gallery->path_src . $_POST['id_album'] . "/" . $response['text'] . "_thumb." . $namearray[count($namearray)-1];
			
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
