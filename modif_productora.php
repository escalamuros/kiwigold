<?php
	require_once 'clasekiwi.php';
	$c=new basededatos();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php 
	if(isset($_POST['id']))
	{
		$c->conexion();
		$c->modif_productora($_POST['id'],$_POST['nf'],$_POST['rs'],$_POST['rut'],$_POST['giro'],$_POST['fono'],$_POST['dir'],$_POST['mail'],$_POST['rl'],$_POST['rutr'],$_POST['fonor'],$_POST['mailr'],$_POST['enc'],$_POST['rute'],$_POST['fonoe'],$_POST['maile']);
		$c->desconexion();
	}
?>
</body>
</html>