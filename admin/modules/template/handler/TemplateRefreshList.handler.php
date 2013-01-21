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
$tpl = new Smarty_Admin ();

$TemplateGroup = $Template->getGroupList();

for ($i = 0; $i < count($TemplateGroup); $i++) {

	$Templates[$i] = $Template->getTemplateByGroup($TemplateGroup[$i][id]);
}
$tpl->assign( "Templates", 	$Templates );
$tpl->assign( "GInfo", 		$TemplateGroup );

print win($tpl->fetch($cfg[PATH][admin_modules]."template/templates/Template_list.tpl.php"));

?>