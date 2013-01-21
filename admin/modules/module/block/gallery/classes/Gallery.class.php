<?php

class Gallery extends WorkWithData {

	////////////////////////////////////////////////////////////////////////////////
	//	СВОЙСТВА КЛАССА
	////////////////////////////////////////////////////////////////////////////////

	function Gallery () {

		global $cfg;

		$this -> WorkWithData ();
		
		$this -> path_src 		= "/images/gallery/";
		$this -> path_server 	= $cfg['PATH']['root'] . "images/gallery/";		
		$this -> path_tmp 		= $cfg['PATH']['root'] . "images/temp/";
		
		$this -> table_albums	= $cfg['DB']['Table']['prefix']."module_gallery_albums";
		$this -> table_photos 	= $cfg['DB']['Table']['prefix']."module_gallery_photos";
		
		return true;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение списка альбомов
	//	$order - порядок сортировки ("ASC" или "DESC")
	////////////////////////////////////////////////////////////////////////////////
	
	function GetAlbums ($order = "ASC") {
		
		$sql = sprintf ("SELECT `id_album`, `name` FROM %s 
						ORDER BY `id_album` %s;", 
						$this->table_albums, $order);
		
		return $this -> db -> getResultArray ($sql);
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Добавление нового альбома
	//	$name - название альбома
	////////////////////////////////////////////////////////////////////////////////
	
	function CreateAlbum ($name) {
		
		$sql = sprintf("INSERT INTO %s (`name`, `date`) 
						VALUES ('%s', NOW())", 
						$this->table_albums, $name);
		
		$this -> db -> query ($sql);
		
		if ($text = $this -> db -> last_id()) {
			$result = "success";
		}			
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно добавить альбом.";
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Обновление альбома
	//	$id_album - id альбома
	//	$alias - текстовый индекс
	//	$name - название
	//	$descr - описание
	////////////////////////////////////////////////////////////////////////////////
	
	function UpdateAlbum ($id_album, $alias, $name, $descr) {
		
		$sql = sprintf("UPDATE %s SET 
							`alias` = '%s', 
							`name` = '%s', 
							`descr` = '%s' 
						WHERE `id_album` = %s;", 
						$this->table_albums, $alias, $name, $descr, $id_album);
		
		if ($this -> db -> query ($sql)) {
			$result = "success";
			$text	= "Сохранено.";
		}			
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно сохранить.";
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Удаление альбома
	//	$id_album - id альбома
	////////////////////////////////////////////////////////////////////////////////
	
	function DeleteAlbum ($id_album) {
		
		$sql = sprintf("DELETE FROM %s WHERE `id_album` = %s", 
						$this->table_albums, $id_album);
		
		if ($this -> db -> query ($sql)) {
			
			$sql = sprintf("DELETE FROM %s WHERE `id_album` = %s;", 
							$this -> table_photos, $id_album);
			
			$this -> db -> query ($sql);
				
			$images = glob($this->path_server . $id_album . "/*.*", GLOB_NOSORT);
				
			if ($images) {
					
				for ($i=0; $i<count($images); $i++)
					@unlink($images[$i]);
					
				@rmdir($this->path_server . $id_album . "/");							
			}
			
			$result = "success";
			$text	= "Удалено.";
		}			
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно удалить альбом.";
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение информации об альбоме
	//	$id_album - id альбома
	////////////////////////////////////////////////////////////////////////////////
	
	function GetAlbum ($id_album) {
		
		$sql = sprintf("SELECT * FROM %s WHERE `id_album` = %s", 
						$this -> table_albums, $id_album);
		
		$album = $this -> db -> getResultArray ($sql);
		
		return ($album) ? $album[0] : array();
	}
		
	////////////////////////////////////////////////////////////////////////////////
	//	Получение фотографий альбома
	//	$id_album - id альбома
	////////////////////////////////////////////////////////////////////////////////
	
	function GetAlbumPhotos ($id_album) {
		
		$sql = sprintf("SELECT `id_photo`, `name` ,`descr` FROM %s 
						WHERE `id_album` = %s;", 
						$this->table_photos, $id_album);
		
		if ($photos = $this -> db -> getResultArray ($sql))	{			
			for ($j=0; $j<count($photos); $j++) {			
				
				$image = glob($this->path_server . $id_album . "/" . $photos[$j]['id_photo'] . ".*", 		GLOB_NOSORT);
				$thumb = glob($this->path_server . $id_album . "/" . $photos[$j]['id_photo'] . "_thumb.*", 	GLOB_NOSORT);
				
				$photos[$j]['photo'] = ($image) ? ($this->path_src.$id_album."/".basename($image[0])) : "";
				$photos[$j]['thumb'] = ($thumb) ? ($this->path_src.$id_album."/".basename($thumb[0])) : "";
			}
		}
		
		return $photos;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение фотографий альбома по текстовому идентификатору
	//	$album - идентификатор альбома
	////////////////////////////////////////////////////////////////////////////////
	
	function GetPhotos ($album) {
		
		$sql = sprintf("SELECT P.id_photo, P.name, P.descr, P.id_album
						FROM %s P INNER JOIN %s A ON P.id_album = A.id_album
						WHERE A.alias = '%s';", 
						$this->table_photos, $this->table_albums, $album);
		
		if ($photos = $this -> db -> getResultArray ($sql))	{			
			for ($j=0; $j<count($photos); $j++) {			
				
				$image = glob($this->path_server . $photos[$j]['id_album'] . "/" . $photos[$j]['id_photo'] . ".*", 			GLOB_NOSORT);
				$thumb = glob($this->path_server . $photos[$j]['id_album'] . "/" . $photos[$j]['id_photo'] . "_thumb.*", 	GLOB_NOSORT);
				
				$photos[$j]['photo'] = ($image) ? ($this->path_src.$photos[$j]['id_album']."/".basename($image[0])) : "";
				$photos[$j]['thumb'] = ($thumb) ? ($this->path_src.$photos[$j]['id_album']."/".basename($thumb[0])) : "";
			}
		}
		
		return $photos;
	}
			
	////////////////////////////////////////////////////////////////////////////////
	//	Добавление новой фотографии
	//	$id_album - id альбома
	////////////////////////////////////////////////////////////////////////////////
	
	function CreatePhoto ($id_album) {
		
		$sql = sprintf("INSERT INTO %s SET `id_album` = %s;", 
						$this->table_photos, $id_album);
		
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
	//	Обновление описания фотографии
	//	$id_photo - id фотографии
	//	$descr - описание
	////////////////////////////////////////////////////////////////////////////////
	
	function UpdatePhoto ($id_photo, $name, $descr) {
		
		$sql = sprintf("UPDATE %s SET `name` = '%s', `descr` = '%s' 
						WHERE `id_photo` = %s", 
						$this->table_photos, $name, $descr, $id_photo);
		
		if ($this -> db -> query ($sql)) {
			$result = "success";
			$text 	= "Сохранено.";
		}

		return array2json(array("result" => $result, "text" => $text));		
	}

	////////////////////////////////////////////////////////////////////////////////
	//	Удаление фотографии
	//	$id_photo - id фотографии
	////////////////////////////////////////////////////////////////////////////////
	
	function DeletePhoto ($id_photo) {
		
		$sql = sprintf("SELECT `id_album` FROM %s 
						WHERE `id_photo` = %s LIMIT 1;", 
						$this->table_photos, $id_photo);
		
		if ($item = $this -> db -> getResultArray($sql)) {
			
			$id_album = $item[0]['id_album'];
		
			$sql = sprintf("DELETE FROM %s WHERE `id_photo` = %s;", 
							$this->table_photos, $id_photo);
			
			if ($this -> db -> query ($sql)) {
				
				$result = "success";
				$text = "Удалено.";
				
				$image = glob($this->path_server . $id_album . "/" . $id_photo . ".*", 			GLOB_NOSORT);
				$thumb = glob($this->path_server . $id_album . "/" . $id_photo . "_thumb.*", 	GLOB_NOSORT);
				
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
			
		return array2json(array("result" => $result, "text" => $text));
	}
	
}

?>