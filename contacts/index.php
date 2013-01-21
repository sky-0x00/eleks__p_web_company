<?php
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // ��������  � ���������� �����������
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //session_start();
    
    include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/settings/DB.inc.php");
    include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/settings/Path.inc.php");
    include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/settings/Table.inc.php");
    
    // �-�� DirInclude ��������� � ����� "functions_lib.inc.php"
    include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/global/functions_lib.inc.php"); 
    DirInclude($cfg[PATH][core]);               // admin/core/
    DirInclude($cfg[PATH][admin_classes]);      // admin/classes/
    
    include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/lib/Smarty 2.6.18/Smarty.class.php");
    include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/global/local.inc.php");
    
    //include_once($_SERVER['DOCUMENT_ROOT'] ."/templates/include/header.tpl.php");       // header
    
        
    // �������� ���������� ������ Smarty (�������)
    $tpl = new Smarty_Site();
    $page = new PageData();
    
    list($url, ) = explode("?", $_SERVER[REQUEST_URI]);
    $url = htmlspecialchars(trim($url, "/"));
    $array_url = explode("/", $url);
    list($pageData, $section, $PARAMS, $LinkLine) = $page->GetRecordByUrl($array_url);
    
        /*$template = new Templates ();
        $module   = new Modules ();
        
     //	�������� QUERY_STRING
        list ( $URL, ) = explode ( "?", $_SERVER[REQUEST_URI] );
        $URL = htmlspecialchars ( trim ( $URL, "/" ) );
        $secArray = array_merge ( array ( "" ), explode ( "/", $URL ) );
        
        $Domain = new Domain();
        $PageError = new PageError();
        $DomainInfo = $Domain->GetDomainInfo();
        
    // �������������� ����� 
        
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
        <p style="font-weight: bold; line-height: 28px; font-size: 16px; height: 40px;">���������� ����������:</p>
        <div>
            <p style="height: 20px;"><b>�������� ��������</b>: ��� "������ �������� �����"</p>
            <p><b>�����</b>: 432030, �.���������, ��.�����������, �.3, 2 ����</p>
            <p><b>E-mail</b>: <a title="�������� ���" href="mailto:mail@eleks-group.ru">mail@eleks-group.ru</a></p>
            <p><b>���/����</b>: (8422) 277-977</p>
            <p style="height: 26px;"><b>���� ������</b>: 8<sup>00</sup> - 17<sup>00</sup> (�� - ��)</p>
            <p style="height: 36px;"><b>���������</b>: �/�: 407028 102 2 3700 000246 � ������������� ������ ��� ��� "�������"<br />
            �/�: 30101 810 4 0000 0000747, ���: 042 202 747</p>
            <p><b>��������</b>: ������ ���� ����������, ���. +7 927 806 00 86</p>
        </div>
    </td>        
    <td></td>    
</tr></table>
<?php
    $tpl->display($_SERVER['DOCUMENT_ROOT'] ."/templates/include/footer.tpl.php");        // footer
?>