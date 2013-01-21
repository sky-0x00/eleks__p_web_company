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

if ($_REQUEST['active'] == "on") $_REQUEST['active'] = 'Y'; else $_REQUEST['active'] = 'N';

if (!isset($_REQUEST['phone']))
	$_REQUEST['phone'] = 0;
	
if (!isset($_REQUEST['icq']))
	$_REQUEST['icq'] = 0;
	
$Users -> db -> query ( sprintf( "
	INSERT INTO %s (active, name, login, password, email, phone, icq, photo, comment, date_add, date_last)
	VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', UNIX_TIMESTAMP(), UNIX_TIMESTAMP())
	", $Users->table_users, $_REQUEST['active'], utf8($_REQUEST['name']), utf8($_REQUEST['login']), md5($_REQUEST['pwd']), $_REQUEST['mail'], $_REQUEST['phone'], $_REQUEST['icq'], $_REQUEST['photo'], utf8($_REQUEST['comment']) ) );

$last_id=$Users->db->last_id();

if ($last_id!=0)
	$Users -> db -> query ( sprintf (" INSERT INTO %s (user_id, group_id) VALUES (%s, 1)", $Users->table_groups_users, $last_id));

?>