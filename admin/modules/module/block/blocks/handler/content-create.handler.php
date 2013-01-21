<?php
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg[PATH][core] );
DirInclude ( $cfg[PATH][admin_classes]);
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $cfg[PATH][admin_modules_path]."blocks/classes/Blocks.class.php" );

$Blocks = new Blocks();

$fields = $Blocks -> GetFields($_REQUEST[id_block]);

if (is_array($fields) && ($_REQUEST[content_name])) {
	
	$okay = true;
	
	foreach ($fields as $key=>$value) {
		if (!isset($_REQUEST[$value[name]]) && ($_REQUEST[$value['empty']]=="N" ))
			$okay = false;
	}
	
	if ($okay) {
		
		$id_content = $Blocks -> AddNewContent($_REQUEST[id_block], utf8($_REQUEST[content_name]));
		
		foreach ($fields as $key=>$value) 			
			if ($id_content) 				
				if (isset($_REQUEST[$value[name]]) || ($_REQUEST[$value['empty']]=="Y" ))		
					$result	.= $Blocks -> AddNewFieldsContent($id_content, $value[id_field], utf8($_REQUEST[$value[name]]));				
		
	}
}

print win ($Blocks -> GetContentListJSON($_REQUEST[id_block], true));
?>