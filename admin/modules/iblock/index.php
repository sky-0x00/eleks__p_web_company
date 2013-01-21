<?php

define ( "__DOCUMENT__", $cfg[PATH][admin_modules]."iblock/templates/Iblock_index.tpl.php" );

$IBlock = new IBlock();

$tpl->assign( "module_path", "/admin/modules/iblock");

switch ($_GET[action]) {

	case "":
	$IBlockArray = $IBlock -> getBlockList();
	$tpl->assign ( "iblock_array", 	$IBlockArray );
	$tpl->assign ( "Template", 		"Iblock_list" );
	break;


	case "create":
	$tpl->assign ( "Template", 		"Iblock_create" );
	break;

	case "edit":
	$tpl->assign ( "iblock_info", 	$IBlock->getBlockInfo($_GET[id]) );
	$tpl->assign ( "Template",		"Iblock_edit" );
	break;
}

?>