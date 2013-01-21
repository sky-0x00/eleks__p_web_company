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


if ((isset($_POST['id_object'])) && (!empty($_POST['id_object'])) && (is_numeric($_POST['id_object'])) &&
	(isset($_POST['id_type'])) && (!empty($_POST['id_type'])) && (is_numeric($_POST['id_type'])) && 
	(isset($_POST['name'])) && (!empty($_POST['name'])) &&  (isset($_POST['primary'])) &&
	(isset($_POST['short_description'])) && (!empty($_POST['short_description'])) && 
	(isset($_POST['description'])) && (!empty($_POST['description']))) {
	
	$response = $Objects -> UpdateObject ($_POST['id_object'], $_POST['id_type'], utf8($_POST['name']), utf8($_POST['town']), utf8($_POST['short_description']), utf8($_POST['description']), $_POST['primary']);
	
	if (($response['result']=="success") && (isset($_POST['picture'])) && (!empty($_POST['picture']))) {
		
		if (!@file_exists($Objects->path_server . $_POST['id_object'] . "/")) {
			if (@mkdir($Objects->path_server . $_POST['id_object'] . "/", 0777))
				@chmod($Objects->path_server . $_POST['id_object'] . "/", 0777);
		}
		
		$namearray = explode(".", $_POST['picture']);
						
		$filename = $Objects->path_server . $_POST['id_object'] . "/" . $_POST['id_object'] . "." . $namearray[count($namearray)-1];
		
		if (@file_exists($Objects->path_tmp . $_POST['picture']))		
			@rename ($Objects->path_tmp . $_POST['picture'], $filename);		
	}	
	
	print win(array2json($response));
}
else {
	$result = "error";
	$text	= "Неверный список параметров.";
	
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>