<?php require('makeSecure.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Perfil <?php echo $_SESSION['UserName']; ?></title>
</head>
<body>
<?php 
echo "<p style=style=\"color:#F00;\">Este es tu perfil ".$_SESSION['UserName']." ¿quieres 
<a href=\"logout.php\" style=\"color:black\">desconectarte</a>?</p>";
echo "cookie <br>";
echo $_COOKIE['user_login'];
?>
<p> O puedes ir al <a href="index.php">inicio</a></p>

 <?php
//echo "PRUEBA<br />";
//$conexion=mysql_connect("localhost", "root", "") or die("Unable to connect to MySQL");
//mysql_select_db("milibreria", $conexion) or die("Unable to select DB!");
//$user = mysql_query("SELECT * FROM user_tbl WHERE id='1' LIMIT 1",$conexion);
//$user = mysql_fetch_assoc($user);
//print_r($user);
//print_r($user[UserName]);
?>
</body>
</html>