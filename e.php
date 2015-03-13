<?php
//session_start();
include_once "clasekiwi.php";
$c=new basededatos();
$c->conexion();
//if(isset($_SESSION['id']))
//{
	$lista = $c->extraer_todos_productores();
	echo "<html xmlns='http://www.w3.org/1999/xhtml'><head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	echo "</head><body>";
	echo "<div style='width:600px;height:800px;'>";
	echo "<table>";
	echo "<tr><td>Cuarteles</td><td>". count($lista)."</dt></tr>";
	echo "<tr><td>Concesionaria</td>";
	echo "<td>Nombre</td>";
	echo "<td>Razón Social</td>";
	echo "<td>Rut</td>";
	echo "<td>Dirección Comercial</td>";
	echo "<td>Telefono empresa</td>";
		
	echo "<td>Reprecentante Legal</td>";
	echo "<td>Rut Reprecentante</td>";
	echo "<td>Numero de Contrato</td>";
	echo "<td>Año Cuartel</td>";
	echo "<td>Nombre Cuartel</td>";
	echo "<td>Direccion Cuartel</td>";
		
	echo "<td>Zona</td>";
	echo "<td>Nombre Encargado</td>";
	echo "<td>Telefono Encargado</td>";
	echo "<td>Geolocalización Cuartel</td>";
	echo "<td>Tipo Plantación</td>";
	echo "<td>Hectareas Plantación</td>";
		
	echo "<td>Total de Plantas</td>";		
	echo "<td>Distancia sobre hilera</td>";
	echo "<td>Distancia entre hileras</td>";
	foreach ($lista as $l)
	{
		echo "<tr><td>".$l[0]."</td>";
		echo "<td>".$l[1]."</td>";
		echo "<td>".$l[2]."</td>";
		echo "<td>".$l[3]."</td>";
		echo "<td>".$l[4]."</td>";
		echo "<td>".$l[5]."</td>";
		echo "<td>".$l[6]."</td>";
		echo "<td>".$l[7]."</td>";
		echo "<td>".$l[8]."</td>";
		echo "<td>".$l[9]."</td>";
		echo "<td>".$l[10]."</td>";
		echo "<td>".$l[11]."</td>";
		echo "<td>".$l[12]."</td>";
		echo "<td>".$l[13]."</td>";
		echo "<td>".$l[14]."</td>";
		echo "<td>".$l[15]."</td>";
		echo "<td>".$l[16]."</td>";
		echo "<td>".$l[17]."</td>";
		echo "<td>".$l[18]."</td>";
		echo "<td>".$l[19]."</td>";
		echo "<td>".$l[20]."</td></tr>";
	}
		
	echo "</table>";
	echo "</div>";
	echo "</body></html>";
//}
//else{echo "<a href='login.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
$c->desconexion();
?>