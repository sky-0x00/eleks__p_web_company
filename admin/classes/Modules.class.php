<?php

////////////////////////////////////////////////////////////////////////////////
//
//	Modules.class.php - клаcc Modules
//
// 	Верcия: 1.0
//
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
//
//	Клаcc для работы c модулями.
//
////////////////////////////////////////////////////////////////////////////////

class Modules extends WorkWithData {

	//	Constructor
	function Modules () {

		global $cfg;

		$this->WorkWithData ();

		$this->fields  = $fields;
		$this->section = "modules";
		$this->table   = $cfg[DB][Table][modules];
		$this->listOrderBy = "";

		return true;
	}

	////////////////////////////////////////////////////////////////////////////////
	//	МЕТОДЫ КЛАCCА
	function GetModulesFilename ( $template_id ) {

		global $cfg;

		return $this->db->getResultArray ( sprintf ( "SELECT HIGH_PRIORITY * FROM %s a, %s b WHERE a.module_id=b.module_id AND b.template_id='%s'", $this->table, $cfg[DB][Table][templates_modules], $template_id ) );

	}

	function getModulesList () {

		global $cfg;

		return $this->db->getResultArray ( sprintf( "SELECT id, name, alias, `desc` FROM %s WHERE active = 'Y' ", $this->table ) );
	}

	function getModuleInfo ($id) {

		global $cfg;

		return $this->db->getResultArray ( sprintf( "SELECT * FROM %s WHERE id = %s ", $this->table, $id ) );
	}

	function getModuleId ($id) {

		global $cfg;

		return $this->db->getResultArray ( sprintf( "SELECT * FROM %s WHERE page_id = %s", $cfg[DB][Table][pages_modules], $id ) );
	}

	function getModulePage ($id) {

		global $cfg;

		return $this->db->getResultArray ( sprintf( "SELECT p.*, m.* FROM %s p INNER JOIN %s m ON m.id = p.module_id WHERE page_id = %s", $cfg[DB][Table][pages_modules], $cfg[DB][Table][modules], $id ) );
	}


}
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//	Вывод информации о подключенном файле.
if ( ERROR_PRINT_INCLUDE_FILENAME != 0 )
echo "Class Modules (file " . basename ( __FILE__ ) . ")<br>";
////////////////////////////////////////////////////////////////////////////////

?>