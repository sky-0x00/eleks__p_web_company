<?php

include_once ( $cfg['PATH']['admin_modules_path']."search/classes/Search.class.php" );

$Search = new Search($_GET['mode']);

$search_page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

if (isset($_GET['text'])) {
	
	$text = htmlspecialchars(trim(strip_tags($_GET['text'])));
	
	if (!empty($text)) {
		$tpl -> assign( "text", 		$text );
		$tpl -> assign( "SearchArray", 	$Search->PageSearch($text, $search_page, $page_array) );
		if (count($page_array)>1)
			$tpl -> assign( "PageArray", $page_array);
	}
}

//print_r($Search->PageSearch($text, $search_page, $page_array));

//$tpl -> assign ( "cms_module_search", $tpl->fetch($cfg['PATH']['admin_modules']."module/block/search/templates/front.tpl.php" ));
?>