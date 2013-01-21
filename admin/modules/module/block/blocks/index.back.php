<?php
include_once ( $cfg[PATH][admin_modules_path]."blocks/classes/Blocks.class.php" );

$Blocks = new Blocks();

$module_path = "/admin/modules/module/block/blocks";

if (isset($_GET[block]) && $_GET[block] != "" && is_numeric($_GET[block]) ) {

	$tpl->assign ( "ContentTemplate", 	"back-block-edit" );
	$tpl->assign ( "BlockType", 		$Blocks -> GetBlock($_GET[block]) );
	$tpl->assign ( "BlockFields", 		$Blocks -> GetBlockFields($_GET[block]) );
	$tpl->assign ( "InputTypes", 		$Blocks -> GetInputTypes() );	

}
elseif (isset($_GET[content]) && is_numeric($_GET[content])) {
	
	$block = $Blocks -> GetBlock($_GET[content]);
	if ($block[name])
		$tpl->assign ( "BlockTitle", 	"(\"" . $block[title] . "\")");
	$tpl->assign ( "ContentTemplate", 	 "back-content" );
	$tpl->assign ( "Block", 	 		$block );
	$tpl->assign ( "ContentArray", 		$Blocks -> GetBlockContentList($_GET[content]) );
	$tpl->assign ( "FieldsArray", 		$Blocks -> GetBlockForm($_GET[content]) );
	
}  
else {

	$tpl->assign ( "ContentTemplate", 	"back-list" );
	$tpl->assign ( "BlockArray", 		$Blocks->GetBlocks() );
}
$tpl -> assign ( "root", 		$cfg[PATH][root] );
$tpl -> assign ( "mod_info", 	$ModuleInfo );
$tpl -> assign ( "mod_path", 	$module_path );
$tpl -> assign ( "SESS_URL",	$sess->url () . "&" );
$tpl -> assign ( "Template",   	$tpl->fetch($cfg[PATH][admin_modules]."module/block/blocks/templates/back.tpl.php" ));
?>