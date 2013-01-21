<?php

define ( "__DOCUMENT__", $cfg[PATH][admin_modules]."structure/templates/Structure_index.tpl.php" );

$RecordsList 	= new PageData ();
$TemplateList 	= new Templates();
$ModulesList 	= new Modules();

switch ($_GET[action]) {

	case "":

	$tpl->assign ( "Template", "Structure_list");
	break;

	case "create":

	$tpl -> assign ( "TemplateArray" , 	$TemplateList->getTemplateList());
	$tpl -> assign ( "PageArray" , 		$RecordsList->GetListTree());
	$tpl -> assign ( "ModuleArray" , 	$ModulesList->getModulesList());
	$tpl -> assign ( "Template", 		"Structure_create");
	break;


	case "setting":
	$tpl -> assign ( "RecordsArray" , 	$RecordsList->GetPageInfo($_GET[id]));
	$tpl -> assign ( "TemplateArray" ,	$TemplateList->getTemplateList());
	$tpl -> assign ( "ModuleArray" , 	$ModulesList->getModulesList());
	$tpl -> assign ( "ModuleID" , 		$ModulesList->getModuleId($_GET[id]) );
	$tpl -> assign ( "Template" ,		"Structure_setting");
	break;

}

$tpl->assign( "m_path", "/admin/modules/structure");

?>