<?php
session_start();
include_once "clasekiwi.php";
$c=new basededatos();
$c->conexion();
$ar=$c->lista_todo_laboratorio();
$c->desconexion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script>
$(document).ready(function(){
	$('#man_datos').hide();
	$('#historico').bind('click',function(){
		$.ajax({
			url:'lab_historico.php',
			type:'POST',
			success:function(e){$('#cont_centro').html(e);}
		});
	});
	$('#Envio_Productor').bind('click',function(){
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{lab_aut:$('#existe_lab').val(),obs_datos:$('#obs_gral').val()},
			success:function(){alert('revisar laboratorios historicos'); }});
	});
	function completarCampos(per)
	{
		for(var de=0;de<=47;de++)
		{
			$('#l_peso'+(de+1)).val(per[de][1]);
			$('#l_pre1'+(de+1)).val(per[de][2]);
			$('#l_pre2'+(de+1)).val(per[de][3]);
			$('#l_solu'+(de+1)).val(per[de][4]);
			$('#l_col1'+(de+1)).val(per[de][5]);
			$('#l_col2'+(de+1)).val(per[de][6]);
			$('#l_pesi'+(de+1)).val(per[de][7]);
			$('#l_pesf'+(de+1)).val(per[de][8]);
			$('#l_obse'+(de+1)).val(per[de][9]);
			if(per[de][10]==1){$('#l_chke'+(de+1)).prop('checked', true);}else{$('#l_chke'+(de+1)).prop('checked', false);}
		}
	}
	$('.labs').bind('click',function(){
		var oe=$(this).attr('id');
		$('#existe_lab').val(oe);
		$.ajax({
				url:'recibeajax.php',
				type:'POST',
				data:{lab_seleccionado:oe},
				dataType:"json",
				success:function(te){ completarCampos(te);for(var de=1;de<=48;de++){calcular(de);}desviaciones(); 	}
		});
		
		$('#man_datos').show();
	});
	//al cambiar un checkbox, calcula y muestra 
	$('.contarlo').change(function(e)
	{	
		var num=$(this).attr('id').substring(6);
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{cam_est_dato:num,analisis:$('#existe_lab').val()},
			success:function(){calcular(num);desviaciones();}
		});
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
		var tot_elem=0;
		for(var de=1;de<=48;de++)
		{
			if($('#l_chke'+de).is(':checked'))
			{
				 tot_elem++;
				 sumapeso=parseFloat($('#l_peso'+de).val())+sumapeso;
				 if (minpeso>parseFloat($('#l_peso'+de).val())){minpeso=parseFloat($('#l_peso'+de).val());}
				 if (maxpeso<parseFloat($('#l_peso'+de).val())){maxpeso=parseFloat($('#l_peso'+de).val());}
				 sumapres=parseFloat($('#p_pres'+de).html())+sumapres;
				 if (minpres>parseFloat($('#p_pres'+de).html())){minpres=parseFloat($('#p_pres'+de).html());}
				 if (maxpres<parseFloat($('#p_pres'+de).html())){maxpres=parseFloat($('#p_pres'+de).html());}
				 sumacol=parseFloat($('#p_colo'+de).html())+sumacol;
				 if (mincol>parseFloat($('#p_colo'+de).html())){mincol=parseFloat($('#p_colo'+de).html());}
				 if (maxcol<parseFloat($('#p_colo'+de).html())){maxcol=parseFloat($('#p_colo'+de).html());}
				 sumasss=parseFloat($('#l_solu'+de).val())+sumasss;
				 if (minss>parseFloat($('#l_solu'+de).val())){minss=parseFloat($('#l_solu'+de).val());}
				 if (maxss<parseFloat($('#l_solu'+de).val())){maxss=parseFloat($('#l_solu'+de).val());}
				 sumaseca=parseFloat($('#m_seca'+de).html())+sumaseca;
				 if (minseca>parseFloat($('#m_seca'+de).html())){minseca=parseFloat($('#m_seca'+de).html());}
				 if (maxseca<parseFloat($('#m_seca'+de).html())){maxseca=parseFloat($('#m_seca'+de).html());}
				 
			}
		}
		prompeso=(sumapeso/tot_elem).toFixed(1);
		prompres=(sumapres/tot_elem).toFixed(1);
		promcol=(sumacol/tot_elem).toFixed(1);
		promss=(sumasss/tot_elem).toFixed(1);
		promseca=(sumaseca/tot_elem).toFixed(1);
		for (var ede=1;ede<=48;ede++)
		{
			if($('#l_chke'+ede).is(':checked'))
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
		}
		var desv=Math.sqrt(difpeso/tot_elem).toFixed(1);
		var desvp=Math.sqrt(difpres/tot_elem).toFixed(1);
		var desvc=Math.sqrt(difcol/tot_elem).toFixed(1);
		var desvs=Math.sqrt(difss/tot_elem).toFixed(1);
		var desvm=Math.sqrt(difseca/tot_elem).toFixed(1);
		$('#resvalidos').html(tot_elem);
		$('#resprom').html(prompeso);
		$('#resmin').html(minpeso);
		$('#resmax').html(maxpeso);
		$('#resdesv').html(desv);
		$('#resvalidosp').html(tot_elem);
		$('#respromp').html(prompres);
		$('#resminp').html(minpres);
		$('#resmaxp').html(maxpres);
		$('#resdesvp').html(desvp);
		$('#resvalidosc').html(tot_elem);
		$('#respromc').html(promcol);
		$('#resminc').html(mincol);
		$('#resmaxc').html(maxcol);
		$('#resdesvc').html(desvc);
		$('#resvalidoss').html(tot_elem);
		$('#resproms').html(promss);
		$('#resmins').html(minss);
		$('#resmaxs').html(maxss);
		$('#resdesvs').html(desvs);
		$('#resvalidosm').html(tot_elem);
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
		$('#deppeso').html(((prompeso*tot_elem-minpeso-maxpeso)/(tot_elem-2)).toFixed(1));
		$('#deppre').html(((prompres*tot_elem-minpres-maxpres)/(tot_elem-2)).toFixed(1));
		$('#depss').html(((promss*tot_elem-minss-maxss)/(tot_elem-2)).toFixed(1));
		$('#depcol').html(((promcol*tot_elem-mincol-maxcol)/(tot_elem-2)).toFixed(1));
		$('#depseca').html(((promseca*tot_elem-minseca-maxseca)/(tot_elem-2)).toFixed(1));
	}
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
			Lista de Laboratorios en proceso de aprobación.
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
			<br>
			<div class="btn_color" id="historico" style="width:200px;">Histórico Laboratorios</div>
		</div>
		<div id="man_datos">
			<input type="hidden" id="existe_lab" value="0" >
			<table style="margin: 0 auto 0 auto;">
			<tr><td>Dato Valido</td><td >Nº</td><td >Peso(g)</td><td >Presion 1(lbs)</td><td >Presion 2(lbs)</td>
				<td >Promedio Presion 1-2</td>
				<td>SS (ºbrix)</td><td>Color 1(ºH)</td><td>Color 2(ºH)</td>
				<td>Promedio Color 1-2</td>
				<td>Peso Neto inicial(g)</td><td>Peso Neto final(g)</td>
				<td>Mat Seca</td> 
				<td>Observaciones</td></tr>
			<?php
					for($a=1;$a<=48;$a++){
					echo '<tr><td><div id="nummer'.$a.'">'.$a.'</div></td>';
					echo '<td><input type="checkbox" id="l_chke'.$a.'" class="contarlo"></td>';
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
					echo '<td><input type="text" id="l_obse'.$a.'" class="cuadrito" size="28"/></td></tr>';	
					}	
				?>
			</table>
			<br>
			<table style="margin: 0 auto 0 auto;">
			<tr><td></td><td>Peso(g)</td><td>Promedio Presión 1-2</td><td>SS (ºbrix)</td><td>Promedio Color 1-2</td><td>Mat Seca</td></tr>
			<tr><td>Datos Válidos</td><td><div id="resvalidos" class="resul"></div></td><td><div id="resvalidosp" class="resul"></td><td><div id="resvalidoss" class="resul"></td><td><div id="resvalidosc" class="resul"></td><td><div id="resvalidosm" class="resul"></td></tr>
			<tr><td>Promedio Aritmetico</td><td><div id="resprom" class="resul"></div></td><td><div id="respromp" class="resul"></td><td><div id="resproms" class="resul"></td><td><div id="respromc" class="resul"></td><td><div id="respromm" class="resul"></td></tr>
			<tr><td>Min</td><td><div id="resmin" class="resul"></div></td><td><div id="resminp" class="resul"></td><td><div id="resmins" class="resul"></td><td><div id="resminc" class="resul"></td><td><div id="resminm" class="resul"></td></tr>
			<tr><td>Max</td><td><div id="resmax" class="resul"></div></td><td><div id="resmaxp" class="resul"></td><td><div id="resmaxs" class="resul"></td><td><div id="resmaxc" class="resul"></td><td><div id="resmaxm" class="resul"></td></tr>
			<tr><td>Desv.Estandar</td><td><div id="resdesv" class="resul"></div></td><td><div id="resdesvp" class="resul"></td><td><div id="resdesvs" class="resul"></td><td><div id="resdesvc" class="resul"></td><td><div id="resdesvm" class="resul"></td></tr>
			</table>  
			<br />
			<div style="float:left;width:350px;height:200px;">
			Observaciones:<br>
			<textarea style="width:300px;height:110px" id="obs_gral" ></textarea><br><br>
			<div class='btn_color' id='Envio_Productor' style=" width:290px;">Generación de Informe</div>

			</div>
			<table style="margin: 0 auto 0 auto;">
			<tr><td colspan="6" align="left">Rango de normalidad de la muestra</td></tr>
			<tr><td></td><td>Peso(g)</td><td>Promedio Presion 1-2</td><td>SS (ºbrix)</td><td>Promedio Color 1-2</td><td>Mat Seca</td></tr>
			<tr><td>Min</td><td><div id="minpeso" class="resul"></div></td><td><div id="minpre" class="resul"></div></td><td><div id="minss" class="resul"></div></td><td><div id="mincol" class="resul"></div></td><td><div id="minseca" class="resul"></div></td></tr>
			<tr><td>Max</td><td><div id="maxpeso" class="resul"></div></td><td><div id="maxpre" class="resul"></div></td><td><div id="maxss" class="resul"></div></td><td><div id="maxcol" class="resul"></div></td><td><div id="maxseca" class="resul"></div></td></tr>
			<!--<tr><td>Datos anormales</td><td><div id="datopeso" class="resul"></div></td><td><div id="datopre" class="resul"></div></td><td><div id="datoss" class="resul"></div></td><td><div id="datocol" class="resul"></div></td><td><div id="datoseca" class="resul"></div></td></tr>-->
			 </table> 
			<br />
			<table style="margin: 0 auto 0 auto;">
			<tr><td></td><td>Peso(g)</td><td>Promedio Presion 1-2</td><td>SS (ºbrix)</td><td>Promedio Color 1-2</td><td>Mat Seca</td></tr>
			<tr><td>Promedio Depurado</td><td><div id="deppeso" class="resul"></div></td><td><div id="deppre" class="resul"></div></td><td><div id="depss" class="resul"></div></td><td><div id="depcol" class="resul"></div></td><td><div id="depseca" class="resul"></div></td></tr>
			</table>     
		</div>

	<?php 
	}
}
else{echo "<a href='login.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
?>
</body>
</html>