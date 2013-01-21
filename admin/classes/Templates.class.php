<?php
////////////////////////////////////////////////////////////////////////////////
//
//	Клаcc для работы с шаблонами.
//
////////////////////////////////////////////////////////////////////////////////

class Templates extends WorkWithData {

	////////////////////////////////////////////////////////////////////////////////
	//	CВОЙCТВА КЛАCCА
	////////////////////////////////////////////////////////////////////////////////

	//	Constructor
	function Templates () {

		global $cfg;

		$this->WorkWithData ();

		$i = 0;
		$fields[$i++] = array ( "name" => "template_id", "description" => "ID запиcи",        "html_type" => "hidden", "no_empty" => 1, "in_list" => 0, "in_select" => "id" );
		$fields[$i++] = array ( "name" => "name",        "description" => "Название шаблона", "html_type" => "text",   "no_empty" => 1, "in_list" => 1, "in_select" => "name" );
		$fields[$i++] = array ( "name" => "filename",    "description" => "Файл шаблона",     "html_type" => "text",   "no_empty" => 1, "in_list" => 1 );
		$fields[$i++] = array ( "name" => "date_add",    "description" => "Дата добавления",  "html_type" => "date",   "no_empty" => 1, "in_list" => 0, "autofill" => time () );

		$this->fields  			= $fields;
		$this->section 			= "templates";
		$this->table 			= $cfg['DB']['Table']['templates'];
		$this->table_templates	= $cfg['DB']['Table']['templates'];
		$this->table_groups 	= $cfg['DB']['Table']['templates_group'];
		$this->listOrderBy 		= "ORDER BY name ASC";

		return true;

	}

	////////////////////////////////////////////////////////////////////////////////
	//	МЕТОДЫ КЛАCCА

	function getTemplateList () {

		return $this -> db -> getResultArray ( sprintf( "SELECT * FROM %s ORDER BY template_id ASC", $this->table_templates ));
	}


	function getGroupList () {

		return $this -> db -> getResultArray ( sprintf( "SELECT * FROM %s ORDER BY id ASC", $this->table_groups ));
	}

	function getCntGroup () {

		return $this -> db-> getResultArray ( sprintf( "SELECT count(id) AS cnt FROM %s", $this->table_groups ));
	}
	
	function getTemplateByID ($id_template) {
	
		$Template = $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE template_id = %s", $this->table_templates, $id_template));
		return $Template[0];
	}
	
	function getTemplateByGroup ($group) {

		return $this -> db -> getResultArray ( sprintf( "SELECT * FROM %s WHERE `group` = %s", $this->table_templates, $group ));
	}

	function CreateTemplate ($name, $filename, $group, $css, $description) {
	
		$this -> db -> query ( sprintf ("INSERT INTO %s (`group`, name, description, filename, css, date_update) VALUES (%s, '%s', '%s', '%s', '%s', UNIX_TIMESTAMP())", $this->table_templates, $group, $name, $description, $filename, $css ));
		
		return $this -> db -> last_id();
	}
	
	function UpdateTemplate ($id_template, $name, $filename, $group, $css, $description) {
		
		global $cfg;
		
		$Template = $this -> getTemplateByID($id_template);
		
		if ($Template[filename]!==$filename)
			if (rename($cfg[PATH][skins][tpl] . $Template[filename] . ".tpl.php", $cfg[PATH][skins][tpl] . $filename . ".tpl.php"))
				return $this -> db -> query ( sprintf ("UPDATE %s SET `group` = %s, name = '%s', description = '%s', filename = '%s', css = '%s', date_update = UNIX_TIMESTAMP() WHERE template_id = %s", $this->table_templates, $group, $name, $description, $filename, $css, $id_template ));
			else
				return 0;
		else
			return $this -> db -> query ( sprintf ("UPDATE %s SET `group` = %s, name = '%s', description = '%s', filename = '%s', css = '%s', date_update = UNIX_TIMESTAMP() WHERE template_id = %s", $this->table_templates, $group, $name, $description, $filename, $css, $id_template ));
	}
	
	function CreateGroup ($name) {
		
		$this -> db -> query ( sprintf ("INSERT INTO %s (name) VALUES ('%s')", $this->table_groups, $name ));
		
		return $this -> db -> last_id();
	}
	
	function DeleteGroup ($id_group) {
		
		$Templates = $this -> getTemplateByGroup($id_group);
		
		if (is_array($Templates))
			for ($i=0; $i<count($Templates); $i++)
				$this -> DeleteTemplate($Templates[$i][template_id]);
		
		return $this -> db -> query ( sprintf ("DELETE FROM %s WHERE id = %s", $this->table_groups, $id_group ));
	}
	
	function DeleteTemplate ($id_template) {
		
		global $cfg;
		$Template = $this -> getTemplateByID ($id_template);
		
		if (unlink($cfg[PATH][skins][tpl].$Template[filename].".tpl.php"))	
			return $this -> db -> query ( sprintf ("DELETE FROM %s WHERE template_id = %s", $this->table_templates, $id_template ));
		else
			return 0;
	}
	
	function UpdateGroup ($id_group, $name) {
	
		return $this -> db -> query ( sprintf ("UPDATE %s SET name = '%s' WHERE id = %s", $this->table_groups, $name, $id_group));
	}
}
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//	Вывод информации о подключенном файле.
if ( ERROR_PRINT_INCLUDE_FILENAME != 0 )
	echo "Class Templates (file " . basename ( __FILE__ ) . ")<br>";
////////////////////////////////////////////////////////////////////////////////

?>