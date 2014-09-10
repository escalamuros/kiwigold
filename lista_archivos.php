<?php
	require('clasekiwi.php');
	$c=new basededatos();
	if(isset($_POST['elegido']))
	{
		$c->conexion();
		$lum=$c->lista_archivos($_POST['elegido']);
		$c->desconexion();
		echo "<table>";
		foreach($lum as $v)	{
			echo "<tr><td><a href='bajar.php?arch=".$v[1],"' >". basename($v[1])."</a></td>";
			echo "<td>X</td></tr>";
		}
		echo "</table>";
	}
?>