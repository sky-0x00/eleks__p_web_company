<?php

class Section extends WorkWithData {

	function Section () {

		global $cfg;

		$this->WorkWithData ();

		$this->table_sections 	= $cfg[DB][Table][sections];
		$this->table_groups		= $cfg[DB][Table][sections_group];

		return true;

	}

	function GetSectionByName($name) {

		$Section = $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE name = '%s'", $this->table_sections, $name ));
		return $Section[0];
	}

}

?>