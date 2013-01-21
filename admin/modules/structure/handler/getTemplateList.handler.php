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
//////////////////////////////////////////////////////////////////////////////////////

include_once($cfg[PATH][admin_classes]."Templates.class.php");

$Template = new Templates();

$TemplateArray = $Template->db->getResultArray ( sprintf( "SELECT template_id, name FROM %s", $cfg[DB][Table][templates] ) );

for ($i = 0; $i < count($TemplateArray); $i++) {

	print '<div><input type="text" readonly value="'.win($TemplateArray[$i][name]).'" tid="'.$TemplateArray[$i][template_id].'"></div>';
}

?>