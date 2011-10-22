<?php 
session_start(); 
require_once('LoginSystem.class.php');
	
if(isset($_POST['Username']))
	{
		if((!$_POST['Username']) || (!$_POST['Password']))
		{
			// display error message
			//print_R($_POST);
			header('location: login.php?msg=1');// show error
			exit;
		}
		
$loginSystem = new LoginSystem();
if($loginSystem->doLogin($_POST['Username'],$_POST['Password'],$_POST['recordarme']))
	{
		
		 //Redirect here to your secure page
		
		header('location: perfil.php');
	}
		else
		{
			//print_R($_POST);
			header('location: login.php?msg=2');
			exit;
		}
	}
	
	
	 //show Error messages

	function showMessage()
	{
		if(is_numeric($_GET['msg']))
		{
			switch($_GET['msg'])
			{
				case 1: echo "Rellene los dos campos.";
				break;
				
				case 2: echo "Datos de acceso incorrectos.";
				break;
			}
		}
	}

$id_usuario=$_SESSION['id'];
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
Tu cookie es:
<?php echo $_COOKIE['user_login']; ?>
<?php  
$loginSys = new LoginSystem();
if(!$loginSys->isLoggedIn())

	{
		?>
		     
             <div><a href="registro.php">Registrate</a></div>
             <div><?php showMessage();?></div>
             <form action="login.php" method="post">
			<input value="Usuario" name="Username" title="Usuario" type="text"/><br /><br />
            <input value="password" name="Password" title="Password" type="password"/><br />
            <label><input name="recordarme" type="checkbox" value="1" />Recordarme</label>
            <input name="Submit" type="submit" value="Login" />
            </form>
            
            <?php } else { ?>
             
<?php 
echo "<p style=style=\"color:#F00;\">Hola ".$_SESSION['userName']." ¿quieres 
 ver tu <a href=\"perfil.php\" style=\"color:black\">perfil</a>?</p>";
 //echo $_COOKIE['user_login'];
 
 }?>  

 
 
 
 
</body>
</html>
