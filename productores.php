<?php session_start();include_once "clasekiwi.php";
$d=new basededatos();
$d->conexion();
$ar=$d->lista_exportadores();
$lis=$d->lista_prod_y_exp();
$d->desconexion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/formato.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
	$('#ventana').hide();
	$('#btn_add').bind('click',function(){
		$('#nue_prod').css('display','block');

	});
	$('#btn_guar').bind('click',function(){
		if (($('#rs').val()!='')&&($('#ne').val()!='')&&($('select#op_exportadora').val()!='0')) {
			$.ajax({
				url:'ingreso_productora.php',
				type:'POST',
				data: {expo:$('select#op_exportadora').val(),rs:$('#rs').val(),nombre:$('#ne').val(),rut:$('#rut').val(),giro:$('giro').val(),fono:$('#fono').val(),dir:$('#dir').val(),mail:$('#mail').val(),rl:$('#rl').val(),rutr:$('#rutr').val(),fonor:$('#fonor').val(),mailr:$('#mailr').val(),agro:$('#agro').val(),amail:$('#amail').val()},
				beforeSend:function(){
					$('#ventana').show();
					$('#ventana').html('Enviando datos al Servidor');
				},
				success:function(a){
					$('#ventana').hide();
					$('#nue_prod').hide();
					$('#list_prod').html(a);
					$('#rs').val('');
					$('#ne').val('');
					$('select#op_exportadora').val('0');
				}
			});
		}
		else{
			alert('Debe ingresar Razón Social y Nombre de Fantasía, ademas de la Concesionaria, para crear un nuevo productor');
		}
		
	});
	$('.prod').bind('click',function(){
		$('#btn_add').css('display','none');
		$.ajax({url:'productora_esp.php',
			type:'POST',
			data:{elegido:$(this).attr('id')},
			success:function(uk){$('#cont_productores').html(uk);}
		});
	});
});
</script>
</head>
<body>
<div id="ventana" style="position:absolute;z-index:100;margin 0 auto 0 auto;background-color:white;"></div>
<?php
if(isset($_SESSION['id']))
{
	if($_SESSION['nivel']=='1')
	{
		?>
		<div id="btn_add">+ Agregar Productor</div>
		<div id="cont_productores">
		<div id='list_prod'>
		<?php
		$a='0';
		foreach($lis as $p)
		{
			if($p[0]!=$a){$a=$p[0];echo "<div class='tit_expo'>Concesionaria ".$p[0]."</div>";}
			echo "<div class='prod' id='".$p[1]."'>".$p[2]."</div>";
		}
		?>
		</div>
		<div id="nue_prod">
		<table>
		<tr><td>Concesionaria</td><td>
		<select id="op_exportadora">
		<option value='0'>Seleccione</option>
		<?php
			foreach($ar as $v)
			{echo "<option value='".$v[0]."'>".$v[1]."</option>";}
		?>
		</select>
		</td></tr>
		<tr><td>Razón Social</td><td> <input type="text" id="rs"></td></tr>
		<tr><td>Nombre Fantasía</td><td> <input type="text" id="ne"></td></tr>
		<tr><td>Rut</td><td> <input type="text" id="rut"></td></tr>
		<tr><td>Giro</td><td><input type="text" id="giro"></td></tr>
		<tr><td>Dirección </td><td><input type="text" id="dir"></td></tr>
		<tr><td>Fono</td><td> <input type="text" id="fono"></td></tr>
		<tr><td>EMail</td><td> <input type="text" id="mail"></td></tr>
		<tr><td>Representante Legal</td><td> <input type="text" id="rl"></td></tr>
		<tr><td>Rut Representante Legal</td><td> <input type="text" id="rutr"></td></tr>
		<tr><td>Fono Representante Legal</td><td> <input type="text" id="fonor"></td></tr>
		<tr><td>EMail Representante Legal</td><td> <input type="text" id="mailr"></td></tr>
		<tr><td>Nombre Agronomo</td><td> <input type="text" id="agro"></td></tr>
		<tr><td>EMail Agronomo</td><td> <input type="text" id="amail"></td></tr>
		</table>
		<div id="btn_guar">Guardar</div>
		
		</div>
		<?php
	}
	else
	{
		 echo "	No tiene nivel de acceso a Productores<br>";
	}
}
else
{
	echo "<a href='index.php' style='color:black'>Sesión cerrada, Reingrese</a>";
}
?>
</body>
</html>