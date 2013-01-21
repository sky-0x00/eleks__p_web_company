<?php

////////////////////////////////////////////////////////////////////////////////
//	����� "�������� �����"
////////////////////////////////////////////////////////////////////////////////

class GuestBook extends WorkWithData {

	////////////////////////////////////////////////////////////////////////////////
	//	�������� ������
	////////////////////////////////////////////////////////////////////////////////
	
	var $table_messages;
	var $table_cats;
	var $per_page;
	var $per_page_admin;
	
	////////////////////////////////////////////////////////////////////////////////
	//	�����������
	////////////////////////////////////////////////////////////////////////////////
	
	function GuestBook () {

		global $cfg;

		$this -> WorkWithData ();
		
		$this -> per_page = 10;
		$this -> per_page_admin = 30;
		$this -> table_messages = $cfg['DB']['Table']['prefix'] . "module_guestbook_messages";
		$this -> table_cats 	= $cfg['DB']['Table']['prefix'] . "module_guestbook_categories";
				
		return true;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	�������� ������ 
	////////////////////////////////////////////////////////////////////////////////
	
	function GetCategories () {
		
		return $this -> db -> getResultArray ( sprintf ("SELECT `id_cat`, `name` FROM %s;", $this -> table_cats ));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	���������� ������ ���������
	//	$id_cat - id ���������
	//	$name - ���
	//	$email - ����� ����������� �����
	//	$text - ����� ���������
	////////////////////////////////////////////////////////////////////////////////
	
	function AddMessage ($id_cat, $name, $email, $text) {
		
		$this -> db -> query ( sprintf ("INSERT INTO %s (`id_cat`, `name`, `email`, `text`, `date`) VALUES (%s, '%s', '%s', '%s', NOW());", $this -> table_messages, $id_cat, $name, $email, $text ));
			
		if ($text = $this -> db -> last_id()) {
			$result = "success";
		}			
		else {
			$result = "error";
			$text	= "Error. Can't add message.";
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	������������� ���������
	//	$id_message - id ���������
	////////////////////////////////////////////////////////////////////////////////
	
	function SubmitMessage ($id_message) {
		
		$this -> db -> query ( sprintf ("UPDATE %s SET `status` = 1 WHERE `id_message` = %s;", $this -> table_messages, $id_message ));
			
		if ($text = $this -> db -> affected_rows()) {
			$result = "success";
		}			
		else {
			$result = "error";
			$text	= "Error. Can't submit message.";
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	���������� ��������� ���������
	//	$id_message - id ���������
	//	$id_cat - id ���������
	////////////////////////////////////////////////////////////////////////////////
	
	function UpdateMessage ($id_message, $id_cat) {
		
		if ($this -> db -> query ( sprintf ("UPDATE %s SET `id_cat` = %s WHERE `id_message` = %s;", $this -> table_messages, $id_cat, $id_message ))) {
			$result = "success";
			$text 	= $this -> db -> affected_rows();
		}			
		else {
			$result = "error";
			$text	= "Error. Can't update message.";
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	�������� ���������
	//	$id_message - id ���������
	////////////////////////////////////////////////////////////////////////////////
	
	function DeleteMessage ($id_message) {
		
		$this -> db -> query ( sprintf ("DELETE FROM %s WHERE `id_message` = %s;", $this -> table_messages, $id_message ));
			
		if ($text = $this -> db -> affected_rows()) {
			$result = "success";
		}			
		else {
			$result = "error";
			$text	= "Error. Can't delete message.";
		}
		
		return array2json(array("result" => $result, "text" => $text));
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	�������� ������ ��������� ��� �������
	////////////////////////////////////////////////////////////////////////////////
	
	function GetAdminMessages ($page) {
		
		$from = ($page-1) * $this -> per_page_admin;
		
		$messages = $this -> db -> getResultArray ( sprintf (  "SELECT * FROM %s ORDER BY `date` DESC, `id_message` DESC LIMIT %s, %s;", $this -> table_messages, $from, $this -> per_page_admin ));
		
		if ($messages) {
			
			for ($i=0; $i<count($messages); $i++) {
				$messages[$i]['num'] = $from + $i + 1;
			}
		}
		
		return $messages;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	�������� ������ ������� ��� �������
	////////////////////////////////////////////////////////////////////////////////
	
	function GetAdminPages () {
		
		$count = $this -> db -> getResultArray ( sprintf (  "SELECT count(*) AS `count` FROM %s;", $this -> table_messages ));
				
		$page_count = ($count[0]['count'] - ($count[0]['count']%$this->per_page_admin)) / $this->per_page_admin;
		
		if (($count[0]['count']%$this->per_page_admin)>0)
			$page_count++;
		
		$pages = array();
		
		for ($i=1; $i<=$page_count; $i++)
			$pages[$i]=$i;		
		
		return $pages;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	�������� ������ ��������� ��� ������� ����� �����
	//	$id_cat - id ��������� ������
	//	$page - ����� ��������
	////////////////////////////////////////////////////////////////////////////////
	
	function GetMessages ($id_cat, $page) {
		
		$from = ($page-1) * $this -> per_page;
		$where = ($id_cat > 0) ? " AND (`id_cat` = " . $id_cat . ")" : "";
		
		$messages = $this -> db -> getResultArray ( sprintf ( "SELECT `name`, `text` FROM %s WHERE (`status` = 1) %s ORDER BY `date` DESC, `id_message` DESC LIMIT %s, %s;", $this -> table_messages, $where, $from, $this -> per_page ));
		
		return $messages;
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	�������� ������ ������� ��� ������� ����� �����
	//	$id_cat - id ��������� ������
	////////////////////////////////////////////////////////////////////////////////
	
	function GetPages ($id_cat) {
		
		$where = ($id_cat > 0) ? " AND (`id_cat` = " . $id_cat . ")" : "";
		
		$count = $this -> db -> getResultArray ( sprintf (  "SELECT count(*) AS `count` FROM %s WHERE (`status` = 1) %s;", $this -> table_messages, $where ));
				
		$page_count = ($count[0]['count'] - ($count[0]['count']%$this->per_page)) / $this->per_page;
		
		if (($count[0]['count']%$this->per_page)>0)
			$page_count++;
		
		$pages = array();
		
		for ($i=1; $i<=$page_count; $i++)
			$pages[$i]=$i;		
		
		return $pages;
	}
}