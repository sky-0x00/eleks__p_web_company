<?php
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

include_once($cfg['PATH']['admin_classes']."UsersList.class.php");

$Users = new UsersList();

if ($_REQUEST['active'] == 'on') $_REQUEST['active'] = 'Y'; else $_REQUEST['active'] = 'N';

if (trim($_REQUEST['pwd']) != "") 
	$query_str = "password = '" . md5($_REQUEST['pwd']) . "'";
else
	$query_str = "";
	
$Users -> db -> query ( sprintf( "UPDATE %s SET 
								active = '%s',
								name = '%s',
								login = '%s',
								".$query_str."
								email = '%s',
								phone = '%s',
								icq = '%s',
								comment = '%s',
								date_last = UNIX_TIMESTAMP()
								WHERE user_id = %s", 
								$Users->table_users, $_REQUEST['active'], utf8($_REQUEST['name']), $_REQUEST['login'], 
								$_REQUEST['mail'], $_REQUEST['phone'], $_REQUEST['icq'], utf8($_REQUEST['comment']), $_REQUEST['uid'] ));

if ($_REQUEST['report'] == 'on') {
	
	
}

?>