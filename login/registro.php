<?php
require_once('LoginSystem.class.php');
if(isset($_POST['Submit']))
{

		$loginSystem = new LoginSystem();
		$_GET['msg'] = $loginSystem->register($_POST['Username'], $_POST['Password']);
	
}

/**
 *	Show error messages etc.
 */
function showMessage()
{
	if(is_numeric($_GET['msg']))
		{
			switch($_GET['msg'])
			{
				case 1: echo "<p align=\"center\">Rellena todos los campos.</p>";
				break;
				
				case 2: echo "<p align=\"center\">Usuario creado correctamente. Ahora puedes hacer <a href=\"login.php\">login</a></p>";
				break;
				
				case 3: echo "<p align=\"center\">Ya hay un usuario con ese nombre</p>";
				break;
				
			}
		}
}


$id_usuario=$_SESSION['id'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>Registro</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<div>
<?php 
 showMessage(); ?>
 <br />
 <?php echo $_SESSION['UserName'];?>
</div>
<form action="registro.php" method="post" name="addUserForm">
<input name="Username" type="text" value="Username" class="prefill example" size="30" maxlength="30" />
<br />
<input name="Password"  value="Password" class="prefill example" type="password" size="30" maxlength="30" />
<br />
<input name="Submit" type="submit" value="Registrarse" />
</form>
</body>
</html>
	
