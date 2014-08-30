<?php
	require('clasekiwi.php');
	$c=new basededatos();
	$c->conexion();
	if((isset($_POST['um']))&&(isset($_POST['fecha'])))
	{
		$c->registrar_fitosanitario($_POST['um'],$_POST['fecha'],$_POST['prog'],$_POST['metodo'],$_POST['est_f']);
	}
	$ar=$c->lista_ultimos10_fito($_POST['um']);
	$c->desconexion();
	echo "Ultimos eventos fitosanitarios Registrados, por Fecha";
	echo "<table>";
	echo "<tr><td>Fecha</td><td>Programa</td><td>Estado Fenologico</td></tr>";
	foreach($ar as $p)
	{
		echo "<tr><td>".$p[0]."</td><td>".$p[1]."</td><td>".$p[2]."</td></tr>";
	}
	echo "</table>";
?>