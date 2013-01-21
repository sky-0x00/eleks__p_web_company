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
include_once ( $cfg['PATH']['admin_modules_path']."news/classes/Article.class.php" );

$Article = new Article();

if ((isset($_POST['title']) && !empty($_POST['title'])) && 
	(isset($_POST['annot']) && !empty($_POST['annot'])) && 
	(isset($_POST['text']) && !empty($_POST['text'])) &&
	(isset($_POST['date']) && !empty($_POST['date']))) {
	
	print win($Article -> CreateArticle (utf8($_POST['title']), utf8($_POST['annot']), utf8($_POST['text']), $_POST['date']));
}
else {
	$result = "error";
	$text	= "Wrong params.";
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>