<?php

include_once($cfg[PATH][admin_classes]."PageData.class.php");

$subStructureTemplate = new Smarty_Admin();

$Structure = new PageData();

$parentlayerid = intval($_POST[parentlayerid]);

$subStructureTemplate -> assign ( "PAGEID" , $parentlayerid );

if ( isset($_POST[newcontent]) )
{
	$Structure -> db -> Query ( sprintf( " UPDATE %s SET content='%s' WHERE page_id=%s" , $Structure -> table ,mysql_escape_string(iconv("UTF-8","WINDOWS-1251",$_POST[newcontent])), $parentlayerid ) );
}

$subStructureTemplate -> assign ("SESS_URL", $_POST[sessid]);

$CurrentPageItem = $Structure -> getRecord( $parentlayerid );
$CurrentContent = $CurrentPageItem[content];

$subStructureTemplate -> assign ( "CONTENT", $CurrentContent );
$subStructureTemplate -> assign ( "UNIQHDWID", $_POST[hdwid]);

$subStructureHTML = $subStructureTemplate -> fetch($cfg[PATH][admin_modules].'filemanager/templates/getContentDB.tpl.php');

$tpl -> assign ("HTMLWINDOWCONTENT", win( $subStructureHTML ));
?>