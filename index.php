<?php
//session_start();
////////////////////////////////////////////////////////////////////////////////
//
//	START 1. ����������� �������� � �������� ���������.
//
////////////////////////////////////////////////////////////////////////////////
//	����������� �������� ����������
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg['PATH']['core'] );            // admin/core/
DirInclude ( $cfg['PATH']['admin_classes']);    // admin/classes/
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/lib/Smarty 2.6.18/Smarty.class.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );

//var_dump($cfg[DB][cls]);

////////////////////////////////////////////////////////////////////////////////
//
//	START 2. �������� �������� �������.
//
////////////////////////////////////////////////////////////////////////////////
//	�������� cache-�������
/*if ( !isset ( $_SESSION[CACHE] ) )
$_SESSION[CACHE] = array ();*/

        //	�������� ���������� ������ Smarty (�������)
        $tpl      = new Smarty_Site();
        //	�������� ���������� ������ PageData (���������� � ����������� ��������)
        $page     = new PageData();
        $template = new Templates();
        $module   = new Modules();
        
        /*var_dump($tpl);
        echo "<br/><br/>";
        var_dump($page);
        echo "<br/><br/>";
        var_dump($template);
        echo "<br/><br/>";
        var_dump($module);*/

////////////////////////////////////////////////////////////////////////////////
//
//	END 2. �������� �������� �������.
//
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
//
//	START 3. ����� ��������, ������� ����� ����������� � �������������� �����.
//		$section - �������� �� ����� �������� (���������� $_SERVER[REQUEST_URI]).
//
////////////////////////////////////////////////////////////////////////////////

        //	�������� QUERY_STRING
        list ( $URL, ) = explode ( "?", $_SERVER['REQUEST_URI'] );
        $URL = htmlspecialchars ( trim ( $URL, "/" ) );
        $secArray = array_merge ( array ( "" ), explode ( "/", $URL ) );
        
        //$url = htmlspecialchars(trim($_SERVER['REQUEST_URI'], "/"));
        //var_dump($url); exit(0);
        //$secArray = explode("/", $url);
        //$secArray = array_merge(array(""), explode("/", $url));
        //var_dump($secArray); exit(0);
                        

////////////////////////////////////////////////////////////////////////////////
//
//	END 3.
//
////////////////////////////////////////////////////////////////////////////////

        $Domain = new Domain();
        $PageError = new PageError();
        $DomainInfo = $Domain->GetDomainInfo();

////////////////////////////////////////////////////////////////////////////////
//
//	START 4. �������������� �����.
//
////////////////////////////////////////////////////////////////////////////////

        if ($DomainInfo[0]['active'] == 1) {
            
            //var_dump($secArray); exit(0);
            list ($pageData, $section, $PARAMS, $LinkLine) = $page->GetRecordByUrl($secArray);      // �������� url, ���� �������� � ������� url �� ������� � ��
            //var_dump($secArray); exit(0);
        	
            /*var_dump($pageData); echo "<br/>";
            var_dump($section);  echo "<br/>";
            var_dump($PARAMS);   echo "<br/>";
            var_dump($LinkLine); exit(0);
            exit($pageData['title']);*/
            
            
        	$templateData = $template -> GetRecord( $pageData['template_id'] );
            //var_dump($secArray); exit(0);
                                            	
        	$moduleData = $module -> getModulePage( $pageData['page_id'] );
            //var_dump($moduleData);  exit(0);
        
        	if ( is_array( $moduleData ) )        
        		for ( $ii = 0; $ii < count( $moduleData ); $ii++ )        
        			include_once( $cfg['PATH']['admin_modules_path'] ."" .$moduleData[$ii]['alias'] ."/index.front.php" );        
        
            if ( !defined ( "__DOCUMENT__" ) ) 
        
        	if ( ($pageData['active'] == 1) && ($page -> checkUrl( $secArray )) ) {
        		
                $cfg['PATH']['skins']['tpl'] .$templateData['filename'] .".tpl.php";
        		
        		if (($templateData['filename'] == "index") &&
        			(stripos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6') !== false) &&
        			(stripos($_SERVER['HTTP_USER_AGENT'], 'opera') === false)) {
        			
        			$templateData['filename'] = "index1";
        			//print ($templateData['filename']);
        		}
        		
        		define("__DOCUMENT__", $cfg['PATH']['skins']['tpl'] .$templateData['filename'] . ".tpl.php");		
        		
        		
        		// 404 ������ - �������� �� �������
        	} else {
        		//var_dump($secArray);    exit("404 ������");
                define( "__DOCUMENT__", $cfg['PATH']['error']['tpl'] .$DomainInfo[0]['page404']['filename'] .".tpl.php" );
        		$tpl -> assign( "Error404", true );
        		$tpl -> display( __DOCUMENT__ );
        		exit();
        	}
        	// 403 ������ - ������ ��������
        } else {
            //var_dump($secArray);    exit("403 ������");
        	define( "__DOCUMENT__", $cfg['PATH']['error']['tpl'] .$DomainInfo[0]['page403']['filename'] .".tpl.php" );
        	$tpl -> display( __DOCUMENT__ );
        	exit();
}

////////////////////////////////////////////////////////////////////////////////
//
//	END 4. �������������� �����.
//
////////////////////////////////////////////////////////////////////////////////
        
        $Statistic = new Statistic();
        if ($Statistic->AllowWrite) {
        	$Statistic->WriteLog();
        }

/*$LoginAuth = new UserAuth();

$LoginAuth -> ValidateLogin(utf8($_POST[login]), utf8($_POST[password]));*/

////////////////////////////////////////////////////////////////////////////////
//
//	START 5. ���������� ����� �������� � ����� ������������.
//
////////////////////////////////////////////////////////////////////////////////
        
        if ( defined ( "__DOCUMENT__" ) ) {
        
        	////////////////////////////////////////////////////////////////////////////////
        	//	���������� ���������� �����-������������
        
        	$BlocksList = new IBlock ();
        	$tpl->assign_by_ref ("iblock", $BlocksList);
        	
        	$today = getdate();
        	
        	if (($today['hours']>=8) && ($today['hours']<20))
        		$tpl->assign ( "Light", false );
        	else
        		$tpl->assign ( "Light",	true );
        	
        	$tpl->assign ( "PATH",                 		$cfg[PATH] );
        	$tpl->assign ( "PATH_SKIN_FILES",      		$cfg[PATH][www_files] );
        	$tpl->assign ( "PATH_SKIN_FILES_RESUME", 	$cfg[PATH][www_resume] );
        
        	//print(implode ( "/", $section ));
        	//print_r ($PARAMS);
            
            //var_dump($LinkLine);
                    	
        	$tpl->assign ( "DOCUMENT_SECTION",     	implode ( "/", $section ) );
        	$tpl->assign ( "DOCUMENT_SECTIONS",    	$LinkLine );
        	$tpl->assign ( "DOCUMENT_SECTIONS_CNT", count ( $LinkLine ) );
        	$tpl->assign ( "DOCUMENT_TITLE",       	htmlspecialchars ( $cfg[GENERAL][title_prefix] ) . ( $pageData[title] != "" ? "" . htmlspecialchars ( $pageData[title] ) : "" ) );
        	$tpl->assign ( "DOCUMENT_KEYWORDS",    	htmlspecialchars ( $pageData[keywords] != "" ? $pageData[keywords] : "" ) );
        	$tpl->assign ( "DOCUMENT_DESCRIPTION", 	htmlspecialchars ( $pageData[description] ) );
        	$tpl->assign ( "DOCUMENT_HOST",        	$cfg[PATH][www_root] );
        	$tpl->assign ( "DOCUMENT_HEADER",      	htmlspecialchars ( $pageData[header] ) );
        	$tpl->assign ( "DOCUMENT_NAME",        	htmlspecialchars ( $pageData[name] ) );
        	$tpl->assign ( "DOCUMENT_CONTENT",     	$pageData[content] );
        	$tpl->assign ( "DOMAIN_CHARSET",		htmlspecialchars ($DomainInfo[0][charset]) );
        
        	$tpl->assign ( "PARAMS",               	$PARAMS );
        	$tpl->assign ( "LOCAL",                	__LOCAL__ );
        
        }

////////////////////////////////////////////////////////////////////////////////
//
//	START 6. ��������� ��������� ������� � ����� ����������.
//
////////////////////////////////////////////////////////////////////////////////
        
        if ( defined ( "__DOCUMENT__" ) ) {
        
        	$tpl->display ( __DOCUMENT__ );
        }

?>