<?php 
class AstMan {

	var $socket;
	var $error;
	
	function AstMan() {
		$this -> socket = FALSE;
		$this -> error = "";
	} 

	function Login($host, $username="admin", $password="admin") {
		
		$this -> socket = @fsockopen($host,"5038", $errno, $errstr, 1); 
		if (!$this -> socket) {
			$this -> error =  "Could not connect - $errstr ($errno)";
			return FALSE;
		}else{
			stream_set_timeout($this -> socket, 1); 
			$wrets = $this -> Query("Action: Login\r\nUserName: $username\r\nSecret: $password\r\nEvents: off\r\n\r\n"); 
			if (strpos($wrets, "Message: Authentication accepted") != FALSE) {
				return true;
			}else{
				$this -> error = "Could not login - Authentication failed";
				fclose($this -> socket); 
				$this -> socket = FALSE;
				return FALSE;
			}
		}
	}
	
	function Logout() {
		if ($this -> socket) {
			fputs($this -> socket, "Action: Logoff\r\n\r\n"); 
			while (!feof($this -> socket)) { 
				$wrets .= fread($this -> socket, 8192); 
			} 
			fclose($this -> socket); 
			$this -> socket = "FALSE";
		}
		return; 
	}
	
	function Query($query) {
		$wrets = "";
		if ($this -> socket === FALSE) {
			return FALSE;
		}	
		fputs($this -> socket, $query); 
		do {
			$line = fgets($this -> socket, 4096);
			$wrets .= '<br>'.$line;
			$info = stream_get_meta_data($this -> socket);
		} while ($line != "\r\n" && $info['timed_out'] == false );
		return $wrets;
	}

	function Reload() {
		$query = "Action: Command\r\nCommand: Reload\r\n\r\n";
		$wrets = "";
		
		if ($this -> socket === FALSE) {
			return FALSE;
		}
			
		fputs($this -> socket, $query); 
		do
		{
			$line = fgets($this -> socket, 4096);
			$wrets .= $line;
			$info = stream_get_meta_data($this -> socket);
		}while ($line != "\r\n" && $info['timed_out'] == false );
		return $wrets;
	}

	function GetUsers() {
		$query = "Action: SIPpeers\r\n\r\n";
		$wrets = "";
		
		if ($this -> socket === FALSE) {
			return FALSE;
		}
			
		fputs($this -> socket, $query); 
		do
		{
			$line = fgets($this -> socket, 4096);
			$wrets .= $line;
			$info = stream_get_meta_data($this -> socket);
		} while ($line != "Event: PeerlistComplete\r\n" && $info['timed_out'] == false );
		return $wrets;
	}

	function AddUser($user,$type,$dir) {
		if ($user && $type && $dir) {
			$file = fopen($dir, 'a+');
			switch ($type) {
				case 'webrtc':
					$str = "[".$user."]\n type=peer\n username=".$user."\n host=dynamic\n secret=".$user."\n context=default\n hasiax = no\n hassip = yes\n encryption = yes\n avpf = yes\n icesupport = yes\n videosupport=no\n directmedia=no\n nat=yes\n qualify=yes\n\n";
					break;
				case 'sip':
					$str = "[".$user."]\n type=peer\n username=".$user."\n host=dynamic\n secret=".$user."\n context=default\n hasiax = no\n hassip = yes\n nat=yes\n\n";
					break;
			}
			fwrite($file, $str);
			fclose($file);
			return true;
		}else{
			$this -> error = "One or more parameters are missing.";
			return false;
		}
	}

	function AddExtension($user,$dir) {
		if ($user && $dir) {
			$file = fopen($dir, 'a+');
			$str = "exten => ".$user.",1,Dial(SIP/".$user.")\n";
			fwrite($file, $str);
			fclose($file);
			return true;
		}else{
			$this -> error = "One or more parameters are missing.";
			return false;
		}
	}
	
	function GetError() {
		return $this -> error;
	}
}
?> 