<?php
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg[PATH][core] );
DirInclude ( $cfg[PATH][admin_classes]);
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );
//////////////////////////////////////////////////////////////////////////////////////

if (isset($_FILES[newfile])) {
	$tmp_name = $_FILES[newfile][tmp_name];
    $name = $_FILES[newfile][name];
	$slash = (strlen($_REQUEST[path])>1) ? "/" : ""; 
    if (move_uploaded_file ($tmp_name, $cfg[PATH][root] . substr($_REQUEST[path], 1) . $slash . $name))
		print "success";
	else
		print "error";
}
?>
