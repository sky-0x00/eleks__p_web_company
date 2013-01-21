<?php

////////////////////////////////////////////////////////////////////////////////
//	Класс "Каталог"
////////////////////////////////////////////////////////////////////////////////

class Catalog extends WorkWithData {

	////////////////////////////////////////////////////////////////////////////////
	//	Свойства класса
	////////////////////////////////////////////////////////////////////////////////
	
	var $table_cats;
	var $table_items;
	var $table_fields;
	var $table_photos;
	var $table_types;
		
	var $path_src;
	var $path_server;
		
	////////////////////////////////////////////////////////////////////////////////
	//	Конструктор
	////////////////////////////////////////////////////////////////////////////////
	
	function Catalog () {

		global $cfg;

		$this -> WorkWithData ();
		
		$this -> table_settings 	= $cfg['DB']['Table']['prefix']."module_catalog";
		$this -> table_cats 		= $cfg['DB']['Table']['prefix']."module_catalog_cats";
		$this -> table_items 		= $cfg['DB']['Table']['prefix']."module_catalog_items";
		$this -> table_fields		= $cfg['DB']['Table']['prefix']."module_catalog_fields";
		$this -> table_properties	= $cfg['DB']['Table']['prefix']."module_catalog_properties";
		$this -> table_photos		= $cfg['DB']['Table']['prefix']."module_catalog_photos";
		$this -> table_orders		= $cfg['DB']['Table']['prefix']."module_catalog_orders";
		$this -> table_order_items	= $cfg['DB']['Table']['prefix']."module_catalog_order_items";
		$this -> table_types 		= $cfg['DB']['Table']['prefix']."module_form_fields_type";
		
		$this -> path_src = "/images/catalog/";
		$this -> path_server = $cfg['PATH']['root'] . "images/catalog/";
		
		$this -> path_tmp = $cfg['PATH']['root'] . "images/temp/";
		
		return true;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Сохранение настроек
	//	$per_page - количество элементов на странице
	////////////////////////////////////////////////////////////////////////////////
	
	function GetSettings () {
		
		$sql = sprintf("SELECT * FROM %s;",	$this->table_settings);
						
		$settings = $this -> db -> getResultArray($sql);
		
		return ($settings) ? $settings[0] : array();
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Сохранение настроек
	//	$per_page - количество элементов на странице
	////////////////////////////////////////////////////////////////////////////////
	
	function UpdateSettings ($per_page) {
		
		$sql = sprintf("UPDATE %s SET `per_page` = %s;",
						$this->table_settings, $per_page);
						
		if ($this -> db -> query($sql)) {
			$result = "success";
			$text	= "Сохранено";
		}
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно сохранить параметры.";
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение информации о конкретной категории
	//	$id_cat - id категории
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCat ($id_cat) {
		
		$sql = sprintf ("SELECT * FROM %s WHERE id = %s LIMIT 1;", $this->table_cats, $id_cat);
		
		$cat = $this -> db -> getResultArray($sql);
		
		return ($cat) ? $cat[0] : array();
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение имени категории
	//	$id_cat - id категории
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCatName ($id_cat) {
		
		$sql = sprintf ("SELECT `name` FROM %s WHERE id = %s LIMIT 1;", $this->table_cats, $id_cat);
		
		$cat = $this -> db -> getResultArray($sql);
		
		return ($cat) ? $cat[0]['name'] : "";		
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение всех "соседей" категории
	//	$id_cat - id категории
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCatSiblings ($id_cat) {
		
		$cat = $this -> GetCat($id_cat);
		
		return $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE (pid = %s) AND (id <> %s) ORDER BY id ASC;", $this->table_cats, $cat['pid'], $id_cat ));	
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение всех непосредственных дочерних элементов категории (получение одного уровня дерева с pid = id_cat)
	//	$id_cat - id родительской вершины
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCatChildren ($id_cat, $order = "ASC", $active = false) {
		
		$condition = ($active) ? "AND (`active` > 0)" : "";
		
		$sql = sprintf("SELECT `id`, `name` FROM %s 
						WHERE (`pid` = %s) %s ORDER BY `sort` %s;", 
						$this->table_cats, $id_cat, $condition, $sort);
		
		return $this -> db -> getResultArray ($sql);	
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение пути к определенной категории
	//	$id - id категории
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCatPath ($id) {
		
		$_path = array();
		$i=0;
		
		while ($id!=0) {
			$cat = $this -> GetCat($id);
			$_path[$i]['id'] = $cat['id'];
			$_path[$i]['name'] = $cat['name']; 
			$id = $cat['pid'];
			$i++;
		}
		
		$path = array();
		
		for ($i=count($_path)-1; $i>=0; $i--)
			$path[] = $_path[$i];
			
		return $path;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение пути до 3-го уровня
	//	$id - id категории
	////////////////////////////////////////////////////////////////////////////////
	
	function GetPath ($id) {
		
		$_path = array();
		$i=0;
		
		while ($id!=0) {
			$cat = $this -> GetCat($id);
			$_path[$i]['id'] = $cat['id'];
			$_path[$i]['name'] = $cat['name']; 
			$id = $cat['pid'];
			$i++;
		}
		
		$path = array();
		
		for ($i=count($_path)-1; $i>=0; $i--)
			$path[] = $_path[$i];
		
		if (count($path)<3)
			$cat = $this -> db -> getResultArray ( sprintf ("SELECT id, name FROM %s WHERE pid = %s ORDER BY id ASC LIMIT 1;", $this -> table_cats, $path[count($path)-1]['id'] ));
		
		while ( (count($path)<3) && (is_array($cat)) && (count($cat)>0) ) {
			$n = count($path);
			$path[$n]['id'] = $cat[0]['id'];
			$path[$n]['name'] = $cat[0]['name'];
			$cat = $this -> db -> getResultArray ( sprintf ("SELECT id, name FROM %s WHERE pid = %s ORDER BY id ASC LIMIT 1;", $this -> table_cats, $path[$n]['id'] ));
		}
		
		return $path;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение "развернтуого" пути к вершине с номером id_cat
	//	$id_cat - id целевой вершины
	//	$array - массив, хранящий путь
	//	$level - номер начального уровня
	////////////////////////////////////////////////////////////////////////////////
	
	function GetFullCatPath (&$array, $pid, $level, $path) {
		
		$array = $this -> GetCatChildren($pid);
		
		for ($i=0; $i<count($array); $i++) {
			
			$array[$i]['level'] = $level;
			
			if (($level<(count($path)-1))&&($array[$i]['id'] == $path[$level]['id'])) {
				
				$children = array();
				$this -> GetFullCatPath ($children, $array[$i]['id'], $level+1, $path);
				$array[$i]['children'] = $children;
			}
		}	
		
		return true;		
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Вывод дерева каталога в массив $array
	//	$pid - id корневой вершины (если 0 - то все дерево)
	//	$level - номер начального уровня
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCatTree (&$array, $pid, $level, $order = "ASC", $active = false) {
		
		$array = $this -> GetCatChildren($pid, $order, $active);
		
		for ($i=0; $i<count($array); $i++) {
			
			$children = array();
			$this -> GetCatTree ($children, $array[$i]['id'], $level+1, $order, $active);
			$array[$i]['level'] = $level;
			$array[$i]['children'] = $children;
			$array[$i]['count'] = count($children);
			$array[$i]['cols'] = ($array[$i]['count'] - ($array[$i]['count'] % 3)) / 3;
			
			if (($array[$i]['count'] % 3) > 0)
				$array[$i]['cols']++;
		}	
		
		return true;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Вывод дерева каталога в виде структурированного списка
	//	$pid - id корневой вершины (если 0 - то все дерево)
	//	$level - номер начального уровня
	////////////////////////////////////////////////////////////////////////////////
	
	function GetListTree (&$array, &$n, $pid = 0, $level = 0, $order = "ASC", $active = false) {
		
		$children = $this -> GetCatChildren($pid, $order, $active);
		
		if (!$children)
			return false;
		
		$prefix = "";
			
		if ($level > 0) {			
			
			for ($j=0; $j<$level; $j++) {
				$prefix .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}				
		}
			
		for ($i=0; $i<count($children); $i++) {		
			
			$array[$n]['value'] = $children[$i]['id'];			
			
			$array[$n]['caption'] = $prefix . $children[$i]['name'];
			
			$n++;
			
			$this -> GetListTree ($array, $n, $children[$i]['id'], $level+1, $order, $active);			
		}	
		
		return true;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение дерева каталога в массив $array (не больше 3-х уровней)
	//	$pid - id корневой вершины
	//	$level - номер уровня
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCatTreeCut (&$array, $pid, $level) {
		
		$array = $this -> GetCatChildren($pid);
		
		for ($i=0; $i<count($array); $i++) {
			
			$children = array();
			
			if ($level<2)
				$this -> GetCatTreeCut ($children, $array[$i]['id'], $level+1);
			
			$array[$i]['photo'] = $this -> path_src . $array[$i]['img'];
			$array[$i]['level'] = $level;
			$array[$i]['children'] = $children;
		}	
		
		return true;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Создание новой категории
	//	$pid - id родительской категории
	//	$name - имя
	////////////////////////////////////////////////////////////////////////////////
	
	function CreateCat ($pid, $name) {
		
		$parent = $this -> db -> getResultArray ( sprintf ("SELECT id FROM %s WHERE id = %s LIMIT 1;", $this -> table_cats, $pid));
		
		if ( ((!is_array($parent))||(count($parent)==0)) && ($pid>0) ) {
			$result = "error";
			$text	= "Error. Can't find parent cat with id = " . $pid;
		}
		else {
			
			$this -> db -> query ( sprintf ("INSERT INTO %s (pid, name) VALUES (%s, '%s');", $this -> table_cats, $pid, $name ));
			
			if ($text = $this -> db -> last_id()) {
				$result = "success";
			}			
			else {
				$result = "error";
				$text	= "Error. Can't create category.";
			}
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Изменение (переименование) категории
	//	$id - id изменяемой категории
	//	$name - новое имя категории
	//	$sort - индекс сортировки
	//	$active - "видимость" категории (1 или 0)
 	////////////////////////////////////////////////////////////////////////////////
	
	function UpdateCat ($id, $name, $sort, $active) {
		
		$sql = sprintf("UPDATE %s SET `name` = '%s', `sort` = %s, `active` = %s WHERE `id` = %s;", $this->table_cats, $name, $sort, $active, $id);
		
		if ( $this -> db -> query ($sql) ) {
			$result = "success";
			$text = 1;
		}			
		else {
			$result = "error";
			$text	= "Error. Can't update category.";
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Удаление категории
	//	$id - id удаляемой категории
	////////////////////////////////////////////////////////////////////////////////
	
	function DeleteCat ($id) {
		
		if ($children = $this -> GetCatChildren($id) )
			for ($i=0; $i<count($children); $i++)
				$this -> DeleteCat($children[$i]['id']);
		
		$sql = sprintf("SELECT `id_item` FROM %s WHERE `id_cat` = %s;",
						$this->table_items, $id);
		
		$items = $this -> db -> getResultArray($sql);
		
		if ($items) {
			
			$items_list = "(";
			
			for ($i=0; $i<count($items); $i++) {
				
				if ($i>0) {
					$items_list .= ", ";
				}
				
				$items_list .= "'" . $items[$i]['id_item'] . "'";
			}
			
			$items_list .= ")";
			
			$sql = sprintf("DELETE FROM %s WHERE `id_item` IN %s;", 
							$this->table_properties, $items_list);
			
			$this->db->query($sql);
			
			$sql = sprintf("DELETE FROM %s WHERE `id_item` IN %s;", 
							$this->table_order_items, $items_list);
			
			$this->db->query($sql);
			
			$sql = sprintf("DELETE FROM %s WHERE `id_cat` = %s;", 
							$this->table_items, $id);
								
			if ($this->db->query($sql)) {
				
				for ($i=0; $i<count($items); $i++) {
					
					$image = glob($this->path_server . $items[$i]['id_item'] . ".*", 		GLOB_NOSORT);			
					$thumb = glob($this->path_server . $items[$i]['id_item'] . "_thumb.*", 	GLOB_NOSORT);			
								
					unlink($image[0]);
					unlink($thumb[0]);
				}
				
				if ($this->db->query(sprintf("DELETE FROM %s WHERE `id_cat` = %s;", $this->table_fields, $id))) {							
				
					if ($this -> db -> query ( sprintf ("DELETE FROM %s WHERE id = %s;", $this -> table_cats, $id ))) {
						$result = "success";
						$text = 1;
					}			
					else {
						$result = "error";
						$text	= "Error. Can't delete category.";
					}
				}
				else {
					$result = "error";
					$text	= "Error. Can't delete categories fields.";
				}
			}
			else {
				$result = "error";
				$text	= "Error. Can't delete category items.";
			}
		}		
		else {
			
			if ($this->db->query(sprintf("DELETE FROM %s WHERE `id_cat` = %s;", $this->table_fields, $id))) {							
				
				if ($this -> db -> query ( sprintf ("DELETE FROM %s WHERE id = %s;", $this -> table_cats, $id ))) {
					$result = "success";
					$text = 1;
				}			
				else {
					$result = "error";
					$text	= "Error. Can't delete category.";
				}
			}
			else {
				$result = "error";
				$text	= "Error. Can't delete categories fields.";
			}
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение списка дополнительных полей определенной категории
	//	$id_cat - id категории
	////////////////////////////////////////////////////////////////////////////////
	
	function GetFields ($id_cat) {
		
		$sql = sprintf("SELECT * FROM %s WHERE `id_cat` = %s", $this->table_fields, $id_cat);
		
		return $this -> db -> getResultArray ($sql);	
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение развернутого массива полей категории
	//	$id - id категории
	////////////////////////////////////////////////////////////////////////////////
	
	function GetDetailedFields ($id) {
		
		$sql = sprintf("SELECT FROM %s WHERE `id_cat` = %s;", 
						$this->table_fields, $this->table_types, $id);
		
		return $this -> db -> getResultArray ($sql);	
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение списка типов полей
	////////////////////////////////////////////////////////////////////////////////
	
	function GetInputTypes () {

		return $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s ORDER BY `sort` ASC;", $this -> table_types ));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Добавление нового поля к категории  
	//	$id_cat - id категории
	//	$name - имя поля (поле name для input)
	//	$title - название поля
	//	$type - тип поля
	//	$options - перечень допустимых вариантов (только для типа поля "select")
	//	$empty - допускается ли для данного поля пустое значение (1 или 0)
	////////////////////////////////////////////////////////////////////////////////
	
	function AddNewField ($id_cat, $name, $title, $type, $options, $empty) {
		
		$cat = $this -> GetCat($id_cat);
		
		if ((!is_array($cat))||(count($cat)==0)) {
			$result = "error";
			$text	= "Can't find category with id = " . $id_cat;
		}
		else {
			
			$sql = sprintf("INSERT INTO %s (`id_cat`, `name`, `title`, `type`, `options`, `empty`) 
							VALUES (%s, '%s', '%s', '%s', '%s', %s);", 
							$this->table_fields, $id_cat, $name, $title, $type, trim(strip_tags($options)), $empty);
			
			$this -> db -> query ($sql);
			
			if ($text = $this -> db -> last_id()) {
				$result = "success";
			}			
			else {
				$result = "error";
				$text	= "Error. Can't create field.";
			}
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Редактирование поля
	//	$id_field - id редактируемого поля
	//	$id_cat - id категории
	//	$name - имя поля (поле name для input)
	//	$title - название поля
	//	$type - тип поля
	//	$options - перечень допустимых вариантов (только для типа поля "select")
	//	$empty - допускается ли для данного поля пустое значение (1 или 0)
	////////////////////////////////////////////////////////////////////////////////
	
	function UpdateField ($id_field, $id_cat, $name, $title, $type, $options, $empty) {
		
		$sql = sprintf("UPDATE %s SET 
							`id_cat` = %s, 
							`name` = '%s', 
							`title` = '%s', 
							`type` = '%s', 
							`options` = '%s', 
							`empty` = %s 
						WHERE `id_field` = %s;", 
						$this->table_fields, $id_cat, $name, $title, $type, trim(strip_tags($options)), $empty, $id_field);
		
		if ( $this -> db -> query ($sql) ) {
			$result = "success";
			$text = 1;
		}			
		else {
			$result = "error";
			$text	= "Error. Can't update field.";
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Удаление поля
	//	$id_field - id удаляемого поля
	////////////////////////////////////////////////////////////////////////////////
	
	function DeleteField ($id_field) {
		
		$sql = sprintf("DELETE FROM %s WHERE `id_field` = %s;", $this->table_properties, $id_field);
		
		if ( $this -> db -> query ($sql) ) {
		
			$sql = sprintf("DELETE FROM %s WHERE `id_field` = %s;", $this->table_fields, $id_field);
		
			if ( $this -> db -> query ($sql) ) {
				$result = "success";
				$text = 1;
			}			
			else {
				$result = "error";
				$text	= "Error. Can't delete field.";
			}
		}
		else {
			$result = "error";
			$text	= "Error. Can't delete field properties.";
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение пути к определенной категории
	//	$id - id категории
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCatTitle ($id) {
		
		$path = $this -> GetCatPath($id);
		$title = "";
		
		for ($i=0; $i < count($path); $i++) {
			$title .= "\"" . $path[$i]['name'] . "\"";
			if ($i < (count($path)-1))
				$title .= " > ";
		}
			
		return $title;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Очистка полей элемента
	//	$id_item - id элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function ClearItemProperties ($id_item) {
		
		$sql = sprintf("DELETE FROM %s WHERE `id_item` = %s;",
						$this->table_properties, $id_item);
						
		return $this -> db -> query ($sql);
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Добавление записи поля элемента
	//	$id_item - id элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function AddItemProperty ($id_item, $id_field, $value) {
		
		$sql = sprintf("INSERT INTO %s (`id_item`, `id_field`, `value`) 
						VALUES (%s, %s, '%s');",
						$this->table_properties, $id_item, $id_field, $value);
						
		return $this -> db -> query ($sql);
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение всех элементов категории
	//	$id_cat - id категории
	//	$order - порядок сортировки ("DESC" или "ASC")
	////////////////////////////////////////////////////////////////////////////////
	
	function GetItemList ($id_cat, $order) {
		
		$sql = sprintf ("SELECT * FROM %s WHERE `id_cat` = %s ORDER BY `sort` %s;", $this -> table_items, $id_cat, $order);
		
		return $this -> db -> getResultArray ($sql);
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение свойств элемента
	//	$id_item - id элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function GetItemProps ($id_item) {
		
		$sql = sprintf("SELECT F.name, F.title, P.value FROM %s F INNER JOIN %s P 
						ON F.id_field = P.id_field WHERE (P.id_item = %s);", 
						$this->table_fields, $this->table_properties, $id_item);
		
		$result = $this -> db -> getResultArray ($sql);	
		
		$properties = array();
		
		if ($result) {
			
			for ($i=0; $i<count($result); $i++) {
				
				$properties[$result[$i]['name']]['title'] = $result[$i]['title'];
				$properties[$result[$i]['name']]['value'] = $result[$i]['value'];
			}
		}
			
		return $properties; 
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение определенного элемента
	//	$id_item - id элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function GetItem ($id_item) {
		
		$sql = sprintf("SELECT * FROM %s WHERE `id_item` = %s LIMIT 1;", $this -> table_items, $id_item);
		
		$item = $this -> db -> getResultArray ($sql);
		
		if ($item) {
			
			$item[0]['properties'] = $this -> GetItemProps($id_item);
			
			$image = glob($this->path_server . $id_item . "/" . $id_item . ".*", 		GLOB_NOSORT);			
			$thumb = glob($this->path_server . $id_item . "/" . $id_item . "_thumb.*", 	GLOB_NOSORT);			
			
			$item[0]['image'] = ($image) ? $this->path_src . $id_item . "/" . basename($image[0]) : "";					
			$item[0]['thumb'] = ($thumb) ? $this->path_src . $id_item . "/" . basename($thumb[0]) : "";
				
			return $item[0];
		}
		else {
			return 0;
		}
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение элементов всех категорий
	//	$from - номер начального элемента
	//	$limit - количество выбираемых элементов
	//	$order - порядок сортировки ("DESC" или "ASC")
	////////////////////////////////////////////////////////////////////////////////
	
	function GetItems (&$total, $filters = array(), $from = 0, $limit = 0, $order = "ASC", $active = false) {
		
		$limits = ($limit > 0) ? ("LIMIT ".$from.", ".$limit) : "";
				
		$filter = ($active) ? "WHERE (I.active > 0)" : "";
		
		if (isset($filters['name']) && !empty($filters['name'])) {
			
			if (!empty($filter))
				$filter .= " AND ";
			else
				$filter .= "WHERE ";
				
			$filter .= "(I.name LIKE '%" . $filters['name'] . "%')";
		}
		
		if (isset($filters['art']) && !empty($filters['art'])) {
			
			if (!empty($filter))
				$filter .= " AND ";
			else
				$filter .= "WHERE ";
			
			$filter .= "(I.art LIKE '%" . $filters['art'] . "%')";
		}
		
		if (isset($filters['WEIGHT']['FROM']) && !empty($filters['WEIGHT']['FROM'])) {
			
			if (!empty($filter))
				$filter .= " AND ";
			else
				$filter .= "WHERE ";
				
			$filter .= "(I.weight >= " . $filters['WEIGHT']['FROM'] . ")";
		}
		
		if (isset($filters['WEIGHT']['TO']) && !empty($filters['WEIGHT']['TO'])) {
			
			if (!empty($filter))
				$filter .= " AND ";
			else
				$filter .= "WHERE ";
				
			$filter .= "(I.weight <= " . $filters['WEIGHT']['TO'] . ")";
		}
		
		if (isset($filters['PROPERTIES']) && !empty($filters['PROPERTIES'])) {
			
			if (!empty($filter))
				$filter .= " AND ";
			else
				$filter .= "WHERE ";
			
			$where = "";
			
			foreach ($filters['PROPERTIES'] as $key => $value) {
				
				if (!empty($where))
					$where .= " AND ";
				
				$where .= "(P.id_field = " . $key . ") AND (P.value IN (";
				
				for ($i=0; $i<count($value); $i++) {
					
					if ($i>0)
						$where .= ", ";
					
					$where .= "'" . $value[$i] . "'";
				}
				
				$where .= "))";
			}
			
			$filter .= sprintf("(I.id_item IN (SELECT P.id_item FROM %s P WHERE %s))", $this->table_properties, $where);
		}
		
		$sql = sprintf("SELECT count(1) AS `count` FROM %s I %s;", $this -> table_items, $filter);
		
		$result = $this -> db -> getResultArray($sql);
		
		$total = ($result) ? $result[0]['count'] : 0;
		
		$sql = sprintf("SELECT I.*, C1.name AS `cat_name`, C2.name AS `root_name` 
						FROM %s I LEFT JOIN %s C1 ON I.id_cat = C1.id
						LEFT JOIN %s C2 ON I.root = C2.id %s
						ORDER BY I.id_item %s %s;", 
						$this -> table_items, $this -> table_cats, $this -> table_cats, $filter, $order, $limits);
		
		$items = $this -> db -> getResultArray($sql);
		
		if ($items) {
			
			for ($i=0; $i<count($items); $i++) {
				
				$image = glob($this->path_server . $items[$i]['id_item'] . "/" . $items[$i]['id_item'] . ".*", 		GLOB_NOSORT);			
				$thumb = glob($this->path_server . $items[$i]['id_item'] . "/" . $items[$i]['id_item'] . "_thumb.*", 	GLOB_NOSORT);			
							
				$items[$i]['image'] = ($image) ? $this->path_src . $items[$i]['id_item'] . "/" . basename($image[0]) : "";					
				$items[$i]['thumb'] = ($thumb) ? $this->path_src . $items[$i]['id_item'] . "/" . basename($thumb[0]) : "";
			}
		}
		
		return $items;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение элементов определенной категории
	//	$id_cat - id категории
	//	$order - порядок сортировки по id ("DESC" или "ASC")
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCatItems (&$total, $id_cat, $filters = array(), $from = 0, $limit = 0, $order = "ASC") {
		
		$cats = $id_cat;
		
		if ($children = $this->GetCatChildren($id_cat)) {
			
			for ($i=0; $i<count($children); $i++) {
				$cats .= ", ".$children[$i]['id'];
			}
		}
		
		$limits = ($limit > 0) ? ("LIMIT ".$from.", ".$limit) : "";
		
		$filter = sprintf("WHERE (I.active > 0) AND (I.id_cat IN (%s))", $cats);
		
		if (isset($filters['name']) && !empty($filters['name'])) {
			
			$filter .= " AND (I.name LIKE '%" . $filters['name'] . "%')";
		}
		
		if (isset($filters['art']) && !empty($filters['art'])) {
			
			$filter .= " AND (I.art LIKE '%" . $filters['art'] . "%')";
		}
		
		if (isset($filters['WEIGHT']['FROM']) && !empty($filters['WEIGHT']['FROM'])) {
			
			$filter .= " AND (I.weight >= " . $filters['WEIGHT']['FROM'] . ")";
		}
		
		if (isset($filters['WEIGHT']['TO']) && !empty($filters['WEIGHT']['TO'])) {
			
			$filter .= " AND (I.weight <= " . $filters['WEIGHT']['TO'] . ")";
		}
		
		if (isset($filters['PROPERTIES']) && !empty($filters['PROPERTIES'])) {
			
			if (!empty($filter))
				$filter .= " AND ";
			else
				$filter .= "WHERE ";
			
			$where = "";
			
			foreach ($filters['PROPERTIES'] as $key => $value) {
				
				if (!empty($where))
					$where .= " AND ";
				
				$where .= "(P.id_field = " . $key . ") AND (P.value IN (";
				
				for ($i=0; $i<count($value); $i++) {
					
					if ($i>0)
						$where .= ", ";
					
					$where .= "'" . $value[$i] . "'";
				}
				
				$where .= "))";
			}
			
			$filter .= sprintf("(I.id_item IN (SELECT P.id_item FROM %s P WHERE %s))", $this->table_properties, $where);
		}
		
		$sql = sprintf("SELECT count(1) AS `count` FROM %s I %s;", $this -> table_items, $filter);
		
		$result = $this -> db -> getResultArray($sql);
		
		$total = ($result) ? $result[0]['count'] : 0;
		
		$sql = sprintf("SELECT I.* FROM %s I %s ORDER BY I.id_item %s %s;", $this -> table_items, $filter, $order, $limits);
		
		$items = $this -> db -> getResultArray($sql);
		
		if ($items) {
			
			for ($i=0; $i<count($items); $i++) {
				
				$image = glob($this->path_server . $items[$i]['id_item'] . "/" . $items[$i]['id_item'] . ".*", 		GLOB_NOSORT);			
				$thumb = glob($this->path_server . $items[$i]['id_item'] . "/" . $items[$i]['id_item'] . "_thumb.*", 	GLOB_NOSORT);			
							
				$items[$i]['image'] = ($image) ? $this->path_src . $items[$i]['id_item'] . "/" . basename($image[0]) : "";					
				$items[$i]['thumb'] = ($thumb) ? $this->path_src . $items[$i]['id_item'] . "/" . basename($thumb[0]) : "";
			}
		}
		
		return $items;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение списка дополнительных полей опр. типа для категории (если отсутствуют, то наследуются поля родительских категорий)
	//	$id_cat - id категории
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCatFields ($id_cat, $type = "") {
		
		$where = (!empty($type)) ? ("AND (`type` = '" . $type . "')") : "";
		
		$sql = sprintf("SELECT * FROM %s WHERE (`id_cat` = %s) %s", 
						$this -> table_fields, $id_cat, $where);
		
		$fields = $this -> db -> getResultArray ($sql);	
		
		while (count($fields)==0) {
		
			$pid = $this -> GetCat($id_cat);
			$id_cat = $pid['pid'];
			
			$sql = sprintf("SELECT * FROM %s WHERE (`id_cat` = %s) %s", 
							$this -> table_fields, $id_cat, $where);
			
			$fields = $this -> db -> getResultArray ($sql);
			
			if ($id_cat==0)
				break;
		}
		
		if ($fields) {
		
			for ($i=0; $i<count($fields); $i++) {
				
				$arr = explode(";", $fields[$i]['options']);
				$_arr = array();
				
				if ($arr) {
					for ($j=0; $j<count($arr); $j++) {
						$arr[$j] = trim($arr[$j]);
						
						if (!empty($arr[$j]))
							$_arr[] = $arr[$j];
					}
				}
					
				$fields[$i]['options'] = $_arr;				
			}
		}
		
		return $fields; 
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Добавление нового элемента в категорию
	//	$id_cat - id категории
	//	$name - название
	//	$active - активность (видимость)
	//	$description - описание
	////////////////////////////////////////////////////////////////////////////////
	
	function CreateItem ($id_cat, $name, $active, $description) {
		
		$path = $this -> GetCatPath ($id_cat);
		
		$sql = sprintf("INSERT INTO %s (`id_cat`, `root`, `name`, `active`, `description`) 
						VALUES (%s, %s, '%s', %s, '%s');", 
						$this -> table_items, $id_cat, $path[0]['id'], $name, $active, $description);
			
		$this -> db -> query ($sql);
			
		if ($text = $this -> db -> last_id()) {
			
			$result = "success";
		}			
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно добавить элемент.";
		}		
					
		return array("result" => $result, "text" => $text);
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Изменение элемента
	//	$id_item - id изменяемого элемента
	//	$name - название
	//	$active - активность (видимость)
	//	$description - описание
	////////////////////////////////////////////////////////////////////////////////
	
	function UpdateItem ($id_item, $name, $active, $description) {
		
		$sql = sprintf("UPDATE %s SET 
							`name` = '%s',
							`active` = %s,
							`description` = '%s' 
						WHERE id_item = %s;", 
						$this->table_items, $name, $active, $description, $id_item);
		 
		if ( $this -> db -> query ($sql) ) {
			$result = "success";
			$text = "Сохранено.";
		}			
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно сохранить элемент.";
		}
				
		return array("result" => $result, "text" => $text);
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Удаление элемента
	//	$id_item - id удаляемого элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function DeleteItem ($id_item) {
		
		$sql = sprintf("DELETE FROM %s WHERE `id_item` = %s;", 
						$this -> table_properties, $id_item);
		
		if ($this -> db -> query ($sql)) {
			
			$sql = sprintf("DELETE FROM %s WHERE `id_item` = %s;", 
							$this -> table_items, $id_item);
			
			if ($this -> db -> query ($sql)) {
				
				$sql = sprintf("DELETE FROM %s WHERE `id_item` = %s;", 
							$this -> table_photos, $id_item);
			
				$this -> db -> query ($sql);
				
				$images = glob($this->path_server . $id_item . "/*.*", GLOB_NOSORT);
				
				if ($images) {
					
					for ($i=0; $i<count($images); $i++)
						@unlink($images[$i]);
					
					@rmdir($this->path_server . $id_item . "/");							
				}
				
				$result = "success";
				$text 	= "Удалено.";				
			}			
			else {
				$result = "error";
				$text	= "Ошибка. Невозможно удалить элемент с id = " . $id_item . ".";
			}
		}
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно удалить элемент с id = " . $id_item . ".";
		}
						
		return array2json( array("result" => $result, "text" => $text) );
	}	
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение фотографий элемента
	//	$id_item - id элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function GetItemPhotos ($id_item) {
		
		$sql = sprintf("SELECT `id_photo` FROM %s WHERE `id_item` = %s", 
						$this->table_photos, $id_item);
		
		if ($photos = $this -> db -> getResultArray ($sql))	{			
			for ($j=0; $j<count($photos); $j++) {			
				
				$image = glob($this->path_server . $id_item . "/photo_" . $photos[$j]['id_photo'] . ".*", 		GLOB_NOSORT);
				$thumb = glob($this->path_server . $id_item . "/photo_" . $photos[$j]['id_photo'] . "_thumb.*", GLOB_NOSORT);
				
				$photos[$j]['photo'] = ($image) ? ($this->path_src.$id_item."/".basename($image[0])) : "";
				$photos[$j]['thumb'] = ($thumb) ? ($this->path_src.$id_item."/".basename($thumb[0])) : "";
			}
		}
		
		return $photos;
	}
			
	////////////////////////////////////////////////////////////////////////////////
	//	Добавление новой фотографии
	//	$id_item - id элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function CreatePhoto ($id_item) {
		
		$sql = sprintf("INSERT INTO %s SET `id_item` = %s;", 
						$this->table_photos, $id_item);
		
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
		
		$sql = sprintf("SELECT `id_item` FROM %s 
						WHERE `id_photo` = %s LIMIT 1;", 
						$this->table_photos, $id_photo);
		
		if ($item = $this -> db -> getResultArray($sql)) {
			
			$id_item = $item[0]['id_item'];
		
			$sql = sprintf("DELETE FROM %s WHERE `id_photo` = %s;", 
							$this->table_photos, $id_photo);
			
			if ($this -> db -> query ($sql)) {
				
				$result = "success";
				$text = "Удалено.";
				
				$image = glob($this->path_server . $id_item . "/photo_" . $id_photo . ".*", 		GLOB_NOSORT);
				$thumb = glob($this->path_server . $id_item . "/photo_" . $id_photo . "_thumb.*", 	GLOB_NOSORT);
				
				if ($image)
					@unlink($image[0]);
					
				if ($thumb)
					@unlink($thumb[0]);
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
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение списка заказов
	////////////////////////////////////////////////////////////////////////////////
	
	function GetOrders(&$total, $from = 0, $limit = 0, $field = "datetime", $order = "DESC") {
		
		$limits = ($limit > 0) ? ("LIMIT ".$from.", ".$limit) : "";
				
		$sql = sprintf("SELECT count(1) AS `count` FROM %s;", $this -> table_orders, $filter);
		
		$result = $this -> db -> getResultArray($sql);
		
		$total = ($result) ? $result[0]['count'] : 0;
		
		$sql = sprintf("SELECT * FROM %s ORDER BY `%s` %s %s;", 
						$this -> table_orders, $field, $order, $limits);
		
		return $this -> db -> getResultArray($sql);
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение информации о заказе
	//	$id_order - id заказа
	////////////////////////////////////////////////////////////////////////////////
	
	function GetOrder ($id_order) {
		
		$sql = sprintf("SELECT IO.id_order, O.*, SUM(IO.amount) AS `amount`, SUM(I.weight*IO.amount) AS `weight`
						FROM %s O INNER JOIN %s IO ON O.id_order = IO.id_order
						INNER JOIN %s I ON IO.id_item = I.id_item
						GROUP BY IO.id_order
						HAVING IO.id_order = %s;",
						$this->table_orders, $this->table_order_items, $this->table_items, $id_order);
						
		$order = $this -> db -> getResultArray($sql);
		
		return ($order) ? $order[0] : false;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение детализации заказа
	//	$id_order - id заказа
	////////////////////////////////////////////////////////////////////////////////
	
	function GetOrderItems ($id_order) {
		
		$sql = sprintf("SELECT I.id_item, I.name, I.art, I.weight, IO.amount
						FROM %s IO INNER JOIN %s I ON IO.id_item = I.id_item
						WHERE IO.id_order = %s;",
						$this->table_order_items, $this->table_items, $id_order);
		
		$items = $this -> db -> getResultArray($sql);
		
		if ($items) {
			
			for ($i=0; $i<count($items); $i++) {
				
				$image = glob($this->path_server . $items[$i]['id_item'] . ".*", 		GLOB_NOSORT);			
				$thumb = glob($this->path_server . $items[$i]['id_item'] . "_thumb.*", 	GLOB_NOSORT);			
							
				$items[$i]['image'] = ($image) ? $this->path_src . basename($image[0]) : "";					
				$items[$i]['thumb'] = ($thumb) ? $this->path_src . basename($thumb[0]) : "";
			}
		}
		
		return $items;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение содержимого корзины
	//	$cart - массив элементов
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCartItems($cart) {
		
		if (!$cart)
			return array();
		
		$items = "";
		
		foreach ($cart as $key => $value) {
			
			if ($items)
				$items .= ", ";
				
			$items .= $key;
		}
		
		$sql = sprintf("SELECT I.*, C.name AS `cat` 
						FROM %s I LEFT JOIN %s C ON I.root = C.id
						WHERE I.id_item IN (%s)
						ORDER BY I.root ASC;", 
						$this -> table_items, $this -> table_cats, $items);
		
		$items = $this -> db -> getResultArray($sql);
		
		if ($items) {
			
			for ($i=0; $i<count($items); $i++) {
				
				$image = glob($this->path_server . $items[$i]['id_item'] . ".*", 		GLOB_NOSORT);			
				$thumb = glob($this->path_server . $items[$i]['id_item'] . "_thumb.*", 	GLOB_NOSORT);			
							
				$items[$i]['image'] 	= ($image) ? $this->path_src . basename($image[0]) : "";					
				$items[$i]['thumb'] 	= ($thumb) ? $this->path_src . basename($thumb[0]) : "";
				$items[$i]['amount']	= $cart[$items[$i]['id_item']]['amount'];
			}
		}
		
		return $items;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение значений свойств элементов корзины
	//	$cart - массив элементов
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCartItemsProperties($cart) {
		
		if (!$cart)
			return array();
		
		$items = "";
		
		foreach ($cart as $key => $value) {
			
			if ($items)
				$items .= ", ";
				
			$items .= $key;
		}
		
		$sql = sprintf("SELECT `id_item`, `value` FROM %s 
						WHERE `id_item` IN (%s) 
						ORDER BY `id_field` ASC;", 
						$this->table_properties, $items);
						
		if ($result = $this -> db -> getResultArray($sql)) {
			
			$properties = array();
			
			for ($i=0; $i<count($result); $i++) {
				
				if (isset($properties[$result[$i]['id_item']]))
					$properties[$result[$i]['id_item']] .= ", ";
				else
					$properties[$result[$i]['id_item']] = "";
					
				$properties[$result[$i]['id_item']] .= $result[$i]['value'];
			}
			
			return $properties;
		}
			
		return false;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение общего веса корзины
	//	$cart - массив элементов
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCartWeight($cart) {
		
		if (!$cart)
			return array("amount"=>0, "weight"=>0);
		
		$items = "";
		
		foreach ($cart as $key => $value) {
			
			if ($items)
				$items .= ", ";
				
			$items .= $key;
		}
		
		$sql = sprintf("SELECT `id_item`, `weight` FROM %s WHERE `id_item` IN (%s);", 
						$this -> table_items, $items);
		
		$items = $this -> db -> getResultArray($sql);
		
		$weight = 0;
		$amount = 0;
		
		if ($items) {
			
			for ($i=0; $i<count($items); $i++) {
				
				$amount += $cart[$items[$i]['id_item']]['amount'];
				$weight += $cart[$items[$i]['id_item']]['amount']*$items[$i]['weight'];
			}
		}
		
		return array("amount"=>$amount, "weight"=>$weight);
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение веса элемента
	//	$id_item - id элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function GetItemWeight($id_item) {
		
		$sql = sprintf("SELECT `weight` FROM %s WHERE `id_item` = %s;", 
						$this -> table_items, $id_item);
		
		$item = $this -> db -> getResultArray($sql);
		
		return ($item) ? $item[0]['weight'] : false;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Добавление заказа
	//	$org - название организации
	//	$name - контактное лицо
	//	$town - город
	//	$phone - телефон
	//	$email - адрес электронной почты
	//	$comment - комментарий к заказу
	//	$cart - содержимое корзины
	////////////////////////////////////////////////////////////////////////////////
	
	function AddOrder ($org, $name, $town, $phone, $email, $comment, $cart) {
		
		$sql = sprintf("INSERT INTO %s (`org`, `name`, `town`, `phone`, `email`, `comment`, `datetime`)
						VALUES ('%s', '%s', '%s', '%s', '%s', '%s', NOW());",
						$this->table_orders, $org, $name, $town, $phone, $email, $comment);
						
		$this -> db -> query($sql);
		
		if ($text = $this -> db -> last_id()) {
			
			$result = "success";
			
			foreach ($cart as $key => $value) {
				
				$sql = sprintf("INSERT INTO %s (`id_order`, `id_item`, `amount`) VALUES (%s, %s, %s)",
								$this->table_order_items, $text, $key, $value['amount']);
								
				$this -> db -> query($sql);
			}
		}
		else {
			$result = "error";
			$text	= "При добавлении заказа возникла ошибка.";
		}
		
		return array("result" => $result, "text" => $text);
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Генерация excel-документа
	//	$items - список элементов
	////////////////////////////////////////////////////////////////////////////////
	
	function GetExcelCart($items, $properties, $id_order = 0) {
		
		global $cfg;
		
		if (empty($items))
			return false;
			
		require_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/lib/excel/writer.php" );
		require_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/lib/excel/pps/file.php" );
		require_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/lib/excel/pps/root.php" );
		
		$filename = "products".time().".xls";
		
		$xls =& new Spreadsheet_Excel_Writer($cfg['PATH']['EXCEL'].$filename);

		$xls->setVersion(8);

		////////////////////////////////////////////

		$sheet = & $xls->addWorksheet(date("d.m.Y"));

		$sheet->setInputEncoding('CP1251');

		$sheet->setLandscape();

		$sheet->setColumn(0, 0, 40);
		$sheet->setColumn(0, 1, 20);
		$sheet->setColumn(0, 2, 40);
		$sheet->setColumn(0, 3, 20);
		$sheet->setColumn(0, 4, 20);

		$format_title = & $xls->addFormat();
		$format_title->setBorder(1);
		$format_title->setAlign('center');
		$format_title->setFontFamily('Verdana');
		$format_title->setBold();
		
		$format_item = & $xls->addFormat();
		$format_item->setFontFamily('Verdana');
		$format_item->setBorder(1);
		$format_item->setAlign('left');

		$format_total = & $xls->addFormat();
		$format_total->setFontFamily('Verdana');
		$format_total->setBorder(1);
		$format_total->setAlign('left');
		$format_total->setBold();
		$format_total->setFgColor(22);
		
		///////////////////////

		$title_array = array("Наименование", "Артикул", "Параметры", "Количество", "Вес");

		for ($i=0; $i<count($title_array); $i++) {

			$sheet->write (0, $i, $title_array[$i], $format_title);
		}
		
		$k = 1;
		
		$amount = 0;
		$weight = 0;
		
		for ($i=0; $i<count($items); $i++) {

			$sheet->write($k, 0, $items[$i]['cat'], 								$format_item);
			$sheet->write($k, 1, $items[$i]['art'], 								$format_item);
			$sheet->write($k, 2, $properties[$items[$i]['id_item']], 				$format_item);
			$sheet->write($k, 3, $items[$i]['amount'], 								$format_item);
			$sheet->write($k, 4, $items[$i]['amount']*$items[$i]['weight']." г", 	$format_item);
			
			$k++;
			$amount += $items[$i]['amount'];
			$weight += $items[$i]['amount']*$items[$i]['weight'];
		}
		
		$sheet->write($k, 0, " ", 			$format_total);
		$sheet->write($k, 1, " ", 			$format_total);
		$sheet->write($k, 2, "Итого", 		$format_total);
		$sheet->write($k, 3, $amount, 		$format_total);
		$sheet->write($k, 4, $weight." г", 	$format_total);
		
		$sheet->write($k+5, 0, "Дата генерации ".date("d/m/Y H:i" ));

		$xls->close();

		chmod($cfg['PATH']['EXCEL'].$filename, 0777);

		$xls->send($filename);
		
		if (file_exists($cfg['PATH']['EXCEL'].$filename))
			return $cfg['PATH']['EXCEL'].$filename;
			
		else
			return false;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Генерация excel-документа
	//	$id_cat - id категории
	////////////////////////////////////////////////////////////////////////////////
	
	function GetPrice($id_cat = 0) {
		
		global $cfg;
		
		require_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/lib/excel/writer.php" );
		require_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/lib/excel/pps/file.php" );
		require_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/lib/excel/pps/root.php" );
		
		$filename = "products".time().".xls";
		
		$xls =& new Spreadsheet_Excel_Writer($cfg['PATH']['EXCEL'].$filename);

		$xls->setVersion(8);

		////////////////////////////////////////////

		$sheet = & $xls->addWorksheet(date("d.m.Y"));

		$sheet->setInputEncoding('CP1251');

		$sheet->setLandscape();

		$sheet->setColumn(0, 0, 40);
		$sheet->setColumn(0, 1, 20);
		$sheet->setColumn(0, 2, 40);
		$sheet->setColumn(0, 3, 20);
		$sheet->setColumn(0, 4, 20);

		$format_title = & $xls->addFormat();
		$format_title->setBorder(1);
		$format_title->setAlign('center');
		$format_title->setFontFamily('Verdana');
		$format_title->setBold();
		
		$format_item = & $xls->addFormat();
		$format_item->setFontFamily('Verdana');
		$format_item->setBorder(1);
		$format_item->setAlign('left');

		$format_total = & $xls->addFormat();
		$format_total->setFontFamily('Verdana');
		$format_total->setBorder(1);
		$format_total->setAlign('left');
		$format_total->setBold();
		$format_total->setFgColor(22);
		
		///////////////////////

		$title_array = array("Наименование", "Артикул", "Параметры", "Количество", "Вес");

		for ($i=0; $i<count($title_array); $i++) {

			$sheet->write (0, $i, $title_array[$i], $format_title);
		}
		
		$k = 1;
		
		$amount = 0;
		$weight = 0;
		
		for ($i=0; $i<count($items); $i++) {

			$sheet->write($k, 0, $items[$i]['cat'], 								$format_item);
			$sheet->write($k, 1, $items[$i]['art'], 								$format_item);
			$sheet->write($k, 2, $properties[$items[$i]['id_item']], 				$format_item);
			$sheet->write($k, 3, $items[$i]['amount'], 								$format_item);
			$sheet->write($k, 4, $items[$i]['amount']*$items[$i]['weight']." г", 	$format_item);
			
			$k++;
			$amount += $items[$i]['amount'];
			$weight += $items[$i]['amount']*$items[$i]['weight'];
		}
		
		$sheet->write($k, 0, " ", 			$format_total);
		$sheet->write($k, 1, " ", 			$format_total);
		$sheet->write($k, 2, "Итого", 		$format_total);
		$sheet->write($k, 3, $amount, 		$format_total);
		$sheet->write($k, 4, $weight." г", 	$format_total);
		
		$sheet->write($k+5, 0, "Дата генерации ".date("d/m/Y H:i" ));

		$xls->close();

		chmod($cfg['PATH']['EXCEL'].$filename, 0777);

		$xls->send($filename);
		
		if (file_exists($cfg['PATH']['EXCEL'].$filename))
			return $cfg['PATH']['EXCEL'].$filename;
			
		else
			return false;
	}
}

?>