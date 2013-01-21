<?php
$cfg['DB']['Host'] 	= "localhost";
//$cfg['DB']['Host'] 	= "www.eleks73.ru";
$cfg['DB']['Name'] 	= "eleks-group";
$cfg['DB']['User'] 	= "root";
$cfg['DB']['Pass'] 	= "toor";
$cfg['DB']['cls']  	= "SYS_DB";
$cfg['DB']['debug'] = 0;

$cfg['SETTINGS']['PAGER']['NEWS'] 	= 5;
$cfg['SETTINGS']['PAGER']['ARTICLES'] 	= 5;

$_MONTHS[1]['name'] 	= "€нварь";
$_MONTHS[2]['name'] 	= "февраль";
$_MONTHS[3]['name'] 	= "март";
$_MONTHS[4]['name'] 	= "апрель";
$_MONTHS[5]['name'] 	= "май";
$_MONTHS[6]['name'] 	= "июнь";
$_MONTHS[7]['name'] 	= "июль";
$_MONTHS[8]['name'] 	= "август";
$_MONTHS[9]['name'] 	= "сент€брь";
$_MONTHS[10]['name'] 	= "окт€брь";
$_MONTHS[11]['name'] 	= "но€брь";
$_MONTHS[12]['name'] 	= "декабрь";

for ($i=1; $i<=12; $i++) {	
	$_MONTHS[$i]['active'] = false;
	$_MONTHS[$i]['num'] = ($i>9) ? $i : ("0".$i);
}

// дополнительные переменные, определ€емые позже
//$cfg['GENERAL']['title_prefix'];      // префикс в заголовке окон
?>