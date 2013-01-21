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

$Page = new PageData();

if ( isset($_POST['page']) && !empty($_POST['page']) ) {
	
	if ( $content = $Page -> db -> getResultArray ( sprintf ("SELECT `content` FROM %s WHERE `url` = '%s';", $Page->table, $_POST['page'] )) ) {
		$result = "success";
		$text	= $content[0]['content'];
	}
	else {
		$result = "error"; 
		$text 	= "Can't get page by url.";
	}
}
else {
	$result = "error"; 
	$text 	= "Wrong page name.";
}
	
print win( array2json(array("result" => $result, "text" => $text)) );
?>