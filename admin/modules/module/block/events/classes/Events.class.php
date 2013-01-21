<?php

////////////////////////////////////////////////////////////////////////////////
//	Класс "Мероприятия"
////////////////////////////////////////////////////////////////////////////////

class Events extends WorkWithData {

	////////////////////////////////////////////////////////////////////////////////
	//	Свойства класса
	////////////////////////////////////////////////////////////////////////////////
	
	var $table_events;
		
	////////////////////////////////////////////////////////////////////////////////
	//	Конструктор
	////////////////////////////////////////////////////////////////////////////////
	
	function Events () {

		global $cfg;

		$this -> WorkWithData ();
		
		$this -> table_events 	= $cfg['DB']['Table']['prefix'] . "module_events";
		$this -> table_photos	= $cfg['DB']['Table']['prefix'] . "module_event_photos";
		
		$this -> path_src = "/images/events/";
		$this -> path_server = $cfg['PATH']['root'] . "images/events/";
		
		return true;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение списка годов
	//	$order - порядок сортировки ("ASC" или "DESC")
	////////////////////////////////////////////////////////////////////////////////
	
	function GetYearList ($order) {
		
		$_years = $this -> db -> getResultArray ( sprintf ("SELECT DISTINCT `year` FROM %s ORDER BY `year` %s;", $this -> table_events, $order ));
		
		if ($_years) {
		
			for ($i=0; $i<count($_years); $i++)
				$years[$i] = $_years[$i]['year'];
				
			return $years;
		}
		else
			return array();
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение списка мероприятий за определенный год
	//	$year - год
	//	$order - порядок сортировки ("ASC" или "DESC")
	////////////////////////////////////////////////////////////////////////////////
	
	function GetEventList ($year, $order) {
		
		return $this -> db -> getResultArray ( sprintf ("SELECT `id_event`, `title` FROM %s WHERE `year` = '%s' ORDER BY `id_event` %s;", $this -> table_events, $year, $order ));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение списка мероприятий за определенный год в формате JSON
	//	$year - год
	//	$order - порядок сортировки ("ASC" или "DESC")
	////////////////////////////////////////////////////////////////////////////////
	
	function GetEventListJSON ($year) {
		
		if ($_items = $this -> GetEventList($year, "DESC")) {
			
			$items = array();
			$items[0]['value'] = 0;
			$items[0]['caption'] = "";
		
			for ($i=0; $i<count($_items); $i++) {
				$items[$i+1]['value'] = $_items[$i]['id_event'];
				$items[$i+1]['caption'] = $_items[$i]['title'];
			}
			
			$result = "success";
			$text = $items;
		}
		else {
			$result = "error";
			$text = "Ошибка. Невозможно получить список мероприятий за данный год.";
		}
		
		return array2json( array("result" => $result, "text" => $text) );
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение информации о мероприятии
	//	$id_event - id мероприятия
	////////////////////////////////////////////////////////////////////////////////
	
	function GetEvent ($id_event) {
		
		if ( $event = $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE `id_event` = %s LIMIT 1;", $this -> table_events, $id_event )) ) {
			$event[0]['photos'] = $this -> GetEventPhotos($id_event);
			return $event[0];
		}
		else
			return array();
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение следующего мероприятия
	//	$date - дата текущего мероприятия
	////////////////////////////////////////////////////////////////////////////////
	
	function GetNext ($id_event, $year) {
		
		if ( $events = $this -> GetEventsByYear ($year) ) {			
			for ($i=0; $i<count($events); $i++)
				if ($events[$i]['id_event']==$id_event) {
					if ($i>0)
						return $events[$i-1];
					else
						return array();			
				}
		}
		else
			return array();
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение предыдущего мероприятия
	//	$date - дата текущего мероприятия
	////////////////////////////////////////////////////////////////////////////////
	
	function GetPrevious ($id_event, $year) {
		
		if ( $events = $this -> GetEventsByYear ($year) ) {
			for ($i=0; $i<count($events); $i++)
				if ($events[$i]['id_event']==$id_event) {
					if ($i<(count($events)-1))
						return $events[$i+1];
					else
						return array();
				}
		}
		else
			return array();
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение детализированной информации о мероприятии
	//	$id_event - id омероприятия
	////////////////////////////////////////////////////////////////////////////////
	
	function GetEventDetails ($id_event) {
		
		$event = $this -> GetEvent($id_event);
		
		if ($event) {
			
			$event['photos'] = $this -> GetEventPhotos($id_event);
			
			$result = "success";
			$text = $event;
		}
		else {
			$result = "error";
			$text	= "Can't get event with id = " . $id_event;
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение мероприятий с краткой аннотацией
	//	$count - количество мероприятий
	////////////////////////////////////////////////////////////////////////////////
	
	function GetEvents ($count) {
	
		return $this -> db -> getResultArray ( sprintf ("SELECT `id_event`, `title`, `annot`, `date`, `year` FROM %s ORDER BY `date` DESC, `id_event` DESC LIMIT %s;", $this -> table_events, $count ));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение мероприятий с краткой аннотацией за последний год
	////////////////////////////////////////////////////////////////////////////////
	
	function GetLastYearEvents () {
		
		return $this -> db -> getResultArray ( sprintf ("SELECT `id_event`, `title`, `annot`, `date`, `year` FROM %s WHERE (`year` = (SELECT MAX(`year`) FROM %s LIMIT 1)) ORDER BY `date` DESC, `id_event` DESC;", $this -> table_events, $this -> table_events ));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение мероприятий с краткой аннотацией за опр. год
	//	$year - год
	////////////////////////////////////////////////////////////////////////////////
	
	function GetEventsByYear ($year) {	
	
		return $this -> db -> getResultArray ( sprintf ("SELECT `id_event`, `title`, `annot`, `date`, `year` FROM %s WHERE `year` = %s  ORDER BY `date` DESC, `id_event` DESC;", $this -> table_events, $year ));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение мероприятий по годам
	////////////////////////////////////////////////////////////////////////////////
	
	function GetEventsByYears ($order) {
		
		$events = array();
		
		if ($years = $this -> GetYearList("DESC"))
			for ($i=0; $i<count($years); $i++) {
				$events[$i]['year'] = $years[$i];
				$events[$i]['events'] = $this -> GetEventList ($years[$i], $order);
			}
			
		return $events;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Добавление нового мероприятия
	//	$title - заголовок мероприятия
	//	$text - текст мероприятия
	//	$date - дата
	////////////////////////////////////////////////////////////////////////////////
	
	function CreateEvent ($title, $annot, $text, $date) {
		
		$year = substr($date, 0, 4);
		
		$this -> db -> query ( sprintf ("INSERT INTO %s (`title`, `annot`, `text`, `year`, `date`) VALUES ('%s', '%s', '%s', '%s', '%s');", $this -> table_events, $title, $annot, $text, $year, $date ));
			
		if ($text = $this -> db -> last_id()) {
			$result = "success";
		}			
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно добавить мероприятие.";
		}
		
		$years = array();
		$years[0]['value'] = 0;
		$years[0]['caption'] = "";
		$_years = $this -> GetYearList("DESC");
			
		if (is_array($_years) && (count($_years)>0)) {
			for ($i=0; $i<count($_years); $i++) {
				$years[$i+1]['value'] = $_years[$i];
				$years[$i+1]['caption'] = $_years[$i];
			}
		}
		
		return array2json( array("result" => $result, "text" => $text, "years" => $years) );
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Сохранение мероприятия
	//	$id_event - id мероприятия
	//	$title - заголовок
	//	$annot - краткая аннотация
	//	$text - текст
	//	$date - дата
	////////////////////////////////////////////////////////////////////////////////
	
	function UpdateEvent ($id_event, $title, $annot, $text, $date) {
		
		$year = substr($date, 0, 4);
		
		if ( $this -> db -> query ( sprintf ("UPDATE %s SET `title` = '%s', `annot` = '%s', `text` = '%s', `year` = '%s', `date` = '%s' WHERE `id_event` = %s;", $this -> table_events, $title, $annot, $text, $year, $date, $id_event )) ) {
			$result = "success";
			$text = "Сохранено.";
		}			
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно сохранить мероприятие.";
		}
		
		$years = array();
		$years[0]['value'] = 0;
		$years[0]['caption'] = "";
		$_years = $this -> GetYearList("DESC");
			
		if (is_array($_years) && (count($_years)>0)) {
			for ($i=0; $i<count($_years); $i++) {
				$years[$i+1]['value'] = $_years[$i];
				$years[$i+1]['caption'] = $_years[$i];
			}
		}
		
		return array2json( array("result" => $result, "text" => $text, "years" => $years) );
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Удаление мероприятия
	//	$id_event - id удаляемого мероприятия
	////////////////////////////////////////////////////////////////////////////////
	
	function DeleteEvent ($id_event) {
		
		if ($this -> db -> query ( sprintf ("DELETE FROM %s WHERE `id_event` = %s;", $this -> table_events, $id_event ))) {
			$result = "success";
			$text = "Удалено.";
			
			if ($photos = $this -> GetEventPhotos($id_event)) {
			
				for ($i=0; $i<count($photos); $i++) {			
					
					if ( file_exists($this->path_server . basename($photos[$i]['photo'])) )
						@unlink($this->path_server . basename($photos[$i]['photo']));
								
					if ( file_exists($this->path_server . basename($photos[$i]['thumb'])) )
						@unlink($this->path_server . basename($photos[$i]['thumb']));
				}
						
				$this -> db -> query ( sprintf ("DELETE FROM %s WHERE `id_event` = %s;", $this -> table_photos, $id_event ));			
			}
		}			
		else {
			$result = "error";
			$text	= "Ошибка. Невозможно удалить мероприятие.";
		}
		
		$years = array();
		$years[0]['value'] = 0;
		$years[0]['caption'] = "";
		$_years = $this -> GetYearList("DESC");
			
		if (is_array($_years) && (count($_years)>0)) {
			for ($i=0; $i<count($_years); $i++) {
				$years[$i+1]['value'] = $_years[$i];
				$years[$i+1]['caption'] = $_years[$i];
			}
		}
		
		return array2json( array("result" => $result, "text" => $text, "years" => $years) );
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	Получение фотографий мероприятия
	//	$id_event - id мероприятия
	////////////////////////////////////////////////////////////////////////////////
	
	function GetEventPhotos ($id_event) {
	
		$photos = $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE `id_event` = %s", $this->table_photos, $id_event ));
		
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
	//	Получить количество фотографий для мероприятия
	//	$id_event - id мероприятия
	////////////////////////////////////////////////////////////////////////////////
	
	function GetEventPhotosCount ($id_event) {
	
		$count = $this -> db -> getResultArray ( sprintf ("SELECT COUNT(*) AS total FROM %s WHERE `id_event` = %s;", $this->table_photos, $id_event ));
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
	//	$id_event - id мероприятия
	//	$image - имя файла
	////////////////////////////////////////////////////////////////////////////////
	
	function CreatePhoto ($id_event, $image) {
		
		$this -> db -> query ( sprintf ("INSERT INTO %s (`id_event`, `image`) VALUES (%s, '%s');", $this->table_photos, $id_event, $image ));
		
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
}

?>