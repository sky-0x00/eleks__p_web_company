<?php
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // страница  с контактной информацией
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //session_start();
    
    include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/settings/DB.inc.php");
    include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/settings/Path.inc.php");
    include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/settings/Table.inc.php");
    
    // ф-ия DirInclude находится в файле "functions_lib.inc.php"
    include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/global/functions_lib.inc.php"); 
    DirInclude($cfg[PATH][core]);               // admin/core/
    DirInclude($cfg[PATH][admin_classes]);      // admin/classes/
    
    include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/lib/Smarty 2.6.18/Smarty.class.php");
    include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/global/local.inc.php");
    
    //include_once($_SERVER['DOCUMENT_ROOT'] ."/templates/include/header.tpl.php");       // header
    
        
    // создание экземпляра класса Smarty (шаблоны)
    $tpl = new Smarty_Site();
    $page = new PageData();
    
    list($url, ) = explode("?", $_SERVER[REQUEST_URI]);
    $url = htmlspecialchars(trim($url, "/"));
    $array_url = explode("/", $url);
    list($pageData, $section, $PARAMS, $LinkLine) = $page->GetRecordByUrl($array_url);
    
        /*$template = new Templates ();
        $module   = new Modules ();
        
     //	вырезаем QUERY_STRING
        list ( $URL, ) = explode ( "?", $_SERVER[REQUEST_URI] );
        $URL = htmlspecialchars ( trim ( $URL, "/" ) );
        $secArray = array_merge ( array ( "" ), explode ( "/", $URL ) );
        
        $Domain = new Domain();
        $PageError = new PageError();
        $DomainInfo = $Domain->GetDomainInfo();
        
    // исполнительная часть 
        
        $Statistic = new Statistic();
        if ($Statistic->AllowWrite) {
        	$Statistic->WriteLog();
        }
    */
    
    $tpl->assign("DOCUMENT_SECTION", "contacts");
    $tpl->assign("DOCUMENT_TITLE", htmlspecialchars($cfg[GENERAL][title_prefix]) .htmlspecialchars($pageData[title]));
    $tpl->display($_SERVER['DOCUMENT_ROOT'] ."/templates/include/header.tpl.php");    
    
    /*
        $DOCUMENT_DESCRIPTION
        $DOCUMENT_KEYWORDS
        $DOCUMENT_TITLE
        $DOCUMENT_SECTION
        
    */
        
    /*if ( defined ( "__DOCUMENT__" ) ) {
        
        	////////////////////////////////////////////////////////////////////////////////
        	//	установить содержимое меток-заполнителей
        
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
        
        if ( defined ( "__DOCUMENT__" ) ) {
        
        	$tpl->display ( __DOCUMENT__ );
        }*/
?>
<table class="content_text"><tr>    
    <td></td>    
    <td class="main">
        <p style="font-weight: bold; line-height: 28px; font-size: 16px; height: 40px;">Контактная информация:</p>
        <div>
            <p style="height: 20px;"><b>Название компании</b>: ООО "Группа компаний Элекс"</p>
            <p><b>Адрес</b>: 432030, г.Ульяновск, ул.Энтузиастов, д.3, 2 этаж</p>
            <p><b>E-mail</b>: <a title="Написать нам" href="mailto:mail@eleks-group.ru">mail@eleks-group.ru</a></p>
            <p><b>Тел/факс</b>: (8422) 277-977</p>
            <p style="height: 26px;"><b>Часы работы</b>: 8<sup>00</sup> - 17<sup>00</sup> (Пн - Пт)</p>
            <p style="height: 36px;"><b>Реквизиты</b>: р/с: 407028 102 2 3700 000246 в Нижегородский филиал ОАО АКБ "РОСБАНК"<br />
            к/с: 30101 810 4 0000 0000747, БИК: 042 202 747</p>
            <p><b>Директор</b>: Осипов Иван Николаевич, тел. +7 927 806 00 86</p>
        </div>
    </td>        
    <td></td>    
</tr></table>
<?php
    $tpl->display($_SERVER['DOCUMENT_ROOT'] ."/templates/include/footer.tpl.php");        // footer
?>