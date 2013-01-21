<?php


////////////////////////////////////////////////////////////////////////////////
//
//	Клаcc для работы c данными страницы.
//
////////////////////////////////////////////////////////////////////////////////

class PageData extends WorkWithData {


	function PageData () {

		global $cfg;

		$this->WorkWithData ();

		$i = 0;
		$fields[$i++] = array ( "name" => "page_id",     "description" => "ID запиcи",              "html_type" => "hidden",    "no_empty" => 0, "in_list" => 0, "in_select" => "id" );
		$fields[$i++] = array ( "name" => "pid",         "description" => "Родительская категория", "html_type" => "select",    "no_empty" => 0, "in_list" => 0, "source" => "PageData->GetSelectTree" );
		$fields[$i++] = array ( "name" => "active",	     "description" => "Статус",		            "html_type" => "checkbox",  "no_empty" => 0, "in_list" => 0 );
		$fields[$i++] = array ( "name" => "priority",    "description" => "Приоритет", 				"html_type" => "text",	    "no_empty" => 0, "in_list" => 0);
		$fields[$i++] = array ( "name" => "name",        "description" => "Название страницы",      "html_type" => "text",      "no_empty" => 1, "in_list" => 1, "in_select" => "name" );
		$fields[$i++] = array ( "name" => "url",         "description" => "URL страницы",           "html_type" => "text",      "no_empty" => 0, "in_list" => 1 );
		$fields[$i++] = array ( "name" => "title",       "description" => "Данные тэга TITLE",      "html_type" => "text",      "no_empty" => 0, "in_list" => 0 );
		$fields[$i++] = array ( "name" => "keywords",    "description" => "Данные keywords",        "html_type" => "textarea",  "no_empty" => 0, "in_list" => 0 );
		$fields[$i++] = array ( "name" => "description", "description" => "Данные description",     "html_type" => "textarea",  "no_empty" => 0, "in_list" => 0 );
		$fields[$i++] = array ( "name" => "content",     "description" => "Содержание",             "html_type" => "content",   "no_empty" => 0, "in_list" => 0 );
		$fields[$i++] = array ( "name" => "template_id", "description" => "Шаблон",                 "html_type" => "select",    "no_empty" => 1, "in_list" => 1, "source" => "Templates->GetSelect" );
		$fields[$i++] = array ( "name" => "type_id", 	 "description" => "Параметры",              "html_type" => "checkbox",  "no_empty" => 1, "in_list" => 1);
		$fields[$i++] = array ( "name" => "date_create", "description" => "Дата добавления",      	"html_type" => "date",      "no_empty" => 1, "in_list" => 0, "autofill" => time () );
		$fields[$i++] = array ( "name" => "date_update", "description" => "Дата изменения",       	"html_type" => "date",      "no_empty" => 1, "in_list" => 0, "autofill" => time () );

		$this->fields  = $fields;
		$this->section = "pages";
		$this->table   = $cfg['DB']['Table']['pages'];
		$this->listOrderBy = "ORDER BY page_id ASC";

		return true;

	}

	////////////////////////////////////////////////////////////////////////////////
	//	МЕТОДЫ КЛАCCА

	function GetPageInfo ( $page_id ) {

		global $cfg;

		$PageInfo 	= $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE page_id = %s", $this->table, $page_id ));
		$PageTpl 	= $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE template_id = %s LIMIT 1", $cfg['DB']['Table']['templates'], $PageInfo[0]['template_id'] ));
		$PageInfo[0]['template_name'] = $PageTpl[0]['name'];
		
		return $PageInfo;
	}

	function getCntPage () {

		return $this->db->getResultArray ( sprintf( "SELECT count(page_id) AS cnt FROM %s", $this->table ) );
	}

	function getCntNodePage ( $page_id ) {

		global $cfg;

		return $this->db->getResultArray ( sprintf( "SELECT count(page_id) AS cnt FROM %s WHERE pid  = %s", $this->table, $page_id ) );
	}

	function checkURL( $urlArr ) {
        global $cfg;
		$really = $this -> getRecordByUrl( $urlArr );
        //var_dump($really); exit( "checkURL();" );
		
        $reallyurl = (((count($urlArr)>=2)&&($urlArr[1]!="")) ? "/" : "") . $this -> getUrlById($really[0]['page_id']);
        //var_dump($reallyurl); exit( "checkURL();" );
		$needurl = implode("/",$urlArr) . (((count($urlArr)>=2)&&($urlArr[1]!="")) ? "/" : "");

		if (($reallyurl!=$needurl)&&($really[0]['type_id']!=1))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	//	Получение URI страницы по её ID
	function GetUrlById ( $page_id ) {

		//	получение первого родителя
		$rec = $this->db->getResultArray ( sprintf ( "SELECT HIGH_PRIORITY pid, url FROM %s WHERE page_id='%s'", $this->table, $page_id ) );
		$url = trim ( $rec[0]['url'] );

		//	если родитель не корневой, то продолжаем собирать URI
		if ( $url != "" ) {

			while ( trim ( $rec[0]['url'] ) != "" ) {

				$rec = $this->db->getResultArray ( sprintf ( "SELECT HIGH_PRIORITY pid, url FROM %s WHERE page_id='%s'", $this->table, $rec[0]['pid'] ) );
				if ( trim ( $rec[0]['url'] ) != "" )
				//	формируем URI
				$url = trim ( $rec[0]['url'] ) . "/" . $url;
				else
				//	если достигли корневого родителя, останавливаем цикл
				break;

			}

		}

		//	возврат сформированного URI
		return $url . "/";

	}

	//	Получение URI страницы по её ID
	function GetPathById ( $page_id )
	{

		//	получение первого родителя
		$rec = $this->db->getResultArray ( sprintf ( "SELECT HIGH_PRIORITY pid, name FROM %s WHERE page_id='%s'", $this->table, $page_id ) );
		$pname = trim ( $rec[0]['name'] );

		//	если родитель не корневой, то продолжаем собирать URI
		if ( $pname != "" ) {

			while ( trim ( $rec[0]['name'] ) != "" ) {

				$rec = $this->db->getResultArray ( sprintf ( "SELECT HIGH_PRIORITY pid, name FROM %s WHERE page_id='%s'", $this->table, $rec[0]['pid'] ) );
				if ( trim ( $rec[0]['name'] ) != "" )
				//	формируем URI
				$pname = trim ( $rec[0]['name'] ) . "/" . $pname;
				else
				//	если достигли корневого родителя, останавливаем цикл
				break;

			}

		}

		//	возврат сформированного URI
		return $pname . "/";

	}


    // $urlArr[0] - имя файла страницы (первый параметр в строке запроса), для главной страницы - '' 
	function GetRecordByUrl($urlArr) {

		global $cfg;
        
        $i = 0;
		$rec = $this->db->getResultArray ( sprintf ( "SELECT HIGH_PRIORITY page_id, type_id, name FROM %s WHERE url='%s'", $this->table, $urlArr[$i] ) );
		$LinkLine[$i]['url']  = $urlArr[$i];
		$LinkLine[$i]['name'] = $rec[0]['name'];
		
        //var_dump($rec); exit(0);
        
		if ( count ( $rec ) > 0 ) {

			$page_id = $rec[0]['page_id'];
			
			$type_id = $rec[0]['type_id'];
			
			if ( !( count ( $urlArr ) == 1 or $rec[0]['type_id'] == 1 ) ) {

				//while ( $rec[0][type_id] != 1 ) {
				while ($i<(count($urlArr)-1)) {
					$i++;
					$rec = $this->db->getResultArray ( sprintf ( "SELECT HIGH_PRIORITY page_id, type_id, name FROM %s WHERE pid='%s' AND url='%s'", $this->table, $page_id, $urlArr[$i] ) );

					if ( count ( $rec ) > 0 ) {
						
						$type_id = $rec[0]['type_id'];
						
						$page_id = $rec[0]['page_id'];
						
						if ( $i > 1 )
							$LinkLine[$i]['url']  = $LinkLine[$i - 1]['url'] . "/" . $urlArr[$i];
						else
							$LinkLine[$i]['url']  = $urlArr[$i];
							
						$LinkLine[$i]['name'] = $rec[0]['name'];

					} 
					else {
						if ($type_id==1)
							$i--;
						
						break;

					}

				}

			}
			
			return array ( $this->GetRecord ( $page_id ), array_slice ( $urlArr, 1, $i ), array_slice ( $urlArr, $i + 1 ), $LinkLine );

		} else {
			page_jump( $cfg['PATH']['www_root'] );
		}

	}
	function GetRecordByField ( $field, $what ) {

		global $cfg;

		$what_line = is_array ( $what ) ? implode ( "', '", $what ) : $what;
		return $this->db->getResultArray ( sprintf ( "SELECT HIGH_PRIORITY * FROM %s WHERE %s IN ('%s')", $this->table, $field, $what_line ) );

	}
	////////////////////////////////////////////////////////////////////////////////

	function GetPageContent ($id_page) {
	
		$Page = $this -> db -> getResultArray ( sprintf ("SELECT content FROM %s WHERE page_id = %s", $this->table, $id_page ));
		return $Page[0]['content'];
	}
	
	function SavePageContent ($id_page, $content) {
	
		return $this -> db -> query ( sprintf ("UPDATE %s SET content = '%s' WHERE page_id = %s", $this->table, $content, $id_page));
	}
}
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//	Вывод информации о подключенном файле.
if ( ERROR_PRINT_INCLUDE_FILENAME != 0 )
echo "Class PageData (file " . basename ( __FILE__ ) . ")<br>";
////////////////////////////////////////////////////////////////////////////////

?>