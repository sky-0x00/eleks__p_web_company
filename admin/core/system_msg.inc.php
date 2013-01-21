<?php

////////////////////////////////////////////////////////////////////////////////
//
//	system_msg.class.php - Системные сообщения
//
// 	Версия: 2.0
//
////////////////////////////////////////////////////////////////////////////////
//
//	Разработчики: Быков Юрий.
//	Автор последнего изменения: Быков Юрий.
//
//	Дата последнего изменения: 30 Июль 2007 г. 11:31:45
//
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
global $cfg;

$cfg[RETURN_MSG][document_timeout]       = "Session timeout, authentification require";
$cfg[RETURN_MSG][standart]               = "Authentification require";
$cfg[RETURN_MSG][password_info]          = "Do not fill &laquo;Password&raquo; field and &laquo;Confirm password&raquo;,\n if you do not want to change it";
$cfg[RETURN_MSG][authorization_empty]    = "Form need to be fill";
$cfg[RETURN_MSG][authorization_good]     = "Authorization OK";
$cfg[RETURN_MSG][authorization_error_lp] = "Authorization failed";
$cfg[RETURN_MSG][cant_del_items]         = "Something data cannot be changed";

$cfg[RETURN_MSG][tune_was_changed]     = "System settings was changed";
$cfg[RETURN_MSG][tune_was_not_changed] = "System settings wasn't changed";
$cfg[RETURN_MSG][tune_file_blocked]    = "System settings file not accessible";

$cfg[RETURN_MSG][need_fields]         = "Fill all fields with \"*\"\n";
$cfg[RETURN_MSG][user_error_exist]    = "Haven't user with this login\n";
$cfg[RETURN_MSG][user_error_password] = "Password incorrect\n";
$cfg[RETURN_MSG][user_was_added]      = "User added to system";
$cfg[RETURN_MSG][user_was_not_added]  = "User don't added to system";

$cfg[RETURN_MSG][group_error_exist]   = "Group with this name already exists\n";
$cfg[RETURN_MSG][group_was_added]     = "Group added";
$cfg[RETURN_MSG][group_was_not_added] = "Group don't added";

$cfg[RETURN_MSG][_was_added]       = "added";
$cfg[RETURN_MSG][_was_not_added]   = "don't added";
$cfg[RETURN_MSG][_was_changed]     = "changed";
$cfg[RETURN_MSG][_was_not_changed] = "don't changed";
$cfg[RETURN_MSG][_was_deleted]     = "removed";
$cfg[RETURN_MSG][_was_not_deleted] = "don't removed";
$cfg[RETURN_MSG][_error_exist]     = "already exists\n";
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//	Вывод информации о подключенном файле.
if ( ERROR_PRINT_INCLUDE_FILENAME != 0 )
	echo "System messages (file " . basename ( __FILE__ ) . ")<br>";
////////////////////////////////////////////////////////////////////////////////

?>