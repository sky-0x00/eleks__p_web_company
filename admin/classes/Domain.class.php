<?php

class Domain extends WorkWithData {

	function Domain() {

		global $cfg;

		$this -> WorkWithData();

		$i = 0;
		$this -> fields  	  = $fields;
		$this -> section 	  = "domain";
		$this -> table_domain = $cfg['DB']['Table']['domain'];
		$this -> table_errors = $cfg['DB']['Table']['page_error'];
        
		return true;

	}

	function GetDomainInfo() {
        $DomainInfo = $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s", $this->table_domain) );
        $Error403 	= $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE id = %s LIMIT 1", $this->table_errors, $DomainInfo[0]['page403'] ) );
		$Error404 	= $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE id = %s LIMIT 1", $this->table_errors, $DomainInfo[0]['page404'] ) );
		//$DomainInfo[0]['page403'] = $Error403[0];
		//$DomainInfo[0]['page404'] = $Error404[0];
		
		return $DomainInfo;
	}

}

?>