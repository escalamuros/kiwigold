<?php
	require('clasekiwi.php');
	$c=new basededatos();
	if(isset($_POST['um']))
	{
		$c->conexion();
		$c->registrar_fenologico($_POST['um'],$_POST['fecha'],$_POST['estado']);
		$ar=$c->lista_fenologico_actual_um($_POST['um'],date('Y'));
		$c->desconexion();
		echo "Ultimos eventos Fenológicos año ".date('Y');
		echo "<table>";
		echo "<tr><td>Fecha</td><td>Estado</td></tr>";
		foreach($ar as $p)
		{
			echo "<tr><td>".$p[0]."</td><td>".$p[1]."</td></tr>";
		}
		echo "</table>";
	}
?>