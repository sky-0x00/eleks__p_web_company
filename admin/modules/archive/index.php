<?php
//////////////////////////////////////////////////////////////////////////////////////
include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/global/functions_lib.inc.php");
include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/settings/DB.inc.php");
include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/settings/Path.inc.php");
include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/settings/Table.inc.php");
DirInclude($cfg['PATH']['core']);
DirInclude($cfg['PATH']['admin_classes']);
include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/lib/Smarty 2.6.18/Smarty.class.php");
include_once($_SERVER['DOCUMENT_ROOT'] ."/admin/global/local.inc.php");
//////////////////////////////////////////////////////////////////////////////////////

define("__DOCUMENT__", $cfg['PATH']['admin_modules'] ."archive/templates/archive-index.tpl.php");
exit("exit: " .$_POST['type']);

switch ($_POST['type']) {

	case "site":
	
		$zip = new ZipArchive();
		$filename = "archive.zip";
		$res = $zip -> open($filename, ZipArchive::CREATE);

		if ($res === true) {

			$dir = opendir($_SERVER['DOCUMENT_ROOT']);
			chdir($_SERVER['DOCUMENT_ROOT']);
			 
			while ($d = readdir($dir)) {
				if (is_file($d)) {
					$zip -> addFile($d, $d);
				}
			}
			
			header("Content-Disposition: attachment; filename=" . $filename);
			header("Content-Type: application/zip"); 
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: public");
			
			$fp = $zip -> getStream("archive");
			echo file_get_contents($fp);
			
			$zip -> close();
			closedir( $dir );
		}
		
		break;
		
	case "db":
	
		$Data = new WorkWithData();
		if ($Data -> db -> query ( printf ("mysqldump -u%s -h%s -p%s %s > %s", $cfg[DB][User], $cfg[DB][Host], $cfg[DB][Pass], $cfg[DB][Name], $cfg[PATH][root] . "dump.sql" )) ) {
			header("Content-Disposition: attachment; filename=" . $filename);
			header("Content-Type: text/xml");
			
			echo file_get_contents($cfg[PATH][root] . "dump.sql");
		}	
		break;
		
	default:
		break;
}
?>
