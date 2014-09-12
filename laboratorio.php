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
	
	var minpeso=999999,maxpeso=0,minpres=999999,maxpres=0,mincol=999999,maxcol=0,minss=999999,maxss=0,minseca=999999,maxseca=0;
	
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
	//si el campo al que se entra,tiene 0.... lo vacia(laboratorio.php)
	$('.cuadrito').focusin(function(e) {
		if($('#'+this.id).val()==0) { $('#'+this.id).val(''); }
	});
		//al cambiar un cuadro, evalua rangos,calcula y muestra (laboratorio.php)
/*	$('.cuadrito').change(function(e)
	{	
		var fo=this.id.substring(0,6);
		var fu=this.id.substring(6);
		rangos(fo,fu);
		calcular(fu);
		desviaciones();
	});
	function rangos(fo,fu)
	{
		var nu=$('#'+fo+fu).val(),box=$('#'+fo+fu);
		if (fo=='l_peso')
		{
			if(nu<60 || nu>191){alert('Sus valores estan fuera de rango permitido. De todas formas, estos se guardaran para referencia');}
		}
		if (fo=='l_pre1' || fo=='l_pre2' )
		{
			if(nu<8 || nu>17){alert('Sus valores estan fuera de rango permitido. De todas formas, estos se guardaran para referencia');}
		}
		if (fo=='l_solu')
		{
			if(nu<3.7 || nu>12){alert('Sus valores estan fuera de rango permitido. De todas formas, estos se guardaran para referencia');}
		}
		if (fo=='l_col1' || fo=='l_col2')
		{
			if(nu<103 || nu>115){alert('Sus valores estan fuera de rango permitido. De todas formas, estos se guardaran para referencia');}
		}
	}
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
			var total=(100*(parseFloat(p6)/parseFloat(p5))).toFixed(1);
			$('#m_seca'+fu).html(total);
		}else{$('#m_seca'+fu).html('');}
	}
	function desviaciones()
	{
		var sumapeso=0,validospeso=0,sumdifpeso,prompeso,difpeso=0;
		var sumapres=0,validospres=0,sumdifpres,prompres,difpres=0;
		var sumasss=0,validosss=0,sumdifss,promss,difss=0;
		var sumacol=0,validoscol=0,sumdifcol,promcol,difcol=0;
		var sumaseca=0,validosseca=0,sumdifseca,promseca,difseca=0;
		for(var de=1;de<=48;de++)
		{
			if($('#l_peso'+de).val()>0)
			{
				sumapeso=parseFloat($('#l_peso'+de).val())+sumapeso;
				validospeso++;
				if (minpeso>parseFloat($('#l_peso'+de).val())){minpeso=parseFloat($('#l_peso'+de).val());}
				if (maxpeso<parseFloat($('#l_peso'+de).val())){maxpeso=parseFloat($('#l_peso'+de).val());}
			}
			if($('#p_pres'+de).html()>0)
			{
				sumapres=parseFloat($('#p_pres'+de).html())+sumapres;
				validospres++;
				if (minpres>parseFloat($('#p_pres'+de).html())){minpres=parseFloat($('#p_pres'+de).html());}
				if (maxpres<parseFloat($('#p_pres'+de).html())){maxpres=parseFloat($('#p_pres'+de).html());}
			}
			if($('#p_colo'+de).html()>0)
			{
				sumacol=parseFloat($('#p_colo'+de).html())+sumacol;
				validoscol++;
				if (mincol>parseFloat($('#p_colo'+de).html())){mincol=parseFloat($('#p_colo'+de).html());}
				if (maxcol<parseFloat($('#p_colo'+de).html())){maxcol=parseFloat($('#p_colo'+de).html());}
			}
			if($('#l_solu'+de).val()>0)
			{
				sumasss=parseFloat($('#l_solu'+de).val())+sumasss;
				validosss++;
				if (minss>parseFloat($('#l_solu'+de).val())){minss=parseFloat($('#l_solu'+de).val());}
				if (maxss<parseFloat($('#l_solu'+de).val())){maxss=parseFloat($('#l_solu'+de).val());}
			}
			if($('#m_seca'+de).html()>0)
			{
				sumaseca=parseFloat($('#m_seca'+de).html())+sumaseca;
				validosseca++;
				if (minseca>parseFloat($('#m_seca'+de).html())){minseca=parseFloat($('#m_seca'+de).html());}
				if (maxseca<parseFloat($('#m_seca'+de).html())){maxseca=parseFloat($('#m_seca'+de).html());}
			}
		}
		prompeso=(sumapeso/validospeso).toFixed(1);
		prompres=(sumapres/validospres).toFixed(1);
		promcol=(sumacol/validoscol).toFixed(1);
		promss=(sumasss/validosss).toFixed(1);
		promseca=(sumaseca/validosseca).toFixed(1);
		for (var ede=1;ede<=48;ede++)
		{	
			if($('#l_peso'+ede).val()>0){
			sumdifpeso=Math.pow(parseFloat($('#l_peso'+ede).val())-prompeso,2);
			difpeso=difpeso+sumdifpeso;}
			if($('#p_pres'+ede).html()>0){
			sumdifpres=Math.pow(parseFloat($('#p_pres'+ede).html())-prompres,2);
			difpres=difpres+sumdifpres;}
			if($('#p_colo'+ede).html()>0){
			sumdifcol=Math.pow(parseFloat($('#p_colo'+ede).html())-promcol,2);
			difcol=difcol+sumdifcol;}
			if($('#l_solu'+ede).val()>0){
			sumdifss=Math.pow(parseFloat($('#l_solu'+ede).val())-promss,2);
			difss=difss+sumdifss;}
			if($('#m_seca'+ede).html()>0){
			sumdifseca=Math.pow(parseFloat($('#m_seca'+ede).html())-promseca,2);
			difseca=difseca+sumdifseca;}
		}
		var desv=Math.sqrt(difpeso/validospeso).toFixed(1);
		var desvp=Math.sqrt(difpres/validospres).toFixed(1);
		var desvc=Math.sqrt(difcol/validoscol).toFixed(1);
		var desvs=Math.sqrt(difss/validosss).toFixed(1);
		var desvm=Math.sqrt(difseca/validosseca).toFixed(1);
		$('#resvalidos').html(validospeso);
		$('#resprom').html(prompeso);
		$('#resmin').html(minpeso);
		$('#resmax').html(maxpeso);
		$('#resdesv').html(desv);
		$('#resvalidosp').html(validospres);
		$('#respromp').html(prompres);
		$('#resminp').html(minpres);
		$('#resmaxp').html(maxpres);
		$('#resdesvp').html(desvp);
		$('#resvalidosc').html(validoscol);
		$('#respromc').html(promcol);
		$('#resminc').html(mincol);
		$('#resmaxc').html(maxcol);
		$('#resdesvc').html(desvc);
		$('#resvalidoss').html(validosss);
		$('#resproms').html(promss);
		$('#resmins').html(minss);
		$('#resmaxs').html(maxss);
		$('#resdesvs').html(desvs);
		$('#resvalidosm').html(validosseca);
		$('#respromm').html(promseca);
		$('#resminm').html(minseca);
		$('#resmaxm').html(maxseca);
		$('#resdesvm').html(desvm);
		$('#minpeso').html((prompeso-3.35*desv).toFixed(1));
		$('#maxpeso').html((parseFloat(prompeso)+3.35*parseFloat(desv)).toFixed(1));
		$('#minpre').html((prompres-3.35*desvp).toFixed(1));
		$('#maxpre').html((parseFloat(prompres)+3.35*parseFloat(desvp)).toFixed(1));
		$('#minss').html((promss-3.35*desvs).toFixed(1));
		$('#maxss').html((parseFloat(promss)+3.35*parseFloat(desvs)).toFixed(1));
		$('#mincol').html((promcol-3.35*desvc).toFixed(1));
		$('#maxcol').html((parseFloat(promcol)+3.35*parseFloat(desvc)).toFixed(1));
		$('#minseca').html((promseca-3.35*desvm).toFixed(1));
		$('#maxseca').html((parseFloat(promseca)+3.35*parseFloat(desvm)).toFixed(1));
		$('#deppeso').html(((prompeso*validospeso-minpeso-maxpeso)/(validospeso-2)).toFixed(1));
		$('#deppre').html(((prompres*validospres-minpres-maxpres)/(validospres-2)).toFixed(1));
		$('#depss').html(((promss*validosss-minss-maxss)/(validosss-2)).toFixed(1));
		$('#depcol').html(((promcol*validoscol-mincol-maxcol)/(validoscol-2)).toFixed(1));
		$('#depseca').html(((promseca*validosseca-minseca-maxseca)/(validosseca-2)).toFixed(1));
	}*/
	
	//al cambiar la fecha de la analisis, genera nueva fecha, en f_analisis(laboratorio.php) 
	/*$('#fmuestra').change(function(e)
	{
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{nuevafecha:$('#fmuestra').val(),fin:sessionStorage['ning']}
		});
	});*/
	// sube los datos, con un session? (laboratorio.php)
/*	$('#btn_subir').click(function(e)
	{
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{ subir_data:sessionStorage['ning']},
			success:function(){alert ('Informacion subida con exito!')}
		});
	});*/
	//al presionar agregar, inserta los datos en a travez de recibeajax (laboratorio.php)
	$('#masdatos').click(function(e)
	{
		for(var aa=1;aa<=48;aa++)
		{
			var numm=$('#nummer'+aa).html();
			var peso=$('#l_peso'+aa).val();
			var presion1=$('#l_pre1'+aa).val();
			var presion2=$('#l_pre2'+aa).val();		
			var ss=$('#l_solu'+aa).val();
			var color1=$('#l_col1'+aa).val();
			var color2=$('#l_col2'+aa).val();
			var pesoi=$('#l_pesi'+aa).val();
			var pesof=$('#l_pesf'+aa).val();
			var obs=$('#l_obse'+aa).val();
			var ning=sessionStorage['ning'];
			$.ajax({
				url:'recibeajax.php',
				type:'POST',
				data:{numm:numm,peso:peso,presion1:presion1,presion2:presion2,ss:ss,color1:color1,color2:color2,pesoi:pesoi,pesof:pesof,obs:obs,ingbd:ning},
				success:function(e){ if(e==48){alert ('Datos guardados con exito!')} }
			});		
		}
	});
/*
	$('#fanalisis').change(function(e)
	{ // AQUI REVISA SI EXISTEN ANALISIS
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{um:$('#flab').val(),fecha:$('#fanalisis').val()},
			success:function(e){ if(e!=''){traerDatos(e);}else{crearDatos();} }
		});
		$('#add_data').show();
		$('#resultados').show();
	});
*/	
/*	function traerDatos(e)
	{
		sessionStorage['ning']=e;
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{ning:e},
			dataType:"json",
			success:function(e){ completarCampos(e); 	}
		});
	}
	function crearDatos()
	{
		for(var de=1;de<=48;de++)
		{
			$('#l_peso'+de).val('');
			$('#l_pre1'+de).val('');
			$('#l_pre2'+de).val('');
			$('#l_solu'+de).val('');
			$('#l_col1'+de).val('');
			$('#l_col2'+de).val('');
			$('#l_pesi'+de).val('');
			$('#l_pesf'+de).val('');
			$('#l_obse'+de).val('');
			calcular(de);
			desviaciones();
		}
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{lab:$('select#flab').val(),fecha:$('#fanalisis').val()},
			success:function(e){ sessionStorage['ning']=e; }
		});
	}
	function completarCampos(per)
	{
		for(var de=1;de<=48;de++)
		{
			$('#l_peso'+de).val(per[de][1]);
			$('#l_pre1'+de).val(per[de][2]);
			$('#l_pre2'+de).val(per[de][3]);
			$('#l_solu'+de).val(per[de][4]);
			$('#l_col1'+de).val(per[de][5]);
			$('#l_col2'+de).val(per[de][6]);
			$('#l_pesi'+de).val(per[de][7]);
			$('#l_pesf'+de).val(per[de][8]);
			$('#l_obse'+de).val(per[de][9]);
			calcular(de);
			desviaciones();
		}	
	}*/
});
</script>
</head>
<body>
	<?php if(isset($_SESSION['id'])){ ?>
	<div id="contenedor" style="color:#567;">
		<div id="titulo_lab">Registro Análisis de Control de Madurez Jintao</div>
		<div class="men_i" style="height:160px">
			<div id="expo_lab" class="expo"><div class="etex">Exportadora :</div>
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
				<tr><td >Nº</td><td >Peso(g)</td><td >Presion 1(lbs)</td><td >Presion 2(lbs)</td><td >Promedio Presion 1-2</td><td>SS (ºbrix)</td><td>Color 1(ºH)</td><td>Color 2(ºH)</td><td>Promedio Color 1-2</td><td>Peso Neto inicial(g)</td><td>Peso Neto final(g)</td><td>Mat Seca</td><td>Observaciones</td></tr>
				<?php
					for($a=1;$a<=48;$a++){
					echo '<tr><td><div id="nummer'.$a.'">'.$a.'</div></td>';
					echo '<td><input type="text" id="l_peso'.$a.'" size="3" class="cuadrito" /></td>';
					echo '<td><input type="text" id="l_pre1'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><input type="text" id="l_pre2'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><div id="p_pres'.$a.'" class="es_1"></div></td>';
					echo '<td><input type="text" id="l_solu'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><input type="text" id="l_col1'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><input type="text" id="l_col2'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><div id="p_colo'.$a.'" class="es_1"></div></td>';
					echo '<td><input type="text" id="l_pesi'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><input type="text" id="l_pesf'.$a.'" class="cuadrito" size="3"/></td>';
					echo '<td><div id="m_seca'.$a.'" class="es_1"></div></td>';
					echo '<td><input type="text" id="l_obse'.$a.'" class="cuadrito" size="8"/></td></tr>';	
					}	
				?>
			</table>
			<div id="masdatos" class="adder">Guardar Datos</div>
		</div>
		<div id="resultados">
			<table border="0">
			<tr><td></td><td>Peso(g)</td><td>Promedio Presion 1-2</td><td>SS (ºbrix)</td><td>Promedio Color 1-2</td><td>Mat Seca</td></tr>
			<tr><td>Datos Válidos</td><td><div id="resvalidos" class="resul"></div></td><td><div id="resvalidosp" class="resul"></td><td><div id="resvalidoss" class="resul"></td><td><div id="resvalidosc" class="resul"></td><td><div id="resvalidosm" class="resul"></td></tr>
			<tr><td>Promedio Aritmetico</td><td><div id="resprom" class="resul"></div></td><td><div id="respromp" class="resul"></td><td><div id="resproms" class="resul"></td><td><div id="respromc" class="resul"></td><td><div id="respromm" class="resul"></td></tr>
			<tr><td>Min</td><td><div id="resmin" class="resul"></div></td><td><div id="resminp" class="resul"></td><td><div id="resmins" class="resul"></td><td><div id="resminc" class="resul"></td><td><div id="resminm" class="resul"></td></tr>
			<tr><td>Max</td><td><div id="resmax" class="resul"></div></td><td><div id="resmaxp" class="resul"></td><td><div id="resmaxs" class="resul"></td><td><div id="resmaxc" class="resul"></td><td><div id="resmaxm" class="resul"></td></tr>
			<tr><td>Desv.Estandar</td><td><div id="resdesv" class="resul"></div></td><td><div id="resdesvp" class="resul"></td><td><div id="resdesvs" class="resul"></td><td><div id="resdesvc" class="resul"></td><td><div id="resdesvm" class="resul"></td></tr>
			</table>  
			<br />
			<table border='0'>
			<tr><td colspan="6" align="left">Rango de normalidad de la muestra</td></tr>
			<tr><td></td><td>Peso(g)</td><td>Promedio Presion 1-2</td><td>SS (ºbrix)</td><td>Promedio Color 1-2</td><td>Mat Seca</td></tr>
			<tr><td>Min</td><td><div id="minpeso" class="resul"></div></td><td><div id="minpre" class="resul"></div></td><td><div id="minss" class="resul"></div></td><td><div id="mincol" class="resul"></div></td><td><div id="minseca" class="resul"></div></td></tr>
			<tr><td>Max</td><td><div id="maxpeso" class="resul"></div></td><td><div id="maxpre" class="resul"></div></td><td><div id="maxss" class="resul"></div></td><td><div id="maxcol" class="resul"></div></td><td><div id="maxseca" class="resul"></div></td></tr>
			<!--<tr><td>Datos anormales</td><td><div id="datopeso" class="resul"></div></td><td><div id="datopre" class="resul"></div></td><td><div id="datoss" class="resul"></div></td><td><div id="datocol" class="resul"></div></td><td><div id="datoseca" class="resul"></div></td></tr>-->
			 </table> 
			<br />
			<table border='0'>
			<tr><td></td><td>Peso(g)</td><td>Promedio Presion 1-2</td><td>SS (ºbrix)</td><td>Promedio Color 1-2</td><td>Mat Seca</td></tr>
			<tr><td>Promedio Depurado</td><td><div id="deppeso" class="resul"></div></td><td><div id="deppre" class="resul"></div></td><td><div id="depss" class="resul"></div></td><td><div id="depcol" class="resul"></div></td><td><div id="depseca" class="resul"></div></td></tr>
			</table>         
			<?php if($_SESSION['nivel']==3 or $_SESSION['nivel']==1){ ?>
			<div class="addersd" id="btn_subir" style="float:left;width:550px;">Subir Información</div>
			<?php  }; ?>      
		</div>
	</div>
	<?php
		}else{echo "<a href='index.php' style='color:black'>Session cerrada, Reingrese</a>";}
	?> 
</body>
</html>