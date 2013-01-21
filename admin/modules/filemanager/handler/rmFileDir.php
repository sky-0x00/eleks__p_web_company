<?php

	function rmfilefolder_recoursively($name)
	{
		print_r($name);
		if (is_file($name))
		{
			unlink($name);
		}
		
		if (is_dir($name))
		{
			$sub = glob($name . "/*");
			foreach ($sub as $itm)
			{
				rmfilefolder_recoursively($itm);				
			}
			rmdir($name);
		}
	}

	$IContentTemplate = new Smarty_Admin();
	$Templates = new Templates();

	$IContentTemplate -> assign ( "PAGEID" , "'" . $_POST[parentlayerid] . "'" );
	$IContentTemplate -> assign ("SESS_URL", $_POST[sessid]);

	if ((!empty($_POST[filefoldername]))&&(!strpos($_POST[filefoldername], ".."))&&(!strpos($_POST[filefoldername], "/")))
	{
		if (!empty($_SESSION[subpath]))
		{
			$pth = $cfg[PATH][root] . substr($_SESSION[subpath], 1, strlen($_SESSION[subpath])-1) . "/" . $_POST[filefoldername];
		}
		else
		{
			$pth = $cfg[PATH][root] . $_POST[filefoldername];
		}
		rmfilefolder_recoursively($pth);
	}
	
	$IContentTemplate -> assign ( "CONTENT",  $cont);
	$IContentTemplate -> assign ( "UNIQHDWID", $_POST[hdwid]);

	$TemplateHTML = $IContentTemplate -> fetch( 'HTMLWindows/innertemplates/htmlsetfoldername.tpl.php' );
	
	$tpl -> assign ( "HTMLWINDOWCONTENT", win( $TemplateHTML ) );
?>