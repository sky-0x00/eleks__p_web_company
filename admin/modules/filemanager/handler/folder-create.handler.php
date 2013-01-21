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
/////////////////////////////////////////////////////////////////////////////////////

if ((!empty($_POST[foldername]))&&(!strpos($_POST[foldername], "."))&&(!strrpos($_POST[foldername], "/"))) {

	$pth = $cfg[PATH][root] . substr($_POST[path], 1) . "/" . utf8($_POST[foldername]);	
	if (mkdir($pth)) {
		chmod($pth, 0774);
		print 1;
	}
	else
		print 0;
}
else
	print 0;
?>