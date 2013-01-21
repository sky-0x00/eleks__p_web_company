<?php

class ICQ {

	/*
	var $uin  = "486712226"; */
	var $pass = "12345678";
	
	function ICQ() {
		$this->method=false;
		$this->sequence=rand(1,30000);
	}
	function sockets($method) {
		$this->method=$method;
	}
	function connect($uin,$pass) {
		if ($this->method) {
			$this->socket=socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
			if ($this->socket<0||$this->socket===false) return false;
			$result=socket_connect($this->socket,"login.icq.com",80);
			if ($result<0||$result===false) return false;
		} else {
			$this->socket=fsockopen("login.icq.com",80,$errno);
			if ($errno!==0) return false;
		}
		$this->getpacket();
		$this->uin=$uin;
		$this->body.=$this->setoption('UIN',$uin);
		$ar=array(0xF3,0x26,0x81,0xC4,0x39,0x86,0xDB,0x92,0x71,0xA3,0xB9,0xE6,0x53,0x7A,0x95,0x7c);
		$hash="";
		for ($i=0;$i<strlen($pass);$i++) $hash.=chr($ar[$i]^ord($pass[$i]));
		$this->body.=$this->setoption('DATA',$hash);
		$this->body.=$this->setoption('CLIENT','HFICQ');
		$this->body.=$this->setoption('CLIENT_ID',266,2);
		$this->body.=$this->setoption('CLI_MAJOR_VER',20,2);
		$this->body.=$this->setoption('CLI_MINOR_VER',34,2);
		$this->body.=$this->setoption('CLI_LESSER_VER',0,2);
		$this->body.=$this->setoption('CLI_BUILD_NUMBER',2321,2);
		$this->body.=$this->setoption('DISTRIB_NUMBER',1085,4);
		$this->body.=$this->setoption('CLIENT_LNG','ru');
		$this->body.=$this->setoption('CLIENT_COUNTRY','ru');
		$this->channel=1;
		$pack=$this->prepare();
		if ($this->method) socket_write($this->socket,$pack,strlen($pack)); else fwrite($this->socket,$pack);
		$this->getpacket();
		$this->info=array();
		while($this->body!='') {
			$arr=unpack('n2',substr($this->body,0,4));
			$this->type=$arr[1];
			$this->size=$arr[2];
			$info=substr($this->body,4,$this->size);
			$key=array_search($this->type,$this->types);
			if($key) $this->info[$key]=$info;
			$this->body=substr($this->body,($this->size+4));
		}
		$this->body=0x0000;
		$pack=$this->prepare();
		if ($this->method) socket_write($this->socket,$pack,strlen($pack)); else fwrite($this->socket,$pack);
		if ($this->method) socket_close($this->socket); else fclose($this->socket);
		$this->socket=false;
		if (isset($this->info['RECONECT_HERE'])) {
			$url=explode(':',$this->info['RECONECT_HERE']);
			if ($this->method) {
				$this->socket=socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
				if ($this->socket<0||$this->socket===false) $res=false;
				$result=socket_connect($this->socket,$url[0],$url[1]);
				if ($result<0||$result===false) $res=false; else $res=true;
			} else {
				$this->socket=fsockopen($url[0],$url[1],$errno);
				if ($errno!==0) $res=false; else $res=true;
			}
			if (!$res) {
				$this->error=isset($this->info['DISCONECT_REASON'])?$this->info['DISCONECT_REASON']:'Невозможно сменить север';
				return false;
			}
		} else {
			$this->error=isset($this->info['DISCONECT_REASON'])?$this->info['DISCONECT_REASON']:'Превышен лимит подключений';
			return false;
		}
		$this->getpacket();
		$this->body.=$this->setoption('COOKIE',$this->info['COOKIE']);
		$pack=$this->prepare();
		if ($this->method) $wr=socket_write($this->socket,$pack,strlen($pack)); else $wr=fwrite($this->socket,$pack);
		if (!$wr) {
			$this->error='Соединение закрыто';
			return false;
		}
		$this->getpacket();
		$this->request_id++;
		$this->body=pack('nnnN',1,2,0,$this->request_id);
		$this->body.=pack('n*',1,3,272,650);
		$this->body.=pack('n*',2,1,272,650);
		$this->body.=pack('n*',3,1,272,650);
		$this->body.=pack('n*',21,1,272,650);
		$this->body.=pack('n*',4,1,272,650);
		$this->body.=pack('n*',6,1,272,650);
		$this->body.=pack('n*',9,1,272,650);
		$this->body.=pack('n*',10,1,272,650);
		$pack=$this->prepare();
		if ($this->method) $wr=socket_write($this->socket,$pack,strlen($pack)); else $wr=fwrite($this->socket,$pack);
		if (!$wr) {
			$this->error='Соединение закрыто';
			return false;
		}
		return true;
	}
	function connected() {
		if ($this->socket) return true; else return false;
	}
	function send($uin,$message) {
		$this->request_id++;
		$cookie=microtime();
		$this->body=pack('nnnNdnca*',4,6,0,$this->request_id,$cookie,2,strlen($uin),$uin);
		$capabilities=pack('H*','094613494C7F11D18222444553540000');
		$data=pack('nd',0,$cookie).$capabilities;
		$data.=pack('nnn',10,2,1);
		$data.=pack('nn', 15, 0);
		$data.=pack('nnvvddnVn',10001,strlen($message)+62,27,8,0,0,0,3,$this->request_id);
		$data.=pack('nndnn',14,$this->request_id,0,0,0);
		$data.=pack('ncvnva*',1,0,0,1,(strlen($message)+1),$message);
		$data.=pack('H*', '0000000000FFFFFF00');
		$this->body.=$this->setoption('RECONECT_HERE',$data);
		$this->body.=$this->setoption('CLIENT','');
		$pack=$this->prepare();
		if ($this->method) $wr=socket_write($this->socket,$pack,strlen($pack)); else $wr=fwrite($this->socket,$pack);
		if (!$wr) {
			$this->error='Не могу отправить сообщение, сервер закрыл соединение';
			return false;
		}
		if (!$this->makeinfo()) {
			$this->request_id++;
			$cookie=microtime();
			$this->body=pack('nnnNdnca*',4,6,0,$this->request_id,$cookie,1,strlen($uin),$uin);
			$data=pack('ccnc',5,1,1,1);
			$data.=pack('ccnnna*',1,1,strlen($message)+4,3,0,$message);
			$this->body.=$this->setoption('DATA', $data);
			$this->body.=$this->setoption('CLIENT','');
			$this->body.=$this->setoption('COOKIE','');
			$pack=$this->prepare();
			if ($this->method) $wr=socket_write($this->socket,$pack,strlen($pack)); else $wr=fwrite($this->socket,$pack);
			if (!$wr) {
				$this->error='Соединение закрыто';
				return false;
			}
			$this->makeinfo();
			return false;
		}
		return true;
	}
	function messages() {
		while($this->getpacket()) {
			$body=$this->body;
			if (strlen($body)) {
				$msg=unpack('nfamily/nsubtype/nflags/Nrequestid/N2msgid/nchannel/cnamesize',$body);
				if ($msg['family']==4&&$msg['subtype']==7) {
					$body=substr($body,21);
					$from=substr($body,0,$msg['namesize']);
					$channel=$msg['channel'];
					$body=substr($body,$msg['namesize']);
					$msg=unpack('nwarnlevel/nTLVnumber',$body);
					$body=substr($body,4);
					for ($i=0;$i<=$msg['TLVnumber'];$i++) {
						$arr=unpack('n2',substr($body,0,4));
						$this->type=$arr[1];
						$this->size=$arr[2];
						$part=substr($body,4,$this->size);
						$body=substr($body,4+$this->size);
						if ($channel==1&&$this->type==2) {
							while (strlen($part)) {
								$frg=unpack('cid/cversion/nsize',substr($part,0,4));
								$frg['data']=substr($part,4,$frg['size']);
								if ($frg['id']==1&&$frg['version']==1) {
									return array('from'=>$from,'text'=>substr($frg['data'],4));
								}
								$part=substr($part,4+$frg['size']);
							}
							$message=false;
						}
					}
				}
			} else $message=false;
		}
		return false;
	}
	function disconnect() {
		if ($this->method) socket_close($this->socket); else fclose($this->socket);
		$this->socket=false;
	}
	var $types=array('UIN'=>1,'DATA'=>2,'CLIENT'=>3,'ERROR_URL'=>4,'RECONECT_HERE'=>5,'COOKIE'=>6,'SNAC_VERSION'=>7,'ERROR_SUBCODE'=>8,'DISCONECT_REASON'=>9,'RECONECT_HOST'=>10,'URL'=>11,'DEBUG_DATA'=>12,'SERVICE'=>13,'CLIENT_COUNTRY'=>14,'CLIENT_LNG'=>15,'SCRIPT'=>16,'USER_EMAIL'=>17,'OLD_PASSWORD'=>18,'REG_STATUS'=>19,'DISTRIB_NUMBER'=>20,'PERSONAL_TEXT'=>21,'CLIENT_ID'=>22,'CLI_MAJOR_VER'=>23,'CLI_MINOR_VER'=>24,'CLI_LESSER_VER'=>25,'CLI_BUILD_NUMBER'=>26);
	var $socet,$channel,$sequence,$body,$uin,$type,$size,$error;
	function getpacket() {
		if ($this->method) {
			if($this->socket&&!socket_last_error($this->socket)) {
				$header=socket_read($this->socket, 6);
				if ($header) {
					$header=unpack('c2channel/n2size',$header);
					$this->channel=$header['channel2'];
					$this->body=socket_read($this->socket,$header['size2']);
					return true;
				} else return false;
			}
		} else {
			if($this->socket) {
				$header=fread($this->socket,6);
				if ($header) {
					$header=unpack('c2channel/n2size',$header);
					$this->channel=$header['channel2'];
					$this->body=fread($this->socket,$header['size2']);
					return true;
				} else return false;
			}
		}
	}
	function makeinfo() {
		$this->getpacket();
		$array=unpack('n3int/Nint',$this->body);
		while ($array['int']!=$this->request_id) {
			$this->getpacket();
			$array=unpack('n3int/Nint',$this->body);
		}
		$this->error='Неизвестный ответ сервера';
		if ($array['int1']==4) {
			switch ($array['int2']) {
				case 1:  $this->error='Error to sent message'; return false; break;
				case 12: return true; break;
			}
		}
		$this->error='Неизвестный ответ сервера';
		return false;
	}
	function setoption($type,$val,$len=false) {
		switch ($len) {
			case 1: $format='c'; break;
			case 2: $format='n'; break;
			case 4: $format='N'; break;
			default: $format='a*'; break;
		}
		if ($len===false) $len=strlen($val);
		return pack('nn'.$format,$this->types[$type],$len,$val);
	}
	function prepare() {
		$this->sequence++;
		$out=pack('ccnn',0x2A,$this->channel,$this->sequence,strlen($this->body)).$this->body;
		return $out;
	}

	function icq_send($uin_to, $message) {

		$this->sockets(true);

		if ($this->connect("486712226", "12345678")) {

			$this->send($uin_to, $message);

		}
	}
}

?>