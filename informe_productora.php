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
<title>Asynchronous Loading</title>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="utf-8">
<script>
$(document).ready(function(){
	$('#mapa').hide();
	$('.bot_cuartel').bind('click',function(){
		window.open('gmap.php?cuartel='+$(this).attr('id'),'_blank');
	});
	sessionStorage['anio']='2014';
	sessionStorage['theone']=<?php echo $_POST['elegido'] ?>;
	
	
	$('.box_cuartel').bind('click',function(){
		sessionStorage['cuartel']=this.id.substr(4);
		$('#resumen_resultados').show();
		cargar_datos();
	})

	$('.flecha').bind('click',function(){
		var anio=$('#s_temp').html();
		if(this.id=='fmenos'){
			anio=parseInt(anio)-1;
			if(parseInt(anio)<2010){anio=2010;}
		}else{anio=parseInt(anio)+1;if(parseInt(anio)>2017){anio=2017}}
		$('#s_temp').html(anio);
		sessionStorage['anio']=anio;
		cargar_datos();
	});

	//manda datos para excel
	$("#exp_excel").click(function() {
		$("#datos_a_enviar").val( $("<div>").append( $("#cont_centro").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
	});

	function cargar_datos(){
		$('#cuadro_fen table').html("<tr><td style='background:#abc;'>Cuartel</td><td style='background:#abc;'>Fecha</td><td style='background:#abc;'>Nombre Comercial</td><td style='background:#abc;'>Ingrediente Activo</td><td style='background:#abc;'>Carencia</td><td style='background:#abc;'>Observaciones</td><td style='background:#abc;'>Estado Fenologico</td></tr>");
		$('#cuadro_labores table').html("<tr><td style='background:#abc;'>Cuartel</td><td style='background:#abc;'>Fecha</td><td style='background:#abc;'>Programa</td><td style='background:#abc;'>Aplicación</td><td style='background:#abc;'>Estado Fenologico</td></tr>");
		$('#cuadro_produccion table').html("<tr><td style='background:#abc;'>Cuartel</td><td style='background:#abc;'>Fecha</td><td style='background:#abc;'>Comercializadora</td><td style='background:#abc;'>Tonelada</td><td style='background:#abc;'>Calibre</td></tr>");
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			dataType:'JSON',
			data:{tnd:1,theone:sessionStorage['theone'],tempo:sessionStorage['anio'],ccuartel:sessionStorage['cuartel']},
			success:function(e){
				for (var fut in e.fitos){
					$('#cuadro_fen table').append('<tr><td>'+e.fitos[fut][0]+'</td><td>'+e.fitos[fut][1]+'</td><td>'+e.fitos[fut][2]+'</td><td>'+e.fitos[fut][3]+'</td><td>'+e.fitos[fut][4]+'</td><td>'+e.fitos[fut][5]+'</td><td>'+e.fitos[fut][6]+'</td></tr>');
				
				}
				for (var fut in e.labs){
					$('#cuadro_labores table').append('<tr><td>'+e.labs[fut][0]+'</td><td>'+e.labs[fut][1]+'</td><td>'+e.labs[fut][2]+'</td><td>'+e.labs[fut][3]+'</td><td>'+e.labs[fut][4]+'</td></tr>');
				
				}
				for(var fut in e.produccion)
					$('#cuadro_produccion table').append('<tr><td>'+e.produccion[fut][0]+'</td><td>'+e.produccion[fut][1]+'</td><td>'+e.produccion[fut][2]+'</td><td>'+e.produccion[fut][3]+'</td><td>'+e.produccion[fut][4]+'</td></tr>');
				
				}
		})
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
		foreach($lum as $v)
		{
			echo "<div class='box_cuartel' id='cuar".$v[0]."'>";
			echo "<table>";
			echo "<tr><td colspan='2'>".$v[1]."</td></tr>";
			$sup=$c->recuperar_cuartel($v[0]);
			echo "<tr><td>Superficie</td><td>Numero de Plantas</td><td>Dist. entre Hileras</td><td>Dist. en Hileras</td><td>% Machos</td><td>Mapa</td></tr>";
			echo "<tr><td style='background:#bcd;'>".$sup[4]."</td><td style='background:#bcd;'>".$sup[5]."</td><td style='background:#bcd;'>".$sup[12]."</td><td style='background:#bcd;'>".$sup[13]."</td><td style='background:#bcd;'>".$sup[14]."</td><td style='background:#bcd;cursor:pointer;' class='bot_cuartel' id='".$v[0]."'><img src='img/tierra.png' width='30'></td></tr>";
			echo "</table>";
			echo "</div>";
			
		}
		echo "</div>";

		echo "<div id='resumen_resultados'>";
		echo "";
		echo "<div id='sel_temporada'><span style='float:left;margin-right:50px;'>Temporada: </span><div class='flecha' id='fmenos'><</div><div id='s_temp'>2014</div><div class='flecha' id='fmas'>></div><div id='exp_excel'><img src='img/excel_logo.png' width='28' alt='Exportar Datos a Excel'></div></div>";
		
		echo "<br>Programa Fitosanitario<br>";
		
		echo "<div class='cuadro_informe' id='cuadro_fen'>";
		echo "<table>";
		
		
		echo "</table>";
		echo "</div>";

		echo "<br>Labores No Químicas<br>";
		echo "<div class='cuadro_informe' id='cuadro_labores'>";
		echo "<table>";
		
	
		echo "</table>";
		echo "</div>";
		echo "<br>Producción<br>";
		echo "<div class='cuadro_informe' id='cuadro_produccion'>";
		echo "<table>";
		echo "</table>";
		echo "</div>";
		

		$c->desconexion();


		//pruebas de exportar a excel

		echo '<form action="informe_productora.php" method="post" target="_blank" id="FormularioExportacion">';
		echo '<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />';
		echo '</form>';
	}
?>
</body></html>