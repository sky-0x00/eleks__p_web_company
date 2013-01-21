<?php
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg['PATH']['core'] );
DirInclude ( $cfg['PATH']['admin_classes']);
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/lib/Smarty 2.6.18/Smarty.class.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );
//////////////////////////////////////////////////////////////////////////////////////

include_once ( $cfg['PATH']['admin_modules_path']."feedback/classes/FeedBack.class.php" );

$FeedBackClass = new FeedBack();
$tpl = new Smarty_Admin();

$feedback_param = $FeedBackClass -> getModuleParam ();

$feedback['name'] 		= utf8($_REQUEST['name']);
$feedback['phone']		= utf8($_REQUEST['phone']);
$feedback['email']		= utf8($_REQUEST['email']);
$feedback['message']	= utf8($_REQUEST['message']);

if (!is_email($feedback['email'])) {
	print 0; exit;
}

$feedback_headers  = "MIME-Version: 1.0" . "\r\n";
$feedback_headers .= "Content-type: text/html; charset=windows-1251" . "\r\n";
$feedback_headers .= "From: " . $feedback['name'] . " <" . $feedback['email'] . ">" . "\r\n";
$feedback_headers .= "Cc: " . $feedback['email'] . "\r\n";
$feedback_headers .= "Bcc: " . $feedback['email'] . "\r\n";

$tpl -> assign ( "feedback_params", 	$feedback );
$tpl -> assign ( "feedback_content",	$feedback_param[0]['feedback_mail_template'] );
$feedback_content = $tpl->fetch($cfg['PATH']['admin_modules'] . "module/block/feedback/templates/mail.tpl.php");

if (mail($feedback_param[0]['feedback_mails'], $feedback_param[0]['feedback_subject'], $feedback_content, $feedback_headers)) 
	print 1; 
else 
	print 0;

?>