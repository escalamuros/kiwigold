<?php
	require_once 'clasekiwi.php';
	$c=new basededatos();
	$c->conexion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php 
	if((isset($_POST['cuar']))&&(isset($_POST['fech'])))
	{
		$c->ingresa_produccion($_POST['cuar'],$_POST['fech'],$_POST['com'],$_POST['ton'],$_POST['cal']);
	}
	$ar=$c->lista_ultimos10_prod($_POST['cuar']);
	$c->desconexion();
	echo "Últimas Producciones Registradas";
	echo "<table>";
	echo "<tr><td>Fecha</td><td>Toneladas</td><td>Calibre</td></tr>";
	foreach($ar as $p)
	{
		echo "<tr><td>".$p[1]."</td><td>".$p[2]."</td><td>".$p[3]."</td></tr>";
	}
	echo "</table>";
?>
</body>
</html>