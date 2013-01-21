<?php
include_once ( $cfg['PATH']['admin_modules_path'] . "events/classes/Events.class.php" );

$Events = new Events();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	≈сли главна€ страница
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($pageData['url'] === "") {
	$tpl -> assign ( "Events",		$Events -> GetEvents(3) );
	$tpl -> assign ( "module_events", 	$tpl->fetch($cfg['PATH']['admin_modules_path'] . "events/templates/front-main.tpl.php") );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	≈сли страница со списком меропри€тий
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
elseif (($pageData['url'] === "events") && (count($PARAMS)==0)) {
	
	$tpl -> assign ( "Years",			$Events -> GetYearList ("DESC") );
	$tpl -> assign ( "Events",			$Events -> GetLastYearEvents() );	
	$tpl -> assign ( "module_events", 	$tpl->fetch($cfg['PATH']['admin_modules_path'] . "events/templates/front-events.tpl.php") );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	≈сли страница со списком меропри€тий за опр. год
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
elseif (($pageData['url'] === "events") && (count($PARAMS)==1)) {
	
	$tpl -> assign ( "Years",			$Events -> GetYearList ("DESC") );
	$tpl -> assign ( "Events",			$Events -> GetEventsByYear($PARAMS[0]) );
	$tpl -> assign ( "module_events", 	$tpl->fetch($cfg['PATH']['admin_modules_path'] . "events/templates/front-events.tpl.php") );
}
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	≈сли страница подробного просмотра меропри€ти€
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

elseif (($pageData['url'] === "events") && (count($PARAMS)==2)) {
	
	$id_event = $PARAMS[1];
	$event = $Events -> GetEvent($id_event);
	
	if ($event) {
		$tpl -> assign ( "Event",	$event );
		$tpl -> assign ( "Next",	$Events -> GetNext($id_event, $event['year']) );
		$tpl -> assign ( "Prev",	$Events -> GetPrevious($id_event, $event['year']) );
	}
	
	$tpl -> assign ( "module_events", 	$tpl->fetch($cfg['PATH']['admin_modules_path'] . "events/templates/front-event.tpl.php") );
}		
?>