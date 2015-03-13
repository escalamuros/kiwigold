<?php
	session_start();
	require_once 'clasekiwi.php';
	$c=new basededatos();
	$c->conexion();
	$ar=$c->lista_todo_laboratorio();
	$c->desconexion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="css/formato.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
	$('#man_datos').hide();
	$('.datos').hide();
	function completarCampos(per)
	{
		var sum_p=0;
		var sum_pre_1=0;
		var sum_pre_2=0;
		var sum_brix=0;
		var sum_col_1=0;
		var sum_col_2=0;
		var sum_peso_i=0;
		var sum_peso_f=0;
		for(var de=0;de<=47;de++)
		{
			$('#l_peso'+(de+1)).val(per[de][1]);if(per[de][1]>0){sum_p=sum_p+1;}
			$('#l_pre1'+(de+1)).val(per[de][2]);if(per[de][2]>0){sum_pre_1=sum_pre_1+1;}
			$('#l_pre2'+(de+1)).val(per[de][3]);if(per[de][3]>0){sum_pre_2=sum_pre_2+1;}
			$('#l_solu'+(de+1)).val(per[de][4]);if(per[de][4]>0){sum_brix=sum_brix+1;}
			$('#l_col1'+(de+1)).val(per[de][5]);if(per[de][5]>0){sum_col_1=sum_col_1+1;}
			$('#l_col2'+(de+1)).val(per[de][6]);if(per[de][6]>0){sum_col_2=sum_col_2+1;}
			$('#l_pesi'+(de+1)).val(per[de][7]);if(per[de][7]>0){sum_peso_i=sum_peso_i+1;}
			$('#l_pesf'+(de+1)).val(per[de][8]);if(per[de][8]>0){sum_peso_f=sum_peso_f+1;}
		}
		$('#t_pesos').html(sum_p);
		$('#t_pre_1').html(sum_pre_1);
		$('#t_pre_2').html(sum_pre_2);
		$('#t_brix').html(sum_brix);
		$('#t_col_1').html(sum_col_1);
		$('#t_col_2').html(sum_col_2);
		$('#t_peso_1').html(sum_peso_i);
		$('#t_peso_2').html(sum_peso_f);
	}
	function Carga_presiones(dt)
	{
		for(var m=0;m<=47;m++)
		{
			$('#l_pre1'+(m+1)).val(dt[m][0]);
			$('#l_pre2'+(m+1)).val(dt[m][1]);
		}
	}
	function Carga_colores(dt)
	{
		for(var m=0;m<=47;m++)
		{
			$('#l_col1'+(m+1)).val(dt[m][0]);
			$('#l_col2'+(m+1)).val(dt[m][1]);
		}
	}
	// al pinchar en un laboratorio, llena los campos para despliegue
	$('.labs').bind('click',function(){
		var oe=$(this).attr('id');
		$('#Info_nro_lab').html('Ingreso de datos Laboratorio Numero: '+oe);
		$('#existe_lab').val(oe);
		$.ajax({
				url:'recibeajax.php',
				type:'POST',
				data:{lab_seleccionado:oe},
				dataType:"json",
				success:function(te){
												completarCampos(te);
												for(var de=1;de<=48;de++){calcular(de);}
												desviaciones();
				}
		});
		$('#man_datos').show();
		$('#lista_labs').hide();
	});
	//al pinchar en un tipo de medicion, muestra los datos, y permite modificar, para guardar; oooo, subir archivos scv
	$('.acc').bind('click',function(){
		var este='#tabla_'+$(this).attr('id');
		$('.datos').hide();
		$(este).show();
	});
	//al cambiar un campo con valores, calcula 
	$('.cuadrito').keydown(function(e)
	{
		if(e.keyCode==38)//flecha hacia arriba [UP]
		{
			var fo=this.id.substring(0,6);
			var fu=this.id.substring(6);
			if(fu!=1)
			{	fu=parseInt(fu)-1;$('#'+fo+fu).focus();}
		}
		if(e.keyCode==40 || e.keyCode==13)//flecha hacia abajo[DOWN] o tecla [ENTER]
		{
			var fo=this.id.substring(0,6);
			var fu=this.id.substring(6);
			if(fu!=48)
			{	fu=parseInt(fu)+1;	$('#'+fo+fu).focus();}
		}
		for(var de=1;de<=48;de++){calcular(de);}
		desviaciones();
	});
	//al seleccionar un cuadro con 0, limpia el contenido 
	$('.cuadrito').focusin(function(e) {
		if($('#'+this.id).val()==0) { $('#'+this.id).val(''); }
	});
	function calcular(fu)
	{
		var p1=$('#l_pre1'+fu).val();
		var p2=$('#l_pre2'+fu).val();
		var p3=$('#l_col1'+fu).val();
		var p4=$('#l_col2'+fu).val();
		var p5=$('#l_pesi'+fu).val();
		var p6=$('#l_pesf'+fu).val();
		if(p1!='' && p2!='')
		{
			var total=((parseFloat(p1)+parseFloat(p2))/2).toFixed(1);
			$('#p_pres'+fu).html(total);
		}
		else{$('#p_pres'+fu).html('');}
		if(p3!='' && p4!='')
		{
			var total=((parseFloat(p3)+parseFloat(p4))/2).toFixed(1);
			$('#p_colo'+fu).html(total);
		}else{$('#p_colo'+fu).html('');}
		if(p5!='' && p6!='')
		{
			if(p5>0){
			var total=(100*(parseFloat(p6)/parseFloat(p5))).toFixed(1);}
			else{ var total=0;}
			$('#m_seca'+fu).html(total);
		}else{$('#m_seca'+fu).html('');}
	}
	function desviaciones()
	{
		var minpeso=999999,maxpeso=0,minpres=999999,maxpres=0,mincol=999999,maxcol=0,minss=999999,maxss=0,minseca=999999,maxseca=0;
		var sumapeso=0,sumdifpeso,prompeso,difpeso=0;
		var sumapres=0,sumdifpres,prompres,difpres=0;
		var sumasss=0,sumdifss,promss,difss=0;
		var sumacol=0,sumdifcol,promcol,difcol=0;
		var sumaseca=0,sumdifseca,promseca,difseca=0;
		var tot_peso=0,tot_pre=0,tot_ss=0,tot_col=0,tot_seca=0;
		for(var de=1;de<=48;de++)
		{
			if($('#l_peso'+de).val()>0)
			{
			 	tot_peso++;
			 	sumapeso=parseFloat($('#l_peso'+de).val())+sumapeso;
			 	if (minpeso>parseFloat($('#l_peso'+de).val())){minpeso=parseFloat($('#l_peso'+de).val());}
			 	if (maxpeso<parseFloat($('#l_peso'+de).val())){maxpeso=parseFloat($('#l_peso'+de).val());}
			}
			if (parseFloat($('#p_pres'+de).html())>0)
			{
				tot_pre++;
				sumapres=parseFloat($('#p_pres'+de).html())+sumapres;
				if (minpres>parseFloat($('#p_pres'+de).html())){minpres=parseFloat($('#p_pres'+de).html());}
				if (maxpres<parseFloat($('#p_pres'+de).html())){maxpres=parseFloat($('#p_pres'+de).html());}
			}
			if ($('#l_solu'+de).val()>0)
			{
				tot_ss++;
				sumasss=parseFloat($('#l_solu'+de).val())+sumasss;
				if (minss>parseFloat($('#l_solu'+de).val())){minss=parseFloat($('#l_solu'+de).val());}
				if (maxss<parseFloat($('#l_solu'+de).val())){maxss=parseFloat($('#l_solu'+de).val());}
			}
			if (parseFloat($('#p_colo'+de).html())>0)
			{
				tot_col++;
				sumacol=parseFloat($('#p_colo'+de).html())+sumacol;
				if (mincol>parseFloat($('#p_colo'+de).html())){mincol=parseFloat($('#p_colo'+de).html());}
				if (maxcol<parseFloat($('#p_colo'+de).html())){maxcol=parseFloat($('#p_colo'+de).html());}
			}
			if (parseFloat($('#m_seca'+de).html())>0)
			{
				tot_seca++;
				sumaseca=parseFloat($('#m_seca'+de).html())+sumaseca;
				if (minseca>parseFloat($('#m_seca'+de).html())){minseca=parseFloat($('#m_seca'+de).html());}
				if (maxseca<parseFloat($('#m_seca'+de).html())){maxseca=parseFloat($('#m_seca'+de).html());}
			}
		}
		prompeso=0;	if(tot_peso>0) {prompeso=(sumapeso/tot_peso).toFixed(1);}
		prompres=0;	if (tot_pre>0) {prompres=(sumapres/tot_pre).toFixed(1);}
		promss=0;	if (tot_ss>0) {promss=(sumasss/tot_ss).toFixed(1);}
		promcol=0;	if(tot_col>0) {promcol=(sumacol/tot_col).toFixed(1);}
		promseca=0;	if(tot_seca>0) {promseca=(sumaseca/tot_seca).toFixed(1);}
		for (var ede=1;ede<=48;ede++)
		{
			sumdifpeso=Math.pow(parseFloat($('#l_peso'+ede).val())-prompeso,2);
			difpeso=difpeso+sumdifpeso;
			sumdifpres=Math.pow(parseFloat($('#p_pres'+ede).html())-prompres,2);
			difpres=difpres+sumdifpres;
			sumdifcol=Math.pow(parseFloat($('#p_colo'+ede).html())-promcol,2);
			difcol=difcol+sumdifcol;
			sumdifss=Math.pow(parseFloat($('#l_solu'+ede).val())-promss,2);
			difss=difss+sumdifss;
			sumdifseca=Math.pow(parseFloat($('#m_seca'+ede).html())-promseca,2);
			difseca=difseca+sumdifseca;
		}
		var desv=0;		if(tot_peso>0){desv=Math.sqrt(difpeso/tot_peso).toFixed(1);}
		var desvp=0;	if (tot_pre>0) {descp=Math.sqrt(difpres/tot_pre).toFixed(1);}
		var desvs=0;	if (tot_ss>0) {desvs=Math.sqrt(difss/tot_ss).toFixed(1);}
		var desvc=0;	if (tot_col>0) {desvc=Math.sqrt(difcol/tot_col).toFixed(1);}
		var desvm=0;	if (tot_seca>0) {desvm=Math.sqrt(difseca/tot_seca).toFixed(1);}
		$('#resvalidos').html(tot_peso);
		$('#resprom').html(prompeso);
		$('#resmin').html(minpeso);
		$('#resmax').html(maxpeso);
		$('#resdesv').html(desv);
		$('#resvalidosp').html(tot_pre);
		$('#respromp').html(prompres);
		$('#resminp').html(minpres);
		$('#resmaxp').html(maxpres);
		$('#resdesvp').html(desvp);
		$('#resvalidosc').html(tot_col);
		$('#respromc').html(promcol);
		$('#resminc').html(mincol);
		$('#resmaxc').html(maxcol);
		$('#resdesvc').html(desvc);
		$('#resvalidoss').html(tot_ss);
		$('#resproms').html(promss);
		$('#resmins').html(minss);
		$('#resmaxs').html(maxss);
		$('#resdesvs').html(desvs);
		$('#resvalidosm').html(tot_seca);
		$('#respromm').html(promseca);
		$('#resminm').html(minseca);
		$('#resmaxm').html(maxseca);
		$('#resdesvm').html(desvm);
		$('#deppeso').html((((prompeso*tot_peso)-minpeso-maxpeso)/(tot_peso-2)).toFixed(1));
		$('#deppre').html((((prompres*tot_pre)-minpres-maxpres)/(tot_pre-2)).toFixed(1));
		$('#depss').html((((promss*tot_ss)-minss-maxss)/(tot_ss-2)).toFixed(1));
		$('#depcol').html((((promcol*tot_col)-mincol-maxcol)/(tot_col-2)).toFixed(1));
		$('#depseca').html((((promseca*tot_seca)-minseca-maxseca)/(tot_seca-2)).toFixed(1));
	}
	$('#guar_pesos_modificados').bind('click',function(){
		var datos= new FormData();
		datos.append('id_laboratorio',$('#existe_lab').val());
		datos.append('solo_pesos','1');
		for (var ede=1;ede<=48;ede++)
		{
			datos.append('s_peso[]',$('#l_peso'+ede).val());
		}
		$.ajax({
			url:'para_laboratorio.php',
			type:'POST',
			data: datos,
			processData: false,
			contentType: false, 
			success:function(qe){ alert ('Pesos Ingresados con exito!'); }
		});
	});
	$('#guar_presiones_modificadas').bind('click',function(){
		var datos= new FormData();
		datos.append('id_laboratorio',$('#existe_lab').val());
		datos.append('solo_presiones','1');
		for (var ede=1;ede<=48;ede++)
		{
			datos.append('s_pres1[]',$('#l_pre1'+ede).val());
			datos.append('s_pres2[]',$('#l_pre2'+ede).val());
		}
		$.ajax({
			url:'para_laboratorio.php',
			type:'POST',
			data: datos,
			processData: false,
			contentType: false, 
			success:function(qe){ alert ('Presiones Ingresadas con exito!'); }
		});
	});
	$('#cargar_presiones_archivo').bind('click',function(){
		var datos_arch = new FormData();
		datos_arch.append('presionometro','1');
		datos_arch.append('arch',$('#arch_presionometro')[0].files[0]);
		$.ajax({
			url:'procesa_arch.php',
			type:'POST',
			data:datos_arch,
			cache: false,
			dataType:"json",
         contentType: false,
         processData: false,
         success:function(resp){ Carga_presiones(resp); desviaciones(); }
		});
	});
	$('#guar_sss_modificados').bind('click',function(){
		var datos= new FormData();
		datos.append('id_laboratorio',$('#existe_lab').val());
		datos.append('solo_solidoss','1');
		for (var ede=1;ede<=48;ede++)
		{
			datos.append('s_brix[]',$('#l_solu'+ede).val());
		}
		$.ajax({
			url:'para_laboratorio.php',
			type:'POST',
			data: datos,
			processData: false,
			contentType: false, 
			success:function(qe){ alert ('Solidos Solubles Ingresadas con exito!'); }
		});
	});
	$('#guar_colores_modificados').bind('click',function(){
		var datos= new FormData();
		datos.append('id_laboratorio',$('#existe_lab').val());
		datos.append('solo_colores','1');
		for (var ede=1;ede<=48;ede++)
		{
			datos.append('s_col1[]',$('#l_col1'+ede).val());
			datos.append('s_col2[]',$('#l_col2'+ede).val());
		}
		$.ajax({
			url:'para_laboratorio.php',
			type:'POST',
			data: datos,
			processData: false,
			contentType: false, 
			success:function(qe){ alert ('Presiones Ingresadas con exito!'); }
		});
	});
	$('#cargar_colores_archivo').bind('click',function(){
		var datos_arch = new FormData();
		datos_arch.append('colorimetro','1');
		datos_arch.append('arch',$('#arch_colorimetro')[0].files[0]);
		$.ajax({
			url:'procesa_arch.php',
			type:'POST',
			data:datos_arch,
			cache: false,
			dataType:"json",
         contentType: false,
         processData: false,
         success:function(resp){ Carga_colores(resp); desviaciones(); }
		});
	});
	$('#guar_materiasecas_modificadas').bind('click',function(){
		var datos= new FormData();
		datos.append('id_laboratorio',$('#existe_lab').val());
		datos.append('solo_materiasecas','1');
		for (var ede=1;ede<=48;ede++)
		{
			datos.append('s_peso_i[]',$('#l_pesi'+ede).val());
			datos.append('s_peso_f[]',$('#l_pesf'+ede).val());
		}
		$.ajax({
			url:'para_laboratorio.php',
			type:'POST',
			data: datos,
			processData: false,
			contentType: false, 
			success:function(qe){ alert ('Presiones Ingresadas con exito!'); }
		});
	});
});
</script>
</head>
<body>
	<?php if(isset($_SESSION['id'])){ ?>
	<div id="contenedor" style="color:#567;">
	<div id="lista_labs">
		<div id="titulo_lab">Lista de Laboratorios en proceso</div>
		<table>
		<tr><td>Lab Numero</td><td>Cuartel</td><td>UM</td><td>Productor</td><td>Fecha Muestra</td><td>Fecha Laboratorio</td></tr>
		<?php
		if(is_array($ar))
		{
			foreach($ar as $i)
			{
				if($i[6]==0){
				echo "<tr><td><div style='width:25px;' class='btn_color labs' id='".$i[0]."'>".$i[0]."</div></td><td>".$i[1]."</td><td>".$i[2]."</td><td>".$i[3]."</td><td>".$i[4]."</td><td>".$i[5]."</td></tr>";
				}
			}
		}
		?>
		</table>
		</div>
		<div id="man_datos">
			<div id="Info_nro_lab"></div>
			<input type="hidden" id="existe_lab" value="0" >
			<div style='width:180px;float:left;' class="btn_color acc" id="ingreso_pesos">Pesos (<span id="t_pesos"></span>)</div>
			<div style='width:180px;float:left;' class="btn_color acc" id="ingreso_presiones">Presiones (<span id="t_pre_1"></span>)(<span id="t_pre_2"></span>)</div>
			<div style='width:180px;float:left;' class="btn_color acc" id="ingreso_brixs">S. Solubles (<span id="t_brix"></span>)</div>
			<div style='width:180px;float:left;' class="btn_color acc" id="ingreso_colores">Colores (<span id="t_col_1"></span>)(<span id="t_col_2"></span>)</div>
			<div style='width:180px;float:left;' class="btn_color acc" id="ingreso_mat_seca">Materia Seca (<span id="t_peso_1"></span>)(<span id="t_peso_2"></span>)</div>
		</div>
		<div style="clear:both;"></div>
		<div class="datos" id="tabla_ingreso_pesos">
		Pesos Ingresados
		<table>
			<tr><td>Numero</td><td>Medición (grs)</td></tr>
			<?php
				for($a=1;$a<=48;$a++){echo '<tr><td>'.$a.'</td><td><input type="text" id="l_peso'.$a.'" size="3" class="cuadrito" /></td></tr>';} 
			?>
			<tr><td>Datos Validos</td><td><div id='resvalidos' class="resul"></div></td></tr>
			<tr><td>min</td>	<td><div id="resmin" class="resul"></div></td></tr>
			<tr><td>Promedio</td>	<td><div id="resprom" class="resul"></div></td></tr>
			<tr><td>MAX</td>	<td><div id="resmax" class="resul"></div></td></tr>
			<tr><td>Desviación Estandar</td><td><div id="resdesv" class="resul"></div></td></tr>
			<tr><td>Promedio Depurado</td><td><div id="deppeso" class="resul"></div></td></tr>
		</table>
		<div style="width:190px;margin-bottom:15px;" class="btn_color" id="guar_pesos_modificados">Guardar Pesos</div>	
		</div>
		<div class="datos" id="tabla_ingreso_presiones">
		Presiones Ingresadas
		<table>
			<tr><td>Numero</td><td>Medición 1 (lbs /cmt²)</td><td>Medición 2 (lbs/cmt²)</td><td>Promedio (lbs/cmt²)</td></tr>
			<?php
				for($a=1;$a<=48;$a++){
					echo '<tr><td>'.$a.'</td>';
					echo '<td><input type="text" id="l_pre1'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><input type="text" id="l_pre2'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><div id="p_pres'.$a.'" class="es_1"></div></td></tr>';
				} 
			?>
			<tr><td>Datos Validos</td><td><div id="resvalidosp" class="resul"></div></td></tr>
			<tr><td>min</td>	<td><div id="resminp" class="resul"></div></td></tr>
			<tr><td>Promedio</td>	<td><div id="respromp" class="resul"></div></td></tr>
			<tr><td>MAX</td>	<td><div id="resmaxp" class="resul"></div></td></tr>
			<tr><td>Desviación Estandar</td><td><div id="resdesvp" class="resul"></div></td></tr>
			<tr><td>Promedio Depurado</td><td><div id="deppre" class="resul"></div></td></tr>
		</table>
		<div style="width:450px;margin-bottom:15px;" class="btn_color" id="guar_presiones_modificadas">Guardar Presiones</div>
		<input id="arch_presionometro" type="file">
		<div style="width:450px;" class="btn_color" id="cargar_presiones_archivo">Cargar Archivo Presionometro</div>	
		</div>
		<div class="datos" id="tabla_ingreso_brixs">
		Solidos Solubles Ingresados
		<table>
			<tr><td>Numero</td><td>Medición (°Bx)</td></tr>
			<?php
				for($a=1;$a<=48;$a++){echo '<tr><td>'.$a.'</td><td><input type="text" id="l_solu'.$a.'" size="3" class="cuadrito" /></td></tr>';} 
			?>
			<tr><td>Datos Validos</td><td><div id="resvalidoss" class="resul"></div></td></tr>
			<tr><td>min</td>	<td><div id="resmins" class="resul"></div></td></tr>
			<tr><td>Promedio</td>	<td><div id="resproms" class="resul"></div></td></tr>
			<tr><td>MAX</td>	<td><div id="resmaxs" class="resul"></div></td></tr>
			<tr><td>Desviación Estandar</td><td><div id="resdesvs" class="resul"></div></td></tr>
			<tr><td>Promedio Depurado</td><td><div id="depss" class="resul"></div></td></tr>
		</table>	
		<div style="width:450px;margin-bottom:15px;" class="btn_color" id="guar_sss_modificados">Guardar Solidos Solubles</div>
		</div>
		<div class="datos" id="tabla_ingreso_colores">
		Colores Ingresados
		<table>
			<tr><td>Numero</td><td>Medición 1 (h)</td><td>Medición 2 (h)</td><td>Promedio (h)</td></tr>
			<?php
				for($a=1;$a<=48;$a++){
					echo '<tr><td>'.$a.'</td>';
					echo '<td><input type="text" id="l_col1'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><input type="text" id="l_col2'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><div id="p_colo'.$a.'" class="es_1"></div></td></tr>';
				} 
			?>
			<tr><td>Datos Validos</td><td><div id="resvalidosc" class="resul"></div></td></tr>
			<tr><td>min</td>	<td><div id="resminc" class="resul"></div></td></tr>
			<tr><td>Promedio</td>	<td><div id="respromc" class="resul"></div></td></tr>
			<tr><td>MAX</td>	<td><div id="resmaxc" class="resul"></div></td></tr>
			<tr><td>Desviación Estandar</td><td><div id="resdesvc" class="resul"></div></td></tr>
			<tr><td>Promedio Depurado</td><td><div id="depcol" class="resul"></div></td></tr>
		</table>
		<div style="width:450px;margin-bottom:15px;" class="btn_color" id="guar_colores_modificados">Guardar Colores</div>
		<input id="arch_colorimetro" type="file">
		<div style="width:450px;" class="btn_color" id="cargar_colores_archivo">Cargar Archivo Colorimetro</div>	
		</div>
		<div class="datos" id="tabla_ingreso_mat_seca">
			Materia Seca Ingresada
			<table>
				<tr><td>Numero</td><td>Peso Inicial (grs)</td><td>Peso Final (grs)</td><td>Porcentaje (%)</td></tr>
				<?php
					for($a=1;$a<=48;$a++){
						echo '<tr><td>'.$a.'</td>';
						echo '<td><input type="text" id="l_pesi'.$a.'" class="cuadrito" size="3"/></td>';
						echo '<td><input type="text" id="l_pesf'.$a.'" class="cuadrito" size="3"/></td>';
						echo '<td><div id="m_seca'.$a.'" class="es_1"></div></td></tr>';
						} 
				?>
				<tr><td>Datos Validos</td><td><div id="resvalidosm" class="resul"></div></td></tr>
				<tr><td>min</td>	<td><div id="resminm" class="resul"></div></td></tr>
				<tr><td>Promedio</td>	<td><div id="respromm" class="resul"></div></td></tr>
				<tr><td>MAX</td>	<td><div id="resmaxm" class="resul"></div></td></tr>
				<tr><td>Desviación Estandar</td><td><div id="resdesvm" class="resul"></div></td></tr>
				<tr><td>Promedio Depurado</td><td><div id="depseca" class="resul"></div></td></tr>
			</table>
			<div style="width:450px;margin-bottom:15px;" class="btn_color" id="guar_materiasecas_modificadas">Guardar Materia Seca</div>	
		</div>	
	</div>
	<?php
		}else{echo "<a href='index.php' style='color:black'>Session cerrada, Reingrese</a>";}
	?> 
</body>
</html>