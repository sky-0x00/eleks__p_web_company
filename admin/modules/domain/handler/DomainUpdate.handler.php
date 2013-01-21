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

include_once($cfg[PATH][admin_classes]."Domain.class.php");

$Domain = new Domain();

if ($_REQUEST[active] == "on") $_REQUEST[active] = 1; else $_REQUEST[active] = 0;

$Domain->db->query ( sprintf( "UPDATE %s SET active = '%s', name = '%s', url = '%s', charset = '%s', page403 = '%s', page404 = '%s', date_update = UNIX_TIMESTAMP() ",

$cfg[DB][Table][domain], $_REQUEST[active], utf8($_REQUEST[name]), $_REQUEST[url], $_REQUEST[charset], $_REQUEST['p403'], $_REQUEST['p404'] ) );

?>