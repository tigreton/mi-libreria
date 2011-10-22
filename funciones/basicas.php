<?php

	function conectar() {
	$dbhost =	"localhost";					
	$dbname =	"milibreria";								
	$dbuser =	"root";								
	$dbpassword =	"";	
	$conexion=mysql_connect($dbhost, $dbuser, $dbpassword) or die("Error");
	mysql_select_db($dbname, $conexion) or die("Error al seleccionar tabla");
	return $conexion;
	}
	
    function guardar_micro($inicio,$fin) {
		$inicio=explode(" ",$inicio);
		$fin =explode(" ", $fin);
        $seconds=$fin[1]-$inicio[1];
        $micros=$fin[0]-$inicio[0];
		$conexion=conectar();
		$microtime=$seconds+$micros;
		$uri=$_SERVER['REQUEST_URI'];
		$query_string=$_SERVER['QUERY_STRING'];
		$sql = "INSERT INTO microtime (microtime, pagina, query) VALUES ('$microtime', '$uri','$query_string')";
		mysql_query($sql, $conexion);	
		mysql_close($conexion);
    } 
	
	function guardar_visita($uri,$query,$usuario) {
		$conexion=conectar();
		$sql="INSERT INTO visitas (pagina, query, usuario) VALUES ('$uri', '$query', '$usuario')";
		mysql_query($sql,$conexion);	
		mysql_close($conexion);	
	}
	
?>