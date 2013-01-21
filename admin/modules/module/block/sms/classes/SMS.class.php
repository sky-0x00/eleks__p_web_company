<?php

////////////////////////////////////////////////////////////////////////////////
//	Êëàññ "Îòïğàâêà ÑÌÑ" (ñ ñàéòà ulgsm)
////////////////////////////////////////////////////////////////////////////////

if (class_exists("RoBot")) {
		
	class SMS extends RoBot {
   
		var $start_url 			= "http://www.ulgsm-ncc.ru/";
		var $current_url 		= "http://www.ulgsm-ncc.ru/sms.php";
		
		var $_type 				= "";
		var $_method			= "";
		var $_delay				= 0;
		var $_proxy_server		= "";
		var $_proxy_param		= "";

		var $_captcha_img_url 	= "http://www.ulgsm-ncc.ru/sms.php?action=kart";
		
		var $isdn;
		
    	////////////////////////////////////////////////////////////////////////////////
		//	Êîíñòğóêòîğ
		////////////////////////////////////////////////////////////////////////////////

		function SMS () {
			
			$this -> _type = "socket";
			$this -> _method = "POST";
			$this -> _delay = 10;
			$this -> _proxy_server = "";
			$this -> _proxy_param = "";
			
			$this -> isdn = 79022441546;
		}
		
		////////////////////////////////////////////////////////////////////////////////
		//	Îòïğàâêà ÑÌÑ
		////////////////////////////////////////////////////////////////////////////////

		function SendSMS($message, $key="") {
			
			if (empty($this->cookies)) {
				
				if (empty($key))
				
					if ($this->GetCaptcha()) {
						//print_r($this->cookies); exit;
					}
					else 
						return FALSE;				
			}

			$this->agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.1.8) Gecko/20100202 Firefox/3.5.8";
			$this->accept = "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
			
			if (empty($this->current_url)) 
				$this->referer = $this->start_url;				
			else 
				$this->referer = $this->current_url;
			
			$this->rawheaders = array(
				'Accept-Language' => 'ru,en-us;q=0.7,en;q=0.3',
				'Accept-Charset' => 'windows-1251,utf-8;q=0.7,*;q=0.7',
				'Accept-Encoding' => 'gzip,deflate',				
				'Keep-Alive' => '300', 'Connection' => 'Keep-Alive',
				'Content-Type' => 'application/x-www-form-urlencoded',
				'Referer' => $this->referer
			);
			
			//$data_string = "isdn=" . $this -> isdn . "&message=" . urlencode($message) . "&keystring=" . $key . "&submit=%CE%F2%EF%F0%E0%E2%E8%F2%FC&action=start";
			$data_string = "isdn=7&message=%F3%EA%E5%EA%F3&keystring=&submit=%CE%F2%EF%F0%E0%E2%E8%F2%FC&action=start";
			
			if ($this->SendRequest($this->_type, $this->_method, $this->current_url, $data_string, TRUE, $this->_proxy_server, $this->_proxy_param)) {
												
				//$this->GetCookies($this->headers);
				print $this->results; exit;
				
				$html = $this->results;
				
				$preg_pattern = '/<div[[:space:]]*style="display: block;"[[:space:]]*id="_myArea">.*?<\/div>/s';
				
				$this->GetCaptcha();
				
				$pause = $this->_delay;
				sleep(($pause>=0) ? $pause : 0);
				
				if (preg_match($preg_pattern, $html, $matches))
					return TRUE;
				else 
					return FALSE;
			}
			else 
				return FALSE;

			return TRUE;
		}
		
		
		function GetCaptcha() {
			
			global $cfg;			
			
			unset($this->cookies);
			
			$this->agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.1.8) Gecko/20100202 Firefox/3.5.8";
			$this->accept = "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
			
			if (empty($this->current_url)) 
				$this->referer = $this->start_url;				
			else 
				$this->referer = $this->current_url;
			
			$this->rawheaders = array(
				'Accept-Language' => 'ru,en-us;q=0.7,en;q=0.3',
				'Accept-Charset' => 'windows-1251,utf-8;q=0.7,*;q=0.7', 
				'Keep-Alive' => '300', 'Connection' => 'Close',
				'Referer' => $this->referer
			);
						
			if ($this->SendRequest($this->_type, "GET", $this->current_url, "", TRUE, $this->_proxy_server, $this->_proxy_param)) {
				
				//print_r($this->headers); exit;
				
				if (($this->GetCookies($this->headers)) === FALSE) {
					return FALSE;
				}
				
				if ($this->SendRequest($this->_type, "GET", $this->_captcha_img_url, "", TRUE, $this->_proxy_server, $this->_proxy_param)) {
						
						$this -> _captcha_img = md5(time()) . ".jpg";
						
						$file = fopen($cfg['PATH']['GARBAGE'] . "captcha/" . $this -> _captcha_img, "w+");
						fwrite($file, $this->results);
						fclose($file);
						
						return true;
				}
				else { 
					return FALSE; 
				}				
				
				unset($this->rawheaders); return TRUE;
			}
			else { 
				return FALSE;
			}
		}
		
	}
	
}
?>