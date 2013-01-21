<?php

/*function subspacestr ($string, $from, $count) {
	if (strlen($string)<$count)
		return $string;
	while (($string[$count-1]!=" ")&&($string[$count-1]!=".")&&($count<=strlen($string)))
		$count++;
	return substr(nl2br(strip_tags($string)), $from, $count);
}*/

class Search extends WorkWithData {

	////////////////////////////////////////////////////////////////////////////////
	//	ÑÂÎÉÑÒÂÀ ÊËÀÑÑÀ
	////////////////////////////////////////////////////////////////////////////////

	function Search ($mode = "all") {

		global $cfg;

		$this -> WorkWithData ();
		
		switch ($mode) {
			
			case "all":
				$this -> pages = array("pages", "module_articles", "module_news", "module_objects");
				break;
				
			default:
				$this -> pages = array("pages", "module_articles", "module_news", "module_objects");
				break;
		}
		
		$this -> table_search = $cfg['DB']['Table']['prefix'] . "module_search";
		
		$search_settings = $this -> db -> getResultArray ( "SELECT * FROM " . $this -> table_search . " LIMIT 1" );
		
		$this -> text_length = $search_settings[0]['text_length'];
		$this -> per_page = $search_settings[0]['per_page'];
		
		for ($i=0; $i<count($this -> pages); $i++)
			$this -> table_pages[$this -> pages[$i]] = $cfg['DB']['Table']['prefix'] . $this -> pages[$i];
		
		return true;
	}

	function PageSearch ($text, $page, &$page_array) {

		$return = array();
		$count=0;
		
		$text = "%".mysql_escape_string($text)."%";
		
		foreach ($this -> table_pages as $key=>$value) {
			
			switch ($key) {
				
				case "pages": 
					$result = $this -> db -> getResultArray ( sprintf ("SELECT `page_id`, `pid`, `name`, `url` FROM %s WHERE (`content` LIKE '%s') AND (`active` = 1) ", $this -> table_pages[$key], $text )); 
					break;
				
				case "module_articles":
					$result = $this -> db -> getResultArray ( sprintf ("SELECT `id_article`, `title`, `year`, `month` FROM %s WHERE (`title` LIKE '%s') OR (`text` LIKE '%s');", $this -> table_pages[$key], $text, $text )); 
					break;
					
				case "module_news":
					$result = $this -> db -> getResultArray ( sprintf ("SELECT `id_article`, `title`, `year`, `month` FROM %s WHERE (`title` LIKE '%s') OR (`text` LIKE '%s');", $this -> table_pages[$key], $text, $text )); 
					break;
					
				case "module_objects":
					$result = $this -> db -> getResultArray ( sprintf ("SELECT `id_object`, `name` FROM %s WHERE (`name` LIKE '%s') OR (`short_description` LIKE '%s') OR (`description` LIKE '%s');", $this -> table_pages[$key], $text, $text, $text )); 
					break;
				
				default: 
					$result = array();
					break;
			}
			
			for ($i=0; $i<count($result); $i++) {
				$count++;
				
				if (($count>(($page-1)*$this->per_page))&&($count<=(($page*$this->per_page)))) {
				
					switch ($key) {
					
						case "pages":
							
							$item['title'] = $result[$i]['name'];
							
							$item['href'] = "";
							
							if ($result[$i]['pid']>0) {
								
								$pid = $result[$i]['pid'];
								
								while ($pid > 0) {
									
									$sql = sprintf("SELECT `pid`, `url` FROM `promycms_pages` WHERE `page_id` = %s;", $pid);
									
									$pg = $this -> db -> getResultArray ($sql);
									
									if (!$pg)
										break;
										
									$item['href'] .= "/" . $pg[0]['url'];
									
									$pid = $pg[0]['pid'];
								}
							}
								
							if ($result[$i]['url']!="")
								$item['href'] .= "/" . $result[$i]['url'] . "/";
							else
								$item['href'] = "/";
								
							break;
							
						case "module_articles": 
							$item['title'] = "Ñòàòüè: &laquo;" . $result[$i]['title'] . "&raquo;";
							$item['href'] = "/articles/" . $result[$i]['year'] . "/" . $result[$i]['month'] . "/" . $result[$i]['id_article'] . "/";							
							break;
							
						case "module_news": 
							$item['title'] = "Íîâîñòè: &laquo;" . $result[$i]['title'] . "&raquo;";
							$item['href'] = "/news/" . $result[$i]['year'] . "/" . $result[$i]['month'] . "/" . $result[$i]['id_article']."/";							
							break;
							
						case "module_objects": 
							$item['title'] = "Îáúåêòû: &laquo;" . $result[$i]['name'] . "&raquo;";
							$item['href'] = "/projects/" . $result[$i]['id_object'] . "/";							
							break;
							
						default: 
							$item['href'] = "";							
							break;
					}
						
					$return[$count] = $item;
				} 
			}
			
		}
		
		if ($count>0) {
			$page_count = ($count-($count%$this->per_page))/$this->per_page;
			if (($count%$this->per_page)>0)
				$page_count++;
			for ($i=1; $i<=$page_count; $i++)
				$page_array[$i]=$i;
		}
		
		return $return;
	}
}

?>