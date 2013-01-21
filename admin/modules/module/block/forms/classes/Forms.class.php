<?php

class Forms extends WorkWithData {

	////////////////////////////////////////////////////////////////////////////////
	//	ябниярбю йкюяяю
	////////////////////////////////////////////////////////////////////////////////

	function Forms () {

		global $cfg;

		$this->WorkWithData ();
		$this->table_form 				= $cfg[DB][Table][prefix]."module_form";
		$this->table_form_fields 		= $cfg[DB][Table][prefix]."module_form_fields";
		$this->table_form_fields_type 	= $cfg[DB][Table][prefix]."module_form_fields_type";

		return true;
	}

	function getFormsList() {

		return $this -> db -> getResultArray ( sprintf( "SELECT F.*, count(FI.id) AS `fields` FROM %s F LEFT JOIN %s FI ON FI.form_id = F.id GROUP BY F.id", $this->table_form,  $this->table_form_fields ) );
	}

	function getDetailForms ($id) {

		return $this -> db -> getResultArray ( sprintf( "SELECT * FROM %s WHERE id = %s", $this->table_form, $id ) )	;
	}


	function getDetailFields ($id) {

		return $this -> db -> getResultArray ( sprintf( "SELECT * FROM %s WHERE form_id = %s", $this->table_form_fields, $id ) );
	}
	
	function getFieldsType ($id) {
	
		return $this -> db -> getResultArray ( sprintf( "SELECT T.* FROM %s T INNER JOIN %s F ON T.id = F.type WHERE F.form_id = %s", $this->table_form_fields_type, $this->table_form_fields, $id ) );
	}
	
	function getFieldsTypes () {
	
		return $this -> db -> getResultArray ( sprintf( "SELECT * FROM %s", $this->table_form_fields_type ) );
	}
}

?>