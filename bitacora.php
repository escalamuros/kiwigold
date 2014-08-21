<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css">
#tb_datos_leg {float:left; width: 300px;color:#456;colapse:colapse;}
#arch_prod{float:left;width: 300px;color:#456;}
#datos_um{float:left;width: 300px;color:#456;}
.bit_um{background-color: #456;color:white;padding: 4px;text-align: center; margin-top:4px; border-radius:5px;}
</style>
<script>
$(document).ready(function(){
	$('.bit_um').bind('click',function(){
		var opcion=$(this).attr('id');
		$.ajax({url:'bitacora_um.php',type:'post',data:{um:opcion},success:function(e){$('#cont_centro').html(e);}});	
	});
});
</script>
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
			$resp=$c->datos_legales_productor($_SESSION['empresa']);
			echo "<table id='tb_datos_leg'>";
			echo "<tr><td colpsan='2'>Datos Legales</td></tr>";
			echo "<tr><td>Razón Social</td>       <td>".$resp[0]."</td></tr>";
			echo "<tr><td>Rut</td>                <td>".$resp[1]."</td></tr>";
			echo "<tr><td>Giro</td>               <td>".$resp[2]."</td></tr>";
			echo "<tr><td>Dirección</td>          <td>".$resp[3]."</td></tr>";
			echo "<tr><td>Fono</td>               <td>".$resp[4]."</td></tr>";
			echo "<tr><td>Mail</td>               <td>".$resp[5]."</td></tr>";
			echo "<tr><td>Reprecentante Legal</td><td>".$resp[6]."</td></tr>";
			echo "<tr><td>Rut</td>                <td>".$resp[7]."</td></tr>";
			echo "<tr><td>Fono</td>               <td>".$resp[8]."</td></tr>";
			echo "<tr><td>Mail</td>               <td>".$resp[9]."</td></tr>";
			echo "<tr><td>Encargado</td>          <td>".$resp[10]."</td></tr>";
			echo "<tr><td>Rut</td>                <td>".$resp[11]."</td></tr>";
			echo "<tr><td>Fono</td>               <td>".$resp[12]."</td></tr>";
			echo "<tr><td>Mail</td>               <td>".$resp[13]."</td></tr>";
			echo "</table>";
			$resp=$c->lista_um_productor($_SESSION['empresa']);
			echo "<div id='arch_prod'>";
			echo "Archivos Adjuntos Productor:";
			echo "<div id='lis_arch'></div>";
			echo "</div>";
			echo "<div id='datos_um'>";
			echo "Unidades de Madurez :<br>";
			foreach($resp as $v)
			{echo "<div class='bit_um' id='".$v[0]."'>".$v[1]."</div>";}
			echo "</div>";
			$c->desconexion();
		}
	}
}
else
{echo "<a href='index.php' style='color:black'>Session cerrada, Reingrese</a>";}
?>
</body>
</html>
