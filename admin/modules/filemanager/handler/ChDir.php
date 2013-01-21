<?php

//#########################################
$IContentTemplate = new Smarty_Admin();

$IContentTemplate -> assign ( "PAGEID" , "'" . $_POST[parentlayerid] . "'" );
$IContentTemplate -> assign ("SESS_URL", $_POST[sessid]);
//#########################################

include_once($cfg[PATH][admin_classes]."Filemanager.class.php");
$filemanager = new FileManager();


if (!isset($_POST[subpath]))
{
	$FilesList = glob($cfg[PATH][root] . "*");
}
else
{
	if ($_POST[subpath]!="upngo")
	{
		if ((!strrpos($_POST[subpath],".."))&&($_SESSION[subpath]!=$cfg[PATH][root])&&(is_dir($cfg[PATH][root] . $_SESSION[subpath] . "/" . $_POST[subpath])))
		{
			$_SESSION[subpath] .= "/" . $_POST[subpath];
		}
	}
	else
	{
		$subpatharr = explode("/",$_SESSION[subpath]);
		$subpatharr = array_slice($subpatharr,0,count($subpatharr)-1);
		$_SESSION[subpath] = implode("/",$subpatharr);
	}
}

$FilesList = glob($cfg[PATH][root] . $_SESSION[subpath] . "/*");

foreach ($FilesList as $FileListItem)
{
	$filenamearr = explode("/",$FileListItem);
	$filename = $filenamearr[count($filenamearr)-1];
	if (is_file($FileListItem))
	{
		$is_folder = 0;
		$size = $filemanager->file_size (filesize($FileListItem));
		$attr = $filemanager->display_perms (fileperms($FileListItem));
		$stat = stat($FileListItem);
		$modified = date("d.m.Y H:i",$stat[9]); //���� ��������� ����������� �����
	}
	else
	{
		$is_folder = 1;
		$size = $filemanager->file_size ($filemanager->dir_size ($FileListItem));
		$attr = $filemanager->display_perms (fileperms($FileListItem));
		$stat = stat($FileListItem);
		$modified = date("d.m.Y H:i",$stat[9]); //���� ��������� ����������� �����
	}

	$NewFileList[] = array("filename"=>$filename, "is_folder"=>$is_folder, "size"=>$size, "date"=>date("d.m.Y H:i:s",filemtime($FileListItem)), "attr"=>$attr, "modified"=>$modified);
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

for ($i = 0; $i < count($FilesList); $i++) {

	if ($FilesList[$i][is_folder] == 0) {

		$is_php = preg_match("/(\.php$)|(\.phtml$)|(\.php3$)|(\.php4$)/mi", $FilesList[$i][filename]);
		$is_img = preg_match("/(\.jpg$)|(\.gif$)|(\.png$)|(\.bmp$)/mi", $FilesList[$i][filename]);

		if ($is_php) {

			$icon[$i] 	= "icon_php";
			$alt[$i] 	= "������ PHP";

		}  elseif($is_img) {

			$icon[$i] 	= "icon_img";
			$alt[$i] 	= "���� �������";

		} else {

			$icon[$i] 	= "icon_blank";
			$alt[$i] 	= "���� ������������ ����";
		}

	} else {

		$icon[$i] 		= "icon_folder";
		$alt[$i] 		= "����������";
	}
}

$IContentTemplate -> assign ("icon",		$icon);
$IContentTemplate -> assign ("alt",			$alt);
$IContentTemplate -> assign ("FilesList", 	$FilesList);
$IContentTemplate -> assign ("CurPath", 	$_SESSION[subpath]);
$IContentTemplate -> assign ( "UNIQHDWID", 	$_POST[hdwid]);

$TemplateHTML = $IContentTemplate -> fetch( $cfg[PATH][admin_modules].'filemanager/templates/Filemanager_list.tpl.php' );

$tpl -> assign ( "HTMLWINDOWCONTENT", win( $TemplateHTML ) );

?>