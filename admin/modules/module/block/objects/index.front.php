<?php
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");

include_once ( $cfg['PATH']['admin_modules_path']."objects/classes/Objects.class.php" );

$Objects = new Objects();

$sections = implode("/", $section);

switch ($sections) {

	case "services":
		
		$tpl -> assign ( "Objects", $Objects -> GetObjects("asu") );		
		break;
		
	case "services/montage":
		
		$tpl -> assign ( "Objects", $Objects -> GetObjects("montage") );		
		break;
		
	case "services/safety":
		
		$tpl -> assign ( "Objects", $Objects -> GetObjects("safety") );		
		break;
		
	case "services/construction":
		
		$tpl -> assign ( "Objects", $Objects -> GetObjects("construction") );		
		break;
		
	case "services/node":
		
		$tpl -> assign ( "Objects", $Objects -> GetObjects("node") );		
		break;		
		
	case "projects":
		
		if (!isset($PARAMS[0]) || !is_numeric($PARAMS[0]) || empty($PARAMS[0]))
			page_jump ("/projects/asu/");

		if (count($PARAMS)>1) {
			define ( "__DOCUMENT__", $cfg[PATH][error][tpl] . $DomainInfo[0]['page404']['filename'] . ".tpl.php" );
			$tpl -> assign ( "Error404", true );
			$tpl -> display ( __DOCUMENT__ );
			exit();
		}
		
		if ($Project = $Objects -> GetObject($PARAMS[0], true)) {
		
			$tpl -> assign ( "Project", 	$Project );
			$tpl -> assign ( "photo_count", count($Project['photos']) );
		}
		else {
			define ( "__DOCUMENT__", $cfg[PATH][error][tpl] . $DomainInfo[0]['page404']['filename'] . ".tpl.php" );
			$tpl -> assign ( "Error404", true );
			$tpl -> display ( __DOCUMENT__ );
			exit();
		}
		
		break;
		
	case "projects/asu":
		
		$count 	= 3;
		$p = (isset($PARAMS[0]) && is_numeric($PARAMS[0]) && !empty($PARAMS[0])) ? $PARAMS[0] : 1;
		
		$from = ($p-1)*$count;
		
		$total = $Objects -> GetObjectsCount("asu");
		
		$pages = (($total-($total%$count))/$count);
		
		if (($total%$count)>0)
			$pages++;
		
		$tpl -> assign ( "projects", 			$Objects -> GetObjects("asu", false, $from, $count) );
		$tpl -> assign ( "primary_projects", 	$Objects -> GetObjects("asu", true) );
		$tpl -> assign ( "pages", 				$pages );
		$tpl -> assign ( "page", 				$p );
		
		break;
		
	case "projects/montage":
		
		$count 	= 3;
		$p = (isset($PARAMS[0]) && is_numeric($PARAMS[0]) && !empty($PARAMS[0])) ? $PARAMS[0] : 1;
		
		$from = ($p-1)*$count;
		
		$total = $Objects -> GetObjectsCount("montage");
		
		$pages = (($total-($total%$count))/$count);
		
		if (($total%$count)>0)
			$pages++;
		
		$tpl -> assign ( "projects", 			$Objects -> GetObjects("montage", false, $from, $count) );
		$tpl -> assign ( "primary_projects", 	$Objects -> GetObjects("montage", true) );
		$tpl -> assign ( "pages", 				$pages );
		$tpl -> assign ( "page", 				$p );
		
		break;
		
	case "projects/safety":
		
		$count 	= 3;
		$p = (isset($PARAMS[0]) && is_numeric($PARAMS[0]) && !empty($PARAMS[0])) ? $PARAMS[0] : 1;
		
		$from = ($p-1)*$count;
		
		$total = $Objects -> GetObjectsCount("safety");
		
		$pages = (($total-($total%$count))/$count);
		
		if (($total%$count)>0)
			$pages++;
		
		$tpl -> assign ( "projects", 			$Objects -> GetObjects("safety", false, $from, $count) );
		$tpl -> assign ( "primary_projects", 	$Objects -> GetObjects("safety", true) );
		$tpl -> assign ( "pages", 				$pages );
		$tpl -> assign ( "page", 				$p );
		
		break;
		
	case "projects/construction":
		
		$count 	= 3;
		$p = (isset($PARAMS[0]) && is_numeric($PARAMS[0]) && !empty($PARAMS[0])) ? $PARAMS[0] : 1;
		
		$from = ($p-1)*$count;
		
		$total = $Objects -> GetObjectsCount("construction");
		
		$pages = (($total-($total%$count))/$count);
		
		if (($total%$count)>0)
			$pages++;
		
		$tpl -> assign ( "projects", 			$Objects -> GetObjects("construction", false, $from, $count) );
		$tpl -> assign ( "primary_projects", 	$Objects -> GetObjects("construction", true) );
		$tpl -> assign ( "pages", 				$pages );
		$tpl -> assign ( "page", 				$p );
		
		break;
		
		case "projects/node":
		
		$count 	= 3;
		$p = (isset($PARAMS[0]) && is_numeric($PARAMS[0]) && !empty($PARAMS[0])) ? $PARAMS[0] : 1;
		
		$from = ($p-1)*$count;
		
		$total = $Objects -> GetObjectsCount("node");
		
		$pages = (($total-($total%$count))/$count);
		
		if (($total%$count)>0)
			$pages++;
		
		$tpl -> assign ( "projects", 			$Objects -> GetObjects("node", false, $from, $count) );
		$tpl -> assign ( "primary_projects", 	$Objects -> GetObjects("node", true) );
		$tpl -> assign ( "pages", 				$pages );
		$tpl -> assign ( "page", 				$p );
		
		break;
		
}
?>