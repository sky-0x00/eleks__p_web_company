<?php

include_once ( $cfg[PATH][admin_modules_path]."feedback/classes/FeedBack.class.php" );

$FeedBackClass = new FeedBack();

$FeedBackParam = $FeedBackClass -> getModuleParam ();

$tpl -> assign ( "mod_param", 	$FeedBackParam );

$tpl -> assign ( "mod_info", 	$ModuleInfo );

$tpl -> assign ( "mod_path",	"/admin/modules/module/block/feedback" );

$tpl -> assign ( "Template",   	$tpl->fetch($cfg[PATH][admin_modules]."module/block/feedback/templates/back.tpl.php" ));

?>