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
include_once ( $cfg['PATH']['admin_modules_path'] . "guestbook/classes/GuestBook.class.php" );

$GuestBook = new GuestBook();

if ((isset($_POST['id_message'])) && (is_numeric($_POST['id_message'])) && (!empty($_POST['id_message'])) &&
	(isset($_POST['id_cat'])) && (is_numeric($_POST['id_cat'])) && (!empty($_POST['id_cat']))) {
	
	print win( $GuestBook -> UpdateMessage ($_POST['id_message'], $_POST['id_cat']) );
}
else {
	$result = "error";
	$text	= "Wrong params.";
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>