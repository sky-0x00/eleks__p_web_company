<?php

include_once($cfg[PATH][admin_classes]."PageData.class.php");

$subStructureTemplate = new Smarty_Admin();
$Structure = new PageData();

$parentlayerid = intval($_POST[parentlayerid]);
$parentdivid = $_POST[parentdivid];

$subStructureList = $Structure -> db -> getResultArray( sprintf( "SELECT * FROM %s WHERE pid=%s", $Structure->table, $parentlayerid ) );

for ($i=0; $i<count($subStructureList);	$i++)
{
	$subStructureList[$i][cntSubItems] = count( $Structure -> db -> getResultArray( sprintf( "SELECT page_id FROM %s WHERE pid=%s ORDER BY priority", $Structure -> table, $subStructureList[$i][page_id] ) ) );
}
$subStructureTemplate -> assign ( "ParentDivId", 		$parentdivid );
$subStructureTemplate -> assign ( "SubStructureList" , 	$subStructureList );
$subStructureTemplate -> assign ( "SESS_URL", 			$_POST[sessid]);

$subStructureHTML = $subStructureTemplate -> fetch($cfg[PATH][admin_modules].'structure/templates/Structure_tree.tpl.php');

$tpl -> assign ("HTMLWINDOWCONTENT", win($subStructureHTML));
?>