<?php
$IContentTemplate = new Smarty_Admin();

$IContentTemplate -> assign ( "PAGEID" , "'" . $_POST[parentlayerid] . "'" );
$IContentTemplate -> assign ("SESS_URL", $_POST[sessid]);

if ((!empty($_POST[filename]))&&(!strpos($_POST[filename], ".."))&&(!strrpos($_POST[filename], "/")))
{
	if (!empty($_SESSION[subpath]))
	{
		$pth = $cfg[PATH][root] . substr($_SESSION[subpath], 1, strlen($_SESSION[subpath])-1) . "/" . $_POST[filename];
	}
	else
	{
		$pth = $cfg[PATH][root] . $_POST[filename];
	}
	$fp = fopen($pth, "a");
	
	fclose($fp);
	
	chmod($cfg[PATH][root] . $_POST[filename], 0664);
}

$IContentTemplate -> assign ( "CONTENT",  $cont);
$IContentTemplate -> assign ( "UNIQHDWID", $_POST[hdwid]);
?>