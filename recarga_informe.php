<?php
include_once "clasekiwi.php";
$c=new basededatos();
if(isset($_POST['tempo']))
{
	$c->conexion();
	$lo=$c->resumen_registro_cuartel($_POST['tempo'],$_POST['ccuartel']);
	$c->desconexion();
	echo "<br>Programa Fitosanitario<br>";
	echo "<div class='cuadro_informe' id='cuadro_fen'>";
	echo "<table>";
	echo "<tr><td style='background:#abc;'>Cuartel</td><td style='background:#abc;'>Fecha</td><td style='background:#abc;'>Nombre Comercial</td><td style='background:#abc;'>Ingrediente Activo</td><td style='background:#abc;'>Carencia</td><td style='background:#abc;'>Observaciones</td><td style='background:#abc;'>Estado Fenologico</td></tr>";
	if(is_array($lo[0]))
	{
		foreach($lo[0] as $a)
		{
			echo "<tr><td>".$a[0]."</td><td>".$a[1]."</td><td>".$a[2]."</td><td>".$a[3]."</td><td>".$a[4]."</td><td>".$a[5]."</td><td>".$a[6]."</td></tr>";
		}
	}
	echo "</table>";
	echo "</div>";
	echo "<br>Labores No Químicas<br>";
	echo "<div class='cuadro_informe' id='cuadro_labores'>";
	echo "<table>";
	echo "<tr><td style='background:#abc;'>Cuartel</td><td style='background:#abc;'>Fecha</td><td style='background:#abc;'>Programa</td><td style='background:#abc;'>Aplicación</td><td style='background:#abc;'>Estado Fenologico</td></tr>";
	if(is_array($lo[1]))
	{
		foreach($lo[1] as $b)
		{
			echo "<tr><td>".$b[0]."</td><td>".$b[1]."</td><td>".$b[2]."</td><td>".$b[3]."</td><td>".$b[4]."</td></tr>";
		}
	}
	echo "</table>";
	echo "</div>";
	echo "<br>Producción<br>";
	echo "<div class='cuadro_informe' id='cuadro_produccion'>";
	echo "<table>";
	echo "<tr><td style='background:#abc;'>Cuartel</td><td style='background:#abc;'>Fecha</td><td style='background:#abc;'>Comercializadora</td><td style='background:#abc;'>Tonelada</td><td style='background:#abc;'>Calibre</td></tr>";
	if(is_array($lo[2]))
	{
		foreach($lo[2] as $c)
		{
			echo "<tr><td>".$c[0]."</td><td>".$c[1]."</td><td>".$c[2]."</td><td>".$c[3]."</td><td>".$c[4]."</td></tr>";
		}
	}
	echo "</table>";
}
?>