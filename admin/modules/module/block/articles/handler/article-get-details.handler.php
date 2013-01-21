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

if (isset($_POST['id_article']) && !empty($_POST['id_article']) && is_numeric($_POST['id_article'])) {
	print win($Article -> GetArticleJSON ($_POST['id_article']));
}
else {
	$result = "error";
	$text	= "Неверный id.";	
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>