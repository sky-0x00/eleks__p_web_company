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
	(isset($_POST['name'])) && (!empty($_POST['name'])) &&
	(isset($_POST['description']))) {	
	
	$response = $Catalog -> CreateItem ($_POST['id_cat'], utf8($_POST['name']), $_POST['active'], utf8($_POST['description']));
	
	if (($response['result']=="success") && $_POST['image']) {	
		
		if (!@file_exists($Catalog->path_server . $response['text'] . "/")) {
			if (@mkdir($Catalog->path_server . $response['text'] . "/", 0777))
				@chmod($Catalog->path_server . $response['text'] . "/", 0777);
		}
		
		$namearray = explode(".", $_POST['image']);
						
		$filename = $Catalog->path_server . $response['text'] . "/" . $response['text'] . "." . $namearray[count($namearray)-1];
		
		if (@file_exists($Catalog->path_tmp . $_POST['image']))
			@rename ($Catalog->path_tmp . $_POST['image'], $filename);
		
		$thumb = "";
		
		for ($i=0; $i<(count($namearray)-1); $i++)
			$thumb .= $namearray[$i];
			
		$thumb .= "_thumb." . $namearray[count($namearray)-1];
		
		$filename = $Catalog->path_server . $response['text'] . "/" . $response['text'] . "_thumb." . $namearray[count($namearray)-1];
		
		if (@file_exists($Catalog -> path_tmp . $thumb))
			@rename ($Catalog -> path_tmp . $thumb, $filename);	
	}
	
	print win(array2json($response));
}
else {
	$result = "error";
	$text	= "Неверный список параметров.";
	
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>