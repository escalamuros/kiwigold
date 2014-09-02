<?php
	require_once 'clasekiwi.php';
	$c=new basededatos();
	if(isset($_POST['id']))
	{
		$c->conexion();
		$c->modif_productora($_POST['id'],$_POST['nf'],$_POST['rs'],$_POST['rut'],$_POST['giro'],$_POST['dir'],$_POST['fono'],$_POST['mail'],$_POST['rl'],$_POST['rutr'],$_POST['fonor'],$_POST['mailr']);
		$c->desconexion();
	}
?>
