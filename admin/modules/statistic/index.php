<?php
//########################################
define ( "__DOCUMENT__", $cfg[PATH][admin_modules]."statistic/templates/Statistic_index.tpl.php" );
//########################################

$Statistic = new Statistic();

//########################################

if (!isset($_GET[filter])) $_GET[filter] = 'week';

switch ($_GET[filter]) {

	case "day":
	$date_s = date ("d.m.Y");
	$date_e = date ("d.m.Y");
	$tpl -> assign ( "date_s",	$date_s );
	$tpl -> assign ( "date_e",	$date_e );
	break;

	case "week":
	$date_s = date("d.m.Y", mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
	$date_e = date("d.m.Y", mktime(0, 0, 0, date("m")  , date("d")-7, date("Y")));
	$tpl -> assign ( "date_s",	$date_s );
	$tpl -> assign ( "date_e",	$date_e );
	break;

	case "month":
	$date_s = date("d.m.Y", mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
	$date_e = date("d.m.Y", mktime(0, 0, 0, date("m")-1  , date("d"), date("Y")));
	$tpl -> assign ( "date_s",	$date_s );
	$tpl -> assign ( "date_e",	$date_e );
	break;

	case "quarter":
	$date_s = date("d.m.Y", mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
	$date_e = date("d.m.Y", mktime(0, 0, 0, date("m")-3  , date("d"), date("Y")));
	$tpl -> assign ( "date_s",	$date_s );
	$tpl -> assign ( "date_e",	$date_e );
	break;

	case "year":
	$date_s = date("d.m.Y", mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
	$date_e = date("d.m.Y", mktime(0, 0, 0, date("m")  , date("d"), date("Y")-1));
	$tpl -> assign ( "date_s",	$date_s );
	$tpl -> assign ( "date_e",	$date_e );
	break;

	default:

	break;
}

switch ($_REQUEST[action]) {

	case "":
	$tpl -> assign( "Template", 	"traffic" );
	$tpl -> assign( "SInfo", 		$Statistic -> Traffic($date_e, $date_s, 0) );
	break;

	default:
	$tpl -> assign( "Template", 	"traffic" );
	$tpl -> assign( "SInfo", 		$Statistic -> Traffic($date_e, $date_s, 0) );
	break;

	case "hourly":
	$tpl -> assign( "Template", 	"hourly" );
	$tpl -> assign ( "SInfo",		$Statistic -> hourly($date_e, $date_s, 0) );
	break;

	case "summary":
	$tpl -> assign( "Template", 	"summary" );
	break;
	
	case "pages":

	$SInfo = $Statistic -> StatPages(0, 0, 0);

	$tpl -> assign( "Template", 	"pages" );
	$tpl -> assign( "SInfo", 		$SInfo );
	break;
}

?>