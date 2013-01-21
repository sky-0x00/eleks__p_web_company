<?php
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg[PATH][core] );
DirInclude ( $cfg[PATH][admin_classes]);
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/lib/Smarty 2.6.18/Smarty.class.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );
//////////////////////////////////////////////////////////////////////////////////////

include_once($cfg[PATH][admin_classes]."PageData.class.php");
$Page = new PageData();

if ($_REQUEST[active] == "on") $_REQUEST[active] = 1; else $_REQUEST[active] = 0;
if ($_REQUEST[type_id] == "on") $_REQUEST[type_id] = 1; else $_REQUEST[type_id] = 0;
//#####################################################################################################################
$Page->db->query ( sprintf( "
	UPDATE %s SET 
	active = '%s',
	priority = '%s',
	name = '%s',
	url = '%s',
	title = '%s',
	description = '%s',
	keywords = '%s',
	template_id = '%s',
	type_id = '%s',
	date_update = UNIX_TIMESTAMP()
	WHERE page_id = %s

",$cfg[DB][Table][pages], $_REQUEST[active], $_REQUEST[priority], utf8($_REQUEST[name]), $_REQUEST[url], utf8($_REQUEST[title]), utf8($_REQUEST[description]), utf8($_REQUEST[keywords]), 
$_REQUEST[template_id], $_REQUEST[type_id], $_REQUEST[id_page] ) );

//#####################################################################################################################
if ($_REQUEST[title_upply] == "on") {
	
	$Page -> db -> query ( sprintf ("UPDATE %s SET title = '%s', description = '%s', keywords = '%s' WHERE active = 1", $cfg[DB][Table][pages], utf8($_REQUEST[title]), utf8($_REQUEST[description]), utf8($_REQUEST[keywords]), $_REQUEST[id_page]) );
}
//#####################################################################################################################
$ModuleID = explode("|", $_REQUEST[module]);

$Page->db->query ( sprintf ( "DELETE FROM %s WHERE page_id = %s", $cfg[DB][Table][pages_modules], $_REQUEST[id_page] ) );

if (is_array($ModuleID)) {

	$i = 0;

	while ($i < count($ModuleID)-1) {

		$Page->db->query ( sprintf( "REPLACE %s SET page_id = %s, module_id = %s", $cfg[DB][Table][pages_modules], $_REQUEST[id_page], $ModuleID[$i] ));

		$i++;
	}
}
//#####################################################################################################################
?>