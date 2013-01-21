<?php

include_once ( $cfg['PATH']['admin_modules_path'] ."feedback/classes/FeedBack.class.php" );

$FeedBackClass = new FeedBack();
$tpl_new = new Smarty_Admin();

$FeedBackParam = $FeedBackClass -> getModuleParam ();

$tpl -> assign ( "DOCUMENT_CONTENT", 	$pageData[content] );

$tpl -> assign ( "module_param", 		$FeedBackParam );
$tpl -> assign ( "module_content",   	$FeedBackParam[0]['feedback_front_template']);
$tpl -> assign ( "cms_module_feedback", $tpl->fetch($cfg['PATH']['admin_modules']."module/block/feedback/templates/front.tpl.php"));

?>