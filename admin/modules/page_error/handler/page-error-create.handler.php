<?php
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg[PATH][core] );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );
//////////////////////////////////////////////////////////////////////////////////////

include_once($cfg[PATH][admin_classes]."PageError.class.php");

$TemplateFilename = $cfg[PATH][error][tpl].utf8($_POST[filename]).".tpl.php";

if (!is_file($TemplateFilename)) {

	$fp = fopen($TemplateFilename, "a+");
	fclose($fp);
	
	chmod($TemplateFilename, 0664);

	$PageError = new PageError();

	print $PageError -> CreatePage (utf8($_POST[name]), utf8($_POST[filename]));
}
?>