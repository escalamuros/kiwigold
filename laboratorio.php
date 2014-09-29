<?php
	session_start();
	require_once 'clasekiwi.php';
	$c=new basededatos();
	$c->conexion();
	$ar=$c->lista_exportadores();
	$c->desconexion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="css/formato.css" rel="stylesheet" type="text/css" />
<!-- <script src="js/jquery.js"></script> -->
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
		<div id="titulo_lab">Registro Análisis de Control de Madurez Jintao</div>
		<div class="men_i" style="height:160px">
			<div id="expo_lab" class="expo"><div class="etex">Consecionaria :</div>
				<select name="opexpo" id="opex"><option>Seleccione</option>
					<?php foreach($ar as $v) { echo "<option value='".$v[0]."'>".$v[1]."</option>";}	?>
				</select>
			</div>
			<div id="expo_prod" class="expo"><div class="etex">Productor :</div> <select name="prodexpo"id="fprod"></select></div>
			<div id="expo_um" class="expo"><div class="etex">Unidad de Maduración :</div> <select name="labexpo"id="flab"></select></div>
		</div>
		<div class="men_i" id="datos_2" style="height:160px">		
		</div>
		<div id="add_data">
			<input type="hidden" id="existe_lab" value="0">
			Fecha Analisis: <input type="date" id="fanalisis" />
			Fecha Muestreo : <input type="date" id="fmuestra" /><br>
			<table>
				<tr><td >Nº</td><td >Peso(g)</td><td >Presion 1(lbs)</td><td >Presion 2(lbs)</td>
				<!-- <td >Promedio Presion 1-2</td> -->
				<td>SS (ºbrix)</td><td>Color 1(ºH)</td><td>Color 2(ºH)</td>
				<!-- <td>Promedio Color 1-2</td> -->
				<td>Peso Neto inicial(g)</td><td>Peso Neto final(g)</td>
				<!-- <td>Mat Seca</td> -->
				<td>Observaciones</td></tr>
				<?php
					for($a=1;$a<=48;$a++){
					echo '<tr><td><div id="nummer'.$a.'">'.$a.'</div></td>';
					echo '<td><input type="text" id="l_peso'.$a.'" size="3" class="cuadrito" /></td>';
					echo '<td><input type="text" id="l_pre1'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><input type="text" id="l_pre2'.$a.'" class="cuadrito" size="3"/></td>';
					//echo '<td><div id="p_pres'.$a.'" class="es_1"></div></td>';
					echo '<td><input type="text" id="l_solu'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><input type="text" id="l_col1'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><input type="text" id="l_col2'.$a.'" class="cuadrito" size="3"/></td>';
					//echo '<td><div id="p_colo'.$a.'" class="es_1"></div></td>';
					echo '<td><input type="text" id="l_pesi'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><input type="text" id="l_pesf'.$a.'" class="cuadrito" size="3"/></td>';
					//echo '<td><div id="m_seca'.$a.'" class="es_1"></div></td>';
					echo '<td><input type="text" id="l_obse'.$a.'" class="cuadrito" size="28"/></td></tr>';	
					}	
				?>
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