<?php
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");

include_once ( $cfg['PATH']['admin_modules_path'] . "blocks/classes/Blocks.class.php" );

$Blocks = new Blocks();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Выполняем выборку в зависимости от текущей страницы
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

switch ($pageData['url']) {
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Если главная 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	case "":
		
		$block_advices	= $Blocks -> GetBlockByName("advices");
		
		$advices 		= $Blocks -> GetBlockContent($block_advices['id_block'], 0, 3, "DESC");
		
		$tpl -> assign ( "Advices", 		$advices );
		$tpl -> assign ( "module_advices", 	$tpl->fetch($cfg['PATH']['admin_modules_path'] . "blocks/templates/front/front-main.tpl.php") );
		
		break;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Если раздел "Полезно знать" 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	case "advices":
		
		if (count($PARAMS)<2) {
			
			$per_page = 10;
		
			$block_advices	= $Blocks -> GetBlockByName("advices");
			
			$p = ((count($PARAMS)>0) && ($PARAMS[0]>0)) ? $PARAMS[0] : 1;
			
			$advices = $Blocks -> GetBlockContent($block_advices['id_block'], ($p-1)*$per_page, $per_page);
			
			$count = count($Blocks -> GetBlockContent($block_advices['id_block'], 0, 0));
			$pages = array();
			
			if ($count > $per_page) {
			
				$n = 1;
				$i = 1;
				
				while ($i<=$count) {
					$pages[$n] = $n;
					$i += $per_page;
					$n++;
				}
			}
			
			$tpl -> assign ( "PARAMS",			$PARAMS );
			$tpl -> assign ( "Pages", 			$pages );
			$tpl -> assign ( "Count", 			count($pages) );
			$tpl -> assign ( "Advices", 		$advices );
			$tpl -> assign ( "module_advices", 	$tpl->fetch($cfg['PATH']['admin_modules_path'] . "blocks/templates/front/front-advices.tpl.php") );
		}
		else {
		
			$advice = $Blocks -> GetContent($PARAMS[1]);
			
			$tpl -> assign ( "Advice", 			$advice );
			$tpl -> assign ( "module_advices", 	$tpl->fetch($cfg['PATH']['admin_modules_path'] . "blocks/templates/front/front-advice.tpl.php") );
		}
		
		break;
}
?>