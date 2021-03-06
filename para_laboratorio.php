<?php
	require_once 'clasekiwi.php';
	$c=new basededatos();
	//retorna lista de fechas de analisis de una um, sin autorizar
	if(isset($_POST['lista_f_anal'])){
		$c->conexion();
		$arr=$c->lista_lab_sin_autorizar($_POST['lista_f_anal']);
		echo "<div class='btn_color' id='n_anal' style='width:200px'>Digitar Nuevo Analisis </div>";
		echo "<div class='btn_color' id='n_anal_serie' style='width:200px'>Nuevo Analisis en Serie</div>";
		echo "<table>";
		echo "<tr><td colpsan='3'>Lista de Laboratorios </td></tr>";
		echo "<tr><td>Fecha</td><td>F Muestreo</td><td>Editar</td></tr>";
		foreach($arr as $a){
			if($a[0]!=0) {
			echo "<tr><td>".$a[1]."</td><td>".$a[2]."</td><td class='btn_edi_lab' id='an_".$a[0]."'><div class='btn_color'>Editar</div></td></tr>";
			}else {
			echo "<tr><td>".$a[1]."</td><td>".$a[2]."</td><td>-</td></tr>";			
			}
		}
		echo "</table>";
		$c->desconexion();
	}
	//cabia de estado unas muestras de laboratorio, para ser revisadas por lab_autoriza
	if(isset($_POST['lab_cam_est']))
	{
		$c->conexion();
		$c->cambia_estado_lab($_POST['lab_cam_est'],1);
		$arr=$c->lista_lab_sin_autorizar($_POST['l_f_anal_nu']);
		echo "<div class='btn_color' id='n_anal' style='width:200px'>Nuevo Analisis</div>";
		echo "<table>";
		echo "<tr><td colpsan='3'>Lista de Laboratorios </td></tr>";
		echo "<tr><td>Fecha</td><td>F Muestreo</td><td>Editar</td></tr>";
		foreach($arr as $a){
			if($a[0]!=0) {
			echo "<tr><td>".$a[1]."</td><td>".$a[2]."</td><td class='btn_edi_lab' id='an_".$a[0]."'><div class='btn_color'>Editar</div></td></tr>";
			}else {
			echo "<tr><td>".$a[1]."</td><td>".$a[2]."</td><td>-</td></tr>";			
			}
		}
		echo "</table>";
		$c->desconexion();
	}
	//retorna lista de todas las fechas de analisis de una um
	if(isset($_POST['t_lista_f_anal'])){
		$c->conexion();
		$arr=$c->lista_laboratorio($_POST['t_lista_f_anal']);
		echo "<table>";
		echo "<tr><td>id</td><td>Fecha</td><td>F Muestreo</td><td>Estado</td></tr>";
		foreach($arr as $a){echo "<tr><td>".$a[0]."</td><td>".$a[1]."</td><td>".$a[2]."</td><td>".$a[3]."</td></tr>";}
		echo "</table>";
		$c->desconexion();
	}
	//actualizar datos de un analisis existente
	if(isset($_POST['peso'])){
		$c->conexion();
		$c->actualiza_analisis($_POST['numm'],$_POST['peso'],$_POST['presion1'],$_POST['presion2'],$_POST['ss'],$_POST['color1'],$_POST['color2'],$_POST['pesoi'],$_POST['pesof'],$_POST['obs'],$_POST['ingbd']);
		$c->desconexion();
	}
	//actualiza solo los pesos del laboratorio
	if(isset($_POST['solo_pesos']))
	{
		$c->conexion();
		$c->actualiza_pesos_analisis($_POST['id_laboratorio'],$_POST['s_peso']);
		$c->desconexion();
	}
	//actualiza solo las presiones
	if(isset($_POST['solo_presiones']))
	{
		$c->conexion();
		$c->actualiza_presiones_analisis($_POST['id_laboratorio'],$_POST['s_pres1'],$_POST['s_pres2']);
		$c->desconexion();
	}
	//actualiza solo los solidos solubles
	if(isset($_POST['solo_solidoss']))
	{
		$c->conexion();
		$c->actualiza_solidos_analisis($_POST['id_laboratorio'],$_POST['s_brix']);
		$c->desconexion();
	}
	//actualiza solo las colores
	if(isset($_POST['solo_colores']))
	{
		$c->conexion();
		$c->actualiza_colores_analisis($_POST['id_laboratorio'],$_POST['s_col1'],$_POST['s_col2']);
		$c->desconexion();
	}
	//actualiza solo las materia inicial y materia final
	if(isset($_POST['solo_materiasecas']))
	{
		$c->conexion();
		$c->actualiza_materiasecas_analisis($_POST['id_laboratorio'],$_POST['s_peso_i'],$_POST['s_peso_f']);
		$c->desconexion();
	}
	//inserta un nuevo f_analisis y los 48 frutos en analisis
	if((isset($_POST['um']))&&(isset($_POST['flab']))&&(isset($_POST['fmue']))){
		$c->conexion();
		$id_f_anal=$c->crearAnalisis($_POST['um'],$_POST['flab'],$_POST['fmue']);
		echo $id_f_anal.'<br>';
		foreach($_POST['num'] as $a)
		{
			$c->llena_analisis($id_f_anal,$a);
		}
		$c->desconexion();
	}
	if((isset($_POST['actualiza_lab']))&&(isset($_POST['flab']))&&(isset($_POST['fmue']))){
		$c->conexion();
		$c->actualiza_fechas_f_analisis($_POST['actualiza_lab'],$_POST['flab'],$_POST['fmue']);
		foreach($_POST['num'] as $a)
		{
			$dat=explode('/',$a);
			$c->actualiza_analisis($dat[0],$dat[1],$dat[2],$dat[3],$dat[4],$dat[5],$dat[6],$dat[7],$dat[8],$dat[9],$_POST['actualiza_lab']);
		}
		$c->desconexion();
	}
?>
<script>
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
	}
}
$('.btn_edi_lab').bind('click',function(){
	var oe=$(this).attr('id').substr(3);
	$('#existe_lab').val(oe);
	$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{lab_seleccionado:oe},
			dataType:"json",
			success:function(te){ completarCampos(te); 	}
	});
	$.ajax({
		url:'recibeajax.php',
		type:'POST',
		data:{f_lab_selec:oe},
		dataType:"json",
		success:function(tii){$('#fanalisis').val(tii[0]);$('#fmuestra').val(tii[1]);}
	});
	$('#add_data').show();
});
$('#n_anal').bind('click',function(){
	$('#add_data').show();
	$('#existe_lab').val('0');
	$('#fanalisis').val('');
	$('#fmuestra').val('');
	for(var aa=1;aa<=48;aa++)
	{
		$('#l_peso'+aa).val('');
		$('#l_pre1'+aa).val('');
		$('#l_pre2'+aa).val('');
		$('#l_solu'+aa).val('');
		$('#l_col1'+aa).val('');
		$('#l_col2'+aa).val('');
		$('#l_pesi'+aa).val('');
		$('#l_pesf'+aa).val('');
		$('#l_obse'+aa).val('');
	};
});
</script>