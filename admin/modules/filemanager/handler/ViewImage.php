<?php
$IContentTemplate = new Smarty_Admin();

$IContentTemplate -> assign ( "PAGEID" , "'" . $_POST[parentlayerid] . "'" );
$IContentTemplate -> assign ("SESS_URL", $_POST[sessid]);
$fname = $_POST[parentlayerid];

$IContentTemplate -> assign ( "UNIQHDWID", $_POST[hdwid]);
$IContentTemplate -> assign ( "FILENAME", str_replace("//","/",$fname) );

$TemplateHTML = $IContentTemplate -> fetch( $cfg[PATH][admin_modules].'filemanager/templates/getContentImageFile.tpl.php' );

$tpl -> assign ( "HTMLWINDOWCONTENT", win( $TemplateHTML ) );

?>