<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
if(isset($_SESSION['id']))
{
	if($_SESSION['nivel']=='4')
	{
		if($_SESSION['empresa']==0){echo "No es productor, o no tiene asignada una productora";}
		else
		{
			include_once('clasekiwi.php');
			$c=new basededatos();
			$c->conexion();
			$resp=$c->datos_um($_POST['um']);
			echo "<table class=datos_um style='float:left;'>";
			echo "<tr><td colspan='2'>Datos de la UM</td></tr>";
			echo "<tr><td>Etiqueta</td>             <td>".$resp[0]."</td></tr>";
			echo "<tr><td>Ubicación</td>            <td>".$resp[1]."</td></tr>";
			echo "<tr><td>Superficie</td>           <td>".$resp[2]."</td></tr>";
			echo "<tr><td>Tipo</td>                 <td>".$resp[3]."</td></tr>";
			echo "<tr><td>Año Plantación</td>       <td>".$resp[4]."</td></tr>";
			echo "<tr><td>Numero de Machos</td>     <td>".$resp[5]."</td></tr>";
			echo "<tr><td>Numero de Hembras</td>    <td>".$resp[6]."</td></tr>";
			echo "<tr><td>Marco</td>                <td>".$resp[7]."</td></tr>";
			echo "<tr><td>Año Replante</td>         <td>".$resp[8]."</td></tr>";
			echo "<tr><td>Certificado Globalgap</td><td>".$resp[9]."</td></tr>";
			echo "<tr><td>Certificado KiwiGold</td> <td>".$resp[10]."</td></tr>";
			echo "</table>";
			$resp=$c->datos_ult_prod_um($_POST['um']);
			echo "<table class=datos_um style='float:left;'>";
			echo "<tr><td colspan='2'>Última Producción Ingresada</td></tr>";
			echo "<tr><td>Fecha</td>                 <td>".$resp[0]."</td></tr>";
			echo "<tr><td>Concesionaria</td>         <td>".$resp[1]."</td></tr>";
			echo "<tr><td>Toneladas por Hectarea</td><td>".$resp[2]."</td></tr>";
			echo "<tr><td>Calibre</td>               <td>".$resp[3]."</td></tr>";
			echo "</table>";
			$resp=$c->lista_fenologico_actual_um($_POST['um'],date('Y'));
			echo "<table class=datos_um style='float:left;'>";
			echo "<tr><td colspan='2'>Avance Fenologico año ". date('Y')."</td></tr>";
			echo "<tr><td>Fecha</td><td>Estado</td></tr>";
			foreach($resp as $r)
			{	echo "<tr><td>".$r[0]."</td><td>".$r[1]."</td></tr>";}

			echo "</table>";
			$ar=$c->lista_ultimos10_fito($_POST['um']);
			echo "<table>";
			echo "<tr><td colspan='3'>Ultimos 10 Eventos Fitosanitarios</td></tr>";
			echo "<tr><td>Fecha</td><td>Programa</td><td>Metodo</td></tr>";
			foreach($ar as $p)
			{
				echo "<tr><td>".$p[0]."</td><td>".$p[1]."</td><td>".$p[2]."</td></tr>";
			}
			echo "</table>";
			$c->desconexion();
		}
	}
}
else
{echo "<a href='index.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
?>
</body>
</html>
