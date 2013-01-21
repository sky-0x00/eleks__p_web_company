<?php

////////////////////////////////////////////////////////////////////////////////
//	Класс "Меню"
////////////////////////////////////////////////////////////////////////////////

class Menu extends WorkWithData {

	////////////////////////////////////////////////////////////////////////////////
	//	Свойства класса
	////////////////////////////////////////////////////////////////////////////////
	
	var $table_cats;
	var $table_items;
	var $table_photos;
	
	var $path_tmp;
	var $path_src;
	var $path_server;
		
	////////////////////////////////////////////////////////////////////////////////
	//	Конструктор
	////////////////////////////////////////////////////////////////////////////////
	
	function Menu () {

		global $cfg;

		$this -> WorkWithData ();
		
		$this -> table_cats		= $cfg['DB']['Table']['prefix'] . "module_menu_cats";
		$this -> table_items 	= $cfg['DB']['Table']['prefix'] . "module_menu_items";
		$this -> table_photos 	= $cfg['DB']['Table']['prefix'] . "module_menu_photos";
		
		$this -> path_src = "/images/menu/";
		$this -> path_server = $cfg['PATH']['root'] . "images/menu/";
		$this -> path_tmp = $cfg['PATH']['root'] . "images/temp/";
		
		return true;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение списка основных категорий
	//	$order - порядок сортировки
	////////////////////////////////////////////////////////////////////////////////	
	
	function GetCats ($order) {
		
		$cats = array();
		
		if ($_cats = $this -> db -> getResultArray ( sprintf ("SELECT `id_cat`, `name` FROM %s WHERE pid = 0 ORDER BY `id_cat` %s;", $this -> table_cats, $order ))) {
			for ($i=0; $i<count($_cats); $i++) {
				$cats[$i]['value'] 		= $_cats[$i]['id_cat'];
				$cats[$i]['caption'] 	= $_cats[$i]['name'];
			}
		}
		
		return $cats;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение имени категории по id
	//	id_cat - id категории
	////////////////////////////////////////////////////////////////////////////////	
	
	function GetCatName ($id_cat) {
		
		$catname = "";
		
		if ($cat = $this -> db -> getResultArray ( sprintf ("SELECT `name` FROM %s WHERE `id_cat` = %s LIMIT 1;", $this -> table_cats, $id_cat ))) {
			$catname = $cat[0]['name'];
		}
		
		return $catname;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение всех непосредственных дочерних элементов категории (получение одного уровня дерева с pid = id_cat)
	//	$id_cat - id родительской вершины
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCatChildren ($id_cat) {
		
		return $this -> db -> getResultArray ( sprintf ("SELECT `id_cat`, `name` FROM %s WHERE `pid` = %s ORDER BY `id_cat` ASC;", $this->table_cats, $id_cat ));	
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Создание новой категории
	//	$pid - id родительской категории
	//	$name - имя
	////////////////////////////////////////////////////////////////////////////////
	
	function CreateCat ($pid, $name) {
		
		if (($pid!=0) && !$this -> db -> getResultArray ( sprintf ("SELECT `id_cat` FROM %s WHERE `id_cat` = %s LIMIT 1;", $this -> table_cats, $pid))) {
			$result = "error";
			$text	= "Error. Can't find parent cat with id = " . $pid;
		}
		else {
			
			$this -> db -> query ( sprintf ("INSERT INTO %s (`pid`, `name`) VALUES (%s, '%s');", $this -> table_cats, $pid, $name ));
			
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
	//	$id_cat - id изменяемой категории
	//	$name - новое имя категории
	////////////////////////////////////////////////////////////////////////////////
	
	function UpdateCat ($id_cat, $name) {
			
		if ( $this -> db -> query ( sprintf ("UPDATE %s SET `name` = '%s' WHERE `id_cat` = %s;", $this -> table_cats, $name, $id_cat )) ) {
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
	//	$id_cat - id удаляемой категории
	////////////////////////////////////////////////////////////////////////////////
	
	function DeleteCat ($id_cat) {
		
		if ($children = $this -> GetCatChildren($id_cat) )
			for ($i=0; $i<count($children); $i++)
				$this -> DeleteCat($children[$i]['id_cat']);
		
		if ($items = $this -> GetItemsByCat($id_cat, "ASC")) {
			
			for ($j=0; $j<count($items); $j++)
				
				if ($photos = $this -> GetItemPhotos($items[$j]['id_item'])) {
			
					for ($i=0; $i<count($photos); $i++) {			
				
						if ( file_exists($this->path_server . basename($photos[$i]['photo'])) )
							@unlink($this->path_server . basename($photos[$i]['photo']));
							
						if ( file_exists($this->path_server . basename($photos[$i]['thumb'])) )
							@unlink($this->path_server . basename($photos[$i]['thumb']));
					}
					
					$this -> db -> query ( sprintf ("DELETE FROM %s WHERE id_item = %s;", $this -> table_photos, $items[$j]['id_item'] ));			
				}
				
			$this -> db -> query ( sprintf ("DELETE FROM %s WHERE id_cat = %s;", $this -> table_items, $id_cat ));
		}
			
		if ($this -> db -> query ( sprintf ("DELETE FROM %s WHERE `id_cat` = %s;", $this -> table_cats, $id_cat ))) {
			$result = "success";
			$text = 1;
		}			
		else {
			$result = "error";
			$text	= "Error. Can't delete category.";
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение детализированной информации о элементе
	//	$id_item - id элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function GetItemDetails ($id_item) {
		
		$item = $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE `id_item` = %s LIMIT 1;", $this -> table_items, $id_item ));
		
		if ($item) {
			
			$item[0]['image']	= $this -> path_src . $item[0]['picture'];
			$item[0]['photos'] 	= $this -> GetItemPhotos($id_item);
			
			$result = "success";
			$text = $item[0];
		}
		else {
			$result = "error";
			$text	= "Can't get item with id = " . $id_item;
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение информации о текущем элементе в опр. категории
	//	$id_cat - id категории элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCurrentItem ($id_cat) {
		
		$item = $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE `id_cat` = %s ORDER BY `id_item` DESC LIMIT 1;", $this -> table_items, $id_cat ));
		
		if ($item) {
			
			$item[0]['image']	= $this -> path_src . $item[0]['picture'];
			$item[0]['photos'] 	= $this -> GetItemPhotos($item[0]['id_item']);
			
			return $item[0];
		}
		else {
		
			return array();
		}
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение элементов основной категории (вместе с подкатегориями)
	//	$id_cat - id категории
	//	$order - порядок сортировки по id ("DESC" или "ASC")
	////////////////////////////////////////////////////////////////////////////////
	
	function GetItems ($id_cat, $order = "DESC") {
		
		$cat = array();
		
		$cat['items'] = $this -> db -> getResultArray ( sprintf ("SELECT `id_item`, `name`, `annot`, `portion`, `price`, `recipe` FROM %s WHERE `id_cat` = %s ORDER BY `id_item` %s", $this -> table_items, $id_cat, $order ));
		
		$_items = $this -> db -> getResultArray ( sprintf ("SELECT I.id_item, I.name, I.annot, I.id_cat, C.name as `catname`, I.portion, I.price, I.recipe, C.pid
															FROM %s C INNER JOIN %s I ON C.id_cat = I.id_cat
															HAVING C.pid = %s 
															ORDER BY I.id_cat ASC, I.id_item %s", 
															$this -> table_cats, $this -> table_items, $id_cat, $order ));
		
		if ($_items) {
			
			$_cats = array();
			$i = 0;			
			$n = 0;
			
			while ($i<count($_items)) {
				
				$_cats[$n]['name'] = $_items[$i]['catname'];
				
				$items = array();
				
				$items[0]['id_item'] 	= $_items[$i]['id_item'];
				$items[0]['name'] 		= $_items[$i]['name'];
				$items[0]['annot'] 		= $_items[$i]['annot'];
				$items[0]['portion'] 	= $_items[$i]['portion'];
				$items[0]['price'] 		= $_items[$i]['price'];
				$items[0]['recipe'] 	= $_items[$i]['recipe'];
				
				$j = 0;
				
				while ((($i+1)<count($_items)) && ($_items[$i]['id_cat'] == $_items[$i+1]['id_cat'])) {
					
					$j++;
					$i++;
					
					$items[$j]['id_item'] 	= $_items[$i]['id_item'];
					$items[$j]['name'] 		= $_items[$i]['name'];
					$items[$j]['annot'] 	= $_items[$i]['annot'];
					$items[$j]['portion'] 	= $_items[$i]['portion'];
					$items[$j]['price'] 	= $_items[$i]['price'];
					$items[$j]['recipe'] 	= $_items[$i]['recipe'];					
				}
				
				$_cats[$n]['items'] = $items;
				$i++;
				$n++;
			}
			
			$cat['cats'] = $_cats;
		}
		else {
			$cat['cats'] = array();
		}
		
		return $cat;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение элементов опр. категории
	//	$id_cat - id категории
	//	$order - порядок сортировки по id ("DESC" или "ASC")
	////////////////////////////////////////////////////////////////////////////////
	
	function GetItemsByCat ($id_cat, $order = "DESC") {
		
		if ( $items = $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE `id_cat` = %s ORDER BY `id_item` %s;", $this -> table_items, $id_cat, $order )) ) {
									
		}		
		
		return $items;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение списка всех элементов опр. категории
	//	$id_cat - id категории
	//	$order - порядок сортировки по id ("DESC" или "ASC")
	////////////////////////////////////////////////////////////////////////////////
	
	function GetItemsListByCat ($id_cat, $order = "DESC") {
		
		$items = array();
		
		$items[0]['value'] = 0;
		$items[0]['caption'] = "";
		$n = 1;
		
		$_items = $this -> db -> getResultArray ( sprintf ("SELECT `id_item`, `name` FROM %s WHERE `id_cat` = %s ORDER BY `id_item` %s", $this -> table_items, $id_cat, $order ));
		
		if ($_items) {
			for ($i=0; $i<count($_items); $i++) {
				$items[$i+1]['value'] = $_items[$i]['id_item'];
				$items[$i+1]['caption'] = $_items[$i]['name'];
				$n++;
			}
		}
		
		$_items = $this -> db -> getResultArray ( sprintf ("SELECT I.id_item, I.name, C.pid
															FROM %s C INNER JOIN %s I ON C.id_cat = I.id_cat
															HAVING C.pid = %s 
															ORDER BY I.id_item %s", 
															$this -> table_cats, $this -> table_items, $id_cat, $order ));
		
		if ($_items) {
			for ($i=0; $i<count($_items); $i++) {
				$items[$n]['value'] = $_items[$i]['id_item'];
				$items[$n]['caption'] = $_items[$i]['name'];
				$n++;
			}
		}
		
		return $items;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение имени файла картинки элемента
	//	$id_item - id элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function GetItemPicture ($id_item) {
		
		if ($item = $this -> db -> getResultArray ( sprintf ("SELECT `picture` FROM %s WHERE `id_item` = %s", $this -> table_items, $id_item ))) {
			return $item[0]['picture'];
		}
		else
			return false;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Создание нового элемента
	//	$id_cat - id категории
	//	$name - имя
	//	$portion - порция
	//	$price - цена
	//	$recipe - есть (1) или нет (0) рецепт
	//	$description - описание
	//	$picture - ссылка на картинку элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function CreateItem ($pid, $id_cat, $name, $annot, $portion, $price, $recipe, $description = "", $picture = "") {
		
		$this -> db -> query ( sprintf ("INSERT INTO %s (`id_cat`, `name`, `annot`, `portion`, `price`, `recipe`, `description`, `picture`) VALUES (%s, '%s', '%s', '%s', '%s', %s, '%s', '%s');", $this -> table_items, $id_cat, $name, $annot, $portion, $price, $recipe, $description, $picture ));
			
		if ($text = $this -> db -> last_id()) {
			$result = "success";
		}			
		else {
			$result = "error";
			$text	= "Error. Can't create item.";
		}
		
		$items = $this -> GetItemsListByCat($pid);		
		
		return array2json( array("result" => $result, "text" => $text, "items" => $items) );
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Обновление элемента
	//	$id_item - id элемента
	//	$id_cat - id категории
	//	$name - имя
	//	$portion - порция
	//	$price - цена
	//	$recipe - есть (1) или нет (0) рецепт
	//	$description - описание
	//	$picture - ссылка на картинку элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function UpdateItem ($pid, $id_item, $id_cat, $name, $annot, $portion, $price, $recipe, $description = "", $picture = "") {
		
		$image = $this -> GetItemPicture($id_item);
		
		if ( $this -> db -> query ( sprintf ("UPDATE %s SET `id_cat` = %s, `name` = '%s', `annot` = '%s', `portion` = '%s', `price` = '%s', `recipe` = %s, `description` = '%s', `picture` = '%s' WHERE `id_item` = %s;", $this -> table_items, $id_cat, $name, $annot, $portion, $price, $recipe, $description, $picture, $id_item )) ) {			if ( ($image) && ($picture) && ($image!=$picture) )
				@unlink($this->path_server . basename($image));
			
			$result = "success";
			$text = 1;
		}			
		else {
			$result = "error";
			$text	= "Error. Can't update item.";
		}
		
		$items = $this -> GetItemsListByCat($pid);		
		
		return array2json( array("result" => $result, "text" => $text, "items" => $items) );
	}
		
	////////////////////////////////////////////////////////////////////////////////
	//	Удаление элемента
	//	$id_item - id удаляемого элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function DeleteItem ($pid, $id_item) {
		
		if ($image = $this -> GetItemPicture($id_item)) {
			@unlink($this->path_server . basename($image));
		}
		
		if ($photos = $this -> GetItemPhotos($id_item)) {
			
			for ($i=0; $i<count($photos); $i++) {			
				
				if ( file_exists($this->path_server . basename($photos[$i]['photo'])) )
					@unlink($this->path_server . basename($photos[$i]['photo']));
							
				if ( file_exists($this->path_server . basename($photos[$i]['thumb'])) )
					@unlink($this->path_server . basename($photos[$i]['thumb']));
			}
					
			$this -> db -> query ( sprintf ("DELETE FROM %s WHERE `id_item` = %s;", $this -> table_photos, $id_item ));			
		}
				
		if ($this -> db -> query ( sprintf ("DELETE FROM %s WHERE `id_item` = %s;", $this -> table_items, $id_item ))) {
			$result = "success";
			$text = "Удалено.";
		}			
		else {
			$result = "error";
			$text	= "Error. Can't delete item.";
		}
		
		$items = $this -> GetItemsListByCat($pid);		
		
		return array2json( array("result" => $result, "text" => $text, "items" => $items) );
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение фотографий элемента
	//	$id_item - id элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function GetItemPhotos ($id_item) {
	
		$photos = $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE `id_item` = %s", $this->table_photos, $id_item ));
		
		if ( (is_array($photos)) && (count($photos)>0) )			
			for ($j=0; $j<count($photos); $j++) {
			
				$img = "";
				$namearray = explode(".", $photos[$j]['image']);
				
				for ($i=0; $i<(count($namearray)-1); $i++)
					$img .= $namearray[$i];
				$img .= "_thumb." . $namearray[count($namearray)-1];
				
				$photos[$j]['photo'] = $this -> path_src . $photos[$j]['image'];
				$photos[$j]['thumb'] = $this -> path_src . $img;
			}
			
		return $photos;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получить количество фотографий для элемента
	//	$id_item - id элемента
	////////////////////////////////////////////////////////////////////////////////
	
	function GetItemPhotosCount ($id_item) {
	
		$count = $this -> db -> getResultArray ( sprintf ("SELECT COUNT(*) AS total FROM %s WHERE `id_item` = %s;", $this->table_photos, $id_item ));
		return $count[0]['total'];
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получить информацию о фотографии по id
	//	$id_photo - id фотографии
	////////////////////////////////////////////////////////////////////////////////
	
	function GetPhoto ($id_photo) {
		
		$photo = $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE `id_photo` = %s LIMIT 1;", $this->table_photos, $id_photo ));
		
		if ( (is_array($photo)) && (count($photo)>0) ) {			
			
			$img = "";
			$namearray = explode(".", $photo[0]['image']);
				
			for ($i=0; $i<(count($namearray)-1); $i++)
				$img .= $namearray[$i];
			$img .= "_thumb." . $namearray[count($namearray)-1];
			
			$photo[0]['photo'] = $this -> path_src . $photo[0]['image'];
			$photo[0]['thumb'] = $this -> path_src . $img;
		}
		
		return $photo[0];
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получить фотографии по имени файла
	//	$image - имя файла
	////////////////////////////////////////////////////////////////////////////////
	
	function GetPhotosByImage ($image) {
		
		return $this -> db -> getResultArray ( sprintf ("SELECT `id_photo` FROM %s WHERE `image` = '%s';", $this->table_photos, $image ));	
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Добавление новой фотографии
	//	$id_item - id элемента
	//	$image - имя файла
	////////////////////////////////////////////////////////////////////////////////
	
	function CreatePhoto ($id_item, $image) {
		
		$this -> db -> query ( sprintf ("INSERT INTO %s (`id_item`, `image`) VALUES (%s, '%s');", $this->table_photos, $id_item, $image ));
		
		if ($id = $this -> db -> last_id()) {
			$text = $this -> GetPhoto($id);
			$result = "success";
		}			
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно добавить фотографию.";
		}
		
		return array2json( array("result" => $result, "text" => $text) );
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Удаление фотографии
	//	$id_photo - id фотографии
	////////////////////////////////////////////////////////////////////////////////
	
	function DeletePhoto ($id_photo) {
		
		$photo_arr = $this -> GetPhoto($id_photo);
		$image = $photo_arr['image'];		
		$photos = $this -> GetPhotosByImage($image);
		
		if (count($photos)==1) {
			if ( file_exists($this->path_server . $image) )
				@unlink($this->path_server . $image);
			if ( file_exists($this->path_server . basename($photo_arr['thumb'])) )
				@unlink($this->path_server . basename($photo_arr['thumb']));
		}
		
		if ( $this -> db -> query ( sprintf ("DELETE FROM %s WHERE `id_photo` = %s;", $this->table_photos, $id_photo )) ){
			$result = "success";
			$text = "Удалено.";
		}			
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно удалить фотографию с id = " . $id_photo . ".";
		}
		
		return array2json( array("result" => $result, "text" => $text) );
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Загрузка данных и csv-файла
	//	$filename - имя файла
	////////////////////////////////////////////////////////////////////////////////
	
	function LoadCSV ($filename) {
	
		$text = @file_get_contents($filename);
		
		if ($text) {
			
			$records_pattern = '/^(.*?);(.*?);(.*?);(.*?);(.*?);(.*?)$/m';
				
			if (preg_match_all($records_pattern, $text, $matches)) {
					
				$n=0;
				//print_r($matches); exit;
					
				if (count($matches[3]) > 0) {
					
					for ($i=1; $i<count($matches[1]); $i++) {
						
						if (($matches[1][$i]!="") && ($matches[3][$i]!="") && ($matches[5][$i]!="") && ($matches[6][$i]!="")) {
						
							$cat = $this -> db -> getResultArray ( sprintf ("SELECT `id_cat` FROM %s WHERE (`pid` = 0) AND (`name` = '%s');", $this -> table_cats, $matches[1][$i] ));
							
							if ($cat) {
								$id_pcat = $cat[0]['id_cat'];
							}
							else {
								$this -> db -> query ( sprintf ("INSERT INTO %s (`pid`, `name`) VALUES (0, '%s');", $this -> table_cats, $matches[1][$i] ));
								$id_pcat = $this -> db -> last_id();
							}
							
							$id_cat = 0;
							
							if ($matches[2][$i]!="") {
								
								$cat = $this -> db -> getResultArray ( sprintf ("SELECT `id_cat` FROM %s WHERE (`pid` = %s) AND (`name` = '%s');", $this -> table_cats, $id_pcat, $matches[2][$i] ));
								
								if ($cat) {
									$id_cat = $cat[0]['id_cat'];
								}
								elseif ($id_pcat!=0) {
									$this -> db -> query ( sprintf ("INSERT INTO %s (`pid`, `name`) VALUES (%s, '%s');", $this -> table_cats, $id_pcat, $matches[2][$i] ));
									$id_cat = $this -> db -> last_id();
								}
							}
							elseif ($id_pcat!=0) {
								$id_cat = $id_pcat;
							}
							
							
							if ($id_cat > 0) {
							
								if ( $this -> db -> query ( sprintf ("REPLACE %s (`id_cat`, `name`, `annot`, `portion`, `price`, `recipe`, `description`, `picture`) VALUES (%s, '%s', '%s', '%s', '%s', 0, '', '');", $this -> table_items, $id_cat, $matches[3][$i], $matches[4][$i], addslashes($matches[5][$i]), addslashes($matches[6][$i]) ))  )
									$n++;
							}
						}
					}
						
					$message = $n . " записей было успешно добавлено (обновлено).";
				}
				else {
					$message = "Не найдено ни одной подходящей записи.";
				}
			}						
			else {
				$message = "Записи отсутствуют.";
			}			
		}
		else {
			$message = "Ошибка. Невозможно открыть файл.";
		}
		
		return $message;		
	}
	
}

?>