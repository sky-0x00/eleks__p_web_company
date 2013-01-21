<?php
include_once ( $cfg['PATH']['admin_modules_path'] . "menu/classes/Menu.class.php" );

$Menu = new Menu();

$_cats = $Menu -> GetCats("ASC");
$cats = array();
$i = 0;
$n = 0;

while ($i<count($_cats)) {
	$j=0;
	$items = array();
	
	while (($j<5) && ($i<count($_cats))) {
		$items[$j] = $_cats[$i];
		$j++;
		$i++;
	}
	
	$cats[$n] = $items;
	$n++;
}

if (count($PARAMS)==0) {
	$tpl -> assign ( "CatName",	$Menu -> GetCatName($cats[0][0]['value']) );
	$tpl -> assign ( "_Items", 	$Menu -> GetItems($cats[0][0]['value'], "ASC") );
}
else {
	$tpl -> assign ( "CatName",	$Menu -> GetCatName($PARAMS[0]) );
	$tpl -> assign ( "_Items", 	$Menu -> GetItems($PARAMS[0], "ASC") );
}

//print_r($Menu -> GetItems($PARAMS[0], "ASC"));

$tpl -> assign ( "PARAMS",		$PARAMS );
$tpl -> assign ( "Cats", 		$cats );
$tpl -> assign ( "module_menu", $tpl->fetch($cfg['PATH']['admin_modules_path'] . "menu/templates/front.tpl.php") );
?>