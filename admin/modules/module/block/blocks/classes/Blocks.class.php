<?php

class Blocks extends WorkWithData {

	////////////////////////////////////////////////////////////////////////////////
	//	ÑÂÎÉÑÒÂÀ ÊËÀÑÑÀ
	////////////////////////////////////////////////////////////////////////////////
	
	var $table_content;
	var $table_fields_content;
	var $table_fields;
	var $table_blocks;
	var $table_photos;
	var $table_types;
		
	var $path_src;
	var $path_server;
		
	function Blocks () {

		global $cfg;

		$this -> WorkWithData ();
		
		$this -> table_content			= $cfg[DB][Table][prefix]."module_blocks_content";
		$this -> table_fields_content 	= $cfg[DB][Table][prefix]."module_blocks_fields_content";
		$this -> table_fields 			= $cfg[DB][Table][prefix]."module_blocks_fields";
		$this -> table_blocks 			= $cfg[DB][Table][prefix]."module_blocks";
		$this -> table_photos 			= $cfg[DB][Table][prefix]."module_blocks_photos";
		$this -> table_types 			= $cfg[DB][Table][prefix]."module_form_fields_type";
		
		$this -> path_src = "/images/blocks/";
		$this -> path_server = $cfg[PATH][root] . "images/blocks/";
		
		return true;
	}
	
	function GetBlocks () {
		
		return $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s ORDER BY id_block", $this -> table_blocks) );
	}
	
	function GetContentDetails ($id_content) {
		
		return $this -> db -> getResultArray ( sprintf (
			"SELECT FC.id_content, FC.id_fields_content, FT.type, FT.name, FC.content 
			FROM %s FC
			LEFT JOIN 
				(SELECT F.id_field, F.name, T.type 
				FROM %s F 
				LEFT JOIN %s T ON F.id_type = T.id
				GROUP BY F.id_field) FT
			ON FC.id_field = FT.id_field
			GROUP BY FC.id_fields_content
			HAVING FC.id_content = %s", 
			$this -> table_fields_content, $this -> table_fields, $this -> table_types, $id_content) );
		
	}
	
	function AddNewBlock ($name, $title) {
		
		$this -> db -> query ( sprintf ("INSERT INTO %s (name, title) VALUES ('%s', '%s')", $this->table_blocks, $name, $title ));
		
		return $this -> db -> last_id();
	}
	
	function UpdateBlock ($id_block, $name, $title, $photo) {
		
		return $this -> db -> query ( sprintf ("UPDATE %s SET name = '%s', title = '%s', photo = '%s' WHERE id_block = %s", $this->table_blocks, $name, $title, $photo, $id_block ));
	}
	
	function DeleteBlock ($id_block) {
		
		return $this -> db -> query ( sprintf ("DELETE FROM %s WHERE id_block = %s", $this->table_blocks, $id_block ));
	}
	
	function AddNewField ($id_block, $name, $title, $id_type, $empty) {
		
		$this -> db -> query ( sprintf ("INSERT INTO %s (id_block, name, title, id_type, empty) VALUES (%s, '%s', '%s', %s, '%s')", $this->table_fields, $id_block, $name, $title, $id_type, $empty ));
		
		return $this -> db -> last_id();
	}
	
	function UpdateField ($id_field, $id_block, $name, $title, $id_type, $empty) {
		
		return $this -> db -> query ( sprintf ("UPDATE %s SET id_block = %s, name = '%s', title = '%s', id_type = %s, empty = '%s' WHERE id_field = %s", $this->table_fields, $id_block, $name, $title, $id_type, $empty, $id_field ));
	}
	
	function DeleteField ($id_field) {
		
		return $this -> db -> query ( sprintf ("DELETE FROM %s WHERE id_field = %s", $this->table_fields, $id_field ));
	}
	
	function GetBlock ($id_block) {
	
		$block = $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE id_block = %s", $this -> table_blocks, $id_block) );
		
		return $block[0];
	}
	
	function GetBlockByName ($name) {
		
		$block = $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE name = '%s'", $this -> table_blocks, $name) );
		
		return $block[0];
	}
	
	function GetBlockFields ($id_block) {
		
		return $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE id_block = %s", $this -> table_fields, $id_block) );	
	}
	
	function GetFields ($id_block) {
		
		return $this -> db -> getResultArray ( sprintf ("SELECT F.id_field, F.id_block, F.name, F.title, T.type FROM %s F LEFT JOIN %s T ON F.id_type = T.id GROUP BY F.id_field HAVING F.id_block = %s", $this -> table_fields, $this -> table_types, $id_block) );	
	}
	
	function GetInputTypes () {

		return $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s ORDER BY id", $this -> table_types) );
	}
	
	function GetBlockContentList ($id_block) {
		
		return $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE id_block = %s ORDER BY id_content DESC", $this -> table_content, $id_block) );
	}
	
	function GetBlockContentCount ($id_block) {
		
		return count( $this -> db -> getResultArray ( sprintf ("SELECT id_content FROM %s WHERE id_block = %s", $this->table_content, $id_block)) );
	}
	
	function GetBlockContentByDate ($id_block, $date) {
		
		$content = $this -> db -> getResultArray ( sprintf ("SELECT FC.id_content, F.name, F.id_block, FC.content FROM %s FC LEFT JOIN %s F ON FC.id_field = F.id_field HAVING (F.id_block = %s) AND (F.name = 'date') AND (FC.content = '%s')", $this->table_fields_content, $this->table_fields, $id_block, $date));
		
		$return = array();
		for ($i=0; $i<count($content); $i++)
			$return[$i] = $content[$i][id_content];
		
		return $return;
	}
	
	function GetBlockContentByMaxDate ($id_block, $ids) {
	
		if (is_array($ids)) {
			
			$in = "";
			
			foreach ($ids as $key => $value) {
				
				if ($in!="")
					$in .= ",";
				$in .= $value;
			}
			$in = "AND (FC.id_content IN (" . $in ."))";
		}
		else 
			$in = "";
	
		$max_date = $this -> db -> getResultArray ( "SELECT FC.id_content as id, F.name, F.id_block, FC.content as date FROM " . $this->table_fields_content . " FC LEFT JOIN " . $this->table_fields . " F ON FC.id_field = F.id_field HAVING (F.id_block = " . $id_block . ") AND (F.name = 'date') " . $in . " ORDER BY STR_TO_DATE(FC.content, '%d.%m.%Y') DESC, FC.id_content DESC LIMIT 1" );
		
		$content = $this -> db -> getResultArray ( sprintf ("SELECT FC.id_content, F.name, F.id_block, FC.content FROM %s FC LEFT JOIN %s F ON FC.id_field = F.id_field HAVING (F.id_block = %s) AND (F.name = 'date') AND (FC.content = '%s') %s", $this->table_fields_content, $this->table_fields, $id_block, $max_date[0][date], $in));
		
		$return = array();
		for ($i=0; $i<count($content); $i++)
			$return[$i] = $content[$i][id_content];
		
		return $return;
	}
	
	function GetBlockContentByType ($id_block, $type) {
		
		$content = $this -> db -> getResultArray ( sprintf ("SELECT HIGH_PRIORITY FC.id_content, F.name, F.id_block, FC.content FROM %s FC LEFT JOIN %s F ON FC.id_field = F.id_field HAVING (F.id_block = %s) AND (F.name = 'type') AND (FC.content = '%s')", $this->table_fields_content, $this->table_fields, $id_block, $type));
		
		$return = array();
		for ($i=0; $i<count($content); $i++)
			$return[$i] = $content[$i][id_content];
		
		return $return;
	}
	
	function GetBlockFieldsCount ($id_block) {
		
		return count( $this -> db -> getResultArray ( sprintf ("SELECT HIGH_PRIORITY id_field FROM %s WHERE id_block = %s", $this->table_fields, $id_block)) );
	}
	
	function GetBlockContent ($id_block, $limit_from, $limit_count, $order = "DESC", $ids = 0) {
		
		if (is_array($ids)) {
			
			$in = "";
			
			foreach ($ids as $key => $value) {
				
				if ($in!="")
					$in .= ",";
				$in .= $value;
			}
			$in = "AND (C.id_content IN (" . $in ."))";
		}
		else 
			$in = "";
		
		if ($limit_count == 0)
			$content = $this -> db -> getResultArray ( sprintf ("
				SELECT HIGH_PRIORITY FC.id_fields_content, F.name AS field_name, FC.content, C.id_content, C.name, C.id_block
				FROM %s C
				LEFT JOIN
    			(%s FC LEFT JOIN %s F ON FC.id_field = F.id_field)
				ON C.id_content = FC.id_content
				GROUP BY FC.id_fields_content
				HAVING (C.id_block = %s) %s
				ORDER BY C.id_content %s, FC.id_fields_content;", $this->table_content, $this->table_fields_content, $this->table_fields, $id_block, $in, $order ) );
		else {
			
			$count = $this -> GetBlockFieldsCount($id_block);
			
			//$content = $this -> db -> getResultArray ( sprintf ("SELECT id_content, name FROM %s WHERE"
			
			$content = $this -> db -> getResultArray ( sprintf ("
				SELECT HIGH_PRIORITY FC.id_fields_content, F.name AS field_name, FC.content, C.id_content, C.name, C.id_block
				FROM %s C
				RIGHT JOIN				
				(%s FC LEFT JOIN %s F ON FC.id_field = F.id_field) 
				ON C.id_content = FC.id_content
				GROUP BY FC.id_fields_content
				HAVING (C.id_block = %s) %s
				ORDER BY C.id_content %s, FC.id_fields_content LIMIT %s, %s;", $this->table_content, $this->table_fields_content, $this->table_fields, $id_block, $in, $order, $limit_from*$count, $limit_count*$count ) );
		}
		
		if (!is_array($content))
			return array();
		
		$return = array();
		$n=0;
		$block = $this -> GetBlock($id_block);
		
		for ($i=0; $i<count($content); $i++) {
			
			$return[$n][id] = $limit_from + $n;
			$return[$n][id_content] = $content[$i][id_content];
			$return[$n][name] = $content[$i][name];
			
			$return_content = array();
			
			while (($i < count($content)) && ($content[$i][id_content] == $return[$n][id_content])) {
				$return_content[$content[$i][field_name]] = $content[$i][content];
				$i++;	
			}
			
			$i--;	
			$return[$n][content] = $return_content;
			
			if ($block[photo]=='Y') {
				$return[$n][photos] = $this -> GetContentPhotos($return[$n][id_content]);
			}
			
			$n++;
		}
		
		return $return;
	}

	function GetContent ($id_content) {
	
		$content = $this -> db -> getResultArray ( sprintf ("
				SELECT FFC.id_fields_content, FFC.name AS field_name, FFC.content, C.id_content, C.name, C.id_block
				FROM %s C
				RIGHT JOIN
    				(SELECT F.id_field, F.name, FC.id_fields_content, FC.content, FC.id_content
    				FROM %s FC
    				LEFT JOIN %s F ON FC.id_field = F.id_field
    				GROUP BY FC.id_fields_content) FFC
				ON C.id_content = FFC.id_content
				GROUP BY FFC.id_fields_content
				HAVING C.id_content = %s
				ORDER BY FFC.id_fields_content", $this->table_content, $this->table_fields_content, $this->table_fields, $id_content) );
		
		$return[id_content] = $content[0][id_content];
		$return[id_block] = $content[0][id_block];
		$return[name] = $content[0][name];
			
		$return_content = array();
			
		for ($i=0; $i < count($content); $i++)
			$return_content[$content[$i][field_name]] = $content[$i][content];
		
		$return[content] = $return_content;
		$block = $this -> GetBlock($return[id_block]);
			
		if ($block[photo]=='Y') 
			$return[photos] = $this -> GetContentPhotos($return[id_content]);
			
		return $return;
	}
	
	function GetLastContent ($id_block) {
		
		$content = $this -> GetBlockContent($id_block, 0, 1, "DESC", 0);
		
		return $content[0];
	}
	
	function GetContentBlock ($id_content) {
		
		$block = $this -> db -> getResultArray ( sprintf ("SELECT id_block FROM %s WHERE id_content = %s", $this -> table_content, $id_content) );
		
		return $block[0][id_block];
	}
	
	function GetContentFields ($id_content) {
		
		return $this -> db -> getResultArray ( sprintf ("SELECT C.id_content, F.id_field, F.name, F.empty FROM %s C LEFT JOIN %s F ON C.id_content = F.id_content HAVING C.id_content = %s", $this -> table_content, $this -> table_fields, $id_content) );
	}
	
	function GetBlockForm ($id_block) {
		
		return $this -> db -> getResultArray ( sprintf ("SELECT F.*, T.type FROM %s F LEFT JOIN %s T ON F.id_type = T.id GROUP BY F.id_field HAVING F.id_block = %s", $this -> table_fields, $this -> table_types, $id_block) );
	}
	
	function UpdateContentName ($id_content, $name) {
		
		return $this -> db -> query ( sprintf ("UPDATE %s SET name = '%s' WHERE id_content = %s", $this->table_content, $name, $id_content) );
	}
	
	function AddNewContent ($id_block, $name) {
		
		$this -> db -> query ( sprintf ("INSERT INTO %s (id_block, name) VALUES (%s, '%s')", $this->table_content, $id_block, $name) );
		
		return $this -> db -> last_id();
	}
	
	function DeleteContent ($id_content) {
		
		$this -> db -> query ( sprintf ("DELETE FROM %s WHERE id_content = %s", $this->table_fields_content, $id_content) );
		
		return $this -> db -> query ( sprintf ("DELETE FROM %s WHERE id_content = %s", $this->table_content, $id_content) );
	}
	
	function AddNewFieldsContent ($id_content, $id_field, $content) {
		
		$this -> db -> query ( sprintf ("INSERT INTO %s (id_content, id_field, content) VALUES (%s, %s, '%s')", $this->table_fields_content, $id_content, $id_field, $content) );
		
		return $this -> db -> last_id();
	}
	
	function UpdateFieldsContent ($id_content, $id_field, $content) {
		
		$id_fields_content = $this -> db -> getResultArray ( sprintf ("SELECT id_fields_content FROM %s WHERE (id_content = %s) AND (id_field = %s) LIMIT 1", $this->table_fields_content, $id_content, $id_field ) );
		
		if ($id_fields_content)					
			return $this -> db -> query ( sprintf ("UPDATE %s SET content = '%s' WHERE id_fields_content = %s", $this->table_fields_content, $content, $id_fields_content[0][id_fields_content] ));
		else
			return $this -> AddNewFieldsContent ($id_content, $id_field, $content);
	}
	
	function GetContentPhotos ($id_content) {
	
		return $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE id_content = %s", $this->table_photos, $id_content ) );
	}
	
	function GetContentPhotosCount ($id_content) {
	
		$count = $this -> db -> getResultArray ( sprintf ("SELECT COUNT(*) AS total FROM %s WHERE id_content = %s", $this->table_photos, $id_content ) );
		return $count[0][total];
	}
	
	function GetPhoto ($id_photo) {
		
		return $this -> db -> getResultArray ( sprintf ("SELECT * FROM %s WHERE id_photo = %s", $this->table_photos, $id_photo ) );	
	}
	
	function GetPhotosByImage ($image) {
		
		return $this -> db -> getResultArray ( sprintf ("SELECT id_photo FROM %s WHERE image = '%s'", $this->table_photos, $image ) );	
	}
	
	function AddNewPhoto ($id_content, $image) {
		
		$this -> db -> query ( sprintf ("INSERT INTO %s (id_content, image) VALUES (%s, '%s')", $this->table_photos, $id_content, $this->path_src . $image) );
		
		return $this -> db -> last_id();
	}
	
	function DeletePhoto ($id_photo) {
		
		$photo_arr = $this -> GetPhoto($id_photo);
		$image = $photo_arr[0][image];		
		$photos = $this -> GetPhotosByImage($image);
		
		if (count($photos)==1)
			unlink($this->path_server . basename($image));
		
		return $this -> db -> query ( sprintf ("DELETE FROM %s WHERE id_photo = %s", $this->table_photos, $id_photo ) );
	}
	
	function GetPhotoJSON ($id_photo) {
		
		$dataJSON = "{";
				
		$photo = $this -> GetPhoto($id_photo);
		
		if (is_array($photo)) {
		
			foreach ($photo[0] as $key=>$value) {
					
				if ($dataJSON!=="{") 
					$dataJSON .= ", ";	
				$dataJSON .= $key.": \"".$value."\"";
			}
		}
		
		$dataJSON .= "}";
		
		return $dataJSON;	
	}
	
	function GetPhotosJSON ($id) {
		
		if (!is_numeric($id))
			return "[]";
			 
		$photos = $this -> GetContentPhotos($id);

		$dataJSON = "[";
		
		if (is_array($photos)) {
		
			foreach ($photos as $k=>$photo) {
				
				if ($dataJSON!=="[") 
					$dataJSON .= ", ";
				$dataJSON .= "{";
				
				foreach ($photo as $key=>$value) {
					
					if ($dataJSON[strlen($dataJSON)-1]!=="{") 
						$dataJSON .= ", ";	
					$dataJSON .= $key.": \"".$value."\"";
				}
				$dataJSON .= "}";
			}
		}
		
		$dataJSON .= "]";
		
		return $dataJSON;
	}
	
	function GetContentJSON ($id) {
		
		if (!is_numeric($id))
			return "[]";
			 
		$content = $this -> GetContentDetails($id);
			
		return array2json($content);
	}
	
	function GetFieldsJSON ($id) {
		
		if (!is_numeric($id))
			return "[]";
			 
		$fields = $this -> GetFields($id);

		$dataJSON = "[";
		
		if (is_array($fields)) {
		
			foreach ($fields as $key=>$value) {
			
				if ($dataJSON!=="[") $dataJSON .= ", ";

				$dataJSON .= "{type: \"" . $value[type] . "\", name: \"" . PrintJSString($value[name]) . "\", title: \"" . PrintJSString($value[title]) . "\"}";
			}
		}
		
		$dataJSON .= "]";
		
		return $dataJSON;
	}
	
	function GetContentListJSON ($id_block, $empty_option) {
		
		if (!is_numeric($id_block))
			return "[{value: \"0\", caption: \"\"}]";
			
		$content_array = $this -> GetBlockContentList($id_block);

		$dataJSON = "[";
		if ($empty_option)
			$dataJSON .= "{value: \"0\", caption: \"\"}";
		
		if (is_array($content_array)) {
		
			foreach ($content_array as $key=>$value) {
			
				if ($dataJSON!=="[") $dataJSON .= ", ";

				$dataJSON .= "{value: \"" . $value[id_content] . "\", caption: \"" . PrintJSString($value[name]) . "\"}";
			}
		}
			
		$dataJSON .= "]";
		
		return $dataJSON;	
	}
}

?>