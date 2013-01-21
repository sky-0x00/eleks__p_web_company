<?php
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");

include_once ( $cfg['PATH']['admin_modules_path']."gallery/classes/Gallery.class.php" );

$Gallery = new Gallery();

$sertificates = $Gallery -> GetPhotos("sertificates");
$comments = $Gallery -> GetPhotos("comments");

$tpl -> assign ("Sertificates", $sertificates);
$tpl -> assign ("Comments", 	$comments);
?>