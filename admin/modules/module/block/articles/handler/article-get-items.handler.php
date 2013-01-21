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
include_once ( $cfg['PATH']['admin_modules_path']."articles/classes/Article.class.php" );

$Article = new Article();

if (isset($_POST['year']) && !empty($_POST['year']) && is_numeric($_POST['year'])) {
	print win($Article -> GetArticleListJSON($_POST['year']));
}
else {
	$result = "error";
	$text	= "Неверный год.";
	
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>