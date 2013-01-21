<?php
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg[PATH][core] );
DirInclude ( $cfg[PATH][admin_classes]);
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/lib/Smarty 2.6.18/Smarty.class.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );

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

//	создание экземпляра класса Smarty (Шаблоны)
$tpl = new Smarty_Admin ();
////////////////////////////////////////////////////////////////////////////////
//
//	END 2. Создание объектов классов.
//
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
//
//	START 3. Выбор действия, которое будет выполняться в исполнительной части.
//		$section - отвечает за выбор действия (массив $_GET или $_POST).
//		Переменной может не быть, если происходит смена языка,
//		в этом случае выполняется предыдущее действие, которое берётся
//		из сессии (переменная $_SESSION[CACHE][last_section]).
//
////////////////////////////////////////////////////////////////////////////////
$section_name = htmlspecialchars ( isset ( $_GET[section] ) ? $_GET[section] : (
isset ( $_POST[section] ) ? $_POST[section] : (
/*isset ( $_SESSION[CACHE][last_section] ) ? $_SESSION[CACHE][last_section] :*/ "cms" ) ) );

$_SESSION[CACHE][last_section] = $section_name;
////////////////////////////////////////////////////////////////////////////////
//
//	END 3.
//
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//
//	START 4. Исполнительная часть.
//
////////////////////////////////////////////////////////////////////////////////
if ( $_SESSION[AUTH]->is_authenticated () ) {

	if  ($section_name == "") $section_name = "cms";

	include_once ( $cfg[PATH][admin_modules] . $section_name . "/index.php" );
	$Users = new UsersList();
	$tpl->assign ( "UserInfo", $Users->getUsersInfo($_SESSION[USER]->user_id)  );

} else {

	include_once ( $cfg[PATH][admin_modules]."auth/index.php" );
}
////////////////////////////////////////////////////////////////////////////////
//
//	Подключение модулей
//
////////////////////////////////////////////////////////////////////////////////
$Domain = new Domain();
$tpl->assign( "DomainInfo", $Domain->GetDomainInfo() );

$Section = new Section();
$tpl->assign ( "SectionName", $Section -> GetSectionByName($section_name) );
////////////////////////////////////////////////////////////////////////////////
//
//	START 5. Применение общих шаблонов и меток заполнителей.
//
////////////////////////////////////////////////////////////////////////////////
if ( defined ( "__DOCUMENT__" ) ) {

	////////////////////////////////////////////////////////////////////////////////
	//	установить содержимое меток-заполнителей

	//	Сессия
	$tpl->assign ( "SESS_URL",	$sess->url () . "&" );
	$tpl->assign ( "root",		$_SERVER['DOCUMENT_ROOT']);

	//	Пути
	$tpl->assign ( "PATH_SKIN_CSS",       $cfg[PATH][skins][css] );
	$tpl->assign ( "PATH_SKIN_IMAGES",    $cfg[PATH][skins][images] );
	$tpl->assign ( "PATH_SKIN_JS",        $cfg[PATH][skins][js] );

	//	Выходной документ
	$tpl->assign ( "DOCUMENT_SECTION",    $section );
	$tpl->assign ( "DOCUMENT_HOST",       $cfg[PATH][www_root] );


}


if ( defined ( "__DOCUMENT__" ) ) {

	//	оформление окончательного вида страницы
	$tpl->display ( __DOCUMENT__ );

}

?>