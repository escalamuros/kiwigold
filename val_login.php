<?php
session_start();
require_once "clasekiwi.php";
if(isset($_POST['usuario']))
{  $c=new basededatos();
	$c->conexion();
	$resp=$c->validar($_POST['usuario'],$_POST['pass']);
	$c->desconexion();
	switch($resp[0])
	{
		case '-1':	echo "index.php?op=4";break;
		case '0':	echo "index.php?op=1";break;
		default:  	$_SESSION['id']=$resp[0];
						$_SESSION['nivel']=$resp[1];
						$_SESSION['nombre']=$resp[2];
						$_SESSION['empresa']=$resp[3];
						echo "menu.php";break;
	}
}
?>