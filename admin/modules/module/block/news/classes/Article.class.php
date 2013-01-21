<?php

////////////////////////////////////////////////////////////////////////////////
//	����� "������"
////////////////////////////////////////////////////////////////////////////////

class Article extends WorkWithData {

	////////////////////////////////////////////////////////////////////////////////
	//	�������� ������
	////////////////////////////////////////////////////////////////////////////////
	
	var $table_articles;
		
	////////////////////////////////////////////////////////////////////////////////
	//	�����������
	////////////////////////////////////////////////////////////////////////////////
	
	function Article () {

		global $cfg;

		$this -> WorkWithData ();
		
		$this -> table_articles = $cfg['DB']['Table']['prefix']."module_news";
		
		return true;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	��������� ������ �����
	//	$order - ������� ���������� ("ASC" ��� "DESC")
	////////////////////////////////////////////////////////////////////////////////
	
	function GetYearList ($order) {
		
		$sql = sprintf("SELECT DISTINCT `year` FROM %s ORDER BY `year` %s;", 
						$this->table_articles, $order);
		
		if ($_years = $this -> db -> getResultArray ($sql)) {
		
			for ($i=0; $i<count($_years); $i++)
				$years[$i] = $_years[$i]['year'];
				
			return $years;
		}
		else
			return false;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	�������� ������ ������� ��� ���. ����
	//	$year - ���
	////////////////////////////////////////////////////////////////////////////////
	
	function GetMonths ($year) {
		
		$sql = sprintf("SELECT DISTINCT `month` FROM %s 
						WHERE `year` = %s ORDER BY `month` ASC;", 
						$this->table_articles, $year);
						
		global $_MONTHS;
			
		$months = $_MONTHS;
		
		if ($result = $this -> db -> getResultArray ($sql)) {			
			for ($i=0; $i<count($result); $i++) {
				$months[$result[$i]['month']]['active'] = true;
			}		
		}
		
		return $months;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	��������� ������ ������ �� ������������ ���
	//	$year - ���
	//	$order - ������� ���������� ("ASC" ��� "DESC")
	////////////////////////////////////////////////////////////////////////////////
	
	function GetArticleList ($year, $order) {
		
		$sql = sprintf("SELECT `id_article`, `title` FROM %s 
						WHERE `year` = '%s' ORDER BY `id_article` %s;", 
						$this->table_articles, $year, $order);
		
		return $this -> db -> getResultArray ($sql);
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	��������� ������ ������ �� ������������ ��� � ������� JSON
	//	$year - ���
	//	$order - ������� ���������� ("ASC" ��� "DESC")
	////////////////////////////////////////////////////////////////////////////////
	
	function GetArticleListJSON ($year) {
		
		if ($_items = $this -> GetArticleList($year, "DESC")) {
			
			$items = array();
			$items[0]['value'] = 0;
			$items[0]['caption'] = "";
		
			for ($i=0; $i<count($_items); $i++) {
				$items[$i+1]['value'] = $_items[$i]['id_article'];
				$items[$i+1]['caption'] = $_items[$i]['title'];
			}
			
			$result = "success";
			$text = $items;
		}
		else {
			$result = "error";
			$text = "������. ���������� �������� ������ �������� �� ������ ���.";
		}
		
		return array2json( array("result" => $result, "text" => $text) );
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	��������� ���������� � ������
	//	$id_article - id ������
	////////////////////////////////////////////////////////////////////////////////
	
	function GetArticle ($id_article) {
		
		$sql = sprintf("SELECT * FROM %s WHERE `id_article` = %s LIMIT 1;", 
						$this->table_articles, $id_article);
		
		if ($article = $this -> db -> getResultArray ($sql))
			return $article[0];
		else
			return false;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	��������� ��������� ������
	//	$date - ���� ������� ������
	////////////////////////////////////////////////////////////////////////////////
	
	function GetNext ($id_article, $date, $filter = false) {
		
		if ($filter) {			
			foreach ($filter as $key => $value) {				
				$_filter .= "(`".$key."` = ".$value.") AND ";
			}
		}
		else {
			$_filter = "";
		}
		
		$sql = sprintf("SELECT `id_article`, `title`, `year`, `month` FROM %s 
						WHERE %s (`id_article` <> %s) AND (`date` >= '%s') 
						ORDER BY `date` ASC, `id_article` ASC LIMIT 1;", 
						$this->table_articles, $_filter, $id_article, $date);
		
		if ($article = $this -> db -> getResultArray ($sql))
			return $article[0];
		else
			return false;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	��������� ���������� ������
	//	$date - ���� ������� ������
	////////////////////////////////////////////////////////////////////////////////
	
	function GetPrevious ($id_article, $date, $filter = false) {
		
		if ($filter) {			
			foreach ($filter as $key => $value) {
				$_filter .= "(`".$key."` = ".$value.")";
			}
		}
		else {
			$_filter = "";
		}
		
		$sql = sprintf("SELECT `id_article`, `title`, `year`, `month` FROM %s 
						WHERE %s (`id_article` <> %s) AND (`date` <= '%s') 
						ORDER BY `date` DESC, `id_article` DESC LIMIT 1;", 
						$this->table_articles, $_filter, $id_article, $date);
		
		if ($article = $this -> db -> getResultArray ($sql))
			return $article[0];
		else
			return false;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	��������� ���������� � ������ � ������� JSON
	//	$id_article - id ������
	////////////////////////////////////////////////////////////////////////////////
	
	function GetArticleJSON ($id_article) {
		
		if ($text = $this -> GetArticle($id_article)) {
			$result = "success";
		}
		else {
			$result = "error";
			$text = "������. ���������� �������� �������.";
		}
		
		return array2json( array("result" => $result, "text" => $text) );
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	��������� ������ � ������� ����������
	////////////////////////////////////////////////////////////////////////////////
	
	function GetShortArticles ($filter, $from = 0, $count = 0) {
		
		if ($filter) {
			
			$_filter = "WHERE ";
			
			$i = 0;
			
			foreach ($filter as $key => $value) {
				
				if ($i>0)
					$_filter .= " AND ";
				
				$_filter .= "(`".$key."` = ".$value.")";
				
				$i++;
			}
		}
		else {
			$_filter = "";
		}
		
		$limits = ($count>0) ? ("LIMIT ".$from.", ".$count) : "";
		
		$sql = sprintf("SELECT `id_article`, `title`, `annot`, `year`, `month`, `date` 
						FROM %s %s ORDER BY `date` DESC, `id_article` DESC %s;", 
						$this->table_articles, $_filter, $limits);
		
		return $this -> db -> getResultArray($sql);		
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	��������� ������ ������
	////////////////////////////////////////////////////////////////////////////////
	
	function GetOtherArticles ($id_article, $count = 4) {
		
		$sql = sprintf("SELECT `id_article`, `title`, `annot`, `year`, `month`, `date` FROM %s
						WHERE `id_article` <> %s ORDER BY `date` DESC, `id_article` DESC;", 
						$this->table_articles, $id_article);
		
		$articles = array();
		
		$result = $this -> db -> getResultArray($sql);
						
		if ($result) {
			
			if (count($result)<$count)
				$count = count($result);
			
			shuffle($result);
			
			for ($i=0; $i<$count; $i++)
				$articles[$i] = $result[$i];
		}
		
		return $articles;		
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	���������� ����� ������
	//	$title - ��������� ������
	//	$annot - ������� ���������
	//	$text - ����� ������
	//	$date - ����
	////////////////////////////////////////////////////////////////////////////////
	
	function CreateArticle ($title, $annot, $text, $date) {
		
		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		
		$sql = sprintf("INSERT INTO %s (`title`, `annot`, `text`, `year`, `month`, `date`) 
						VALUES ('%s', '%s', '%s', %s, '%s', '%s');", 
						$this->table_articles, $title, $annot, $text, $year, $month, $date);
		
		$this -> db -> query($sql);
			
		if ($text = $this -> db -> last_id()) {
			$result = "success";
		}			
		else {
			$result = "error";
			$text	= "������. ���������� �������� �������.";
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
	//	���������� ������
	//	$id_article - id ������
	//	$title - ��������� ������
	//	$annot - ������� ���������
	//	$text - ����� ������
	//	$date - ����
	////////////////////////////////////////////////////////////////////////////////
	
	function UpdateArticle ($id_article, $title, $annot, $text, $date) {
		
		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		
		$sql = sprintf("UPDATE %s SET 
							`title` = '%s', 
							`annot` = '%s', 
							`text` = '%s', 
							`year` = %s, 
							`month` = '%s', 
							`date` = '%s' 
						WHERE id_article = %s;", 
						$this->table_articles, $title, $annot, $text, $year, $month, $date, $id_article);
		
		if ($this -> db -> query ($sql)) {
			$result = "success";
			$text = "���������.";
		}			
		else {
			$result = "error";
			$text	= "������. ���������� ��������� �������.";
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
	//	�������� ������
	//	$id_article - id ��������� ������
	////////////////////////////////////////////////////////////////////////////////
	
	function DeleteArticle ($id_article) {
		
		$sql = sprintf("DELETE FROM %s WHERE `id_article` = %s;", 
						$this->table_articles, $id_article);
		
		if ($this -> db -> query ($sql)) {
			$result = "success";
			$text = "�������.";
		}			
		else {
			$result = "error";
			$text	= "������. ���������� ������� �������.";
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
	
}

?>