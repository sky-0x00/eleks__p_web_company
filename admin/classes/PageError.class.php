<?php

class PageError extends WorkWithData {

	function PageError() {

		global $cfg;

		$this->WorkWithData();

		$i = 0;
		$this -> fields  = $fields;
		$this -> section = "page_error";
		$this -> table   = $cfg['DB']['Table']['page_error'];

		return true;

	}

	function getPageList() {
		return $this -> db -> getResultArray( sprintf( "SELECT * FROM %s", $this -> table ) );
	}

	function getPageId( $id ) {
		return $this -> db -> getResultArray( sprintf ( "SELECT filename FROM %s WHERE id = %s", $this -> table, $id ) );
	}

	function getList() {
		return $this -> db -> getResultArray( sprintf ( "SELECT * FROM %s", $this -> table ) );
	}
	
	function CreatePage( $name, $filename ) {	
		if ($this -> db -> query ( sprintf ( "INSERT INTO %s (name, filename) VALUES ('%s', '%s')", $this -> table, $name, $filename ) ) == 1 )
			return $this -> db -> last_id();
		else
			return 0;
	}
	
	function UpdatePage( $id, $name, $filename ) {	
		global $cfg;
		
		$Template = $this -> getPageId( $id );
		
		if ( $Template['filename'] !== $filename )
			if ( rename( $cfg['PATH']['error']['tpl'] .$Template[0]['filename'] .".tpl.php", $cfg['PATH']['error']['tpl'] .$filename .".tpl.php" ) )
				return $this -> db -> query ( sprintf ( "UPDATE %s SET name = '%s', filename = '%s' WHERE id = %s", $this -> table, $name, $filename, $id ) );
			else
				return 0;
		else
			return $this -> db -> query ( sprintf ( "UPDATE %s SET name = '%s', filename = '%s' WHERE id = %s", $this -> table, $name, $filename, $id ) );
		
	}
	
	function DeletePage ( $id ) {	
		return $this -> db -> query ( sprintf ( "DELETE FROM %s WHERE id = %s", $this -> table, $id ) );
	}
}

?>