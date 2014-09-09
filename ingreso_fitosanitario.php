<?php
	require('clasekiwi.php');
	$c=new basededatos();
	$c->conexion();
	if((isset($_POST['cuar']))&&(isset($_POST['fecha'])))
	{
		$c->registrar_fitosanitario($_POST['cuar'],$_POST['fecha'],$_POST['ncom'],$_POST['iac'],$_POST['cad'],$_POST['obs'],$_POST['est_f']);
	}
	$ar=$c->lista_ultimos10_fito($_POST['cuar']);
	$c->desconexion();
	echo "Ultimos eventos fitosanitarios Registrados, por Fecha";
	echo "<table>";
	echo "<tr><td>Fecha</td><td>Nombre Comercial</td><td>Estado Fenologico</td></tr>";
	foreach($ar as $p)
	{
		echo "<tr><td>".$p[0]."</td><td>".$p[1]."</td><td>".$p[2]."</td></tr>";
	}
	echo "</table>";
?>