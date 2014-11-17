<?php
//session_start();
include_once "clasekiwi.php";
$c=new basededatos();
$c->conexion();
if(isset($_SESSION['id']))
{
	if(isset($_SESSION['cuartel']))
	{
		
		$c_dt=$c->recuperar_cuartel($_SESSION['cuartel']);
		$lo=$c->resumen_registro_cuartel($_SESSION['temporada'],$_SESSION['cuartel']);
		echo "<html xmlns='http://www.w3.org/1999/xhtml'><head>";
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		echo "</head><body>";
		echo "<div style='width:600px;height:800px;'>";
		echo "<table>";
		echo "<tr><td>Nombre Cuartel</td>";
		echo "<td>Año</td>";
		echo "<td>Zona</td>";
		echo "<td>Dirección</td>";
		echo "<td>Geolocalización</td>";
		echo "<td>Nombre Encargado</td>";
		echo "<td>Fono Encargado</td>";
		echo "<td>EMail Encargado</td>";
		echo "<td>Superficie</td>";
		echo "<td>Numero de Plantas</td>";
		echo "<td>Distancia sobre hilera</td>";
		echo "<td>Distancia entre hileras</td>";
		echo "<td>Porcentaje de Machos</td>";
		echo "<td>Tipo Plantación</td>";
		echo "<td>Contrato</td>";
		echo "<td>Observación</td></tr>";
		echo "<tr><td>".$c_dt[3]."(".$c_dt[0].")</td>";
		echo "<td>".$c_dt[2]."</td>";
		echo "<td>".$c_dt[6]."</td>";
		echo "<td>".$c_dt[7]."</td>";
		echo "<td>".$c_dt[11]."</td>";
		echo "<td>".$c_dt[8]."</td>";
		echo "<td>".$c_dt[9]."</td>";
		echo "<td>".$c_dt[10]."</td>";
		echo "<td>".$c_dt[4]."</td>";
		echo "<td>".$c_dt[5]."</td>";
		echo "<td>".$c_dt[12]."</td>";
		echo "<td>".$c_dt[13]."</td>";
		echo "<td>".$c_dt[14]."</td>";
		echo "<td>".$c_dt[15]."</td>";
		echo "<td>".$c_dt[16]."</td>";
		echo "<td>".$c_dt[17]."</td></tr>";
		$l_p=$c->lista_plantas($_SESSION['cuartel']);
		if(is_array($l_p))
		{
			echo "<tr><td>Tipos de Plantas</td></tr>";
			echo "<tr>";foreach($l_p as $j) { echo "<td>".$j[0]."</td>"; }; echo "</tr>";
			echo "<tr>";foreach($l_p as $j) { echo "<td>".$j[1]."</td>"; }; echo "</tr>";
		}
		echo "<tr><td>Período de Eventos</td><td>de Mayo ".$_SESSION['temporada']." a Junio ".($_SESSION['temporada']+1)."</td></tr>";
		echo "<tr><td>Programa Fitosanitario</td></tr>";
		echo "<tr><td style='background:#abc;'>Cuartel</td><td style='background:#abc;'>Fecha</td><td style='background:#abc;'>Nombre Comercial</td><td style='background:#abc;'>Ingrediente Activo</td><td style='background:#abc;'>Carencia</td><td style='background:#abc;'>Observaciones</td><td style='background:#abc;'>Estado Fenológico</td></tr>";
		if(is_array($lo[0]))
		{
			foreach($lo[0] as $a)
			{
				echo "<tr><td>".$a[0]."</td><td>".$a[1]."</td><td>".$a[2]."</td><td>".$a[3]."</td><td>".$a[4]."</td><td>".$a[5]."</td><td>".$a[6]."</td></tr>";
			}
		}
		echo "<tr><td>Labores No Químicas</td></tr>";
		echo "<tr><td style='background:#abc;'>Cuartel</td><td style='background:#abc;'>Fecha</td><td style='background:#abc;'>Programa</td><td style='background:#abc;'>Aplicación</td><td style='background:#abc;'>Estado Fenológico</td></tr>";
		if(is_array($lo[1]))
		{
			foreach($lo[1] as $b)
			{
				echo "<tr><td>".$b[0]."</td><td>".$b[1]."</td><td>".$b[2]."</td><td>".$b[3]."</td><td>".$b[4]."</td></tr>";
			}
		}
		echo "<tr><td>Proyección</td></tr>";
		echo "<tr><td style='background:#abc;'>Cuartel</td><td style='background:#abc;'>Fecha</td><td style='background:#abc;'>Tonelada</td><td style='background:#abc;'>Calibre</td></tr>";
		if(is_array($lo[2]))
		{
			foreach($lo[2] as $c)
			{
				echo "<tr><td>".$c[0]."</td><td>".$c[1]."</td><td>".$c[2]."</td><td>".$c[3]."</td></tr>";
			}
		}
		echo "<tr><td>Producción</td></tr>";
		echo "<tr><td style='background:#abc;'>Cuartel</td><td style='background:#abc;'>Fecha</td><td style='background:#abc;'>Comercialisadora</td><td style='background:#abc;'>Tonelada</td><td style='background:#abc;'>Calibre</td></tr>";
		if(is_array($lo[3]))
		{
			foreach($lo[3] as $c)
			{
				echo "<tr><td>".$c[0]."</td><td>".$c[1]."</td><td>".$c[2]."</td><td>".$c[3]."</td><td>".$c[4]."</td></tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		echo "</body></html>";
	}
}
else{echo "<a href='login.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
$c->desconexion();
$_SESSION['temporada']=0;
$_SESSION['cuartel']=0;
?>