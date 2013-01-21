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
include_once ( $cfg['PATH']['admin_modules_path'] . "sms/classes/RoBot.class.php" );
include_once ( $cfg['PATH']['admin_modules_path'] . "sms/classes/SMS.class.php" );

$SMS = new SMS();

if ((isset($_POST['contacts'])) && (!empty($_POST['contacts'])) &&
	(isset($_POST['name'])) && (!empty($_POST['name'])) &&
	(isset($_POST['type'])) && (!empty($_POST['type'])) &&
	(isset($_POST['table'])) && (!empty($_POST['table'])) &&
	(isset($_POST['date'])) && (!empty($_POST['date'])) &&
	(isset($_POST['time'])) && (!empty($_POST['time']))) {
	
	if ($SMS -> GetCaptcha()) {
		$result = "success";
		$text['captcha'] 	= $SMS->_captcha_img;
		$text['phpsessid']	= $SMS->cookies['PHPSESSID'];
	}
	else {
		$result = "captcha";
		$text	= $SMS->error;
	}	
}
else {
	$result = "error";
	$text	= "Wrong params.";
}

print win(array2json(array("result" => $result, "text" => $text)));
	
?>