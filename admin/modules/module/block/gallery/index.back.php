<?php
include_once ( $cfg['PATH']['admin_modules_path']."gallery/classes/Gallery.class.php" );

$Gallery = new Gallery();

$module_path = "/admin/modules/module/block/gallery";

if (isset($_GET['edit_album']) && is_numeric($_GET['edit_album']) ) {

	$tpl->assign ( "ContentTemplate", 	"back-album-edit" );
	$tpl->assign ( "Album", 			$Gallery->GetAlbum($_GET['edit_album']) );
}
elseif (isset($_GET['album']) && is_numeric($_GET['album']) ) {

	$tpl->assign ( "ContentTemplate", 	"back-photos" );
	$tpl->assign ( "PhotoArray", 		$Gallery->GetAlbumPhotos($_GET['album']) );
}
else {

	$tpl->assign ( "ContentTemplate", 	 "back-albums" );
	$tpl->assign ( "AlbumArray", 		$Gallery->GetAlbums() );
}

$tpl -> assign ( "root", 		$cfg['PATH']['root'] );
$tpl -> assign ( "mod_info", 	$ModuleInfo );
$tpl -> assign ( "mod_path", 	$module_path );
$tpl -> assign ( "SESS_URL",	$sess->url () . "&" );
$tpl -> assign ( "Template",   	$tpl->fetch($cfg['PATH']['admin_modules']."module/block/gallery/templates/back.tpl.php" ));
?>