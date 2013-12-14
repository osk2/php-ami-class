
#php-ami-class#
----------
A PHP class for Asterisk Manager Interface

This class modified from [voip-info.org][1].

Functions
----------
**This class provide following functions**

 - `Login($host,$username,$password)`

    - $host : Server's IP
    - $username : AMI account
    - $password : AMI password


 - `Logout()`
 
 - `Query($query)`
 
    - $query : Query string e.g. `Action: SIPpeers\r\n\r\n`


 - `Reload()`
 
 - `GetUsers()`
 
 - `AddUser($user,$type,$dir)`
 
    - $user : Username to add
    - $type : User type (`webrtc` or `sip`)
    - $dir : Path to `users.conf`


 - `AddExtension($user,$dir)`
    
    - $user : Username to add
    - $dir : Path to `extensions.conf`


 - `GetError()`

Usage
----------

    include 'php-ami-class';
    $conn = new AstMan;


Example
----------
**To reload Asterisk**

    include 'php-ami-class.php';
	$server_addr = '192.168.1.7';
	$conn = new AstMan;
	if ($conn -> Login($server_addr)) {
		$conn -> Reload();
		$conn -> Logout();
		return true;
	}else{
		echo $conn -> getError();
	    return false;
	}

**To add user**

    include 'class.php';
	$server_addr = '192.168.1.7';
	$user = '5566';
	$type = 'webrtc';
	$user_dir = '../conf/users'; //path to users.conf
	$ext_dir = '../conf/extensions'; //path to extensions.conf
	$conn = new AstMan;
	$conn -> AddUser($user,$type,$user_dir);
	$conn -> AddExtension($user,$ext_dir);
	$conn -> Login($server_addr);
	$conn -> Reload(); //don't forget to reload Asterisk
	$conn -> Logout();
	$status = array("result" => "ok");
	echo json_encode($status);

License
----------

**GNU v2**
  [1]: http://www.voip-info.org/wiki/view/Asterisk+manager+Example:+PHP "voip-info.org"