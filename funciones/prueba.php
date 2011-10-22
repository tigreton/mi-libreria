<?php
$inicio=microtime();
include "basicas.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
</body>
</html>
<?php 
for ($i = 1; $i <= 100000; $i++) {
}
guardar_micro($inicio,microtime());
$id_usuario=1;
$uri=$_SERVER['REQUEST_URI'];
$query=$_SERVER['QUERY_STRING'];
guardar_visita($uri, $query, $id_usuario);
?>