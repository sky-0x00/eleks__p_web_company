<?php

class FileManager {

	function file_size($file_size) {
		if ($file_size >= 1073741824) {
			$file_size = round($file_size / 1073741824 * 100) / 100 . " G";
		}
		elseif ($file_size >= 1048576) {
			$file_size = round($file_size / 1048576 * 100) / 100 . " M";
		}
		elseif ($file_size >= 1024) {
			$file_size = round($file_size / 1024 * 100) / 100 . " К";
		}
		else {
			$file_size = $file_size . " b";
		}
		return $file_size;
	}

	function dir_size($dir) {
		$dh = opendir($dir);
		$size = 0;
		while (($file = readdir($dh)) !== false)
		if ($file != "." and $file != "..") {
			$path = $dir."/".$file;
			if (is_dir($path)) $size += $this->dir_size($path);
			elseif (is_file($path)) $size += filesize($path);
		}
		closedir($dh);
		return $size;
	}

	function display_perms( $mode ) {
		if(($mode & 0xC000) === 0xC000) // Сокет домена
		$type = "s";
		elseif(($mode & 0x4000) === 0x4000) // Директория
		$type = "d";
		elseif(($mode & 0xA000) === 0xA000) // Символическая ссылка
		$type = "l";
		elseif(($mode & 0x8000) === 0x8000) // Регулярный файл
		$type = "-";
		elseif(($mode & 0x6000) === 0x6000) // Специальный файл БЛОК
		$type = "b";
		elseif(($mode & 0x2000) === 0x2000) // Специальный файл Символ
		$type = "c";
		elseif(($mode & 0x1000) === 0x1000) // PIPE
		$type = "p";
		else // Неизвестный
		$type = "?";

		$owner['read'] = ($mode & 00400) ? "r" : "-";
		$owner['write'] = ($mode & 00200) ? "w" : "-";
		$owner['execute'] = ($mode & 00100) ? "x" : "-";
		$group['read'] = ($mode & 00040) ? "r" : "-";
		$group['write'] = ($mode & 00020) ? "w" : "-";
		$group['execute'] = ($mode & 00010) ? "x" : "-";
		$world['read'] = ($mode & 00004) ? "r" : "-";
		$world['write'] = ($mode & 00002) ? "w" : "-";
		$world['execute'] = ($mode & 00001) ? "x" : "-";

		if( $mode & 0x800 )
		$owner['execute'] = ($owner[execute]=="x") ? "s" : "S";
		if( $mode & 0x400 )
		$group['execute'] = ($group[execute]=="x") ? "s" : "S";
		if( $mode & 0x200 )
		$world['execute'] = ($world[execute]=="x") ? "t" : "T";

		$return = $type.$owner['read'].$owner['write'].$owner['execute'].$group['read'].$group['write'].$group['execute'].$world['read'].$world['write'].$world['execute'];

		return $return;
	}

	function directory_chmod($dirname)
	{

		$dir = opendir($dirname);
		while (($file = readdir($dir)) !== false) {

			if($file != "." && $file != "..")  {

				chmod($dirname."/".$file, 0777);
				if(is_dir($dirname."/".$file)) {
					directory_chmod($dirname."/".$file);
				}
			}
		}

		closedir($dir);
	}


	function directory_delete($dirname){

		$dir = opendir($dirname);
		while (($file = readdir($dir)) !== false)
		{
			if($file != "." && $file != "..")
			{
				if(is_file($dirname."/".$file)) {
					unlink($dirname."/".$file);
				}
				if(is_dir($dirname."/".$file)) {
					$this->directory_delete($dirname."/".$file);

					rmdir($dirname."/".$file);
				}
			}
		}
		closedir($dir);
		rmdir($dirname);
	}
}

?>