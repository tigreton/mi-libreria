<?php

/**
 * LoginSystem
 * 
 * Simple Login system with sessions and MySQL User DB
 * 
 * @version		1.0
 * @author 		A.Surrey	(www.surneo.com)
 * 
 * 
 */
error_reporting(E_ALL & ~E_NOTICE);  
class LoginSystem
{
	var	$db_host,
		$db_name,
		$db_user,
		$db_password,
		$connection,
		$username,
		$recordarme,
		$password;
		

	/**
	 * Constructor
	 */
	function LoginSystem()
	{
		require_once('settings.php');
		
		$this->db_host = $dbhost;
		$this->db_name = $dbname;
		$this->db_user = $dbuser;
		$this->db_password = $dbpassword;
	}
	
	/**
	 * Check if the user is logged in
	 * 
	 * @return true or false
	 */
	function isLoggedIn()
	{
		if($_SESSION['LoggedIn'])
		{
			return true;
		}
		else return false;
	}
	
	
	function register($username, $password)
	{
		$this->connect();
		
		$this->username = $this->clean($username);
		$this->password = md5($password);
		
		
		//$pw = md5($this->clean($this->password));
		//$username = $this->clean($this->Username);
		if((!$this->username) || (!$this->password)){
			$msg = 1;
			return $msg;
		}
		
		
		$sql = "SELECT * FROM user_tbl WHERE UserName = '$this->username'";
		$result = mysql_query($sql, $this->connection);
		$row = mysql_fetch_assoc($result);
	
		if  ($row['UserName'] == "") {
			$sql = "INSERT INTO user_tbl (UserName, Password) VALUES ('$this->username', '$this->password')";
			mysql_query($sql, $this->connection);
			$this->disconnect();
			$this->doLogin($username,$password,"1");
			$msg = 2;
			return $msg;
		}else{
			$msg = 3;
			return $msg;
			}
		
	}
	
	/**
	 * Check username and password against DB
	 *
	 * @return true/false
	 */
	function doLogin($username, $password, $recordarme)
	{
		$this->connect();
		
		$this->username = $username;
		$this->password = $password;
		$this->recordarme = $recordarme;
		
		//codigo nuevo
		 if ($_COOKIE['user_login'] != "") {
			 
			$user = $this->checkUserCookie($_COOKIE['user_login']); 
		 } else {
			
				
		// check db for user and pass here.
		$sql = sprintf("SELECT * FROM user_tbl WHERE UserName = '%s' and Password = '%s'", 
											$this->clean($this->username), md5($this->clean($this->password)));
						
		$result = mysql_query($sql, $this->connection);
		
		// If no user/password combo exists return false
		if(mysql_affected_rows($this->connection) != 1)
		{
			$this->disconnect();
			return false;
		}
		else // matching login ok
		{
			$row = mysql_fetch_assoc($result);
			
					// more secure to regenerate a new id.
					session_regenerate_id();
					
					//set session vars up
					$_SESSION['LoggedIn'] = true;
					$_SESSION['UserName'] = $this->username;
					$_SESSION['id'] = $row['id'];
                    if ($this->recordarme == 1)
                    {
     setcookie("user_login", $row['id'] ."-".md5($row['id'].$row['UserName'].$row['Password']), time() + 604800);
                    } 
			
			
			
		}}
		
		$this->disconnect();
		return true;
	}
	
	
	
	
	/**
	 * Se usa en makesecure, si tiene cookie guardada
	 * la comprueba, si es correcta lo logea.
	 */
	function loginUserCookie($cookie)
        {
			$this->connect();
            if ($_SESSION['LoggedIn'] != true)
            {
                $tmp = explode("-",$cookie);
                if ($tmp[0] != "")
                {			
					$user = mysql_query("SELECT * FROM user_tbl WHERE id='{$tmp[0]}' LIMIT 1",$this->connection);
					$user = mysql_fetch_assoc($user);
					$cadena_control = md5($user['id'].$user['UserName'].$user['Password']);
                    if ($cadena_control != $tmp[1])
                    {
                        @setcookie("user_login","");
                    }else{
                       	$_SESSION['LoggedIn'] = true;
						$_SESSION['UserName'] = $user['UserName'];
						$_SESSION['id'] = $user['id'];
						//$_SESSION['user'] = $user['UserName'];
                    }
                }else{
                    @setcookie("user_login","");
                }
            }
			$this->disconnect();
        }
	
	/**
	 * Destroy session data/Logout.
	 */
	function logout()
	{
		unset($_SESSION['LoggedIn']);
		unset($_SESSION['UserName']);
		unset($_SESSION['id']);
		setcookie("user_login","");
		session_destroy();
		
	}
	
	/**
	 * Connect to the Database
	 * 
	 * @return true/false
	 */
	function connect()
	{
		$this->connection = mysql_connect($this->db_host, $this->db_user, $this->db_password) 
														or die("Unable to connect to MySQL");
		
		mysql_select_db($this->db_name, $this->connection) or die("Unable to select DB!");
		
		// Valid connection object? everything ok?
		if($this->connection)
		{
			return true;
		}
		else return false;
	}
	
	/**
	 * Disconnect from the db
	 */
	function disconnect()
	{
		mysql_close($this->connection);
	}
	
	/**
	 * Cleans a string for input into a MySQL Database.
	 * Gets rid of unwanted characters/SQL injection etc.
	 * 
	 * @return string
	 */
	function clean($str)
	{
		// Only remove slashes if it's already been slashed by PHP
		if(get_magic_quotes_gpc())
		{
			$str = stripslashes($str);
		}
		// Let MySQL remove nasty characters.
		$str = mysql_real_escape_string($str);
		
		return $str;
	}
	
	/**
	 * create a random password
	 * 
	 * @param	int $length - length of the returned password
	 * @return	string - password
	 *
	 */
	function randomPassword($length = 8)
	{
		$pass = "";
		
		// possible password chars.
		$chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J",
			   "k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T",
			   "u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
			   
		for($i=0 ; $i < $length ; $i++)
		{
			$pass .= $chars[mt_rand(0, count($chars) -1)];
		}
		
		return $pass;
	}
	
	 /**
	  * Comprueba la cookie para dologin(),
	  * la limpia si no coincide.
	  */
	
	    function checkUserCookie($cookie)
        {
			$this->connect();
            $tmp = explode("-",$cookie);
            if ($tmp[0] != "")
            {
	            $user = mysql_query("SELECT * FROM user_tbl WHERE id='{$tmp[0]}' LIMIT 1",$this->connection);
				$user = mysql_fetch_assoc($user);
                $cadena_control = md5($user['id'].$user['UserName'].$user['Password']);
                if ($cadena_control != $tmp[1])
                {
                    setcookie("user_login","");
                    $user=array();
                }
            }else{
                $user=array();
                setcookie("user_login","");
            }
            return $user;
			$this->disconnect();
        }

}

?>