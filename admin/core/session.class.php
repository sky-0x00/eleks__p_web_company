<?php

////////////////////////////////////////////////////////////////////////////////
//
//	session.class.php - класс Session
//
// 	Версия: 2.0
//
////////////////////////////////////////////////////////////////////////////////
//
//	Разработчики: Быков Юрий.
//	Автор последнего изменения: Быков Юрий.
//
//	Дата последнего изменения: 31 March 2006 18:52:57
//
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//
//	Класс для работы с сессиями.
//
////////////////////////////////////////////////////////////////////////////////
class Session {
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	START 1. Свойства класса.
	//
	////////////////////////////////////////////////////////////////////////////////
	var $sess_id;
	////////////////////////////////////////////////////////////////////////////////
	//
	//	END 1. Свойства класса.
	//
	////////////////////////////////////////////////////////////////////////////////
	
	//	Constructor
	function Session () {
		
		$this->get_id ();
		$this->sess_start ();
		
		if ( ( !$_GET[sess_id] ) and ( !$_POST[sess_id] ) ) {
			
			page_jump ( $this->self_url () );
			
		}
		
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	START 2. Методы класса.
	//
	////////////////////////////////////////////////////////////////////////////////
	function get_id () {
		
		$this->sess_id = isset ( $_GET[sess_id] ) ? $_GET[sess_id] : ( isset ( $_POST[sess_id] ) ? $_POST[sess_id] : ( generate_md5 () ) );
		
		return $this->sess_id;
		
	}
	
	function sess_start () {
		
		session_id ( $this->sess_id );
		session_start ();
		
		return true;
		
	}
	
	function sess_delete () {
		
		// Unset all of the session variables.
		session_unset ();
		// Finally, destroy the session.
		session_destroy ();
		
		return true;
		
	}
	
	function url ( $url = "" ) {
		
		// Remove existing session info from url
		$url = ereg_replace ( "([&?])" . "sess_id=" . $this->sess_id . "(&|$)", "\\1", $url );
		
		// Remove trailing ?/& if needed
		$url = ereg_replace ( "[&?]+$", "", $url );
		
		$url .= ( strpos ( $url, "?" ) !== false ?  "&" : "?" ) . "sess_id=" . $this->sess_id;
		
		// Encode naughty characters in the URL
		$url = str_replace ( array ( "<", ">", " ", "\"", "'" ), array ( "%3C", "%3E", "+", "%22", "%27" ), $url );
		
		return $url;
		
	}
	
	function def_url () {
		
		return $_SERVER[PHP_SELF] . "?sess_id=" . $this->sess_id;
		
	}
	
	function self_url ( $var = "" ) {
		
		$url = $this->url ( $_SERVER[PHP_SELF] . ( ( isset ( $_SERVER[QUERY_STRING] ) and ( "" != $_SERVER[QUERY_STRING] ) ) ? "?" . $_SERVER[QUERY_STRING] : "" ) );
		
		if ( isset ( $var ) and $var != "" ) {
			
			if ( is_array ( $var ) ) {
				
				while ( list ( , $value ) = each ( $var ) ) {
					
					// Remove existing var info from url
					$url = ereg_replace ( "([&?])" . $value . "=" . $_GET[$value] . "(&|$)", "\\1", $url );
					// Remove trailing ?/& if needed
					$url = ereg_replace ( "[&?]+$", "", $url );
					
				}
				
			} else {
				
				// Remove existing var info from url
				$url = ereg_replace ( "([&?])" . $var . "=" . $_GET[$var] . "(&|$)", "\\1", $url );
				// Remove trailing ?/& if needed
				$url = ereg_replace ( "[&?]+$", "", $url );
				
			}
			
		}
		
		return $url;
		
	}
	
	function hidden_session () {
		
		printf ( "<input type=\"hidden\" name=\"sess_id\" value=\"%s\">\n", $this->sess_id );
		
	}
	
	function add_query ( $qarray ) {
		
		if ( isset ( $_SERVER[QUERY_STRING] ) and ( "" != $_SERVER[QUERY_STRING] ) ) {
			
			$sep_char = "&";
			
		} else {
			
			$sep_char = "?";
			
		}
		
		$qstring = "";
		
		while ( list ( $k, $v ) = each ( $qarray ) ) {
			
			$qstring .= $sep_char . urlencode ( $k ) . "=" . urlencode ( $v );
			$sep_char = "&";
			
		}
		
		return $qstring;
		
	}
	////////////////////////////////////////////////////////////////////////////////
	//
	//	END 2. Методы класса.
	//
	////////////////////////////////////////////////////////////////////////////////
	
}
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//	Вывод информации о подключенном файле.
if ( ERROR_PRINT_INCLUDE_FILENAME != 0 )
	echo "Class Session (file " . basename ( __FILE__ ) . ")<br>";
////////////////////////////////////////////////////////////////////////////////

?>