<?php
	require('clasekiwi.php');
	$c=new basededatos();
	if(isset($_POST['prod']))
	{
		$c->conexion();
		$ar=$c->lista_ultimos10_prod($_POST['prod']);
		$c->desconexion();
		echo "Ultimas Producciones Registradas";
		echo "<table>";
		echo "<tr><td>Fecha</td><td>Toneladas</td><td>Calibre</td></tr>";
		foreach($ar as $p)
		{
			echo "<tr><td>".$p[0]."</td><td>".$p[1]."</td><td>".$p[2]."</td></tr>";
		}
		echo "</table>";
	}
?>