
#php-ami-class#
----------
A PHP class for Asterisk Manager Interface.

This class modified from [voip-info.org][1].

Functions
----------
**This class provide following functions**

 - `Login()`

 - `Logout()`
 
 - `Query($query)`
 
    - $query : Command string to query e.g. `Action: SIPpeers\r\n\r\n`

 - `Reload()`
 
 - `GetUsers()`
 
 - `AddUser($user,$type,$dir)`
 
    - $user : Username to create
    - $type : Account type (`webrtc` or `sip`)
    - $dir : Path to `users.conf`


 - `AddExtension($user,$dir)`
    
    - $user : Username to create
    - $dir : Path to `extensions.conf`


 - `GetError()`

Basic Usage
----------

    include 'php-ami-class';
    $conn = new AstMan;
	$conn -> amiHost = 'AMI_HOST_IP_HERE';
	$conn -> amiPort = 'AMI_PORT_HERE';
		//default port is '5038'.
	$conn -> amiUsername = 'AMI_USERNAME_HERE'; 
		//default username is 'admin'.
	$conn -> amiPassword = 'AMI_PASSWORD_HERE';
		//default password is 'admin.


Example
----------
**To reload Asterisk**

    include 'php-ami-class.php';

	$conn = new AstMan;
	$conn -> amiHost = '192.168.1.7';

	if ($conn -> Login()) {
		$conn -> Reload();
		$conn -> Logout();
		return true;
	}else{
		echo $conn -> getError();
	    return false;
	}

**To create user**

    include 'php-ami-class.php';

	$user = '5566';
	$type = 'webrtc';
	$user_dir = '../conf/users'; 
		//path to users.conf
	$ext_dir = '../conf/extensions'; 
		//path to extensions.conf

	$conn = new AstMan;
	$conn -> amiHost = '192.168.1.7';
	$conn -> AddUser($user,$type,$user_dir);
	$conn -> AddExtension($user,$ext_dir);
	$conn -> Login();
	$conn -> Reload();
		//don't forget to reload Asterisk after creating user.
	$conn -> Logout();
	return true;

License
----------

**GNU v2**
  [1]: http://www.voip-info.org/wiki/view/Asterisk+manager+Example:+PHP "voip-info.org"