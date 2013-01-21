<?php
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg[PATH][core] );
DirInclude ( $cfg[PATH][admin_classes]);
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/lib/Smarty 2.6.18/Smarty.class.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );
//////////////////////////////////////////////////////////////////////////////////////
$tpl = new Smarty_Admin();

include_once ( $cfg[PATH][admin_modules_path]."feedback/classes/FeedBack.class.php" );

$FeedBackClass = new FeedBack();

if ($_REQUEST[allow] == 'on') $_REQUEST[allow] = 'Y'; else $_REQUEST[allow] = 'N';

if ($_REQUEST[captcha] == 'on') $_REQUEST[captcha] = 'Y'; else $_REQUEST[captcha] = 'N';

$FeedBackClass -> db -> query ( sprintf( "UPDATE %s SET feedback_allow_mail = '%s', feedback_mails = '%s', feedback_subject = '%s', feedback_captcha = '%s', feedback_mail_template = '%s', feedback_front_template = '%s', feedback_access = '%s', feedback_error = '%s'",

$FeedBackClass->table, $_REQUEST[allow], $_REQUEST[mails], addslashes(utf8($_REQUEST[subject])), $_REQUEST[captcha], addslashes(utf8($_REQUEST[mail])), addslashes(utf8($_REQUEST[template])), utf8($_REQUEST[access]), utf8($_REQUEST[error]) ));

?>