<?php
	session_start();
	require('clasekiwi.php');
	$c=new basededatos();
	if(!isset($_SESSION['id'])){ header('location:login.php?op=2'); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Kiwi Gold - Home</title>
<link rel="icon" href="img/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/formato.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.js"></script>
<script src="js/js_menu.js"></script>
</head>
<body>
	<div id="contenedor">
		<div id="header">
			<div id="logo"><img src="img/kiwi_logo.png" height="120" /></div>
         <div id="welcome">Bienvenido(a) <?php echo $_SESSION['nombre']; ?></div><br />
         <div id="finsession">Cerrar Sesión</div>
      </div>
      <div id="separador"><img src="img/separador.png" width="100%" height="15" /></div>
      <div id="menu_iz">
      	<?php switch($_SESSION['nivel'])
      	{
      		case 1:
      			echo "<div class='nivel'>Administrador</div>";
      			echo "<div class='barra' id='productores'><img class='imgmenu' src='img/productores.png' />Productores</div>";
      			echo "<div class='barra' id='fitosanitario'><img class='imgmenu' src='img/fitosanitarios.png' />Fitosanitarios</div>";
      			echo "<div class='barra' id='labores'><img class='imgmenu' src='img/labores.png' />Labores No Químicas</div>";
      			echo "<div class='barra' id='proyeccion'><img class='imgmenu' src='img/proyeccion.png' />Proyección</div>";
      			echo "<div class='barra' id='produccion'><img class='imgmenu' src='img/produccion.png' />Producción</div>";
      			echo "<div class='barra' id='informes'><img class='imgmenu' src='img/informes.png' />Informes Productores</div>";
      			echo "<div class='barra' id='controlum'><img class='imgmenu' src='img/controlum.png' />Control de UM</div>";
      			echo "<div class='barra' id='laboratorio'><img class='imgmenu' src='img/laboratorio.png' />Digitar Laboratorio</div>";
      			echo "<div class='barra' id='laboratorio_serie'><img class='imgmenu' src='img/kiwimeter.png' />Registro Lab en Serie</div>";
      			echo "<div class='barra' id='lab_autorisa'><img class='imgmenu' src='img/autorisa.png' />Analisis y Liberación</div>";
      			echo "<div class='barra' id='usuarios'><img class='imgmenu' src='img/usuarios.png' />Usuarios</div>";		
      		break;
      		case 2:
      			echo "<div class='nivel'>Supervisor</div>";
      			echo "<div class='barra' id='fitosanitario'><img class='imgmenu' src='img/fitosanitarios.png' />Fitosanitarios</div>";
      			echo "<div class='barra' id='labores'><img class='imgmenu' src='img/labores.png' />Labores No Químicas</div>";
      			echo "<div class='barra' id='proyeccion'><img class='imgmenu' src='img/proyeccion.png' />Proyección</div>";
      			echo "<div class='barra' id='lab_autorisa'><img class='imgmenu' src='img/autorisa.png' />Analisis y Liberación</div>";
      			echo "<div class='barra' id='controlum'><img class='imgmenu' src='img/controlum.png' />Control de UM</div>";
      		break;
      		case 3: 
      			echo "<div class='nivel'>Digitador</div>";
      			echo "<div class='barra' id='laboratorio'><img class='imgmenu' src='img/laboratorio.png' />Digitar Laboratorio</div>";
      			echo "<div class='barra' id='laboratorio_serie'><img class='imgmenu' src='img/kiwimeter.png' />Registro Lab en Serie</div>";
      			echo "<div class='barra' id='kiwimeter'><img class='imgmenu' src='img/kiwimeter.png' />Kiwimeter</div>";
      			echo "<div class='barra' id='controlum'><img class='imgmenu' src='img/controlum.png' />Control de UM</div>";
      		break;
      		case 4:
      			echo "<div class='nivel'>Productor</div>";
      			echo "<div class='barra' id='bitacora'><img class='imgmenu' src='img/etiqueta_n.png' />Bitácora</div>";
      			echo "<div class='barra' id='olabs'><img class='imgmenu' src='img/etiqueta_b.png' />Laboratorio</div>";
      			break;
      		case 5:
      			echo "<div class='nivel'>Directorio</div>";
      			echo "<div class='barra' id='informes'><img class='imgmenu' src='img/informes.png' />Informes Productores</div>";
      			break;
      		default:break;
      	}
      	 ?>
		</div>
      <div id="cont_centro">
         	
		</div>
	</div>
     <div class="footer"><img src="img/footer.png" width="100%" height="50"  /></div>
</body>
</html>