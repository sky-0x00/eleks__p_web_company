<?php

////////////////////////////////////////////////////////////////////////////////
//
//	page.inc.php - page managment functions
//
// 	Версия: 2.0
//
////////////////////////////////////////////////////////////////////////////////
//
//	Разработчики: Быков Юрий.
//	Автор последнего изменения: Быков Юрий.
//
//	Дата последнего изменения: 31 March 2006 20:00:41
//
////////////////////////////////////////////////////////////////////////////////

function page_open ( $feature ) {
	
	//	enable sess and all dependent features.
	if ( isset ( $feature[sess] ) ) {
		
		global $sess;
		
		$sess = new $feature[sess];
		
		//	the auth feature depends on sess
		if ( isset ( $feature[auth] ) ) {
			
			if ( !isset ( $_SESSION[AUTH] ) )
				$_SESSION[AUTH] = new $feature[auth];
			else
				$_SESSION[AUTH]->Auth ();
			
		    //	the user feature depends on auth and sess
		    if ( isset ( $feature[user] ) and $_SESSION[AUTH]->is_authenticated () and !isset ( $_SESSION[USER] ) )
				$_SESSION[USER] = new $feature[user] ( $_SESSION[AUTH]->user_id );
			
		}
		
	}
	
}

function page_close ( $page = "" ) {
	
	global $sess, $cfg;
	
	$_SESSION[AUTH]->logout ();
	$sess->sess_delete ();
	
	$page = $page != "" ? $page : $cfg[PATH][www_root];
	page_jump ( $page );
	
}

////////////////////////////////////////////////////////////////////////////////
//	Вывод информации о подключенном файле.
if ( ERROR_PRINT_INCLUDE_FILENAME != 0 )
	echo "Page managment functions (file " . basename ( __FILE__ ) . ")<br>";
////////////////////////////////////////////////////////////////////////////////

?>