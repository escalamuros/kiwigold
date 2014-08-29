<?php
	session_start();
	require('clasekiwi.php');
	$c=new basededatos();
	if(!isset($_SESSION['id'])){ header('location:index.php?op=2'); }

   if(isset($_GET['ece'])){
      echo "<script> alert ('Archivos cargados con exito');</script>";

   }

   

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
      			echo "<div class='barra' id='fenologicos'><img class='imgmenu' src='img/fenologico.png' />Estados Fenológicos</div>";
      			echo "<div class='barra' id='fitosanitario'><img class='imgmenu' src='img/fitosanitario.png' />Programa Fitosanitario</div>";
      			echo "<div class='barra' id='laboratorio'><img class='imgmenu' src='img/laboratorio.png' />Laboratorio</div>";
      			echo "<div class='barra' id='lab_autorisa'><img class='imgmenu' src='img/autorisa.png' />Autorizar Laboratorio</div>";
      			echo "<div class='barra' id='produccion'><img class='imgmenu' src='img/registro.png' />Producción</div>";
      			echo "<div class='barra' id='usuarios'><img class='imgmenu' src='img/usuarios.png' />Usuarios</div>";
      			echo "<div class='barra' id='productores'><img class='imgmenu' src='img/campos.png' />Productores</div>";
      		break;
      		case 2:
      			echo "Digitador Laboratorio";
      			echo "<div class='barra' id='laboratorio'><img class='imgmenu' src='img/laboratorio.png' />Laboratorio</div>";
      		break;
      		case 3: echo "nivel 3";break;
      		case 4:
      			echo "Productor";
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