<?php
///////////////////////////////////////////////
define ( "__DOCUMENT__", $cfg[PATH][admin_modules]."users/templates/Users_index.tpl.php" );
///////////////////////////////////////////////

$Users = new UsersList();
$Group = new GroupsList();

switch ($_GET[action]) {

	case "":
	$tpl -> assign ( "UsersArray", 	$Users->getUsersList() );
	$tpl -> assign ( "GroupArray", 	$Group->getGroupList() );
	$tpl -> assign ( "Template", 	"Users_list" );
	break;

	case "create":
	$tpl -> assign ( "Template", 	"Users_create" );
	break;

	case "edit":
	$tpl -> assign ( "data", 		$Users->getUsersInfo($_GET[id]) );
	$tpl -> assign ( "Template", 	"Users_edit" );
	break;
}

$tpl->assign( "m_path", "/admin/modules/users/");

?>