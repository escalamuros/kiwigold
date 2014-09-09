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
		echo "Lista de Cuarteles <br>";
		$lum=$c->lista_cuarteles_productor($_POST['elegido']);
		foreach($lum as $v)
		{
			echo "<table>";
			echo "<tr><td colspan='6'>".$v[1]."</td></tr>";
			$sup=$c->recuperar_cuartel($v[0]);
			echo "<tr><td>Superficie</td><td>Numero de Plantas</td><td>Dist. entre Hileras</td><td>Dist. en Hileras</td><td>% Machos</td><td>Mapa</td></tr>";
			echo "<tr><td>".$sup[4]."</td><td>".$sup[5]."</td><td>".$sup[12]."</td><td>".$sup[13]."</td><td>".$sup[14]."</td><td style='cursor:pointer;' class='bot_cuartel' id='".$v[0]."'><img src='img/tierra.png' width='40'></td></tr>";
			echo "</table>";
		}
		echo "</div>";
		$c->desconexion();
	}
?>
</body></html>