<?php
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg['PATH']['core'] );
DirInclude ( $cfg['PATH']['admin_classes']);
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );
//////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
//	создание сессии, аутентификации, пользователя
page_open ( array (
"sess" => "SYS_Session",
"auth" => "SYS_Auth",
"user" => "SYS_User"
) );
////////////////////////////////////////////////////////////////////////////////

//	создание cache-массива
if ( !isset ( $_SESSION[CACHE] ) )
	$_SESSION[CACHE] = array ();
	
if ( !$_SESSION[AUTH]->is_authenticated () ) 
	die("Access denied");	
	
?>