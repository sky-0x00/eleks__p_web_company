<?php
include_once ( $cfg['PATH']['admin_modules_path'] . "guestbook/classes/GuestBook.class.php" );

$GuestBook = new GuestBook();

$module_path = "/admin/modules/module/block/guestbook";

if (isset($_GET['p']) && !empty($_GET['p']) && is_numeric($_GET['p'])) {
	$messages = $GuestBook -> GetAdminMessages($_GET['p']);
}
else {
	$messages = $GuestBook -> GetAdminMessages(1);
}

$pages = $GuestBook -> GetAdminPages();

$tpl -> assign ( "Messages", 	$messages );
$tpl -> assign ( "Cats", 		$GuestBook -> GetCategories() );

if (count($pages)>1)
	$tpl -> assign ( "Pages", 	$pages );

$tpl -> assign ( "root", 		$cfg['PATH']['root'] );
$tpl -> assign ( "mod_info", 	$ModuleInfo );
$tpl -> assign ( "mod_path", 	$module_path );
$tpl -> assign ( "SESS_URL",	$sess->url () . "&" );
$tpl -> assign ( "Template",   	$tpl->fetch($cfg['PATH']['admin_modules'] . "module/block/guestbook/templates/back.tpl.php" ));
?>