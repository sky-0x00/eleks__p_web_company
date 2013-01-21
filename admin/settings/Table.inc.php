<?php
$cfg['DB']['Table']['prefix'] 		     = "promycms_";

$cfg['DB']['Table']['domain']      	     = $cfg['DB']['Table']['prefix'] ."domain";
$cfg['DB']['Table']['pages']             = $cfg['DB']['Table']['prefix'] ."pages";
$cfg['DB']['Table']['page_error']        = $cfg['DB']['Table']['prefix'] ."page_error";
$cfg['DB']['Table']['templates']         = $cfg['DB']['Table']['prefix'] ."templates";
$cfg['DB']['Table']['templates_group']   = $cfg['DB']['Table']['prefix'] ."templates_group";
$cfg['DB']['Table']['sections']      	 = $cfg['DB']['Table']['prefix'] ."sections";
$cfg['DB']['Table']['sections_group']    = $cfg['DB']['Table']['prefix'] ."sections_group";
$cfg['DB']['Table']['stats_log']         = $cfg['DB']['Table']['prefix'] ."stats_log";
$cfg['DB']['Table']['users']             = $cfg['DB']['Table']['prefix'] ."users";
$cfg['DB']['Table']['groups']            = $cfg['DB']['Table']['prefix'] ."users_groups";
$cfg['DB']['Table']['groups_users']      = $cfg['DB']['Table']['prefix'] ."users_in_groups";
$cfg['DB']['Table']['menus']             = $cfg['DB']['Table']['prefix'] ."menus";    //нет
$cfg['DB']['Table']['pages_menu']        = $cfg['DB']['Table']['prefix'] ."pages_in_menu";
$cfg['DB']['Table']['modules']           = $cfg['DB']['Table']['prefix'] ."modules";
$cfg['DB']['Table']['pages_modules']	 = $cfg['DB']['Table']['prefix'] ."pages_modules";
$cfg['DB']['Table']['iblock']            = $cfg['DB']['Table']['prefix'] ."iblock";

//нет всего перечисленного ниже
//$cfg['DB']['Table'][groups]            = $cfg['DB']['Table']['prefix'] . "catalog_" . "groups";
$cfg['DB']['Table']['categories']        = $cfg['DB']['Table']['prefix'] ."catalog_" ."categories";
$cfg['DB']['Table']['goods']             = $cfg['DB']['Table']['prefix'] ."catalog_" ."goods";
$cfg['DB']['Table']['properties']        = $cfg['DB']['Table']['prefix'] ."catalog_" ."properties";
$cfg['DB']['Table']['orders']            = $cfg['DB']['Table']['prefix'] ."catalog_" ."orders";
$cfg['DB']['Table']['o_r_table']         = $cfg['DB']['Table']['prefix'] ."catalog_" ."orders_items";
$cfg['DB']['Table']['g_p_links']         = $cfg['DB']['Table']['prefix'] ."catalog_" ."goods_properties";

?>