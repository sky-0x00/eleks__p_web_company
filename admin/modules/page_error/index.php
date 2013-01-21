<?php
///////////////////////////////////////////////////////
define ( "__DOCUMENT__", $cfg[PATH][admin_modules]."page_error/templates/page-error-index.tpl.php" );
///////////////////////////////////////////////////////

$PageError = new PageError();

switch ($_GET[action]) {

	case "":
		$tpl->assign ( "PageList", $PageError->getPageList() );
		$tpl->assign ( "Template" , "page-error-list" );
		break;
}



?>