<?php

////////////////////////////////////////////////////////////////////////////////
//
//	Класс для работы со списком пользователей.
//
////////////////////////////////////////////////////////////////////////////////

class UsersList extends WorkWithData {

	function UsersList () {

		global $cfg;

		$this->WorkWithData ();

		$this->table_users  		= $cfg[DB][Table][prefix]."users";
		$this->table_groups 		= $cfg[DB][Table][prefix]."users_groups";
		$this->table_groups_users 	= $cfg[DB][Table][prefix]."users_in_groups";

		return true;

	}

	function getUsersList () {

		return $this->db->getResultArray ( sprintf( "SELECT * FROM %s", $this->table_users ) );
	}


	function getUsersInfo ($id) {

		return $this->db->getResultArray ( sprintf( "SELECT * FROM %s WHERE user_id = %s ", $this->table_users, $id ) );
	}

	function DeleteUser ($id) {

		$this -> db -> query ( sprintf ("DELETE FROM %s WHERE user_id = %s", $this->table_groups_users, $id ));
	
		return $this -> db-> query ( sprintf ("DELETE FROM %s WHERE user_id = %s", $this->table_users, $id ));
	}

}
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//	Вывод информации о подключенном файле.
if ( ERROR_PRINT_INCLUDE_FILENAME != 0 )
echo "Class UsersList (file " . basename ( __FILE__ ) . ")<br>";
////////////////////////////////////////////////////////////////////////////////

?>