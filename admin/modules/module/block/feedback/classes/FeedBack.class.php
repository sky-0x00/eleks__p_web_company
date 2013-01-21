<?php

class FeedBack extends WorkWithData {

	////////////////////////////////////////////////////////////////////////////////
	//	ябниярбю йкюяяю
	////////////////////////////////////////////////////////////////////////////////

	function FeedBack () {

		global $cfg;

		$this->WorkWithData ();
		$this->table = $cfg['DB']['Table']['prefix'] ."module_feedback";


		return true;
	}

	function getModuleParam () {

		global $cfg;
		
		return $this -> db -> getResultArray ( sprintf( "SELECT * FROM %s", $this->table ) );
	}
	
}

?>