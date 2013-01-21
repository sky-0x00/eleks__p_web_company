<?php
//########################################
define ( "__DOCUMENT__", $cfg[PATH][admin_modules]."setting/templates/SettingMain.tpl.php" );
//########################################

$cfg[module][path][templates] = $cfg[PATH][admin_modules]. "setting/templates/";

switch ($_GET[action]) {

	case "interface":

	$tpl -> assign( "Template", $cfg[module][path][templates]."Setting_Interface");
	break;

	case "db":

	$tpl -> assign( "Template", "Setting_DB");
	break;
	
	default:
	$tpl -> assign( "Template", $cfg[module][path][templates]."Setting_Interface");
	break;


}

?>