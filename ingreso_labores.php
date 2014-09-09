<?php
	require('clasekiwi.php');
	$c=new basededatos();
	$c->conexion();
	if((isset($_POST['cuar']))&&(isset($_POST['fecha'])))
	{
		$c->registrar_labores($_POST['cuar'],$_POST['fecha'],$_POST['prog'],$_POST['metodo'],$_POST['ef']);
	}
	$ar=$c->lista_ultimos10_labores($_POST['cuar']);
	$c->desconexion();
	echo "Ultimas labores no quimicas Registrados, por Fecha";
	echo "<table>";
	echo "<tr><td>Fecha</td><td>Programa</td><td>Estado Fenologico</td></tr>";
	foreach($ar as $p)
	{
		echo "<tr><td>".$p[0]."</td><td>".$p[1]."</td><td>".$p[2]."</td></tr>";
	}
	echo "</table>";
?>