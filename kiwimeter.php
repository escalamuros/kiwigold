<?php
	session_start();
	require_once 'clasekiwi.php';
	$c=new basededatos();
	$c->conexion();
	$ar=$c->lista_exportadores();
	$c->desconexion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<!-- <link href="css/formato.css" rel="stylesheet" type="text/css" /> -->
<script>
$(document).ready(function(){	
	$('#opex').bind('change',function(e) {
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findprod:$('select#opex').val()},
			success:function(re){ $('#fprod').html(re);$('#datos_2').hide();$('#add_data').hide();	}
		});
		$('#expo_prod').show();
	});
	$('#fprod').bind('change',function(e) {
		$('#flab').html('');
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findlab:$('select#fprod').val()},
			success:function(re){ $('#flab').html(re);$('#datos_2').hide();$('#add_data').hide(); }
		});
		$('#expo_um').show();
	});
	$('#flab').bind('change',function() {
		$.ajax({
			url:'para_laboratorio.php',
			type:'POST',
			data:{lista_f_anal:$('select#flab').val()},
			success:function(yy){$('#datos_2').html(yy);}
		});
		$('#datos_2').show();	
	});
	//al presionar una tecla, baja o sube en la linea de datos (laboratorio.php)
	$('.cuadrito').keydown(function(e)
	{
		if(e.keyCode==38)//flecha hacua arriba [UP]
		{
			var fo=this.id.substring(0,6);
			var fu=this.id.substring(6);
			if(fu!=1)
			{
				fu=parseInt(fu)-1;
				$('#'+fo+fu).focus();
			}
		}
		if(e.keyCode==40 || e.keyCode==13)//flecha hacia abajo[DOWN] o tecla [ENTER]
		{
			var fo=this.id.substring(0,6);
			var fu=this.id.substring(6);
			if(fu!=48)
			{
				fu=parseInt(fu)+1;
				$('#'+fo+fu).focus();
			}
		}
	});
	//si el campo al que se entra,tiene 0.... lo vacia 
	$('.cuadrito').focusin(function(e) {
		if($('#'+this.id).val()==0) { $('#'+this.id).val(''); }
	});
	//al presionar agregar, inserta los datos o actualiza 
	$('#masdatos').bind('click',function(){
		var existe = $('#existe_lab').val();

		if(existe==0){
			var ndatos= new FormData();
			ndatos.append('um',$('select#flab').val());
			ndatos.append('flab',$('#fanalisis').val());
			ndatos.append('fmue',$('#fmuestra').val());
			for(var aa=1;aa<=48;aa++)
			{
				ndatos.append('num[]',$('#nummer'+aa).html()+'/'+$('#l_peso'+aa).val()+'/'+$('#l_pre1'+aa).val()+'/'+$('#l_pre2'+aa).val()+'/'+$('#l_solu'+aa).val()+'/'+$('#l_col1'+aa).val()+'/'+$('#l_col2'+aa).val()+'/'+$('#l_pesi'+aa).val()+'/'+$('#l_pesf'+aa).val()+'/'+$('#l_obse'+aa).val());
			}
			$.ajax({
				url:'para_laboratorio.php',
				type:'POST',
				data: ndatos,
				processData: false,
				contentType: false, 
				success:function(qe){ $('#existe_lab').val(qe);alert ('Datos Ingresados con exito!'); }
			});
		}else{
			var datos= new FormData();
         datos.append('actualiza_lab',existe);
         datos.append('flab',$('#fanalisis').val());
         datos.append('fmue',$('#fmuestra').val());
			for(var aa=1;aa<=48;aa++)
			{
				datos.append('num[]',$('#nummer'+aa).html()+'/'+$('#l_peso'+aa).val()+'/'+$('#l_pre1'+aa).val()+'/'+$('#l_pre2'+aa).val()+'/'+$('#l_solu'+aa).val()+'/'+$('#l_col1'+aa).val()+'/'+$('#l_col2'+aa).val()+'/'+$('#l_pesi'+aa).val()+'/'+$('#l_pesf'+aa).val()+'/'+$('#l_obse'+aa).val());
			}
			$.ajax({
				url:'para_laboratorio.php',
				type:'POST',
				data: datos ,
				processData: false,
				contentType: false, 
				success:function(){ alert ('Datos Actualizados con exito!\n'); }
			});
		};		
	});
	
	$('#cambia_estado_lab').bind('click',function(){
		var existe = $('#existe_lab').val();
		if(existe == 0) 
		{
			alert('No Hay datos Guardados para Enviar');
		}
		else
		{
			$.ajax({
				url:'para_laboratorio.php',
				type:'POST',
				data:{lab_cam_est:existe,l_f_anal_nu:$('select#flab').val()},
				success:function(hh){$('datos_2').html(hh);}
			});
			$('#add_data').hide();
		}
	});	
});
</script>
</head>
<body>
	<?php if(isset($_SESSION['id'])){ ?>
	<div id="contenedor" style="color:#567;">
		<div id="titulo_lab"><img class='imgmenu' src='img/kiwimeter.png' />Registro Kiwimeter</div>
		<div class="men_i" style="height:160px">
			<div id="expo_lab" class="expo"><div class="etex">Concesionaria :</div>
				<select name="opexpo" id="opex"><option>Seleccione</option>
					<?php foreach($ar as $v) { echo "<option value='".$v[0]."'>".$v[1]."</option>";}	?>
				</select>
			</div>
			<div id="expo_prod" class="expo"><div class="etex">Productor :</div> <select name="prodexpo"id="fprod"></select></div>
			<div id="expo_um" class="expo"><div class="etex">Unidad de Maduración :</div> <select name="labexpo"id="flab"></select></div>
		</div>
		<div class="men_i" id="datos_2" style="height:160px">		
		</div>
		<div id="add_data" sy>
			<input type="hidden" id="existe_lab" value="0">
			<table style="width:400px;">
				<tr><td>Fecha Muestra</td>					<td><input type="date" id="fmuestra" /></td></tr>
				<tr><td>Nombre archivo Externo</td>		<td><input /></td></tr>
				<tr><td>Promedio Externo</td>				<td><input /></td></tr>
				<tr><td>Presión</td>							<td><input /></td></tr>
				<tr><td>Solidos solubles</td>				<td><input /></td></tr>
				<tr><td>Nombre archivo Interno</td>		<td><input /></td></tr>
				<tr><td>Promedio Interno</td>				<td><input /></td></tr>
				<tr><td>Indicaciones</td>					<td><input /></td></tr>
			</table>
			<div id="masdatos" class="adder">Guardar Datos</div>
			<br>
			<div id="cambia_estado_lab" class="adder">Entrega a Analisis de Datos</div>
		</div>
	</div>
	<?php
		}else{echo "<a href='index.php' style='color:black'>Session cerrada, Reingrese</a>";}
	?> 
</body>
</html>