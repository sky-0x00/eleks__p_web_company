<?php
////////////////////////////////////////////////////////////////////////////////
//	загрузить файл, назначить ему идентификатор
define ( "__DOCUMENT__", $cfg[PATH][admin_modules]."cms/templates/index.tpl.php" );
////////////////////////////////////////////////////////////////////////////////

$StatisticInfo = new Statistic();
$tpl->assign( "StatisticInfo" , $StatisticInfo->ShowTotalData());
$tpl->assign( "Stat" , $Stat);


?>