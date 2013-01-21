<?php
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg[PATH][core] );
DirInclude ( $cfg[PATH][admin_classes]);
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $cfg[PATH][admin_modules_path]."blocks/classes/Blocks.class.php" );

if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
	die("You have not permissions to access this page");

$Blocks = new Blocks();
	
if (is_numeric($_REQUEST['id']) && !empty($_REQUEST['id'])) {
	
	$filename = $Blocks -> path_server . basename($_FILES['newfile']['name']);
	
	if (!move_uploaded_file( $_FILES['newfile']['tmp_name'], $filename ))
		
		die ("Can't move uploaded file.");
}
else
	die ("Wrong params");
	
if ($filename) {
	
	$id_photo = $Blocks -> AddNewPhoto($_REQUEST['id'], basename($filename));
	
	if ($id_photo)
		print win($Blocks -> GetPhotoJSON($id_photo) );
	else 
		print win(0);
}
else 
	print win("Upload error");
?>
