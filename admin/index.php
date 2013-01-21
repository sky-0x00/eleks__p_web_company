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
//	�������� ������, ��������������, ������������
page_open ( array (
"sess" => "SYS_Session",
"auth" => "SYS_Auth",
"user" => "SYS_User"
) );
////////////////////////////////////////////////////////////////////////////////

//	�������� cache-�������
if ( !isset ( $_SESSION[CACHE] ) )
$_SESSION[CACHE] = array ();

//	�������� ���������� ������ Smarty (�������)
$tpl = new Smarty_Admin ();
////////////////////////////////////////////////////////////////////////////////
//
//	END 2. �������� �������� �������.
//
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
//
//	START 3. ����� ��������, ������� ����� ����������� � �������������� �����.
//		$section - �������� �� ����� �������� (������ $_GET ��� $_POST).
//		���������� ����� �� ����, ���� ���������� ����� �����,
//		� ���� ������ ����������� ���������� ��������, ������� ������
//		�� ������ (���������� $_SESSION[CACHE][last_section]).
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
//	START 4. �������������� �����.
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
//	����������� �������
//
////////////////////////////////////////////////////////////////////////////////
$Domain = new Domain();
$tpl->assign( "DomainInfo", $Domain->GetDomainInfo() );

$Section = new Section();
$tpl->assign ( "SectionName", $Section -> GetSectionByName($section_name) );
////////////////////////////////////////////////////////////////////////////////
//
//	START 5. ���������� ����� �������� � ����� ������������.
//
////////////////////////////////////////////////////////////////////////////////
if ( defined ( "__DOCUMENT__" ) ) {

	////////////////////////////////////////////////////////////////////////////////
	//	���������� ���������� �����-������������

	//	������
	$tpl->assign ( "SESS_URL",	$sess->url () . "&" );
	$tpl->assign ( "root",		$_SERVER['DOCUMENT_ROOT']);

	//	����
	$tpl->assign ( "PATH_SKIN_CSS",       $cfg[PATH][skins][css] );
	$tpl->assign ( "PATH_SKIN_IMAGES",    $cfg[PATH][skins][images] );
	$tpl->assign ( "PATH_SKIN_JS",        $cfg[PATH][skins][js] );

	//	�������� ��������
	$tpl->assign ( "DOCUMENT_SECTION",    $section );
	$tpl->assign ( "DOCUMENT_HOST",       $cfg[PATH][www_root] );


}


if ( defined ( "__DOCUMENT__" ) ) {

	//	���������� �������������� ���� ��������
	$tpl->display ( __DOCUMENT__ );

}

?>