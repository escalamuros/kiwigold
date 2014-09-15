<?php
	require('clasekiwi.php');
	$c=new basededatos();
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
			echo "<div class='box_cuartel'>";
			echo "<table>";
			echo "<tr><td colspan='2'>".$v[1]."</td></tr>";
			$sup=$c->recuperar_cuartel($v[0]);
			echo "<tr><td>Superficie</td><td>Numero de Plantas</td><td>Dist. entre Hileras</td><td>Dist. en Hileras</td><td>% Machos</td><td>Mapa</td></tr>";
			echo "<tr><td style='background:#bcd;'>".$sup[4]."</td><td style='background:#bcd;'>".$sup[5]."</td><td style='background:#bcd;'>".$sup[12]."</td><td style='background:#bcd;'>".$sup[13]."</td><td style='background:#bcd;'>".$sup[14]."</td><td style='background:#bcd;cursor:pointer;' class='bot_cuartel' id='".$v[0]."'><img src='img/tierra.png' width='40'></td></tr>";
			echo "</table>";
			echo "</div>";
			
		}
		echo "</div>";
		
		echo "<br>Programa Fitosanitario<br>";

		echo "<div class='cuadro_informe' id='cuadro_fen'>";
		echo "<table>";
		echo "<tr><td style='background:#abc;'>Cuartel</td><td style='background:#abc;'>Fecha</td><td style='background:#abc;'>Nombre Comercial</td><td style='background:#abc;'>Ingrediente Activo</td><td style='background:#abc;'>Cadencia</td><td style='background:#abc;'>Observaciones</td><td style='background:#abc;'>Estado Fenologico</td></tr>";
		foreach ($lum as $cu){
			$pfs=$c->resumen_fito($cu[0]);
			if($pfs!=''){
			echo "<tr><td>".$pfs[0]."</td><td>".$pfs[1]."</td><td>".$pfs[2]."</td><td>".$pfs[3]."</td><td>".$pfs[4]."</td><td>".$pfs[5]."</td><td>".$pfs[6]."</td></tr>";
			}
		}
		echo "</table>";
		echo "</div>";

		echo "<br>Labores No Químicas<br>";
		echo "<div class='cuadro_informe' id='cuadro_labores'>";
		echo "<table>";
		echo "<tr><td style='background:#abc;'>Cuartel</td><td style='background:#abc;'>Fecha</td><td style='background:#abc;'>Programa</td><td style='background:#abc;'>Aplicación</td><td style='background:#abc;'>Estado Fenologico</td></tr>";
		foreach ($lum as $cu){
			$pfs=$c->resumen_labs($cu[0]);
			if($pfs!=''){
			echo "<tr><td>".$pfs[0]."</td><td>".$pfs[1]."</td><td>".$pfs[2]."</td><td>".$pfs[3]."</td><td>".$pfs[4]."</td></tr>";
			}
		}
		echo "</table>";
		echo "</div>";

		echo "<br>Producción<br>";
		echo "<div class='cuadro_informe' id='cuadro_produccion'>";
		echo "<table>";
		echo "<tr><td style='background:#abc;'>Productor</td><td style='background:#abc;'>Fecha</td><td style='background:#abc;'>Comercializadora</td><td style='background:#abc;'>Tonelada</td><td style='background:#abc;'>Calibre</td></tr>";
		$inp=$c->resumen_produccion($_POST['elegido']);
		foreach ($inp as $cu){
			
			if($cu[0]!=''){
			echo "<tr><td>".$cu[0]."</td><td>".$cu[1]."</td><td>".$cu[2]."</td><td>".$cu[3]."</td><td>".$cu[4]."</td></tr>";
			}
		}
		echo "</table>";
		echo "</div>";



		$c->desconexion();
	}
?>
</body></html>