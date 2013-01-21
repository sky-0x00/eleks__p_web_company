<?php

define ( "__DOCUMENT__", $cfg[PATH][admin_modules]."module/templates/Module_index.tpl.php" );

$Modules = new Modules();

if (isset($_GET[type]) && $_GET[type] != "" ) {

	$ModuleInfo = $Modules->getModuleInfo($_GET[type]);
	$tpl->assign ( "ModuleName", 	$ModuleInfo[0][name]);
	
	include($cfg[PATH][admin_modules]."module/block/".$ModuleInfo[0][alias]."/index.back.php");

} else {

	$tpl->assign ( "ModuleArray", 	$Modules->getModulesList() );

	$tpl->assign ( "Template", 	 	"Module_list" );
}

?>