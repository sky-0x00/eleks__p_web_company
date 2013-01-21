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
if ((!empty($_POST[oldname]))&&(!strpos($_POST[oldname], ".."))&&(!strpos($_POST[oldname], "/"))&&(!empty($_POST[newname]))&&(!strpos($_POST[newname],".."))&&(!strpos($_POST[newname],"/"))) {

	switch ($_REQUEST[type]) {

		case "file":
			print rename($cfg[PATH][root] . substr(utf8($_REQUEST[path]), 1) . "/" . utf8($_REQUEST[oldname]), $cfg[PATH][root] . substr(utf8($_REQUEST[path]), 1) . "/" . utf8($_REQUEST[newname]));
			break;
			
		case "folder":
			print rename($cfg[PATH][root] . substr(utf8($_REQUEST[path]), 1) . "/" . utf8($_REQUEST[oldname]), $cfg[PATH][root] . substr(utf8($_REQUEST[path]), 1) . "/" . utf8($_REQUEST[newname]));
			break;
	}
}
else
	print 0;
?>