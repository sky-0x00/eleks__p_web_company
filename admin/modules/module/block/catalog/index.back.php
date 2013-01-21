<?php
include_once ( $cfg['PATH']['admin_modules_path']."catalog/classes/Catalog.class.php" );

$Catalog = new Catalog();

$module_path = "/admin/modules/module/block/catalog";

switch ($_GET['action']) {
	
	case "":
		
		$page = (isset($_GET['p']) && !empty($_GET['p']) && is_numeric($_GET['p'])) ? $_GET['p'] : 1;
		$per_page = (isset($_GET['c']) && !empty($_GET['c']) && is_numeric($_GET['c'])) ? $_GET['c'] : 100;
				
		$from = ($page-1)*$per_page;
		$total = 0;
		
		$filters = array();
		$filters['name'] = (isset($_GET['filter_name'])) ? $_GET['filter_name'] : "";
		
		$items = $Catalog -> GetItems($total, $filters, $from, $per_page);
		
		$j=1; $pages=1;
				
		while ($j<=$total) {
			$j += $per_page;
			$pages++;
		}
		
		$tpl -> assign ( "Items",			$items );
		$tpl -> assign ( "total",			$total );
		$tpl -> assign ( "pages",			$pages );
		$tpl -> assign ( "per_page",		$per_page );
		$tpl -> assign ( "ContentTemplate", "back-items" );
		
		break;
		
	case "tree":
		
		$array = array();
		$Catalog -> GetCatTree($array, 0, 0);
	
		$tpl -> assign ( "ContentTemplate",	"back-tree" );
		$tpl -> assign ( "CatTree", 		$array );
		
		break;
		
	case "category":
		
		$tpl -> assign ( "ContentTemplate",	"back-category" );
		$tpl -> assign ( "Cat", 			$Catalog -> GetCat($_GET['id']) );
		$tpl -> assign ( "CatFields", 		$Catalog -> GetFields($_GET['id']) );
		$tpl -> assign ( "InputTypes", 		$Catalog -> GetInputTypes() );
		
		break;
		
	case "edit":
		
		$Item = $Catalog -> GetItem($_GET['id']);
		$Fields = $Catalog -> GetCatFields($Item['id_cat']);
		
		if ($Fields) {
			
			for ($i=0; $i<count($Fields); $i++) {
				
				if (isset($Item['properties'][$Fields[$i]['name']])) {
				
					$Fields[$i]['value'] = $Item['properties'][$Fields[$i]['name']]['value'];
				}
			}
		}
		
		$tpl -> assign ( "ContentTemplate",	"back-edit" );
		$tpl -> assign ( "Itm",				$Item );
		$tpl -> assign ( "FieldsArray", 	$Fields );
		$tpl -> assign ( "Photos", 			$Catalog -> GetItemPhotos($Item['id_item']) );
		
		break;
		
	case "add":
		
		$array = array();
		$n = 0;
		
		$Catalog -> GetListTree($array, $n);
		
		$tpl -> assign ( "ContentTemplate",	"back-edit" );
		$tpl -> assign ( "CatList", 		$array );
		
		break;
		
	case "settings":
		
		$tpl -> assign ( "ContentTemplate",	"back-settings" );
		$tpl -> assign ( "Settings", 		$Catalog -> GetSettings() );
		
		break;
		
	case "orders":
		
		if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
			
			$tpl -> assign ( "Order", 			$Catalog -> GetOrder($_GET['id']) );
			$tpl -> assign ( "Items", 			$Catalog -> GetOrderItems($_GET['id']) );
			$tpl -> assign ( "ContentTemplate", "back-order" );
		}
		else {
		
			$page = (isset($_GET['p']) && !empty($_GET['p']) && is_numeric($_GET['p'])) ? $_GET['p'] : 1;
			$per_page = (isset($_GET['c']) && !empty($_GET['c']) && is_numeric($_GET['c'])) ? $_GET['c'] : 100;
					
			$from = ($page-1)*$per_page;
			$total = 0;
			
			$orders = $Catalog -> GetOrders($total, $from, $per_page);
			
			$j=1; $pages=1;
					
			while ($j<=$total) {
				$j += $per_page;
				$pages++;
			}
			
			$tpl -> assign ( "Orders",			$orders );
			$tpl -> assign ( "total",			$total );
			$tpl -> assign ( "pages",			$pages );
			$tpl -> assign ( "per_page",		$per_page );
			$tpl -> assign ( "ContentTemplate", "back-orders" );
		}
		
		break;
}

$tpl -> assign ( "root", 		$cfg['PATH']['root'] );
$tpl -> assign ( "mod_info", 	$ModuleInfo );
$tpl -> assign ( "mod_path", 	$module_path );
$tpl -> assign ( "SESS_URL",	$sess->url () . "&" );
$tpl -> assign ( "Template",   	$tpl->fetch($cfg['PATH']['admin_modules']."module/block/catalog/templates/back.tpl.php" ));
?>