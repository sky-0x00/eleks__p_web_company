<?php
include_once ( $cfg[PATH][admin_modules_path]."forms/classes/Forms.class.php" );

$Forms = new Forms();

$module_path = $cfg[PATH][admin_modules_path]."forms";

switch ($_GET[action]) {

	case "":
	$FormsList = $Forms->getFormsList();
	$tpl -> assign ( "Template", "default");
	break;

	case "setting":
	$tpl -> assign ( "FormInfo", 	$Forms -> getDetailForms($_GET[id]) );
	$tpl -> assign ( "FormFields", 	$Forms -> getDetailFields($_GET[id]) );
	$tpl -> assign ( "FormTypes", 	$Forms -> getFieldsType($_GET[id]) );
	$tpl -> assign ( "FormAllTypes",$Forms -> getFieldsTypes());
	$tpl -> assign ( "Template", 	"setting" );
	break;
}

$tpl -> assign ( "FormsList" ,	$FormsList);
$tpl -> assign ( "ModuleInfo", 	$ModuleInfo );
$tpl -> assign ( "module_path", $module_path );
$tpl -> assign ( "SESS_URL",	$sess->url () . "&" );
$tpl -> assign ( "Template",   	$tpl->fetch($cfg[PATH][admin_modules]."module/block/forms/templates/Back_Main.tpl.php" ));
?>