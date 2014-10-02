<?php
	require('clasekiwi.php');
	$c=new basededatos();
	if(isset($_POST['datos_a_enviar'])){
		header("Content-type: application/vnd.ms-excel; name='excel'");
		header("Content-Disposition: filename=DatosExportadoras.xls");
		header("Pragma: no-cache");	
		header("Expires: 0");
		echo $_POST['datos_a_enviar'];
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<script>
$(document).ready(function(){
	//abre otra pestaña con el mapa
	$('.bot_mapa_cuartel').bind('click',function(){
		window.open('gmap.php?cuartel='+$(this).attr('id'),'_blank');
	});
	$('#resumen_resultados').hide();$('#sel_temporada').hide();
	$('.box_cuartel').bind('click',function(){
		$('#cuartel_sel').val(this.id.substr(4));
		$('#resumen_resultados').show();
		$('#sel_temporada').show();
		cargar_datos();
	})
	$('.flecha').bind('click',function(){
		var anio=$('#s_temp').html();
		if(this.id=='fmenos'){
			anio=parseInt(anio)-1;
			if(parseInt(anio)<2010){anio=2010;}
		}else{anio=parseInt(anio)+1;if(parseInt(anio)>2017){anio=2017}}
		$('#s_temp').html(anio);
		cargar_datos();
	});
	//manda datos para excel
	$("#exp_excel").click(function() {
		$("#datos_a_enviar").val( $("<div>").append( $("#resumen_resultados").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
	});
	function cargar_datos(){
		$.ajax({
			url:'recarga_informe.php',
			type:'POST',
			data:{tempo:$('#s_temp').html(),ccuartel:$('#cuartel_sel').val()},
			success:function(e){ $('#resumen_resultados').html(e);}	
		});
	} //cerrar cargar_datos
});
</script>
</head>
<body>
<?php
	
	if(isset($_POST['elegido']))
	{
		$c->conexion();
		$lis=$c->recuperar_productora($_POST['elegido']);
		echo "<input type='hidden' id='ide' value='".$lis[0]."' >";
		echo "<div id='a' style='width:500px;'>";
		echo "Datos De la Productora<br>";
		echo "<table>";
		echo "<tr><td>Nombre</td><td>".$lis[2]."</td>            </tr>";
		echo "<tr><td>Razón Social</td><td>".$lis[3]."</td>      </tr>";
		echo "<tr><td>Rut</td><td>".$lis[4]."</td>                </tr>";
		echo "<tr><td>Giro</td><td>".$lis[5]."</td>               </tr>";
		echo "<tr><td>Dirección</td><td>".$lis[6]."</td>          </tr>";
		echo "</table>";
		echo "</div>";
		echo "<div class='mod' id='mantenedor_cuarteles' >";
		echo "<div id='lis_cuarteles'>";
		echo "<br>Lista de Cuarteles <br>";
		$lum=$c->lista_cuarteles_productor($_POST['elegido']);
		echo "<input type='hidden' id='cuartel_sel' value='0'>";
		echo "<table>";
		echo "<tr><td>Cuartel</td><td>Superficie</td><td>Numero de Plantas</td><td>Dist. entre Hileras</td><td>Dist. sobre Hileras</td><td>% Machos</td><td>Tipo de plantación</td><td>Mapa</td></tr>";
		foreach($lum as $v)
		{
			$sup=$c->recuperar_cuartel($v[0]);
			echo "<tr><td class='box_cuartel' id='cuar".$v[0]."'>".$v[1]."</td><td style='background:#bcd;'>".$sup[4]."</td>";
			echo "<td style='background:#bcd;'>".$sup[5]."</td><td style='background:#bcd;'>".$sup[12]."</td>";
			echo "<td style='background:#bcd;'>".$sup[13]."</td><td style='background:#bcd;'>".$sup[14]."</td>";
			echo "<td style='background:#bcd;'>".$sup[15]."</td><td style='background:#bcd;cursor:pointer;' class='bot_mapa_cuartel' id='".$v[0]."'>";
			echo "<img src='img/tierra.png' width='30'></td></tr>";
		}
		echo "</table>";
		echo "</div>";
		echo "<div id='sel_temporada'><span style='float:left;margin-right:50px;'>Temporada: </span><div class='flecha' id='fmenos'><</div><div id='s_temp'>".date('Y')."</div><div class='flecha' id='fmas'>></div><div id='exp_excel'><img src='img/excel_logo.png' width='28' alt='Exportar Datos a Excel'></div></div>";
		echo "<div id='resumen_resultados'>";

		echo "</div>";
		$c->desconexion();
		//pruebas de exportar a excel
		echo '<form action="informe_productora.php" method="post" target="_blank" id="FormularioExportacion">';
		echo '<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />';
		echo '</form>';
	}
?>
</body></html>