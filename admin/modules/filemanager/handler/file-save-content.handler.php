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

if ( (!empty($_POST[filename]))&&(!empty($_POST[filecontent])) ) {
	
	$filename = $cfg[PATH][root] . substr(utf8($_POST[filename]), 1);
	if ($filehandler = fopen($filename, 'w+')) {
		if (fwrite( $filehandler, utf8($_POST[filecontent]), strlen(utf8($_POST[filecontent])) ))
			print win("Файл успешно сохранен.");
		fclose($filehandler);
	}
	else
		print win("Невозможно открыть файл \"" . $filename . "\".");
}
?>