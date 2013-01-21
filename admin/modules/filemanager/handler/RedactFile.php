<?php
$IContentTemplate = new Smarty_Admin();

$IContentTemplate -> assign ( "PAGEID" , "'" . $_POST[parentlayerid] . "'" );
$IContentTemplate -> assign ("SESS_URL", $_POST[sessid]);

$fname = $cfg[PATH][root] . "" . $_POST[parentlayerid];

if ( isset($_POST[newcontent]) && isset($_POST[filename]) )
{
	print_r("<br><br><br>" . $fname);
	$CurrentContentFile = fopen($_POST[filename], 'w+');
	fwrite( $CurrentContentFile, iconv("UTF-8", "WINDOWS-1251", $_POST[newcontent]), strlen( $_POST[newcontent] ) );
	fclose($CurrentContentFile);
}

$filehandler = fopen($fname, "r+");
if (filesize($fname)>0)
{
	$cont = fread($filehandler, filesize($fname));
}

$IContentTemplate -> assign ( "CONTENT",  $cont);
$IContentTemplate -> assign ( "UNIQHDWID", $_POST[hdwid]);
$IContentTemplate -> assign ( "FILENAME", str_replace("//","/",$fname) );
$IContentTemplate -> assign ( "NAME", $fname );

$TemplateHTML = $IContentTemplate -> fetch( $cfg[PATH][admin_modules].'filemanager/templates/getContentTextFile.tpl.php' );

$tpl -> assign ( "HTMLWINDOWCONTENT", win( $TemplateHTML ) );

?>