<?php

////////////////////////////////////////////////////////////////////////////////
//
//	Класс для работы со списком групп.
//
////////////////////////////////////////////////////////////////////////////////

class GroupsList extends WorkWithData {

	//	Constructor
	function GroupsList () {

		global $cfg;

		$this->WorkWithData ();
		$this->table = $cfg[DB][Table][groups];
		$this->table_groups = $cfg[DB][Table][groups];
		return true;

	}

	function getGroupList () {

		return $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s ORDER BY date_add ASC", $this->table_groups ));
	}
	
	function GetGroup ($id_group) {

		return $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE group_id = %s", $this->table_groups, $id_group ));
	}
	
	function DeleteGroup ($id_group) {
		
		$Group = $this -> GetGroup($id_group);
		if ($Group[0][no_del]==1) {
			$message = "Ошибка. Данную группу невозможно удалить.";
			$success = 0;
		}
		elseif (!is_array($Group)) {
			$message = "Ошибка. Данной группы не существует.";
			$success = 0;
		}
		elseif ($this -> db -> query ( sprintf ("DELETE FROM %s WHERE group_id = %s", $this->table_groups, $id_group ))) {
			$message = "Группа была успешно удалена.";
			$success = 1;
		}
		else {
			$message = "При удалении группы возникла ошибка.";
			$success = 0;
		}
		
		return "{success: \"" . $success . "\", message: \"" . PrintJSString($message) . "\"}";
	}

	function CreateGroup ($name, $admin) {
	
		$this -> db -> query ( sprintf ("INSERT INTO %s (name, admin, date_add, no_del) VALUES ('%s', %s, UNIX_TIMESTAMP(), 0)", $this->table_groups, $name, $admin ));
		
		return $this -> db -> last_id();
	}
	
	function UpdateGroup ($id_group, $name, $admin) {
		
		if ($this -> db -> query ( sprintf ("UPDATE %s SET name = '%s', admin = %s WHERE group_id = %s", $this->table_groups, $name, $admin, $id_group ))) {
			$message = "Изменения сохранены.";
			$success = 1;
		}
		else {
			$message = "Ошибка. Невозможно применить изменения.";
			$success = 0;
		}
		
		return "{success: \"" . $success . "\", message: \"" . PrintJSString($message) . "\"}";
	}
}

////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//	Вывод информации о подключенном файле.
if ( ERROR_PRINT_INCLUDE_FILENAME != 0 )
	echo "Class GroupsList (file " . basename ( __FILE__ ) . ")<br>";
////////////////////////////////////////////////////////////////////////////////

?>