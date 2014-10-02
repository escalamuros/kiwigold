<?php
session_start();
include_once "clasekiwi.php";
$c=new basededatos();
$c->conexion();
$ar=$c->lista_laboratorios_f();
$c->desconexion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script>
$(document).ready(function(){
	$('.labs').bind('click',function(){
		var oe=$(this).attr('id');
		$.ajax({
			url:'a.php',
			type:'POST',
			data:{lab:oe},
			success:function(oua){$('#cont_centro').html(oua);}
		});
	});
});
</script>
</head>
<body>
<?php
if(isset($_SESSION['id']))
{
	if(($_SESSION['nivel']=='1')||($_SESSION['nivel']=='2'))
	{?>
		<div id='lista_t_lab'>
			Lista de Laboratorios Autorizados.
			<table>
			<tr><td>Lab Numero</td><td>UM</td><td>Campo</td><td>Productor</td><td>Fecha de Lab</td><td>Fecha Muestreo</td><td>Estado</td></tr>
			<?php
			if(is_array($ar))
			{
				foreach($ar as $i)
				{
					echo "<tr><td><div class='btn_color labs' id='".$i[0]."'>".$i[0]."</div></td><td>".$i[1]."</td><td>".$i[2]."</td><td>".$i[3]."</td><td>".$i[4]."</td><td>".$i[5]."</td><td>";
					switch($i[6])
					{case 0: echo "Datos Incompletos";break;case 1: echo "Datos Completos";break;case 2: echo "Informe Enviado";break;}
					echo "</td></tr>";
				}
			}
			?>
			</table>
		</div>
	<?php 
	}
}
else{echo "<a href='login.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
?>
</body>
</html>