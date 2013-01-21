<?php
	$IContentTemplate = new Smarty_Admin();
	$Templates = new Templates();

	$IContentTemplate -> assign ( "PAGEID" , "'" . $_POST[parentlayerid] . "'" );
	$IContentTemplate -> assign ("SESS_URL", $_POST[sessid]);

	if ((!empty($_POST[oldname]))&&(!strpos($_POST[oldname], ".."))&&(!strpos($_POST[oldname], "/"))&&(!empty($_POST[newname]))&&(!strpos($_POST[newname],".."))&&(!strpos($_POST[newname],"/")))
	{
		if (!empty($_SESSION[subpath]))
		{
			$fulloldname = $cfg[PATH][root] . substr($_SESSION[subpath], 1, strlen($_SESSION[subpath])-1) . "/" . $_POST[oldname];
			$fullnewname = $cfg[PATH][root] . substr($_SESSION[subpath], 1, strlen($_SESSION[subpath])-1) . "/" . $_POST[newname];
		}
		else
		{
			$fulloldname = $cfg[PATH][root] . $_POST[oldname];
			$fullnewname = $cfg[PATH][root] . $_POST[newname];
		}
		
		rename($fulloldname,$fullnewname);
	}
		
	$IContentTemplate -> assign ( "CurrentFilename",  $_POST[oldname]);
	$IContentTemplate -> assign ( "UNIQHDWID", $_POST[hdwid]);

	$TemplateHTML = $IContentTemplate -> fetch( 'HTMLWindows/innertemplates/htmlrenamefilefolder.tpl.php' );
	
	$tpl -> assign ( "HTMLWINDOWCONTENT", win( $TemplateHTML ) );
?>