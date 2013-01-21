<?php
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg['PATH']['core'] );
DirInclude ( $cfg['PATH']['admin_classes']);
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $cfg['PATH']['admin_modules_path']."catalog/classes/Catalog.class.php" );

$Catalog = new Catalog();

if ((isset($_POST['id_item'])) && (!empty($_POST['id_item'])) && (is_numeric($_POST['id_item'])) && 
	(isset($_POST['id_cat'])) && (!empty($_POST['id_cat'])) && (is_numeric($_POST['id_cat'])) && 
	(isset($_POST['name'])) && (!empty($_POST['name'])) &&
	(isset($_POST['description']))) {
	
	$fields = $Catalog -> GetCatFields($_POST['id_cat']);		
	
	//print_r($fields);
	
	if (is_array($fields)) {
			
		$okay = true;
			
		foreach ($fields as $key => $value) {
			
			$index = "property_".$value['name'];					
					
			if ( (!isset($_POST[$index]) || empty($_POST[$index])) && ($value['empty']==0) ) {
				$okay = false;
				break;
			}
		}
			
		if ($okay) {
				
			if ($Catalog -> ClearItemProperties($_POST['id_item'])) {
					
				$result = "success";
					
				$n = 0;
	
				foreach ($fields as $key => $value) {
					
					$index = "property_".$value['name'];
					
					if ($Catalog -> AddItemProperty ($_POST['id_item'], $value['id_field'], utf8($_POST[$index])))
						$n++;
				}
					
				$text = $n . " записей обновлено.";
				
				print win(array2json(array("result" => $result, "text" => $text)));
				
				$response = $Catalog -> UpdateItem ($_POST['id_item'], utf8($_POST['name']), $_POST['active'], utf8($_POST['description']));
													
				if (($response['result']=="success") && $_POST['image']) {	
		
					if (!@file_exists($Catalog->path_server . $_POST['id_item'] . "/")) {
						if (@mkdir($Catalog->path_server . $_POST['id_item'] . "/", 0777))
							@chmod($Catalog->path_server . $_POST['id_item'] . "/", 0777);
					}
					
					$namearray = explode(".", $_POST['image']);
									
					$filename = $Catalog->path_server . $_POST['id_item'] . "/" . $_POST['id_item'] . "." . $namearray[count($namearray)-1];
					
					if (@file_exists($Catalog->path_tmp . $_POST['image']))
						@rename ($Catalog->path_tmp . $_POST['image'], $filename);
					
					$thumb = "";
					
					for ($i=0; $i<(count($namearray)-1); $i++)
						$thumb .= $namearray[$i];
						
					$thumb .= "_thumb." . $namearray[count($namearray)-1];
					
					$filename = $Catalog->path_server . $_POST['id_item'] . "/" . $_POST['id_item'] . "_thumb." . $namearray[count($namearray)-1];
					
					if (@file_exists($Catalog -> path_tmp . $thumb))
						@rename ($Catalog -> path_tmp . $thumb, $filename);	
				}
			}
			else {
				$result = "error";
				$text	= $response['text'];
			}			
				
		}
		else {
			$result = "error";
			$text	= "¬се об€зательные пол€ должны быть заполнены.";
		
			print win(array2json(array("result" => $result, "text" => $text)));			
		}
	}
	else {
		
		$response = $Catalog -> UpdateItem( $_POST['id_item'], utf8($_POST['name']), $_POST['active'], utf8($_POST['description']));
											
		if (($response['result']=="success") && $_POST['image']) {	
		
			if (!@file_exists($Catalog->path_server . $_POST['id_item'] . "/")) {
				if (@mkdir($Catalog->path_server . $_POST['id_item'] . "/", 0777))
					@chmod($Catalog->path_server . $_POST['id_item'] . "/", 0777);
			}
					
			$namearray = explode(".", $_POST['image']);
									
			$filename = $Catalog->path_server . $_POST['id_item'] . "/" . $_POST['id_item'] . "." . $namearray[count($namearray)-1];
					
			if (@file_exists($Catalog->path_tmp . $_POST['image']))
				@rename ($Catalog->path_tmp . $_POST['image'], $filename);
					
			$thumb = "";
					
			for ($i=0; $i<(count($namearray)-1); $i++)
				$thumb .= $namearray[$i];
						
			$thumb .= "_thumb." . $namearray[count($namearray)-1];
					
			$filename = $Catalog->path_server . $_POST['id_item'] . "/" . $_POST['id_item'] . "_thumb." . $namearray[count($namearray)-1];
					
			if (@file_exists($Catalog -> path_tmp . $thumb))
				@rename ($Catalog -> path_tmp . $thumb, $filename);		
		}
		
		print win(array2json($response));
	}
	
}
else {
	$result = "error";
	$text	= "Ќеверный список параметров.";
	
	print win(array2json(array("result" => $result, "text" => $text)));
}
?>