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

if (isset($_POST[sessid]))
{
	setcookie('PHPSESSID',substr($_POST[sessid],9,strlen($_POST[sessid])-10));
}

session_start();

////////////////////////////////////////////////////////////////////////////////
//	создание сессии, аутентификации, пользователя
////////////////////////////////////////////////////////////////////////////////

if ( !isset ( $_SESSION[CACHE] ) )
$_SESSION[CACHE] = array ();

$tpl = new Smarty_Admin ();

if ( $_SESSION[AUTH]->is_authenticated () ) {
	/////////////////////////////////////////////////////////////////////////////////////
	if (isset ($_POST[htmlwindow]))
	{
		$tplname = $_POST[htmlwindow];
		if (!empty($_POST[htmlwindowprocessor]))
		{
			include( $cfg[PATH][admin_modules] ."". $_POST[htmlwindowprocessor]);
		}
		$tpl -> display($cfg[PATH][admin_modules]."statistic/templates/".$tplname);
	}

}
?>