<?php
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");

include_once ( $cfg['PATH']['admin_modules_path']."articles/classes/Article.class.php" );

//var_dump($PARAMS);  exit("params");

$Article = new Article();

switch (count($PARAMS)) {
	
	case 0:
		
		$years = $Article -> GetYearList ("DESC");
		
		$year = ($years) ? $years[0] : 0;
		
		$filter['year'] = $year;
		
		$articles = $Article -> GetShortArticles($filter);
		
		$count = count($articles);
		
		if ($count>0) {
		
			$rest 	= $count%$cfg['SETTINGS']['PAGER']['ARTICLES'];				
			$pages 	= ($count-$rest)/$cfg['SETTINGS']['PAGER']['ARTICLES'];
			
			if ($rest > 0)
				$pages++;
		}
		else {
			$pages = 0;
		}
        
		$tpl -> assign ( "pages",			$pages );
		$tpl -> assign ( "years",			$years );
		$tpl -> assign ( "months", 			$Article -> GetMonths($year) );
		$tpl -> assign ( "year", 			$year );		
		$tpl -> assign ( "articles", 		$articles );		
		$tpl -> assign ( "pager", 			$cfg['SETTINGS']['PAGER']['ARTICLES'] );
		$tpl -> assign ( "module_articles", $tpl->fetch($cfg['PATH']['admin_modules_path']."articles/templates/front-list.tpl.php") );
		break;
		
		
	case 1:
        $filter['year'] = $PARAMS[0];
		
		$articles = $Article -> GetShortArticles($filter);		
		
		if (empty($articles)) {
			define ( "__DOCUMENT__", $cfg[PATH][error][tpl] . $DomainInfo[0]['page404']['filename'] . ".tpl.php" );
			$tpl -> assign ( "Error404", true );
			$tpl -> display ( __DOCUMENT__ );
			exit();
		}
		
		$count = count($articles);
		
		if ($count>0) {
		
			$rest 	= $count%$cfg['SETTINGS']['PAGER']['ARTICLES'];				
			$pages 	= ($count-$rest)/$cfg['SETTINGS']['PAGER']['ARTICLES'];
			
			if ($rest > 0)
				$pages++;
		}
		else {
			$pages = 0;
		}
		
        //var_dump($articles[0]);  exit("articles");
        
		$tpl -> assign ( "pages",			$pages );
		$tpl -> assign ( "years",			$Article -> GetYearList("DESC") );
		$tpl -> assign ( "months", 			$Article -> GetMonths($filter['year']) );
		$tpl -> assign ( "year", 			$PARAMS[0] );
		$tpl -> assign ( "articles", 		$articles );
		$tpl -> assign ( "pager", 			$cfg['SETTINGS']['PAGER']['ARTICLES'] );
		$tpl -> assign ( "module_articles", $tpl->fetch($cfg['PATH']['admin_modules_path']."articles/templates/front-list.tpl.php") );
		break;
		
		
	case 2:
	
		$filter['year'] = $PARAMS[0];
		$filter['month'] = $PARAMS[1];
		
		$articles = $Article -> GetShortArticles($filter);		
		
		if (empty($articles)) {
			define ( "__DOCUMENT__", $cfg[PATH][error][tpl] . $DomainInfo[0]['page404']['filename'] . ".tpl.php" );
			$tpl -> assign ( "Error404", true );
			$tpl -> display ( __DOCUMENT__ );
			exit();
		}
		
		$count = count($articles);
		
		if ($count>0) {
		
			$rest 	= $count%$cfg['SETTINGS']['PAGER']['ARTICLES'];				
			$pages 	= ($count-$rest)/$cfg['SETTINGS']['PAGER']['ARTICLES'];
			
			if ($rest > 0)
				$pages++;
		}
		else {
			$pages = 0;
		}
		
		$tpl -> assign ( "pages",			$pages );
		$tpl -> assign ( "years",			$Article -> GetYearList("DESC") );
		$tpl -> assign ( "months", 			$Article -> GetMonths($filter['year']) );
		$tpl -> assign ( "year", 			$PARAMS[0] );
		$tpl -> assign ( "month", 			$PARAMS[1] );
		$tpl -> assign ( "articles", 		$articles );
		$tpl -> assign ( "pager", 			$cfg['SETTINGS']['PAGER']['ARTICLES'] );
		$tpl -> assign ( "module_articles", $tpl->fetch($cfg['PATH']['admin_modules_path']."articles/templates/front-list.tpl.php") );
		break;
		
		
	case 3:
		
		$article = $Article -> GetArticle($PARAMS[2]);
		
		if ($article) {
			$tpl -> assign ( "Article", 	$article );
			$tpl -> assign ( "articles", 	$Article -> GetOtherArticles($article['id_article'], 4) ); 
			$tpl -> assign ( "Prev", 		$Article -> GetPrevious($article['id_article'], $article['date']) );
			$tpl -> assign ( "Next", 		$Article -> GetNext($article['id_article'], $article['date']) );
		}				
		else {
			define ( "__DOCUMENT__", $cfg[PATH][error][tpl] . $DomainInfo[0]['page404']['filename'] . ".tpl.php" );
			$tpl -> assign ( "Error404", true );
			$tpl -> display ( __DOCUMENT__ );
			exit();
		}
			
		$tpl -> assign ( "module_articles", $tpl->fetch($cfg['PATH']['admin_modules_path']."articles/templates/front-detail.tpl.php") );
		break;

	default:
		
		define ( "__DOCUMENT__", $cfg[PATH][error][tpl] . $DomainInfo[0]['page404']['filename'] . ".tpl.php" );
		$tpl -> assign ( "Error404", true );
		$tpl -> display ( __DOCUMENT__ );
		exit();
			
		break;
}

?>