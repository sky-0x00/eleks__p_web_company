<?php
///////////////////////////////////////////////
define ( "__DOCUMENT__", $cfg[PATH][admin_modules]."group/templates/group_index.tpl.php" );
///////////////////////////////////////////////

$Group = new GroupsList();

$tpl -> assign ( "Groups", 		$Group -> getGroupList() );
$tpl -> assign ( "Template", 	"group_list" );
$tpl -> assign ( "m_path", 		"/admin/modules/group/" );

?>