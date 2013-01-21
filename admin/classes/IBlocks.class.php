<?php

class IBlock extends WorkWithData {

	////////////////////////////////////////////////////////////////////////////////
	//	СВОЙСТВА КЛАССА
	////////////////////////////////////////////////////////////////////////////////

	//	Constructor
	function IBlock () {

		global $cfg;

		$this->WorkWithData ();
		$this->section	= "iblock";
		$this->table	= $cfg[DB][Table][prefix]."iblock";

		return true;

	}
	////////////////////////////////////////////////////////////////////////////////


	function getBlockList() {

		return $this->db->getResultArray ( sprintf( "SELECT id, name, description, content FROM %s", $this->table ) );
	}


	function getBlockInfo ($id) {

		return $this->db->getResultArray ( sprintf( "SELECT * FROM %s WHERE id = %s", $this->table, $id ) );
	}
	
	function getBlockContent ($id) {
		
		$content = $this->db->getResultArray ( sprintf( "SELECT `content` FROM %s WHERE id = %s", $this->table, $id ) );
		
		return ($content) ? $content[0]['content'] : "";
	}
	
	function saveBlockContent ($id, $content) {
		
		$sql = sprintf("UPDATE %s SET `content` = '%s' WHERE id = %s", $this->table, $content, $id);
		
		if ($this->db->query($sql))
			return "Сохранено.";
		else
			return "Ошибка.";
	}
	
	
	function createBlock ($name, $description, $content, $active) {
		
		$sql = sprintf("INSERT INTO %s SET 
							`name` = '%s',
							`description` = '%s',
							`content` = '%s',
							`active` = '%s';", 
						$this->table, $name, $description, $content, $active);
		
		if ($this->db->query($sql))
			return "Сохранено.";
		else
			return "Ошибка.";
	}
	
	
	function updateBlock ($id, $name, $description, $content, $active) {
		
		$sql = sprintf("UPDATE %s SET 
							`name` = '%s',
							`description` = '%s',
							`content` = '%s',
							`active` = '%s' 
						WHERE id = %s", 
						$this->table, $name, $description, $content, $active, $id);
		
		if ($this->db->query($sql))
			return "Сохранено.";
		else
			return "Ошибка.";
	}


	function IBlockDelete ( $id ) {

		return $this -> db -> query ( sprintf( "DELETE FROM %s WHERE id = %s", $this->table, $id ) );
	}


	////////////////////////////////////////////////////////////////////////////////

	function getData ( $name ) {

		$rec = $this->db->getResultArray ( sprintf ( "SELECT active, content FROM %s WHERE name = '%s'", $this->table, trim(mysql_real_escape_string($name)) ) );

		if ($rec[0][active] == "Y") {

			return $rec[0][content];

		} else {


		}
	}

	////////////////////////////////////////////////////////////////////////////////



}
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//	Вывод информации о подключенном файле.
if ( ERROR_PRINT_INCLUDE_FILENAME != 0 )
echo "Class Blocks (file " . basename ( __FILE__ ) . ")<br>";
////////////////////////////////////////////////////////////////////////////////

?>