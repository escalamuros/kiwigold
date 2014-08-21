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
<style type="text/css">
#list_prod{float:left;width:450px;scroll:auto;height:470px;overflow: auto;}
#nue_prod{float:left;width:450px;height:470px;margin-left:40px;color:#345;overflow: auto;}
#btn_guar{color:white;background:#345;padding:5px;border-radius:5px;}
.tit_expo{background-color:#345;color:white;width:400px;font-size: 16px;text-align: center;}
.prod{ cursor:pointer;background-color:white;border:1px solid #345;color:#345;font-size: 13px;width:400px; }
</style>
<script>
$(document).ready(function(){
	$('#btn_guar').bind('click',function(){
		$.ajax({
			url:'ingreso_productora.php',
			type:'POST',
			data:{expo:$('select#opex').val(),rs:$('#rs').val(),nombre:$('#ne').val(),rut:$('#rut').val(),giro:$('giro').val(),fono:$('#fono').val(),dir:$('#dir').val(),mail:$('#mail').val(),rl:$('#rl').val(),rutr:$('#rutr').val(),fonor:$('#fonor').val(),mailr:$('#mailr').val(),enc:$('#enc').val(),rute:$('#rute').val(),fonoe:$('#fonoe').val(),maile:$('#maile').val()},
			success:function(a){$('#list_prod').html(a);}});
	});
	$('.prod').bind('click',function()
	{
		$.ajax({url:'productora_esp.php',
			type:'POST',
			data:{elegido:$(this).attr('id')},
			success:function(uk){$('#cont_productores').html(uk);}
		})
	});
});
</script>
</head>
<body>
<?php
if(isset($_SESSION['id']))
{
	if($_SESSION['nivel']=='1')
	{
		?>
		<div id="cont_productores">
		<div id='list_prod'>
		<?php
		$a='0';
		foreach($lis as $p)
		{
			if($p[0]!=$a){$a=$p[0];echo "<div class='tit_expo'>Exportadora ".$p[0]."</div>";}
			echo "<div class='prod' id='".$p[1]."'>".$p[2]."</div>";
		}
		?>
		</div>
		<div id="nue_prod">
		<table>
		<tr><td>Exportadora</td><td>
		<select name="opexpo" id="opex">
		<option>Seleccione</option>
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
		<tr><td>Mail</td><td> <input type="text" id="mail"></td></tr>
		<tr><td>Representante Legal</td><td> <input type="text" id="rl"></td></tr>
		<tr><td>Rut Representante Legal</td><td> <input type="text" id="rutr"></td></tr>
		<tr><td>Fono Representante Legal</td><td> <input type="text" id="fonor"></td></tr>
		<tr><td>Mail Representante Legal</td><td> <input type="text" id="mailr"></td></tr>
		<tr><td>Encargado</td><td> <input type="text" id="enc"></td></tr>
		<tr><td>Rut Encargado </td><td><input type="text" id="rute"></td></tr>
		<tr><td>Fono Encargado </td><td><input type="text" id="fonoe"></td></tr>
		<tr><td>Mail Encargado </td><td><input type="text" id="maile"></td></tr>
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
	echo "<a href='index.php' style='color:black'>Session cerrada, Reingrese</a>";
}
?>
</body>
</html>