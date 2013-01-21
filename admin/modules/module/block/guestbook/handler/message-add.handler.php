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
include_once ( $cfg['PATH']['admin_modules_path'] . "guestbook/classes/GuestBook.class.php" );

$GuestBook = new GuestBook();

if ((isset($_POST['id_cat'])) && (is_numeric($_POST['id_cat'])) && (!empty($_POST['id_cat'])) &&
	(isset($_POST['name'])) && (!empty($_POST['name'])) &&
	(isset($_POST['email'])) && (!empty($_POST['email'])) &&
	(isset($_POST['text'])) && (!empty($_POST['text']))) {
	
	if (is_email($_POST['email'])) {
		print win( $GuestBook -> AddMessage ($_POST['id_cat'], strip_tags(utf8($_POST['name'])), utf8($_POST['email']), strip_tags(utf8($_POST['text']))) );
	}
	else {
		$result = "error";
		$text	= "Wrong email.";
		print win(array2json(array("result" => $result, "text" => $text)));
	}
}
else {
	$result = "error";
	$text	= "Wrong params.";
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>