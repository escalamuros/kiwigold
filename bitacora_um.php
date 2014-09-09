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
			$resp=$c->recuperar_cuartel($_POST['um']);
			$c->desconexion();
			echo "<table class=datos_um style='float:left;'>";
			echo "<tr><td colspan='2'>Datos de la UM</td></tr>";
			echo "<tr><td>Nombre</td>               <td>".$resp[3]."</td></tr>";
			echo "<tr><td>Año</td>                  <td>".$resp[2]."</td></tr>";
			echo "<tr><td>Superficie</td>           <td>".$resp[4]."</td></tr>";
			echo "<tr><td>Numero de Plantas</td>    <td>".$resp[5]."</td></tr>";
			echo "<tr><td>Zona</td>                 <td>".$resp[6]."</td></tr>";
			echo "<tr><td>Dirección</td>            <td>".$resp[7]."</td></tr>";
			echo "<tr><td>Geolocalización</td>      <td>".$resp[11]."</td></tr>";
			echo "<tr><td>Nombre Encargado</td>     <td>".$resp[8]."</td></tr>";
			echo "<tr><td>Telefono Encargado</td>   <td>".$resp[9]."</td></tr>";
			echo "<tr><td>E Mail Encargado</td>     <td>".$resp[10]."</td></tr>";
			echo "</table>";
			echo "Listar Labores y Fito; Analisis de Laboratorios Aceptados"
			
		}
	}
}
else
{echo "<a href='index.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
?>
</body>
</html>
