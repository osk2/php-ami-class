
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

    - $query : Command string to query. e.g. `Action: SIPpeers\r\n\r\n`


 - `Reload()`
 
 - `GetUsers()`
 
 - `AddUser($user, $type, $dir)`
 
    - $user : Username to create

    - $type : User type (`webrtc` or `sip`)

    - $dir : Path to `users.conf`


 - `AddExtension($user, $dir)`
    
    - $user : Username to create
    - $dir : Path to `extensions.conf`


 - `GetError()`

Basic Usage
----------

    include 'php-ami-class';
    $conn = new AstMan;
	$conn -> amiHost = 'AMI_HOST_IP_HERE';
	$conn -> amiPort = 'AMI_PORT_HERE';
	$conn -> amiUsername = 'AMI_USERNAME_HERE'; 
	$conn -> amiPassword = 'AMI_PASSWORD_HERE';
	//and do something else


Example
----------
**To reload Asterisk**

    include 'php-ami-class.php';

	$conn = new AstMan;
	$conn -> amiHost = '192.168.1.7';
	$conn -> amiPort = '5038';
	$conn -> amiUsername = 'admin';
	$conn -> amiPassword = 'admin';

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
	$user_dir = './conf/users';
		//path to users.conf
	$ext_dir = './conf/extensions';
		//path to extensions.conf
	$conn = new AstMan;
	$conn -> amiHost = '192.168.1.7';
	$conn -> Login();
	$conn -> AddUser($user,$type, $user_dir);
	$conn -> AddExtension($user, $ext_dir);
	$conn -> Reload();
		//don't forget to reload Asterisk after creating user.
	$conn -> Logout();

License
----------

This software is licensed under GNU v2.

Please read LICENSE for information.


  [1]: http://www.voip-info.org/wiki/view/Asterisk+manager+Example:+PHP "voip-info.org"