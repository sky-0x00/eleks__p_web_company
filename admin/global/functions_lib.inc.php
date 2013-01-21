<?php

////////////////////////////////////////////////////////////////////////////////
//
//	functions_lib.inc.php - библиотека функций
//
// 	Версия: 1.0
//

////////////////////////////////////////////////////////////////////////////////
//
//	void DirInclude ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция включает все файлы, которые находятся в каталоге $path_include.
//
////////////////////////////////////////////////////////////////////////////////
function DirInclude ( $path_include ) {

	$dir = dir ( $path_include );
	
	//	последовательное получение имен каждого файла, имеющегося
	//	в каталоге $path_include
	while ( false !== ( $file_name = $dir->read () ) ) {

		//	исключение файлов с именем "." и ".."
		if ( $file_name != "." && $file_name != ".." ) {

			//	включение файла
			//echo $path_include . $file_name . "<br>";
			if ( is_dir ( $path_include . $file_name ) )
			DirInclude ( $path_include . $file_name . "/" );
			else
			include_once ( $path_include . $file_name );

		}

	}

	//	деинициализация экземпляра класса каталога $path_include
	$dir->close ();

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	void DirArray ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//
//
////////////////////////////////////////////////////////////////////////////////
function DirArray ( $path_include ) {

	$dir = dir ( $path_include );

	//	последовательное получение имен каждого файла, имеющегося
	//	в каталоге $path_include
	while ( false !== ( $file_name = $dir->read () ) ) {

		//	исключение файлов с именем "." и ".."
		if ( $file_name != "." && $file_name != ".." ) {

			$file_array[] = $file_name;

		}

	}

	//	деинициализация экземпляра класса каталога $path_include
	$dir->close ();

	return $file_array;

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	void DirDel ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция удаляет каталог и всё его содержимое.
//
////////////////////////////////////////////////////////////////////////////////
function DirDel ( $path_include ) {

	$dir = dir ( $path_include );

	//	последовательное получение имен каждого файла, имеющегося в каталоге $path_include
	while ( false !== ( $file_name = $dir->read () ) ) {

		//	исключение файлов с именем "." и ".."
		if ( $file_name != "." and $file_name != ".." ) {

			if ( is_dir ( $path_include . "/" . $file_name ) )
			DirDel ( $path_include . "/" . $file_name );

			unlink ( $path_include . "/" . $file_name );

		}

	}

	//	деинициализация экземпляра класса каталога $path_include
	$dir->close ();

	rmdir ( $path_include );

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	void OnlyDir ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция выдает список каталогов заданной директории.
//
////////////////////////////////////////////////////////////////////////////////
function OnlyDir ( $path_include ) {

	$dir = dir ( $path_include );

	//	последовательное получение имен каждого файла, имеющегося в каталоге $path_include
	while ( false !== ( $file_name = $dir->read () ) ) {

		//	исключение файлов с именем "." и ".."
		if ( $file_name != "." and $file_name != ".." ) {

			if ( is_dir ( $path_include . "/" . $file_name ) )
			$arr[] = $file_name;

		}

	}

	//	деинициализация экземпляра класса каталога $path_include
	$dir->close ();

	return $arr;

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	void LoadSettings ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция загружает настройки из файла в формате CSV.
//
////////////////////////////////////////////////////////////////////////////////
function LoadSettings ( $file ) {

	global $cfg;

	$file_content = file ( $file );

	while ( list ( , $line ) = each ( $file_content ) ) {

		if ( trim ( $line ) != "" ) {

			list ( $key, $val, $str ) = explode ( ";;", $line );

			$cfg[LOAD][$key][val] = $val;
			$cfg[LOAD][$key][str] = $str;

		}

	}

	return true;

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	void SaveSettings ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция сохраняет настройки в файл в формате CSV.
//
////////////////////////////////////////////////////////////////////////////////
function SaveSettings () {

	global $cfg, $_POST, $_SESSION;

	if ( !$handle = fopen ( $cfg[GENERAL][tune_file], "w" ) )
	$_SESSION[CACHE][RETURN_MSG] = $cfg[RETURN_MSG][tune_file_blocked];

	while ( list ( $key, $val ) = each ( $_POST ) ) {

		if ( substr ( $key, 0, 2 ) == "s_" ) {

			$key = substr ( $key, 2 );
			$line = $key . ";;" . $val . ";;" . $cfg[LOAD][$key][str];
			fwrite ( $handle, $line );

		}

	}

	fclose ( $handle );

	return true;

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	void page_jump ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция организует переход сценария на другую страницу.
//
////////////////////////////////////////////////////////////////////////////////
function page_jump ( $page ) {

	//	Отправляет заголовок серверу
	header ( "Location: $page" );
	exit;

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	boolean isEmail ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция проверяет правильность e-mail-адреса.
//
////////////////////////////////////////////////////////////////////////////////
function is_email ( $email ) {

	$pattern = '/^[a-z0-9_.\-]+@[a-z0-9_.\-]+\.[a-z0-9_.\-]+$/i';

	$res = preg_match($pattern, $email);

	return (bool)$res;
}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	boolean is_url ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция проверяет правильность url-адреса.
//
////////////////////////////////////////////////////////////////////////////////
function is_url ( $url ) {

	$pattern  = "/^(http:\/\/){1}([a-z0-9_]|\.)+[a-z]{2,4}\/$/si";

	if ( preg_match ( $pattern, $url ) and strpos ( $url, ".." ) === false )
	return true;
	else
	return false;

}
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//
//	string specialchars ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция возвращает строку для HTML-вывода.
//
////////////////////////////////////////////////////////////////////////////////
function specialchars ( $text ) {

	return nl2br ( htmlspecialchars ( stripslashes ( $text ) ) );

}

function validateForm ( $text ) {

	return trim ( nl2br ( htmlspecialchars ( stripslashes ( strip_tags ( $text ) ) ) ) );

}

////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	string specialchars2 ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция возвращает строку для HTML-вывода.
//
////////////////////////////////////////////////////////////////////////////////
function specialchars2 ( $text ) {

	return htmlspecialchars ( stripslashes ( $text ) );

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	string specialchars3 ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция возвращает строку для HTML-вывода.
//
////////////////////////////////////////////////////////////////////////////////
function specialchars3 ( $text ) {

	return nl2br ( stripslashes ( $text ) );

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	string generate_md5 ( void )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция возвращает md5-хэдж.
//
////////////////////////////////////////////////////////////////////////////////
function generate_md5 () {

	return md5 ( uniqid ( time () ) );
	//return substr ( md5 ( uniqid ( time () ) ), 0, 6 );

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	string date2unix ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция возвращает время в формате Timestamp.
//
////////////////////////////////////////////////////////////////////////////////
function date2unix ( $date ) {

	$time_array = explode ( ".", $date );
	$timestamp = mktime ( 23, 59, 59, $time_array[1], $time_array[0], $time_array[2] );

	return $timestamp;

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	string str2time ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция преобразует время в формате HH:MM:SS в Timestamp.
//
////////////////////////////////////////////////////////////////////////////////
function str2time ( $time ) {

	list ( $hour, $min, $sec ) = explode ( ":", $time );
	$timestamp = $hour * 3600 + $min * 60 + $sec;

	return $timestamp;

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	string time2str ( string )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Функция преобразует время Timestamp в формат HH:MM:SS.
//
////////////////////////////////////////////////////////////////////////////////
function time2str ( $time ) {

	return str_pad ( floor ( $time / 3600 ), 2, "0", STR_PAD_LEFT ) . ":" . str_pad ( floor ( $time % 3600 / 60 ), 2, "0", STR_PAD_LEFT ) . ":" . str_pad ( floor ( $time % 3600 % 60 ), 2, "0", STR_PAD_LEFT );

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//	int getmicrotime ( void )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Возвращает время в микросекундах.
//
////////////////////////////////////////////////////////////////////////////////
function getmicrotime () {

	list ( $usec, $sec ) = explode ( " ", microtime () );
	return ( ( float ) $usec + ( float ) $sec );

}
////////////////////////////////////////////////////////////////////////////////

 /**
   * Converts an associative array of arbitrary depth and dimension into JSON representation.
   *
   * NOTE: If you pass in a mixed associative and vector array, it will prefix each numerical
   * key with "key_". For example array("foo", "bar" => "baz") will be translated into
   * {'key_0': 'foo', 'bar': 'baz'} but array("foo", "bar") would be translated into [ 'foo', 'bar' ].
   *
   * @param $array The array to convert.
   * @return mixed The resulting JSON string, or false if the argument was not an array.
   * @author Andy Rusterholz
   *
   */
 
function array2json( $array ) {

    if ( !is_array( $array ) ) {
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    if ( $associative ) {

        $construct = array();
        foreach ( $array as $key => $value ) {

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if ( is_numeric($key) ) {
                $key = "key_$key";
            }
            $key = "\"".addslashes($key)."\"";

            // Format the value:
            if ( is_array( $value )) {
                $value = array2json( $value );
            } 
			else if ( !is_numeric( $value ) || is_string( $value ) ) {
                $value = "\"".addslashes($value)."\"";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } 
	else { // If the array is a vector (not associative):

        $construct = array();
        foreach ( $array as $value ) {

            // Format the value:
            if ( is_array( $value )) {
                $value = array2json( $value );
            } 
			else if ( !is_numeric( $value ) || is_string( $value ) ) {
                $value = "\"".addslashes($value)."\"";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return PrintJSString ($result);
}
  
  /*
   * Convert string to js format (for "json")
   *
   * @param string $str
   * @return string $str
   *
  */
  
function PrintJSString ($str) {
	
	$str = str_replace ("\r\n", '\n', $str);
	$str = str_replace ("\n", '\n', $str);
	$str = str_replace ("\r", '\n', $str);
	
	return $str;
}

////////////////////////////////////////////////////////////////////////////////
//
//	int MonthDifference ( int, int )
//
////////////////////////////////////////////////////////////////////////////////
//
//	Возвращает разницу дат в месяцах.
//
////////////////////////////////////////////////////////////////////////////////

function MonthDifference ( $first_date, $second_date ) {

	$temp_date = $first_date;
	$t = date ( "n", $first_date );
	$difference = 0;

	while ( $temp_date < $second_date ) {

		$difference++;
		$t++;

		$temp_date = mktime ( 0, 0, 0, $t, 1, date ( "Y", $first_date ) );

	}

	return $difference;

}

////////////////////////////////////////////////////////////////////////////////

function GetRealIp() {
 
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
  		$ip=$_SERVER['HTTP_CLIENT_IP'];
 	}
 	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
  		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
 	}
 	else {
   		$ip=$_SERVER['REMOTE_ADDR'];
 	}
 	return $ip;
}

////////////////////////////////////////////////////////////////////////////////

function SearchSubstr ($string, $count) {
	if (strlen($string)<$count)
		return $string;
	while ( !(($string[$count-1]==" ")||($string[$count-1]==".")) && ($count<=strlen($string)) )
		$count++;
	return substr($string, 0, $count);
}

////////////////////////////////////////////////////////////////////////////////

function SubText ($text, $count) {
	if (strlen($text)<$count)
		return $text;
	
	while (! ( (($text[$count-4]=='<')&&($text[$count-3]=='b')&&($text[$count-2]=='r')&&($text[$count-1]=='>')) || (($text[$count-4]=='<')&&($text[$count-3]=='/')&&($text[$count-2]=='p')&&($text[$count-1]=='>')) ) && ($count<=strlen($text)) ) {
		$count++;
	}
	return substr($text, 0, $count);
}

////////////////////////////////////////////////////////////////////////////////

function ToRealDate ($date) {
	
	$months = array("01" => "января",
					"02" => "февраля",
					"03" => "марта",
					"04" => "апреля",
					"05" => "мая",
					"06" => "июня",
					"07" => "июля",
					"08" => "августа",
					"09" => "сентября",
					"10" => "октября",
					"11" => "ноября",
					"12" => "декабря");
	
	$date_ar = explode(".", $date);
	
	return $date_ar[0] . " " . $months[$date_ar[1]] . " " . $date_ar[2];
	
}

////////////////////////////////////////////////////////////////////////////////

function ToDatePicker ($date) {
	
	$date_ar = explode(".", $date);
	
	return $date_ar[0] . "/" . $date_ar[1] . "/" . $date_ar[2];
	
}

////////////////////////////////////////////////////////////////////////////////

function uploadImage($file, $uploaddir, $md5, $name, $width, $height, $thumb, $width_tmb, $height_tmb) {
	
	$namearray = explode(".", basename($file['name']));
		
	if ($md5) {
	
		$time 			= time();
		$md5_name 		= md5($time);
		$filename		= $md5_name . "." . $namearray[count($namearray)-1];
		$filename_thumb	= $md5_name . "_thumb." . $namearray[count($namearray)-1];
		$uploadfile 	= $uploaddir . $filename;
		$thumbnail 		= $uploaddir . $filename_thumb;
	}	
	else {
	
		$filename		= $name . "." . $namearray[count($namearray)-1];
		$filename_thumb	= $name . "_thumb." . $namearray[count($namearray)-1];
		$uploadfile 	= $uploaddir . $filename;
		$thumbnail 		= $uploaddir . $filename_thumb;
	}
	
	if ($thumb)
		if ( (imageResize($file['tmp_name'], $uploadfile, $width, $height)) && (imageResize($file['tmp_name'], $thumbnail, $width_tmb, $height_tmb)) ) {
			unlink($file['tmp_name']);
			return array("image" => $filename, "thumb" => $filename_thumb);
		}
		else
			return false;
	else 
		if (imageResize($file['tmp_name'], $uploadfile, $width, $height)) {
			unlink($file['tmp_name']);
			return array("image" => $filename);
		}
		else
			return false;
}

// array imageResize (string $src, string $dest, integer $width, integer $height);
//  $src             - имя исходного файла
//  $dest            - имя генерируемого файла
//  $width, $height  - максимальные ширина и высота генерируемого изображения
// возвращает массив (0=>$width, 1=>$height) с шириной и высотой получившегося изображения

function imageResize ($src, $dest, $width, $height) {
	
	if (!file_exists($src)) 
		return false;
  	if (($size=getimagesize($src))===false) 
  		return false;

  	$format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
  	$icfunc = 'imagecreatefrom' . $format;
  	if (!function_exists($icfunc)) 
  		return false;

  	if ($size[0] < $width)
		$width = $size[0];
	
	if ($size[1] < $height)
		$height = $size[1];
	
	$x_ratio = $width/$size[0];
  	$y_ratio = $height/$size[1];

  	$ratio = min($x_ratio, $y_ratio);
  	$use_x_ratio = ($x_ratio==$ratio);

  	$new_width = $use_x_ratio ? $width : floor($size[0]*$ratio);
  	$new_height = !$use_x_ratio ? $height : floor($size[1]*$ratio);
  	$new_left = $use_x_ratio ? 0 : floor(($width-$new_width)/2);
  	$new_top = !$use_x_ratio ? 0 : floor(($height-$new_height)/2);

  	$isrc = $icfunc($src);
  	$idest = imagecreatetruecolor($new_width, $new_height);

  	imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $new_width, $new_height, $size[0], $size[1]);
 
  	if ($format=='jpeg') 
  		imagejpeg($idest, $dest);
  	else 
  		imagepng($idest, $dest);

  	imagedestroy($isrc);
  	imagedestroy($idest);

  	return array($new_width, $new_height);
}

////////////////////////////////////////////////////////////////////////////////

function DateAdd($interval, $number, $date) {
	
	$datearr = explode('-', $date);
	$date = mktime(0, 0, 0, $datearr[1], $datearr[2], $datearr[0]);
	
    $date_time_array = getdate($date);
	
    $hours = $date_time_array['hours'];
    $minutes = $date_time_array['minutes'];
    $seconds = $date_time_array['seconds'];
    $month = $date_time_array['mon'];
    $day = $date_time_array['mday'];
    $year = $date_time_array['year'];

    switch ($interval) {
    
        case 'yyyy':
            $year += $number;
            break;
        case 'q':
            $year += ($number*3);
            break;
        case 'm':
            $month += $number;
            break;
        case 'y':
        case 'd':
        case 'w':
            $day += $number;
            break;
        case 'ww':
            $day += ($number*7);
            break;
        case 'h':
            $hours += $number;
            break;
        case 'n':
            $minutes += $number;
            break;
        case 's':
            $seconds += $number; 
            break;            
    }
	$timestamp = mktime($hours, $minutes, $seconds, $month, $day, $year);
	
    return $timestamp;
}

////////////////////////////////////////////////////////////////////////////////

function DateDiff ($date1, $date2) {

	$datearr1 = explode('-', $date1);
	$datearr2 = explode('-', $date2);

	$date1 = mktime(0, 0, 0, $datearr1[1], $datearr1[2], $datearr1[0]);
	$date2 = mktime(0, 0, 0, $datearr2[1], $datearr2[2], $datearr2[0]);

	$timedifference = $date1 - $date2;
	
	return $timedifference;
}

function recursiveDelete($str){
    
	if (is_file($str)) {
        return @unlink($str);
    }
	
    elseif (is_dir($str)) {
	
        $scan = glob(rtrim($str,'/').'/*');
        foreach ($scan as $index => $path) {
            recursiveDelete($path);
        }
		
        return @rmdir($str);
    }
}

function subspacestr ($string, $from, $count) {
	if (strlen($string)<$count)
		return $string;
	while (($string[$count-1]!=" ")&&($string[$count-1]!=".")&&($count<=strlen($string)))
		$count++;
	return substr(nl2br(strip_tags($string)), $from, $count);
}

// Функция переводит русские слова в транслит

function translateToLat($string) {
	
	$russian = array("ай", "ей", "ий", "ой", "уй", "ый", "эй", "юй", "яй");
	$latin = array("ay", "ey", "iy", "oy", "uy", "iy", "ey", "yuy", "yay");
	
	$string = str_replace($russian, $latin, $string);
	
	$russian = array('ё','ж','ц','ч','ш','щ','ъ','ы','ь', 'ю','я','Ё','Ж','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Ю','Я');
	$latin = array('yo','zh','c','ch','sh','sh','``', 'y`', '`','yu','ya','Yo','Zh','C','Ch','Sh','Sh','``', 'Y`', '`','Yu','Ya');
	
	$string = str_replace($russian, $latin, $string);
	$string = strtr($string, "АБВГДЕЗИЙКЛМНОПРСТУФХЪЫЬЭабвгдезийклмнопрстуфхэ", "ABVGDEZIJKLMNOPRSTUFH_Y_Eabvgdezijklmnoprstufhe");
 
	return($string);
}

///////////////////////////////////////////////////////************************//////////////////////
// 	X-Mail O_o 
//	
//	ДАЛЕЕ ОЧЕНЬ ВАЖНАЯ ПОСЛЕДОВАЕЛЬНОСТЬ СИМВОЛОВ! НЕ УДАЛЯТЬ НЕ ПРИ КАКИХ УСЛОВИЯХ!!1 			
//
//	*/%@/#$*/!;№*"*;":;*№"@##$@_+@#--@!#$)@_-@*@%:%*№*;="№;**"№%;№;**/!~~@#@*@#~@)#-@&%^$#
//
///////////////////////////////////////////////////////************************/////////////////////

function xmail( $from, $to, $subj, $text, $filename) {
	
	$f		= 	fopen($filename,"rb");
	$un     = 	strtoupper(uniqid(time()));
	$head   = 	"From: $from\n";
	$head   .= 	"To: $to\n";
	$head   .= 	"Subject: $subj\n";
	$head   .= 	"X-Mailer: PHPMail Tool\n";
	$head   .= 	"Reply-To: $from\n";
	$head   .= 	"Mime-Version: 1.0\n";
	$head   .= 	"Content-Type:multipart/mixed;";
	$head   .= 	"boundary=\"----------".$un."\"\n\n";
	$zag    = 	"------------".$un."\nContent-Type:text/html;\n";
	$zag    .= 	"Content-Transfer-Encoding: 8bit\n\n$text\n\n";
	$zag    .= 	"------------".$un."\n";
	$zag	.= 	"Content-Type: application/octet-stream;";
	$zag    .= 	"name=\"".basename($filename)."\"\n";
	$zag    .= 	"Content-Transfer-Encoding:base64\n";
	$zag    .= 	"Content-Disposition:attachment;";
	$zag    .= 	"filename=\"".basename($filename)."\"\n\n";
	$zag    .= 	chunk_split(base64_encode(fread($f,filesize($filename))))."\n";
 
	return @mail("$to", "$subj", $zag, $head);
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function utf8($string) {
	return iconv("utf-8", "windows-1251", $string);
}

function win($string) {

	return iconv("windows-1251", "utf-8", $string);
	//return iconv("ISO-8859-1", "ISO-8859-1", $string);
}


////////////////////////////////////////////////////////////////////////////////
//	Вывод информации о подключенном файле.
if ( ERROR_PRINT_INCLUDE_FILENAME != 0 )
echo "Functions library (file " . basename ( __FILE__ ) . ")<br>";
////////////////////////////////////////////////////////////////////////////////

?>
