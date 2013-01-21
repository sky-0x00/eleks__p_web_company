<?php
session_start();
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg['PATH']['core'] );
DirInclude ( $cfg['PATH']['admin_classes']);
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/lib/Smarty 2.6.18/Smarty.class.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $cfg['PATH']['admin_modules_path']."catalog/classes/Catalog.class.php" );
include_once ( $cfg['PATH']['admin_modules_path']."feedback/classes/FeedBack.class.php" );

$Catalog = new Catalog();

if (isset($_POST['id_cat']) && !empty($_POST['id_cat']) && is_numeric($_POST['id_cat'])) {
	
	$_SESSION['CATALOG']['CATEGORY'] = $_POST['id_cat'];
	
	if (isset($_SESSION['CATALOG']['FILTER'])) {
		unset($_SESSION['CATALOG']['FILTER']);
	}
}

if (isset($_POST['clear_filter'])) {
	
	if (isset($_SESSION['CATALOG']['FILTER']))
		unset($_SESSION['CATALOG']['FILTER']);
	
	unset($_SESSION['CATALOG']['PAGE']);
	$_SESSION['CATALOG']['SETTINGS'] = $Catalog -> GetSettings();
}

if (isset($_POST['page']) && !empty($_POST['page']) && is_numeric($_POST['page'])) {

	$_SESSION['CATALOG']['PAGE'] = $_POST['page'];
}




if (isset($_POST['filter_art'])) {
	
	if (empty($_POST['filter_art'])) {
		unset($_SESSION['CATALOG']['FILTER']['art']);
	}
	else {
		$_SESSION['CATALOG']['FILTER']['art'] = trim(utf8($_POST['filter_art']));
	}
}




if (isset($_POST['filter_from'])) {
	
	if (empty($_POST['filter_from']) || !is_numeric($_POST['filter_from'])) {
		unset($_SESSION['CATALOG']['FILTER']['WEIGHT']['FROM']);
	}
	else {
		$_SESSION['CATALOG']['FILTER']['WEIGHT']['FROM'] = trim($_POST['filter_from']);
	}
}

if (isset($_POST['filter_to'])) {
	
	if (empty($_POST['filter_to']) || !is_numeric($_POST['filter_to'])) {
		unset($_SESSION['CATALOG']['FILTER']['WEIGHT']['TO']);
	}
	else {
		$_SESSION['CATALOG']['FILTER']['WEIGHT']['TO'] = trim($_POST['filter_to']);
	}
}



if (isset($_POST['filter_props'])) {
			
	if (!empty($_POST['filter_props'])) {
		
		$_SESSION['CATALOG']['FILTER']['PROPERTIES'] = array();
		
		$groups = explode(";", utf8($_POST['filter_props']));
		
		if ($groups) {
			
			for ($i=0; $i<count($groups); $i++) {
				
				$group = explode(":", $groups[$i]);
				
				if (count($group)==2) {
					
					$_SESSION['CATALOG']['FILTER']['PROPERTIES'][trim($group[0])] = explode("_", $group[1]);
				}
			}
		}
	}
	else {
		unset($_SESSION['CATALOG']['FILTER']['PROPERTIES']);
	}
}
	
if (!isset($_SESSION['CATALOG']['PAGE']))
	$_SESSION['CATALOG']['PAGE'] = 1;
	
if (!isset($_SESSION['CATALOG']['SETTINGS']))
	$_SESSION['CATALOG']['SETTINGS'] = $Catalog -> GetSettings();

if (isset($_POST['per_page']) && is_numeric($_POST['per_page']))
	$_SESSION['CATALOG']['SETTINGS']['per_page'] = $_POST['per_page'];
	
$from = ($_SESSION['CATALOG']['PAGE']-1)*$_SESSION['CATALOG']['SETTINGS']['per_page'];
$total = 0;
			
if (isset($_SESSION['CATALOG']['CATEGORY']) && ($_SESSION['CATALOG']['CATEGORY']>0)) {		
	
	$items 		= $Catalog -> GetCatItems ($total, $_SESSION['CATALOG']['CATEGORY'], $_SESSION['CATALOG']['FILTER'], $from, $_SESSION['CATALOG']['SETTINGS']['per_page']);
	
	$path 		= $Catalog -> GetCatPath ($_SESSION['CATALOG']['CATEGORY']);
	
	$properties = $Catalog -> GetCatFields ($_SESSION['CATALOG']['CATEGORY']);
	
	for ($i=0; $i<count($properties); $i++) {
		
		$properties[$i]['visible'] = false;
		
		if ($properties[$i]['options']) {
			
			for ($j=0; $j<count($properties[$i]['options']); $j++) {
				
				$val = $properties[$i]['options'][$j];
				
				$properties[$i]['options'][$j] = array();
				$properties[$i]['options'][$j]['value'] = trim($val);
				
				if (isset( $_SESSION['CATALOG']['FILTER']['PROPERTIES'][$properties[$i]['id_field']]) && 
					in_array($properties[$i]['options'][$j]['value'], $_SESSION['CATALOG']['FILTER']['PROPERTIES'][$properties[$i]['id_field']])) {
					
					$properties[$i]['visible'] = true;
					$properties[$i]['options'][$j]['checked'] = true;
				}
				else {
					$properties[$i]['options'][$j]['checked'] = false;
				}
			}
		}
	}
}
else {
	$_SESSION['CATALOG']['CATEGORY'] = 0;
	$path 		= array();
	$properties = array();
	$items 		= $Catalog -> GetItems ($total, $_SESSION['CATALOG']['FILTER'], $from, $_SESSION['CATALOG']['SETTINGS']['per_page']);
}

$pages=1;

if ($_SESSION['CATALOG']['SETTINGS']['per_page'] > 0) {
	
	$j=1;
	
	while ($j<=$total) {
		$j += $_SESSION['CATALOG']['SETTINGS']['per_page'];
		$pages++;
	}
}
	
$result = "success";
	
$tpl = new Smarty_Admin();
	
$tpl -> assign ( "Items",		$items );
$tpl -> assign ( "path",		$path );
$tpl -> assign ( "pages",		$pages );
$tpl -> assign ( "page",		$_SESSION['CATALOG']['PAGE'] );
$tpl -> assign ( "properties",	$properties );
	
$text['items'] 		= $tpl->fetch($cfg['PATH']['admin_modules']."module/block/catalog/templates/front-items.tpl.php");
$text['path']  		= $tpl->fetch($cfg['PATH']['admin_modules']."module/block/catalog/templates/front-path.tpl.php");
$text['pages']  	= $tpl->fetch($cfg['PATH']['admin_modules']."module/block/catalog/templates/front-pages.tpl.php");
$text['properties']	= $tpl->fetch($cfg['PATH']['admin_modules']."module/block/catalog/templates/front-properties.tpl.php");

$text['total'] 			= $total;	
$text['pages_count'] 	= $pages;
$text['per_page'] 		= $_SESSION['CATALOG']['SETTINGS']['per_page'];


print win(array2json(array("result" => $result, "text" => $text)));

?>