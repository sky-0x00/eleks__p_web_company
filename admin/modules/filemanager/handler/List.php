<?php

$IContentTemplate = new Smarty_Admin();
$Templates = new Templates();

$IContentTemplate -> assign ( "PAGEID" , "'" . $_POST[parentlayerid] . "'" );
$IContentTemplate -> assign ("SESS_URL", $_POST[sessid]);

$FilesList = glob($cfg[PATH][root] . $_SESSION[subpath] . "/*");

foreach ($FilesList as $FileListItem)
{
	$filenamearr = explode("/",$FileListItem);
	$filename = $filenamearr[count($filenamearr)-1];
	if (is_file($FileListItem))
	{
		$is_folder = 0;
	}
	else
	{
		$is_folder = 1;
	}
	$NewFileList[] = array("filename"=>$filename,"is_folder"=>$is_folder,"size"=>filesize($FileListItem),"date"=>date("d.m.Y H:i:s",filemtime($FileListItem)));
}

if (is_array($NewFileList))
{
	$DopFilesList = array();
	$DopFoldersList = array();

	foreach ($NewFileList  as $key=>$item)
	{
		if ($item[is_folder]==0)
		{
			$DopFilesList[] = $item;
		}
		else
		{
			$DopFoldersList[] = $item;
		}
	}
	$NewFileList = array_merge($DopFoldersList, $DopFilesList);
}

$FilesList = $NewFileList;

$IContentTemplate -> assign ("FilesList", $FilesList);
$IContentTemplate -> assign ("CurPath", $_SESSION[subpath]);
$IContentTemplate -> assign ( "UNIQHDWID", $_POST[hdwid]);

$TemplateHTML = $IContentTemplate -> fetch( 'HTMLWindows/innertemplates/htmlfilelist.tpl.php' );

$tpl -> assign ( "HTMLWINDOWCONTENT", win( $TemplateHTML ) );

?>