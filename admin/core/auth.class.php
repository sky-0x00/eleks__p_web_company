<?php

////////////////////////////////////////////////////////////////////////////////
//
//	auth.inc.php - ����� Auth
//
// 	������: 2.1
//
////////////////////////////////////////////////////////////////////////////////
//
//	������������: ����� ����.
//	����� ���������� ���������: ����� ����.
//
//	���� ���������� ���������: 13 ���� 2007 �. 9:28:32
//
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//
//	����� ��������������.
//
////////////////////////////////////////////////////////////////////////////////
class Auth {

	////////////////////////////////////////////////////////////////////////////////
	//
	//	START 1. �������� ������.
	//
	////////////////////////////////////////////////////////////////////////////////
	var $user_id;
	var $user_hash;

	var $authenticate = false;
	var $timeout;
	////////////////////////////////////////////////////////////////////////////////
	//
	//	END 1. �������� ������.
	//
	////////////////////////////////////////////////////////////////////////////////

	//	Constructor
	function Auth () {

		global $sess, $cfg;

		if ( $this->is_authenticated () ) {

			$logout = 0;

			//	���������� ��� ������� ����� � ����������� id � ������ ������ ��� �� ������� ��������
			if ( $this->user_hash != md5 ( $_SERVER[REMOTE_ADDR] . $_SERVER[HTTP_X_FORWARDED_FOR] . $_SERVER[HTTP_USER_AGENT] ) ) {

				$_SESSION[CACHE][RETURN_MSG] = $cfg[RETURN_MSG][standart];
				$logout = 1;

			}

			//	���������� �� ����-����
			if ( $cfg[GENERAL][document_timeout] != 0 and $this->timeout <= time () ) {

				$_SESSION[CACHE][RETURN_MSG] = $cfg[RETURN_MSG][document_timeout];
				$logout = 1;

			}

			if ( $logout == 1 ) {

				$this->authenticate = false;
				$this->logout ();
				page_jump ( $sess->url () );

			}

		} else {

			if ( trim ( $_POST[auth_login] ) == "" ) {

				if ( $_POST[auth_response] ) {

					$_SESSION[CACHE][RETURN_MSG] = $cfg[RETURN_MSG][authorization_error_lp];
					page_jump ( $sess->url () );

				}

			} else {

				if ( !$this->auth_validatelogin () ) {

					$_SESSION[CACHE][RETURN_MSG] = $cfg[RETURN_MSG][authorization_error_lp];

				} else {

					$_SESSION[CACHE][RETURN_MSG] = $cfg[RETURN_MSG][authorization_good];
					$this->user_hash = md5 ( $_SERVER[REMOTE_ADDR] . $_SERVER[HTTP_X_FORWARDED_FOR] . $_SERVER[HTTP_USER_AGENT] );

				}

				page_jump ( $sess->self_url () );

			}

		}

		$this->timeout = time () + $cfg[GENERAL][document_timeout];

	}

	////////////////////////////////////////////////////////////////////////////////
	//
	//	START 2. ������ ������.
	//
	////////////////////////////////////////////////////////////////////////////////
	function logout () {

		unset ( $_SESSION[AUTH], $_SESSION[USER] );

	}

	function is_authenticated () {

		return $this->authenticate;

	}

	function auth_validatelogin () {

		global $cfg;


		//	�������� ����� ��
		if ( isset ( $this->database_class ) ) {

			$db = new $this->database_class;

		}
		$login     = trim ( $_POST[auth_login] );
		$password  = $_POST[auth_password];
		$challenge = $_SESSION[CACHE][AUTH_CHALLENGE];
		$response  = $_POST[auth_response];

		$db->query ( sprintf ( "SELECT HIGH_PRIORITY user_id, password FROM %s WHERE login='%s' AND active = 1", $cfg[DB][Table][users], addslashes ( $login ) ) );
		if ( $db->nf () == 0 ) {

			return false;

		}


		$db->next_record ();
		$user_id = $db->f ( "user_id" );
		$pass    = $db->f ( "password" );   // Password is stored as a md5 hash

		$expected_response = md5 ( "$login:$pass:$challenge" );

		//	����������� ���� � �������� �������� JavaScript
		if ( $response == "" ) {

			if ( md5 ( $password ) != $pass ) {       // md5 hash for non-JavaScript browsers

			return false;

			} else {

				$this->authenticate = true;
				$this->user_id = $user_id;

			}

		}

		//	����������� ���� � �������� ������� JavaScript
		if ( $expected_response != $response ) {

			return false;

		} else {

			$this->authenticate = true;
			$this->user_id = $user_id;

		}

		/* ��������� ���� ���������� ����� */
		$db->query ( sprintf( "UPDATE %s SET last_visit = UNIX_TIMESTAMP() WHERE user_id = %s", $cfg[DB][Table][users], $this->user_id ) );

		/*
		//	���� ������������ �� ������ �� � ���� ������, �� ������ ��� ������
		$this->db->query ( sprintf ( "SELECT HIGH_PRIORITY group_id FROM %s WHERE user_id='%s'", $cfg[DB][Table][groups_users], $user_id ) );
		if ( $this->db->nf () == 0 ) {

		$this->authenticate = false;

		return false;

		}
		*/

		unset ( $_SESSION[CACHE][AUTH_CHALLENGE] );

		return true;

	}

}


////////////////////////////////////////////////////////////////////////////////
//	����� ���������� � ������������ �����.
if ( ERROR_PRINT_INCLUDE_FILENAME != 0 )
echo "Class Auth (file " . basename ( __FILE__ ) . ")<br>";
////////////////////////////////////////////////////////////////////////////////

?>