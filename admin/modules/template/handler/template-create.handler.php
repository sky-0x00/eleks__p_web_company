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

include_once($cfg[PATH][admin_classes]."Templates.class.php");

$TemplateFilename = $cfg[PATH][skins][tpl].$_REQUEST[filename].".tpl.php";

if (!is_file($TemplateFilename)) {

	$fp = fopen($TemplateFilename, "a+");
	fclose($fp);
	
	chmod($TemplateFilename, 0666);

	$Template = new Templates();

	print $Template -> CreateTemplate (utf8($_REQUEST[name]), $_REQUEST[filename], $_REQUEST[group], $_REQUEST[css], utf8($_REQUEST[description]));
}
else {
	print 0;
}

?>