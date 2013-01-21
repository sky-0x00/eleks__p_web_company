<?php
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");

include_once ( $cfg['PATH']['admin_modules_path']."catalog/classes/Catalog.class.php" );

$Catalog = new Catalog();

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Если запрос на генерацию excel-документа
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['getexcel'])) {
	
	/*if ($filename = $Catalog -> GetPrice()) {
		print file_get_contents($filename);
		exit;
	}*/
}

$categories = $Catalog -> GetCatChildren(0);

$tpl -> assign( "Categories", $categories );

if ($pageData['url']=="products") {
		
	$cat_id 	= (isset($PARAMS[0]) && is_numeric($PARAMS[0]) && !empty($PARAMS[0])) ? $PARAMS[0] : $categories[0]['id'];
	$cat_name 	= (isset($PARAMS[0]) && is_numeric($PARAMS[0]) && !empty($PARAMS[0])) ? $Catalog -> GetCatName($PARAMS[0]) : $categories[0]['name'];
	
	$count = 3;
	$total = 0;
	
	$filter = array();
	
	$p = (isset($PARAMS[1]) && is_numeric($PARAMS[1]) && !empty($PARAMS[1])) ? $PARAMS[1] : 1;
		
	$from = ($p-1)*$count;
	
	$items = $Catalog -> GetCatItems ($total, $cat_id, $filter, $from, $count);	
	
	if ($items) {		
		for ($i=0; $i<count($items); $i++) {
			$items[$i]['properties'] = $Catalog -> GetItemProps($items[$i]['id_item']);
		}
	}
	
	if (!$items || (count($PARAMS)>2)) {
		define ( "__DOCUMENT__", $cfg[PATH][error][tpl] . $DomainInfo[0]['page404']['filename'] . ".tpl.php" );
		$tpl -> assign ( "Error404", true );
		$tpl -> display ( __DOCUMENT__ );
		exit();
	}
	
	$pages = (($total-($total%$count))/$count);
	
	if (($total%$count)>0)
		$pages++;
			
	$tpl -> assign( "cat_name", $cat_name );
	$tpl -> assign( "cat_id", 	$cat_id );
	$tpl -> assign( "Items", 	$items );
	$tpl -> assign( "pages", 	$pages );
	$tpl -> assign( "page", 	$p );
}

?>