<?php

////////////////////////////////////////////////////////////////////////////////
//
//	WorkWithData.inc.php - ����� WorkWithData
//
// 	������: 2.0
//
////////////////////////////////////////////////////////////////////////////////
//
//	������������: ����� ����.
//	����� ���������� ���������: ����� ���� & ������� ����� & ������ ������ & �������� ����� & ������� ������
//   ����� �������...
//
//	���� ���������� ���������: 18 ���� 2007 �. 10:06:55
//
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//
//	����� ��� ������ � �������.
//
////////////////////////////////////////////////////////////////////////////////
class WorkWithData {
	
	////////////////////////////////////////////////////////////////////////////////
	//	�������� ������
	var $db;           // ����� ��
	var $table;        // ������� ��
	var $fields;       // ���� ������� ��
	var $section;      // ��������, �������������� ���������
	var $listOrderBy;  // ���������� ������
	var $gen_id;       // ���� ��������� ID, ���� true, �� ��������� ���������� ��� ������ PHP � ������� md5, ���� false - MySQL auto_increment
	var $fields_line;
	////////////////////////////////////////////////////////////////////////////////
	
	//	Constructor
	function WorkWithData () {
		
		global $cfg;
		
        //	�������� ����� ��
		if ( isset ( $cfg[DB][cls] ) ) {
			
			$this->db = new $cfg[DB][cls];			
		}
        
		return true;
		
	}
	
	////////////////////////////////////////////////////////////////////////////////
	//	������ ������. ������
	
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	string GetSection ( void )
	//
	////////////////////////////////////////////////////////////////////////////////
	//
	//	��������� ������, � ������� ����� ����������� ���������.
	//
	////////////////////////////////////////////////////////////////////////////////
	function GetSection () {
		
		return $this->section;
		
	}
	////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	string GetFirstFieldName ( void )
	//
	////////////////////////////////////////////////////////////////////////////////
	//
	//	��������� ����� ������� ����.
	//
	////////////////////////////////////////////////////////////////////////////////
	function GetFirstFieldName () {
		
		return $this->fields[0][name];
		
	}
	////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	array GetFields ( void )
	//
	////////////////////////////////////////////////////////////////////////////////
	//
	//	��������� ������ ����� � ������������ ����� select.
	//
	////////////////////////////////////////////////////////////////////////////////
	function GetFields () {
		
		$FieldsArray = $this->fields;
		
		for ( $i = 0; $i < count ( $FieldsArray ); $i++ ) {
			
			if ( $FieldsArray[$i][html_type] == "select" and trim ( $FieldsArray[$i][source] ) != "" ) {
				
				unset ( $t_arr );
				//	��������� ������ ���������� ������ ��� ���� select
				$t_arr = explode ( ";", $FieldsArray[$i][source] );
				//	��������� ���������� ���������� ������
				$t_cnt = count ( $t_arr );
				
				for ( $j = 0; $j < $t_cnt; $j++ ) {
					
					unset ( $t_array, $t_class, $temp );
					//	��������� ����� ������ � ����� ������, ������� ���������� ���������
					$t_array[$j] = explode ( "->", $t_arr[$j] );
					//	�������� ���������� ������
					$t_class[$j] = new $t_array[$j][0]();
					
					$temp = $t_class[$j]->$t_array[$j][1]();
					
					//	������� (��������� �) ������ ������, ���������� ������� ���������� ������
					if (is_array($FieldsArray[$i]['source_arr'])) $FieldsArray[$i]['source_arr'] = array_merge ( $FieldsArray[$i]['source_arr'], $t_class[$j]->$t_array[$j][1]() );
					else $FieldsArray[$i]['source_arr'] = $t_class[$j]->$t_array[$j][1]();
					
				}
				
				//	���� ����� ���������� ������, �� ������������� ��������� ������� ������ ����������
				if ( $t_cnt == 1 )
					$FieldsArray[$i][source_add] = $t_class[0]->GetSection ();
				else
					$FieldsArray[$i][add_icon] = 0;
				
			}
			
		}
		
		return $FieldsArray;
		
	}
	////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	array GetFieldsNames ( void )
	//
	////////////////////////////////////////////////////////////////////////////////
	//
	//	��������� ������ ���������� ����� ��� ������ ������ �������.
	//
	////////////////////////////////////////////////////////////////////////////////
	function GetFieldsNames () {
		
		for ( $i = 1; $i < count ( $this->fields ); $i++ )
			if ( $this->fields[$i][in_list] == 1 )
				$fields_desc[] = $this->fields[$i][description];
		
		return $fields_desc;
		
	}
	////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	array GetSelect ( string $key, string|array $vals )
	//
	////////////////////////////////////////////////////////////////////////////////
	//
	//	��������� ������ ��� ����� select.
	//
	////////////////////////////////////////////////////////////////////////////////
	function GetSelect ( $key = "", $vals = "" ) {
		
		$fields_line = "";
		
		for ( $i = 0; $i < count ( $this->fields ); $i++ )
			if ( $this->fields[$i][in_select] ) {
				
				$comma = ( $fields_line ==  "" ) ? "" : ", ";
				$fields_line .= $comma . $this->fields[$i][name] . " AS " . $this->fields[$i][in_select];
				
			}
		
		if ( $key )
			$where = sprintf ( " WHERE %s IN ('%s') ", $key, ( is_array ( $vals ) ? implode ( "', '", $vals ) : $vals ) );
			
          /*
	$temp = get_class($this);
	echo $temp;
	if ($temp = 'Goods') {
          echo "<br />";
          printf ( "SELECT HIGH_PRIORITY %s FROM %s %s %s", $fields_line, $this->table, $where, $this->listOrderBy );
          echo "<br />";
	die('G!');} */
		
		return $this->db->getResultArray ( sprintf ( "SELECT HIGH_PRIORITY %s FROM %s %s %s", $fields_line, $this->table, $where, $this->listOrderBy ) );
		
	}
	////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	array GetSelectTree ( void )
	//
	////////////////////////////////////////////////////////////////////////////////
	//
	//	��������� ������ ��� ����� select � ���� ������.
	//
	////////////////////////////////////////////////////////////////////////////////
	function GetSelectTree () {
		
		global $cfg;
		
		$records = array ();
		Tree ( 0, 0, &$this, &$records );
		
		for ( $i = 0; $i < count ( $records ); $i++ ) {
			
			$recs[$i][id]   = $records[$i][$this->GetFirstFieldName()];
			$recs[$i][name] = str_repeat ( "&nbsp;&nbsp;&nbsp;&nbsp;", $records[$i][level] ) . $records[$i][name];
			
		}
		
		return $recs;
		
	}
	////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	string AddElem ( void )
	//
	////////////////////////////////////////////////////////////////////////////////
	//
	//	���������� ������.
	//
	////////////////////////////////////////////////////////////////////////////////
	function AddElem () {
		
		global $cfg;
		
		////////////////////////////////////////////////////////////////////////////////
		//	Check data
		while ( list ( $key, $val ) = each ( $_POST ) ) {
			
			if ( $key != "section" and $key != "submit" ) {
				
				if ( substr ( $key, -4 ) == "_use" and trim ( $val ) == "" ) {
					
					$_SESSION[CACHE][RETURN_MSG] = $cfg[RETURN_MSG][need_fields];
					return false;
					
				} else {
					
					if ( substr ( $key, -4 ) == "_use" )
						$key = substr ( $key, 0, -4 );
					
					$ReceivedDataT[$key] = addslashes ( trim ( $val ) );
					
				}
				
			}
			
		}
		
		for ( $i = 0; $i < count ( $this->fields ); $i++ ) {
			
			$fields_line[] = $key = $this->fields[$i][name];
			
			//	��������� �������� ����
			//	1) ���� ���� ��������������, �� ������������ ��� � ���� ��������� �� �������� ��������;
			//	2) � ��������� ������ ��������������� ���������� �������� ��� �������� �� ���������
			if ( $this->fields[$i][autofill] and $this->fields[$i][autofill] != "" ) {
				
				$ReceivedData[$key] = $this->fields[$i][autofill];
				continue;
				
			} else {
				
				$ReceivedData[$key] = $ReceivedDataT[$key] ? $ReceivedDataT[$key] : $this->fields[$i][default_value];
				
			}
			
			//	��������� ���� ���� date
			if ( $this->fields[$i][html_type] == "date" ) {
				
				if ( $ReceivedData[$key] == "" ) {
					
					$ReceivedData[$key] = time ();
					
				} else {
					
					$date = explode ( ".", $ReceivedData[$key] );
					$ReceivedData[$key] = mktime ( 6, 0, 0, $date[1], $date[0], $date[2] );
					
				}
				
			}
			
			//	��������� ���� ���� file
			if ( $this->fields[$i][html_type] == "file" ) {
				
				//	����� ��������� ������, ���� ����������� ��� ���� ������������ ���, ���� ��� - ������������ �����
				$storage = $this->fields[$i][storage] ? $this->fields[$i][storage] : $cfg[PATH][files];
				
				$filename = "";
				if ( $_FILES[$key][name] and $_FILES[$key][error] == 0 ) {
					
					//	��������� ���������� � �����
					$path_parts = pathinfo ( $_FILES[$key][name] );
					//	�������� ����� �����
					$filename = generate_md5 () . "." . $path_parts[extension];
					
					//	���� ����� ���� ��� ����������, �� ���������� ���������������� ��� ������������ �����
					if ( file_exists ( $storage . $filename ) ) {
						
						while ( file_exists ( $storage . $filename ) )
							//	����������������� ����� �����
							$filename = generate_md5 () . "." . $path_parts[extension];
						
					}
					
					//	����������� ����� �� ������
					if ( !copy ( $_FILES[$key][tmp_name], $storage . $filename ) ) {
						
						$_SESSION[CACHE][RETURN_MSG] = $cfg[RETURN_MSG][need_fields];
						return false;
						
					}
					
				}
				
				$ReceivedData[$key] = $filename;
				
			}
			
		}
		while ( list ( $key, $val ) = each ( $ReceivedData ) ) {
			
			if ( $ReceivedData[$key] != "NULL" )
				$ReceivedData[$key] = "'" . $val . "'";
			
		}
		////////////////////////////////////////////////////////////////////////////////
		
		if ( $this->gen_id )
			$ReceivedData[( $this->GetFirstFieldName () )] = generate_md5 ();
		
		////////////////////////////////////////////////////////////////////////////////
		//	Write data to DB
		$this->db->query ( sprintf ( "INSERT INTO %s (%s) VALUES (%s)", $this->table, implode ( ", ", $fields_line ), implode ( ", ", $ReceivedData ) ) );
		
		////////////////////////////////////////////////////////////////////////////////
		
		$id = $this->gen_id ? $ReceivedData[( $this->GetFirstFieldName () )] : $this->db->last_id ();
		
		if ( method_exists ( $this, "OnAdd" ) )
			$this->OnAdd ( $id );
		
		return $id;
		
	}
	////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	string UpdateElem ( void )
	//
	////////////////////////////////////////////////////////////////////////////////
	//
	//	���������� ������.
	//
	////////////////////////////////////////////////////////////////////////////////
	function UpdateElem () {
		
		global $cfg;
		
		////////////////////////////////////////////////////////////////////////////////
		//	Check data
		while ( list ( $key, $val ) = each ( $_POST ) ) {
			
			if ( $key != "section" and $key != "submit" ) {
				
				if ( substr ( $key, -4 ) == "_use" and trim ( $val ) == "" ) {
					
					$_SESSION[CACHE][RETURN_MSG] = $cfg[RETURN_MSG][need_fields];
					return false;
					
				} else {
					
					if ( substr ( $key, -4 ) == "_use" )
						$key = substr ( $key, 0, -4 );
					
					$ReceivedDataT[$key] = addslashes ( $val );
					
				}
				
			}
			
		}
		
		$fields_line = "";
		
		for ( $i = 0; $i < count ( $this->fields ); $i++ ) {
			
			$key = $this->fields[$i][name];
			
			//	��������� �������� ����
			//	1) ���� ���� ��������������, �� ���� ��������� �� �������� ��������;
			//	2) � ��������� ������ ��������������� ���������� �������� ��� �������� �� ���������
			if ( $this->fields[$i][autofill] and $this->fields[$i][autofill] != "" ) {
				
				//$ReceivedData[$key] = $this->fields[$i][autofill];
				continue;
				
			} else {
				
				$ReceivedData[$key] = $ReceivedDataT[$key] ? $ReceivedDataT[$key] : $this->fields[$i][default_value];
				
			}
			
			//	��������� ���� ���� date
			if ( $this->fields[$i][html_type] == "date" ) {
				
				if ( $ReceivedData[$key] == "" ) {
					
					$ReceivedData[$key] = time ();
					
				} else {
					
					$date = explode ( ".", $ReceivedData[$key] );
					$ReceivedData[$key] = mktime ( 6, 0, 0, $date[1], $date[0], $date[2] );
					
				}
				
			}
			
			//	��������� ���� ���� file
			if ( $this->fields[$i][html_type] == "file" ) {
				
				//	����� ��������� ������, ���� ����������� ��� ���� ������������ ���, ���� ��� - ������������ �����
				$storage = $this->fields[$i][storage] ? $this->fields[$i][storage] : $cfg[PATH][files];
				
				$filename = "";
				if ( $_FILES[$key][name] and $_FILES[$key][error] == 0 ) {
					
					//	�������� �� ������������� ������������ ����� �����
					$old_file = $this->db->getResultArray ( sprintf ( "SELECT HIGH_PRIORITY %s FROM %s WHERE %s='%s'", $key, $this->table, $this->GetFirstFieldName (), $ReceivedData[( $this->GetFirstFieldName () )] ) );
					if ( trim ( $old_file[0][$key] ) != "" ) {
						
						//	���� ���� ����������, �� ��� ���������� �������
						unlink ( $storage . $old_file[0][$key] );
						
					}
					
					//	��������� ���������� � �����
					$path_parts = pathinfo ( $_FILES[$key][name] );
					//	�������� ����� �����
					$filename = generate_md5 () . "." . $path_parts[extension];
					
					//	���� ����� ���� ��� ����������, �� ���������� ���������������� ��� ������������ �����
					if ( file_exists ( $storage . $filename ) ) {
						
						while ( file_exists ( $storage . $filename ) )
							//	����������������� ����� �����
							$filename = generate_md5 () . "." . $path_parts[extension];
						
					}
					
					//	����������� ����� �� ������
					if ( !copy ( $_FILES[$key][tmp_name], $storage . $filename ) ) {
						
						$_SESSION[CACHE][RETURN_MSG] = $cfg[RETURN_MSG][need_fields];
						return false;
						
					}
					
				}
				
				if ( $filename != "" )
					$ReceivedData[$key] = $filename;
				else
					$key = "";
				
			}
			
			if ( $key != "" ) {
				
				$comma = ( $fields_line ==  "" ) ? "" : ", ";
				if ( $ReceivedData[$key] == "NULL" )
					$fields_line .= $comma . $key . "=" . $ReceivedData[$key] . "";
				else
					$fields_line .= $comma . $key . "='" . $ReceivedData[$key] . "'";
				
			}
			
		}
		
		////////////////////////////////////////////////////////////////////////////////
		//	Write data to DB
		$this->db->query ( sprintf ( "UPDATE %s SET %s WHERE %s='%s'", $this->table, $fields_line, $this->GetFirstFieldName (), $ReceivedData[( $this->GetFirstFieldName () )] ) );
		////////////////////////////////////////////////////////////////////////////////
		
		if ( method_exists ( $this, "OnUpdate" ) )
			$this->OnUpdate ( $ReceivedData[( $this->GetFirstFieldName () )] );
		
		return $ReceivedData[( $this->GetFirstFieldName () )];
		
	}
	////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	true DeleteElem ( string $id )
	//
	////////////////////////////////////////////////////////////////////////////////
	//
	//	�������� ������.
	//
	////////////////////////////////////////////////////////////////////////////////
	function DeleteElem ( $id ) {
		
		if ( method_exists ( $this, "OnDelete" ) )
			$this->OnDelete ( $id );
		
		$id_line = is_array ( $id ) ? implode ( "', '", $id ) : $id;
		$this->db->query ( sprintf ( "DELETE LOW_PRIORITY FROM %s WHERE %s IN ('%s')", $this->table, $this->GetFirstFieldName (), $id_line ) );
		
		return true;
		
	}
	////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	array GetList ( string $conditions, string $sorting, int $full )
	//
	////////////////////////////////////////////////////////////////////////////////
	//
	//	��������� ������ �������.
	//
	//	$conditions - ������� �������
	//	$sorting    - ���������� �������
	//	$full       - ���� ������� ������� ����� (���� 0 - ���������� ������ ���� in_list, ����� - ��� ����)
	//	$no_select  - �� ������������ ���� select (���� 1 - ��������������, ����� - ���)
	//
	////////////////////////////////////////////////////////////////////////////////
	function GetList ( $conditions = "", $sorting = "", $full = 0, $no_select = 1 ) {
          //var_dump($conditions) . '<br />';
          //die;
		
		global $cfg;
		
		for ( $i = 1; $i < count ( $this->fields ); $i++ )
			if ( $this->fields[$i][in_list] == 1 or $full != 0 ) {
				
				$fields_line[] = $this->fields[$i][name];
				
				if ( $this->fields[$i][html_type] == "select" and trim ( $this->fields[$i][source] ) != "" and $no_select ) {
					
					unset ( $t_arr );
					//	��������� ������ ���������� ������ ��� ���� select
					$t_arr = explode ( ";", $this->fields[$i][source] );
					//	��������� ���������� ���������� ������
					$t_cnt = count ( $t_arr );
					
					//var_dump($t_arr);
					//die;
					
					for ( $j = 0; $j < $t_cnt; $j++ ) {
						
						unset ($t_array, $t_class, $temp, $t_classname, $t_methodname, $t_fieldname);
						//	��������� ����� ������ � ����� ������, ������� ���������� ���������
						$temp = explode ( "->", $t_arr[$j] );
						$t_classname = $temp[0];
						$t_methodname= $temp[1];
						
						//	�������� ���������� ������
						$t_class = new $t_classname();
						
						// ���� ������ �������
						$temp = $t_class->$t_methodname();
						
						//���� ��� ����
						$t_fieldname = $this->fields[$i][name];
						
						//	������� (��������� �) ������ ������, ���������� ������� ���������� ������
						if (is_array($SelectArray[$t_fieldname])) $SelectArray[$t_fieldname] = array_merge ( $SelectArray[$t_fieldname], $temp );
						else $SelectArray[$t_fieldname] = $temp;
					}
					
				}
				
			}
		
		$where = "";
		if ( is_array ( $conditions ) ) {
			
			while ( list ( $key, $val ) = each ( $conditions ) ) {
				
				$where_type = "AND";
				
				//	���� ������������ ���������
				if ( strpos ( strtoupper ( $key ), " IN" ) !== false )
					$cond[] = sprintf ( " %s ('%s') ", $key, implode ( "', '", $val ) );
				//	���� ������������ ����� �� ������
				elseif ( strpos ( strtoupper ( $key ), " LIKE" ) !== false ) {
					$cond[] = sprintf ( " %s '%s' ", $key, "%" . addslashes ( $val ) . "%" );
					$where_type = "OR";
				//	����������� �������
				} else
					$cond[] = sprintf ( " %s'%s' ", $key, addslashes ( $val ) );
				
			}
			
			$where = " WHERE " . implode ( $where_type, $cond );
			
		}
		$orders = "";
		if ( is_array ( $sorting ) ) {
			
			while ( list ( $key, $val ) = each ( $sorting ) )
				$sort[] = sprintf ( " %s %s ", $key, $val );
			
			$orders = " ORDER BY " . implode ( ",", $sort );
			
		}
		if ( $orders == "" )
			$orders = $this->listOrderBy;
		
		$this->db->query ( sprintf ( "SELECT HIGH_PRIORITY %s, %s FROM %s %s %s", $this->GetFirstFieldName (), implode ( ", ", $fields_line ), $this->table, $where, $orders ) );
		
		//printf ( "SELECT HIGH_PRIORITY %s, %s FROM %s %s %s", $this->GetFirstFieldName (), implode ( ", ", $fields_line ), $this->table, $where, $orders ); echo "<br> <br>";
		//die;
		
		$i = -1;
		while ( $this->db->next_record () ) {
			
			$i++;
			
			while ( list ( $key, $val ) = each ( $this->db->Record ) ) {
				
				if ( $SelectArray[$key][0][name] != "" ) {
					
					for ( $j = 0; $j < count ( $SelectArray[$key] ); $j++ )
						if ( $SelectArray[$key][$j][id] == $val )
							$val = $SelectArray[$key][$j][name];
					
				}
				
				$records[$i][$key] = $val;
				
			}
			
		}
		
		return $records;
		
	}
	////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	array GetListTree ( int $a, int $full )
	//
	////////////////////////////////////////////////////////////////////////////////
	//
	//	��������� ������ ������� � ���� ������.
	//
	//	$a    - ���� ������� ��� ����������� ������ (���� 0 - �������� &nbsp;, ����� - ����������� ������� �����������)
	//	$full - ���� ������� ������� ����� (���� 0 - ���������� ������ ���� in_list, ����� - ��� ����)
	//
	////////////////////////////////////////////////////////////////////////////////
	function GetListTree ( $a = 0, $full = 0 ) {
		
		global $cfg;
		
		$records = array ();
		Tree ( 0, 0, &$this, &$records );
		
		for ( $i = 0; $i < count ( $this->fields ); $i++ )
			if ( $this->fields[$i][in_list] == 1 or $i == 0 or $full == 1 ) {
				
				$key = &$this->fields[$i][name];
				
				for ( $j = 0; $j < count ( $records ); $j++ )
					$recs[$j][$key] = $records[$j][$key];
				
			}
		
		if ( $a == 0 )
			for ( $i = 0; $i < count ( $recs ); $i++ )
				$recs[$i][name] = str_repeat ( "&nbsp;&nbsp;&nbsp;&nbsp;", $records[$i][level] ) . $recs[$i][name];
		else
			for ( $i = 0; $i < count ( $recs ); $i++ )
				$recs[$i][level] = $records[$i][level];
		
		return $recs;
		
	}
	////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	array GetRecord ( $id )
	//
	////////////////////////////////////////////////////////////////////////////////
	//
	//	��������� ������ �� ����� ������.
	//
	//	$id - ������������� ������ � �� (��� $id - ����� �������������� ��)
	//
	////////////////////////////////////////////////////////////////////////////////
	function GetRecord($id) {
		
		global $cfg;
		
		$id_line = is_array($id) ? implode("', '", $id) : $id;
		$records = $this->db->getResultArray(sprintf("SELECT HIGH_PRIORITY * FROM %s WHERE %s IN ('%s')", $this->table, $this->GetFirstFieldName(), $id_line));
        
		if ( $this->db->nf () > 1 )
			return $records;
		else
			return $records[0];
		
	}
	////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////////
	//
	//	int GetCountRecord ( void )
	//
	////////////////////////////////////////////////////////////////////////////////
	//
	//	��������� ���������� ������� � �������.
	//
	////////////////////////////////////////////////////////////////////////////////
	function GetCountRecord () {
		
		$cnt = $this->db->getResultArray ( sprintf ( "SELECT HIGH_PRIORITY COUNT(*) AS cnt FROM %s", $this->table ) );
		
		return $cnt[0][cnt];
		
	}
	////////////////////////////////////////////////////////////////////////////////
	
}
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//
//	array Tree ( $pid, int $level, object& $this, array& $records )
//
////////////////////////////////////////////////////////////////////////////////
//
//	��������������� ������� ������ ��� ���������� ������.
//	�������� ��������� ������ �� ���� pid.
//
//	$pid     - ������������� ������������ ������
//	$level   - ������� ����������� ������
//	$this    - ������ �� ������, ������� ��������� ���������� ������
//	$records - ������ ������ (����������� ������)
//
////////////////////////////////////////////////////////////////////////////////
function Tree ( $pid, $level, $that, $records ) {
	
	if ( $pid == 0 or $pid == "" )
		$where = "pid='0' OR pid IS NULL";
	else
		$where = "pid='" . $pid . "'";
	
	$res = $that->db->getResultArray ( sprintf ( "SELECT HIGH_PRIORITY * FROM %s WHERE %s", $that->table, $where ) );
	for ( $i = 0; $i < count ( $res ); $i++ ) {
		
		$cnt = count ( $records );
		
		$records[$cnt]        = $res[$i];
		$records[$cnt][level] = $level;
		
		if ( $records[$cnt][$that->GetFirstFieldName()] )
			$res2 = $that->db->getResultArray ( sprintf ( "SELECT HIGH_PRIORITY COUNT(*) AS cnt FROM %s WHERE pid='%s'", $that->table, $records[$cnt][$that->GetFirstFieldName()] ) );
		
		if ( $res2[0][cnt] > 0 )
			Tree ( $records[$cnt][$that->GetFirstFieldName()], $level + 1, &$that, &$records );
		
	}
	
}


////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//	����� ���������� � ������������ �����.
if ( ERROR_PRINT_INCLUDE_FILENAME != 0 )
	echo "Class WorkWithData (file " . basename ( __FILE__ ) . ")<br>";
////////////////////////////////////////////////////////////////////////////////

?>