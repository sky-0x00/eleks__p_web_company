<?php

////////////////////////////////////////////////////////////////////////////////
//	загрузить файл, назначить ему идентификатор
define ( "__DOCUMENT__", $cfg[PATH][admin_modules]."auth/templates/auth.tpl.php" );
////////////////////////////////////////////////////////////////////////////////

$title = "Авторизация";
$_SESSION[CACHE][AUTH_CHALLENGE] = generate_md5 ();

$tpl->assign ( "AUTH_CHALLENGE", $_SESSION[CACHE][AUTH_CHALLENGE] );
$tpl->assign ( "AUTH_LOGIN",     specialchars ( $_POST[auth_login] ) );
$tpl->assign ( "AUTH_EMPTY",     $cfg[RETURN_MSG][authorization_empty] );

?>