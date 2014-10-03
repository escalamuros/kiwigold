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
			$lnq=$c->lista_ultimos10_labores($_POST['um']);
			$lf=$c->lista_ultimos10_fito($_POST['um']);
			$c->desconexion();
			echo "<div style='float:left;'>";
			echo "<table class='datos_um' >";
			echo "<tr><td colspan='2'>Datos del Cuartel</td></tr>";
			echo "<tr><td>Nombre</td>                  <td>".$resp[3]."</td></tr>";
			echo "<tr><td>Año</td>                     <td>".$resp[2]."</td></tr>";
			echo "<tr><td>Superficie</td>              <td>".$resp[4]."</td></tr>";
			echo "<tr><td>Tipo de Plantación</td>      <td>".$resp[15]."</td></tr>";
			echo "<tr><td>Numero de Plantas</td>       <td>".$resp[5]."</td></tr>";
			echo "<tr><td>Distancia entre Hileras</td> <td>".$resp[12]."</td></tr>";
			echo "<tr><td>Distancia sobre Hilera</td>  <td>".$resp[13]."</td></tr>";
			echo "<tr><td>% Machos</td>                <td>".number_format($resp[14],2,',','.')."%</td></tr>";
			echo "<tr><td>Zona</td>                    <td>".$resp[6]."</td></tr>";
			echo "<tr><td>Dirección</td>               <td>".$resp[7]."</td></tr>";
			echo "<tr><td>Geolocalización</td>         <td class='bot_mapa_cuartel' id='".$resp[0]."'  ><img src='img/tierra.png' width='30'></td></tr>";
			echo "<tr><td>Nombre Encargado</td>        <td>".$resp[8]."</td></tr>";
			echo "<tr><td>Telefono Encargado</td>      <td>".$resp[9]."</td></tr>";
			echo "<tr><td>E Mail Encargado</td>        <td>".$resp[10]."</td></tr>";
			echo "</table>";
			echo "</div>";
			echo "<div style='float:left;margin-left:8px;'>";
			echo " Labores No Quimicas";
			echo "<table style='width:350px;'>";
			echo "<tr><td>Fecha</td><td>Programa</td><td>Estado Fenológico</td></tr>";
			foreach($lnq as $a)
			{
				echo "<tr><td>".$a[0]."</td><td>".$a[1]."</td><td>".$a[2]."</td></tr>";
			}
			echo "</table><br>";
			echo "Labores Fitosanitarias";
			echo "<table style='width:350px;'>";
			echo "<tr><td>Fecha</td><td>Nombre Comercial</td><td>Estado Fenológico</td></tr>";
			foreach($lf as $a)
			{
				echo "<tr><td>".$a[0]."</td><td>".$a[1]."</td><td>".$a[2]."</td></tr>";
			}
			echo "</table>";
			echo "</div>";	
		}
	}
}
else
{echo "<a href='login.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
?>
<script>
$('.bot_mapa_cuartel').bind('click',function(){
		window.open('gmap.php?cuartel='+$(this).attr('id'),'_blank');
	});
</script>
</body>
</html>
