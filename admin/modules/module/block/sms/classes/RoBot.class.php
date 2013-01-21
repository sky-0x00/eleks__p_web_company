<?php

  /*
   * Project: SEOBOX.BIZ
   * File:    RoBot.class.php
   *
   * @idea Recovery Is Possible
   * @link http://www.pro-mt.ru
   * @author Andrey N. Petrov
   * @contact <andrey@pro-mt.ru>
   * @development Prometey LLC
   * @copiright Prometey LLC
  */

  class RoBot
  {
   /******************\
     Public variables
   \******************/

   var $agent			= "";			// agent we masquerade as
   var $accept			= "";			// set accepted types
   var $referer			= "";			// referer info to pass
   var $contentype		= "";			// set content type

   var $rawheaders		= array();		// additional headers
   var $cookies			= array();		// array of cookies to set

   var $charset			= "";			// save page charset
   var $respcode		= "";			// response server code
   var $status			= 0;			// save request status
   var $error			= "";			// error msg save here

   var $readtimeout		= 0;			// timeout on read (sec)

   var $headers			= array();		// returned headers
   var $results			= "";			// where the content is put

   /*******************\
     Private variables
   \*******************/

   var $_httpvers		= "HTTP/1.1";		// http request version

   var $_port			= 80;			// port for connecting
   var $_contimeout		= 120;			// timeout for connection
   var $_timedout		= false;		// if a timed out read

   var $_maxlinelen		= 512;			// max length for headers
   var $_maxlength		= 500000;		// max return data length

   /*==================================================================================*\
    * Purpose:	Send request on server
    * Input:	$type (connection type: SOCKET, CURL)
    *           $method (http request method: GET || POST)
    *           $url (the full URI)
    *           $body (get body? true || false)
    *           $proxy_server (proxy "host:port")
    *           $proxy_param (proxy "user:pass")
    * Output:	TRUE ($this->headers && $this->results) or FALSE ($this->error)
   \*==================================================================================*/

   function SendRequest($type, $method, $url, $data, $body, $proxy_server="", $proxy_param="")
   {
    switch(strtolower($type))
    {
     /*******************\
       SOCKET connection
     \*******************/

     case "socket":

     // $url = "http://username:password@hostname/path?arg=value#anchor";
     // preg_match("|^([^:]+)://([^:/]+)(:[\d]+)*(.*)|", $url, $URI_PARTS);
     //
     //	$URI_PARTS[scheme] => http
     // $URI_PARTS[host] => hostname
     // $URI_PARTS[user] => username
     // $URI_PARTS[pass] => password
     // $URI_PARTS[path] => /path
     // $URI_PARTS[query] => arg=value
     // $URI_PARTS[fragment] => anchor

     $URI_PARTS = parse_url($url); // print_r($URI);

     if (empty($URI_PARTS["host"]))
     {
      $this->error = 'Invalid host name "' . $URI_PARTS["host"] . '"';
      return FALSE; break;
     }

     switch(strtolower($URI_PARTS["scheme"]))
     {
      case "http":

      if (empty($proxy_server))
      {
       if (empty($URI_PARTS["query"])) $URI_PARTS["query"] = '';
       if (empty($URI_PARTS["path"])) $URI_PARTS["path"] = '';

       $path = $URI_PARTS["path"].($URI_PARTS["query"] ? "?".$URI_PARTS["query"]:"");

       $host = $URI_PARTS["host"];
       if (!empty($URI_PARTS["port"])) $port = $URI_PARTS["port"];
       else $port = $this->_port;
      }
      else
          {
           $path = $url;

           $proxy = explode(":", trim($proxy_server));
           if (!empty($proxy) && is_array($proxy) && count($proxy) == 2)
           {
            $host = $proxy[0]; $port = $proxy[1];
           }
           else
               {
                $this->error = 'Invalid proxy "' . $proxy_server . '"';
                return FALSE; break;
               }
          }

      // print "host = " . $host . ", port = " . $port . "<BR>\n";

      $this->status = 0;

      // make a socket connection here

      $fs = fsockopen($host, $port, $errno, $errstr, $this->_contimeout);

      if (!$fs)
      {
       $this->status = $errno;

       switch ($errno)
       {
        case -3: $this->error = "Socket creation failed (-3)";
        case -4: $this->error = "DNS lookup failure (-4)";
        case -5: $this->error = "Connection refused or timed out (-5)";
        default: $this->error = "connection failed (" . $errno . ")";
       }

       return FALSE; break;
      }

      if (empty($path)) $path = "/";

      $headers = $method." ".$path." ".$this->_httpvers."\r\n";

      if (!isset($this->rawheaders['Host']))
      {
       $headers .= "Host: " . $URI_PARTS["host"];
       if (!empty($URI_PARTS["port"])) $headers .= ":".$URI_PARTS["port"];
       $headers .= "\r\n";
      }

      if (!isset($this->rawheaders['User-Agent']))
      {
       if (!empty($this->agent)) $headers .= "User-Agent: ".$this->agent."\r\n";
      }

      if (!isset($this->rawheaders['Accept']))
      {
       if (!empty($this->accept)) $headers .= "Accept: ".$this->accept."\r\n";
      }

      if (!isset($this->rawheaders['Referer']))
      {
       if (!empty($this->referer)) $headers .= "Referer: ".$this->referer."\r\n";
      }

      if (!empty($this->contentype))
      {
       $headers .= "Content-type: " . $this->contentype;

       if ($this->contentype == "multipart/form-data")
       $headers .= "; boundary=" . $this->_mime_boundary;

       $headers .= "\r\n";
      }

      if (!empty($this->rawheaders))
      {
       if (!is_array($this->rawheaders))
       $this->rawheaders = (array)$this->rawheaders;

       while (list($headerKey, $headerVal) = each($this->rawheaders))
       $headers .= $headerKey . ": " . $headerVal . "\r\n";
      }

      // set cookies, if needs

      if (!empty($this->cookies))
      {
       $cookie_headers = '';

       if (!is_array($this->cookies)) $this->cookies = (array)$this->cookies;

       reset($this->cookies);

       if (count($this->cookies) > 0)
       {
        $cookie_headers .= 'Cookie: ';

        foreach ($this->cookies as $cookieKey => $cookieVal)
        {
         $cookie_headers .= $cookieKey . "=" . urlencode($cookieVal) . "; ";
        }

        $headers .= substr($cookie_headers, 0, -2) . "\r\n";
       }
      }

      if (!empty($URI_PARTS["user"]) || !empty($URI_PARTS["pass"]))
      {
       $headers .= "Authorization: Basic " . base64_encode(
       $URI_PARTS["user"] . ":" . $URI_PARTS["pass"]) . "\r\n";
      }
		
      if (!empty($proxy_param))
      {
       $headers .= 'Proxy-Authorization: Basic '.base64_encode($proxy_param)."\r\n";
      }

      //$headers .= "\r\n"; 
	  
	  if ($data) {
		$headers .= "Content-Length: " . strlen($data) . "\r\n\r\n";
		//$headers .= "\r\n";
		$headers .= $data."\r\n";		
	  }
	  
	  $headers .= "\r\n";
	  
	  //print $headers; exit;

      // set the read timeout if needed

      if ($this->readtimeout > 0) socket_set_timeout($fs, $this->readtimeout);

      $this->_timedout = false;

      fputs($fs, $headers); unset($this->headers);

      while($curHeader = fgets($fs, $this->_maxlinelen))
      {
       if ($this->readtimeout > 0 && $this->CheckTimeout($fs))
       {
        $this->error = 'Timeout has occurred: "' . $url . '"';
        return FALSE; break;
       }

       if ($curHeader == "\r\n") break;

       if (preg_match("|^HTTP/|", $curHeader))
       {
        if (preg_match("|^HTTP/[^\s]*\s(.*?)\s|", $curHeader, $status))
        {
         $this->status= $status[1];
        }
       
        $this->respcode = $curHeader;
       }

       $this->headers[] = $curHeader;
      }

      if (($this->status == 200)||($this->status == 302))
      {
       if ($body === TRUE)
       {
        $results = '';

        do
        {
         $_data = fread($fs, $this->_maxlength);

         if (strlen($_data) == 0)
         {
          break;
         }

         $results .= $_data;
        }
        while(true);

        if ($this->readtimeout > 0 && $this->CheckTimeout($fs))
        {
         $this->error = 'Timeout has occurred: "' . $url . '"';
         return FALSE; break;
        }

        $this->results = $results;
       }
      }
      else
          {
           $this->error = 'Response code: "'.$this->respcode.'"';
           return FALSE; break;
          }

      fclose($fs);
      return TRUE;
      break;

      case "https": /* Action for HTTPS scheme */ break;

      default:
      $this->error = 'Invalid protocol "'.$URI_PARTS["scheme"].'"';
      return FALSE;
      break;
     }
     break;

     /*****************\
       CURL connection
     \*****************/

     case "curl":
		      
		break;

     default:
	 
		$this->error = 'Invalid connection type "' . $type . '"';
		return FALSE; 
		break;
    }
   }

   /*==================================================================================*\
    * Purpose:	Get set cookies
    * Input:	$headers (array headers result)
    *           $cookie_param (array cookie var patterns)
    * Output:	TRUE ($this->$cookies) or FALSE ($this->error)
   \*==================================================================================*/

   function GetCookies($headers, $cookie_param = "")
   {
    if (!empty($cookie_param))
    {
     if (!is_array($cookie_param)) $cookie_param = (array)$cookie_param;

     $cookie_param_set = true;
    }
    else { $cookie_param_set = false; $cookie_param = array(); }

    //unset($this->cookies);

    for ($x = 0; $x < count($headers); $x++)
    {
     if (preg_match('/^set-cookie:[\s]+([^=]+)=([^;]+)/i', $headers[$x], $match))
     {
      if ($cookie_param_set)
      {
       if (in_array($match[1], $cookie_param))
       $this->cookies[$match[1]] = urldecode($match[2]);
      }
      else $this->cookies[$match[1]] = urldecode($match[2]);
     }
    }

    if (empty($this->cookies))
    {
     if ($cookie_param_set)
     {
      $cookie_vars = "";
      while (list($key, $val) = each($cookie_param)) $cookie_vars .= $val.", ";
      $this->error = 'Cookies "'.(substr($cookie_vars, 0, -2)).'" not found';
     }
     else $this->error = 'Cookies not found'; return FALSE;
    }
    else return TRUE;
   }

   /*==================================================================================*\
    * Purpose: 	Get set charset
    * Input:   	$headers (array headers result)
    * Output:  	TRUE ($this->charset) or FALSE ($this->error)
   \*==================================================================================*/

   function GetCharset($headers)
   {
    $this->charset = "";

    while(list($key, $val) = each($headers))
    {
     if (stristr($val, 'charset='))
     {
      $pos = strpos($val, 'charset=');

      if (is_int($pos))
      {
       $this->charset = substr($val, $pos + strlen('charset=')); return TRUE;
      }
     }
    }

    if (empty($this->charset))
    {
     $this->error = 'Page charset not found'; return FALSE;
    }
   }

   /*******************\
     Private functions
   \*******************/

   /*==================================================================================*\
    * Purpose:	Checks whether timeout has occurred
    * Input:	$fp (file pointer)
    * Output:	boolean TRUE or FALSE
   \*==================================================================================*/

   function CheckTimeout($fp)
   {
    if ($this->readtimeout > 0)
    {
     $fp_status = socket_get_status($fp);

     if ($fp_status["timed_out"])
     {
      $this->_timedout = true; return TRUE;
     }
    }
    return FALSE;
   }

  } // class end

  if (PRINT_FILENAME === TRUE) print realpath(__FILE__) . BR;

?>