<?php

define ( "__DOCUMENT__", $cfg[PATH][admin_modules]."domain/templates/Domain_index.tpl.php" );

$Page 		= new PageData();
$Domain  	= new Domain();
$PageError  = new PageError();

$tpl -> assign ( "DomainInfo", 	$Domain->getDomainInfo());
$tpl -> assign ( "ErrorArray", 	$PageError->getPageList());

$tpl->assign( "m_path", "/admin/modules/domain/");

?>