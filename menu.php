<?php
	session_start();
	require('clasekiwi.php');
	$c=new basededatos();
	if(!isset($_SESSION['id'])){ header('location:index.php?op=2'); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Kiwi Gold - Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/formato.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.js"></script>
<script src="js/js_menu.js"></script>
<script src="js/jquery-ui.js"></script>
</head>

<body>
	<div id="contenedor">
		<div id="header">
			<div id="logo"><img src="img/kiwi_logo.png" height="120" /></div>
         <div id="welcome">Bienvenido(a) <?php echo $_SESSION['nombre']; ?></div><br />
         <div id="finsession">Cerrar Sesion</div>
      </div>
      <div id="separador"><img src="img/separador.png" width="100%" height="15" /></div>
      <div id="menu_iz">
      	<?php switch($_SESSION['nivel'])
      	{
      		case 1:
      			echo "<div class='nivel'>Superusuario</div>";
      			echo "<div class='barra' id='fitosanitario'><img class='imgmenu' src='img/fenologico.png' />Fitosaitarios</div>";
      			echo "<div class='barra' id='labores'><img class='imgmenu' src='img/fitosanitario.png' />Labores No Quimicas</div>";
      			echo "<div class='barra' id='laboratorio'><img class='imgmenu' src='img/laboratorio.png' />Laboratorio</div>";
      			echo "<div class='barra' id='lab_autorisa'><img class='imgmenu' src='img/autorisa.png' />Autorizar Laboratorio</div>";
      			echo "<div class='barra' id='controlum'><img class='imgmenu' src='img/registro.png' />Control de UM</div>";
      			echo "<div class='barra' id='produccion'><img class='imgmenu' src='img/registro.png' />Producción</div>";
      			echo "<div class='barra' id='usuarios'><img class='imgmenu' src='img/usuarios.png' />Usuarios</div>";
      			echo "<div class='barra' id='productores'><img class='imgmenu' src='img/campos.png' />Productores</div>";
      		break;
      		case 2:
      			echo "<div class='nivel'>Supervisor</div>";
      		break;
      		case 3: 
      			echo "<div class='nivel'>Digitador</div>";
      			echo "<div class='barra' id='laboratorio'><img class='imgmenu' src='img/laboratorio.png' />Laboratorio</div>";
      			echo "<div class='barra' id='controlum'><img class='imgmenu' src='img/registro.png' />Control de UM</div>";
      		break;
      		case 4:
      			echo "<div id='nivel'>Productor</div>";
      			echo "<div class='barra' id='bitacora'><img class='imgmenu' src='img/bitacora.png' />Bitácora</div>";
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