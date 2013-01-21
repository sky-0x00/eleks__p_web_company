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

if ( (!empty($_POST[filename])) && (!strpos($_POST[filename], "..")) && (!strrpos($_POST[filename], "/")) ) {

	if (empty($_POST[path]))
		$pth = $cfg[PATH][root] . utf8($_POST[filename]);
		
	else
		$pth = $cfg[PATH][root] . substr($_POST[path], 1) . "/" . utf8($_POST[filename]);
	
	if (is_file($pth))
		print 0;
		
	else {
		$fp = fopen($pth, "a+");	
		fclose($fp);	
		chmod($pth, 0664);
		print 1;
	}
}
else
	print 0;
?>