<?php

////////////////////////////////////////////////////////////////////////////////
//	Класс "Объекты"
////////////////////////////////////////////////////////////////////////////////

class Objects extends WorkWithData {

	////////////////////////////////////////////////////////////////////////////////
	//	Свойства класса
	////////////////////////////////////////////////////////////////////////////////
	
	var $table_objects;
	var $table_prices;
	var $table_photos;
	var $table_types;
	
	var $path_tmp;
	var $path_src;
	var $path_server;
		
	////////////////////////////////////////////////////////////////////////////////
	//	Конструктор
	////////////////////////////////////////////////////////////////////////////////
	
	function Objects () {

		global $cfg;

		$this -> WorkWithData ();
		
		$this -> table_objects 	= $cfg['DB']['Table']['prefix']."module_objects";
		$this -> table_photos	= $cfg['DB']['Table']['prefix']."module_object_photos";
		$this -> table_types	= $cfg['DB']['Table']['prefix']."module_object_types";
		
		$this -> path_src = "/images/objects/";
		$this -> path_server = $cfg['PATH']['root'] . "images/objects/";
		$this -> path_tmp = $cfg['PATH']['root'] . "images/temp/";
		
		return true;
	}
	
	function GetTypes () {
		
		$types = array();
		
		$sql = sprintf("SELECT `id_type`, `type` 
						FROM %s ORDER BY `id_type` ASC", 
						$this -> table_types, $operation);
		
		$_types = $this -> db -> getResultArray ($sql);
		
		if (is_array($_types) && (count($_types)>0)) {
			for ($i=0; $i<count($_types); $i++) {
				$types[$i]['value'] = $_types[$i]['id_type'];
				$types[$i]['caption'] = $_types[$i]['type'];
			}
		}
		
		return $types;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение информации об объекте
	//	$id_object - id объекта
	////////////////////////////////////////////////////////////////////////////////
	
	function GetObject ($id_object, $get_siblings = false) {
		
		$sql = sprintf("SELECT O.*, T.alias, T.type
						FROM %s O INNER JOIN %s T ON O.id_type = T.id_type
						WHERE O.id_object = %s LIMIT 1;", 
						$this->table_objects, $this->table_types, $id_object);
		
		$object = $this -> db -> getResultArray ($sql);
		
		if ($object) {
			
			$image = glob($this->path_server . $object[0]['id_object'] . "/" . $object[0]['id_object'] . ".*", 			GLOB_NOSORT);
						
			if ($get_siblings) {
			
				$sql = sprintf("SELECT `id_object` FROM %s 
								WHERE (`id_type` = %s) AND (`id_object` < %s)
								ORDER BY `id_object` DESC LIMIT 1;", 
								$this->table_objects, $object[0]['id_type'], $id_object);
						
				$prev = $this -> db -> getResultArray ($sql);
				
				$object[0]['prev'] = ($prev) ? $prev[0]['id_object'] : false;
				
				$sql = sprintf("SELECT `id_object` FROM %s 
								WHERE (`id_type` = %s) AND (`id_object` > %s)
								ORDER BY `id_object` ASC LIMIT 1;", 
								$this->table_objects, $object[0]['id_type'], $id_object);
						
				$next = $this -> db -> getResultArray ($sql);
				
				$object[0]['next'] = ($next) ? $next[0]['id_object'] : false;
			}
			
			$object[0]['picture'] 	= ($image) ? basename($image[0]) : "";			
			$object[0]['image'] 	= ($image) ? ($this->path_src.$object[0]['id_object']."/".$object[0]['picture']) : "";
			
			$object[0]['photos'] = $this -> GetObjectPhotos($id_object);
			
			return $object[0];
		}
		else {
			return array();
		}
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение информации о текущем объекте в опр. категории
	//	$id_type - id типа объекта
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCurrentObject ($id_type) {
		
		$sql = sprintf("SELECT * FROM %s WHERE `id_type` = %s 
						ORDER BY `id_object` DESC LIMIT 1;", 
						$this->table_objects, $id_type);
		
		$object = $this -> db -> getResultArray ($sql);
		
		if ($object) {
			
			$image = glob($this->path_server . $object[0]['id_object'] . "/" . $object[0]['id_object'] . ".*", 			GLOB_NOSORT);
			
			$object[0]['picture'] 	= ($image) ? basename($image[0]) : "";			
			$object[0]['image'] 	= ($image) ? ($this->path_src.$object[0]['id_object']."/".$object[0]['picture']) : "";
			
			$object[0]['photos'] = $this -> GetObjectPhotos($id_object);
			
			return $object[0];
		}
		else {
			return false;
		}
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение списка всех объектов
	//	$order - порядок сортировки по id ("DESC" или "ASC")
	////////////////////////////////////////////////////////////////////////////////
	
	function GetObjectsList ($order = "DESC") {
		
		$objects = array();
		
		$objects[0]['value'] = 0;
		$objects[0]['caption'] = "";
		
		$sql = sprintf("SELECT `id_object`, `name` FROM %s 
						ORDER BY `id_object` %s;", 
						$this -> table_objects, $order);
		
		$_objects = $this -> db -> getResultArray ($sql);
		
		if (is_array($_objects) && (count($_objects)>0)) {
			for ($i=0; $i<count($_objects); $i++) {
				$objects[$i+1]['value'] = $_objects[$i]['id_object'];
				$objects[$i+1]['caption'] = $_objects[$i]['name'];
			}
		}
		
		return $objects;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение списка объектов опр. типа
	//	$type - тип объекта
	////////////////////////////////////////////////////////////////////////////////
	
	function GetObjects ($type, $primary = false, $from = 0, $count = 0) {
		
		$limits = ($count>0) ? ("LIMIT ".$from.", ".$count) : "";
		
		$cond = ($primary) ? "AND (O.primary>0)" : "";
		
		$sql = sprintf("SELECT O.id_object, O.name, O.town, O.short_description, P.id_photo, T.type
						FROM %s O RIGHT JOIN %s T ON O.id_type = T.id_type
						LEFT JOIN %s P ON O.id_object = P.id_object
						WHERE (T.alias = '%s') %s GROUP BY O.id_object %s;",
						$this->table_objects, $this->table_types, $this->table_photos, $type, $cond, $limits);
						
		$objects = $this -> db -> getResultArray($sql);
		
		if ($objects) {
			
			for ($i=0; $i<count($objects); $i++) {
			
				$picture 	= glob($this->path_server . $objects[$i]['id_object'] . "/" . $objects[$i]['id_object'] . ".*", 			GLOB_NOSORT);
				$image 		= glob($this->path_server . $objects[$i]['id_object'] . "/photo_" . $objects[$i]['id_photo'] . ".*", 		GLOB_NOSORT);
				$thumb 		= glob($this->path_server . $objects[$i]['id_object'] . "/photo_" . $objects[$i]['id_photo'] . "_thumb.*", 	GLOB_NOSORT);
				
				$objects[$i]['picture'] = 	($picture) 	? ($this->path_src.$objects[$i]['id_object']."/".basename($picture[0])) : "";
				$objects[$i]['photo'] 	= 	($image) 	? ($this->path_src.$objects[$i]['id_object']."/".basename($image[0])) 	: "";
				$objects[$i]['thumb'] 	= 	($thumb) 	? ($this->path_src.$objects[$i]['id_object']."/".basename($thumb[0])) 	: "";
			}
		}
		
		return $objects;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение количества объектов опр. типа
	//	$type - тип объекта
	////////////////////////////////////////////////////////////////////////////////
	
	function GetObjectsCount ($type) {
		
		$sql = sprintf("SELECT count(1) AS `count` FROM %s O 
						INNER JOIN %s T ON O.id_type = T.id_type
						WHERE T.alias = '%s'",
						$this->table_objects, $this->table_types, $type);
		
		$count = $this -> db -> getResultArray($sql);
		
		return ($count) ? $count[0]['count'] : 0;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение имени файла картинки объекта
	//	$id_object - id объекта
	////////////////////////////////////////////////////////////////////////////////
	
	function GetObjectPicture ($id_object) {
		
		return basename(glob($this->path_server . $id_object . "/" . $id_object . ".*", GLOB_NOSORT));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Создание нового объекта
	//	$id_type - id типа
	//	$name - имя
	//	$town - место нахождения (город)
	//	$short_description - краткое описание
	//	$description - описание
	//	$primary - ключевой проект (1 или 0)
	////////////////////////////////////////////////////////////////////////////////
	
	function CreateObject ($id_type, $name, $town, $short_description, $description, $primary) {
		
		$sql = sprintf("INSERT INTO %s (`id_type`, `name`, `town`, `short_description`, `description`, `primary`) 
						VALUES (%s, '%s', '%s', '%s', '%s', %s);", 
						$this->table_objects, $id_type, $name, $town, $short_description, $description, $primary);
		
		$this -> db -> query ($sql);
			
		if ($text = $this -> db -> last_id()) {
			$result = "success";
		}			
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно добавить проект.";
		}
		
		$objects = $this -> GetObjectsList("DESC");		
		
		return array("result" => $result, "text" => $text, "objects" => $objects);
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Обновление объекта
	//	$id_object - id объекта
	//	$id_type - id типа площади
	//	$name - имя
	//	$town - место нахождения (город)
	//	$short_description - краткое описание
	//	$description - описание
	//	$primary - ключевой проект (1 или 0)
	////////////////////////////////////////////////////////////////////////////////
	
	function UpdateObject ($id_object, $id_type, $name, $town, $short_description, $description, $primary) {
		
		$sql = sprintf("UPDATE %s SET						
							`id_type` = %s,
							`name` = '%s',  
							`town` = '%s',  
							`short_description` = '%s', 
							`description` = '%s',
							`primary` = %s
						WHERE `id_object` = %s;", 
						$this -> table_objects, $id_type, $name, $town, $short_description, $description, $primary, $id_object);
		
		if ($this -> db -> query ($sql)) {			
			$result = "success";
			$text = 1;
		}			
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно сохранить проект.";
		}
		
		$objects = $this -> GetObjectsList("DESC");		
		
		return array("result" => $result, "text" => $text, "objects" => $objects);
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Удаление объекта
	//	$id_object - id удаляемого объекта
	////////////////////////////////////////////////////////////////////////////////
	
	function DeleteObject ($id_object) {
		
		$sql = sprintf("DELETE FROM %s WHERE `id_object` = %s;", 
						$this -> table_objects, $id_object);
		
		if ($this -> db -> query ($sql)) {
			
			$sql = sprintf("DELETE FROM %s WHERE `id_object` = %s;", 
							$this -> table_photos, $id_object);
			
			$this -> db -> query ($sql);
			
			$images = glob($this->path_server . $id_object . "/*.*", GLOB_NOSORT);
			
			if ($images) {
				
				for ($i=0; $i<count($images); $i++)
					@unlink($images[$i]);
				
				@rmdir($this->path_server . $id_object . "/");							
			}
				
			$result = "success";
			$text = "Удалено.";
		}					
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно удалить проект.";
		}
		
		$objects = $this -> GetObjectsList("DESC");		
		
		return array("result" => $result, "text" => $text, "objects" => $objects);
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение фотографий объекта
	//	$id_object - id объекта
	////////////////////////////////////////////////////////////////////////////////
	
	function GetObjectPhotos ($id_object) {
		
		$sql = sprintf("SELECT `id_photo` FROM %s WHERE `id_object` = %s", 
						$this->table_photos, $id_object);
		
		if ($photos = $this -> db -> getResultArray ($sql))	{			
			for ($j=0; $j<count($photos); $j++) {			
				
				$image = glob($this->path_server . $id_object . "/photo_" . $photos[$j]['id_photo'] . ".*", 		GLOB_NOSORT);
				$thumb = glob($this->path_server . $id_object . "/photo_" . $photos[$j]['id_photo'] . "_thumb.*", 	GLOB_NOSORT);
				
				$photos[$j]['photo'] = ($image) ? ($this->path_src.$id_object."/".basename($image[0])) : "";
				$photos[$j]['thumb'] = ($thumb) ? ($this->path_src.$id_object."/".basename($thumb[0])) : "";
			}
		}
		
		return $photos;
	}
			
	////////////////////////////////////////////////////////////////////////////////
	//	Добавление новой фотографии
	//	$id_object - id объекта
	////////////////////////////////////////////////////////////////////////////////
	
	function CreatePhoto ($id_object) {
		
		$sql = sprintf("INSERT INTO %s SET `id_object` = %s;", 
						$this->table_photos, $id_object);
		
		$this -> db -> query ($sql);
		
		if ($text = $this -> db -> last_id()) {
			$result = "success";
		}			
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно добавить фотографию.";
		}
		
		return array("result" => $result, "text" => $text);
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Удаление фотографии
	//	$id_photo - id фотографии
	////////////////////////////////////////////////////////////////////////////////
	
	function DeletePhoto ($id_photo) {
		
		$sql = sprintf("SELECT `id_object` FROM %s 
						WHERE `id_photo` = %s LIMIT 1;", 
						$this->table_photos, $id_photo);
		
		if ($object = $this -> db -> getResultArray($sql)) {
			
			$id_object = $object[0]['id_item'];
			
			$sql = sprintf("DELETE FROM %s WHERE `id_photo` = %s;", 
							$this->table_photos, $id_photo);
			
			if ($this -> db -> query ($sql)){
				$result = "success";
				$text = "Удалено.";
				
				$image = glob($this->path_server . $id_object . "/photo_" . $id_photo . ".*", GLOB_NOSORT);
				
				if ($image)
					@unlink($image[0]);
			}			
			else {
				$result = "error";
				$text	= "Ошибка. Невозможно удалить фотографию с id = " . $id_photo . ".";
			}
		}
		else {
			$result = "error";
			$text	= "Ошибка. Фотография не найдена.";
		}
		
		return array2json( array("result" => $result, "text" => $text) );
	}
	
}

?>