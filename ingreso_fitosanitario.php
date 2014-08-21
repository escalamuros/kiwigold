<?php
	require('clasekiwi.php');
	$c=new basededatos();
	if(isset($_POST['um']))
	{
		$c->conexion();
		$c->registrar_fitosanitario($_POST['um'],$_POST['fecha'],$_POST['prog'],$_POST['metodo']);
		$ar=$c->lista_ultimos10_fito($_POST['um']);
		$c->desconexion();
		echo "Ultimos eventos fitosanitarios Registrados, por Fecha";
		echo "<table>";
		echo "<tr><td>Fecha</td><td>Programa</td><td>Metodo</td></tr>";
		foreach($ar as $p)
		{
			echo "<tr><td>".$p[0]."</td><td>".$p[1]."</td><td>".$p[2]."</td></tr>";
		}
		echo "</table>";
	}
?>