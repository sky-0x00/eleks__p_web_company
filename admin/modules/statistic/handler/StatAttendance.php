<?php
//#########################################
$IContentTemplate = new Smarty_Admin();
$IContentTemplate -> assign ( "PAGEID" , "'" . $_POST[parentlayerid] . "'" );
$IContentTemplate -> assign ("SESS_URL", $_POST[sessid]);
//#########################################
include_once($cfg[PATH][admin_classes]."Statistic.class.php");

$Statistic = new Statistic();
$SInfo = $Statistic->Traffic($_REQUEST[period_1], $_REQUEST[period_2], $_REQUEST[type]);
$IContentTemplate -> assign( "SInfo", $SInfo );

$TemplateHTML = $IContentTemplate -> fetch( $cfg[PATH][admin_modules].'statistic/templates/StatAttenList.tpl.php' );
$tpl -> assign ( "HTMLWINDOWCONTENT", win( $TemplateHTML ) );

?>
