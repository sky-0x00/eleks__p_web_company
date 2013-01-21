<?php
///////////////////////////////////////////////
define ( "__DOCUMENT__", $cfg[PATH][admin_modules]."template/templates/template-index.tpl.php" );

$Template = new Templates();

$TemplateGroup = $Template -> getGroupList();

for ($i = 0; $i < count($TemplateGroup); $i++) {

	$Templates[$i] = $Template -> getTemplateByGroup($TemplateGroup[$i][id]);
}

switch ($_GET[action]) {
	
	case "":
	
		$tpl -> assign( "Templates", 	$Templates );
		$tpl -> assign( "GInfo", 		$TemplateGroup );
		$tpl -> assign( "Template", 	"template-main" );
		break;
		
	case "create":
	
		$tpl -> assign( "TemplateGroups", 	$TemplateGroup );
		$tpl -> assign( "Template", 		"template-create" );
		break;
		
	case "edit":
	
		$tpl -> assign( "TemplateGroups", 	$TemplateGroup );
		$tpl -> assign( "TemplateInfo",		$Template -> getTemplateByID($_GET[id]) );
		$tpl -> assign( "Template", 		"template-edit" );
		break;
}

$tpl -> assign( "m_path", "/admin/modules/template");

?>
