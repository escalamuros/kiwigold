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
	if(isset($_POST['prod']))
	{
		$c->conexion();
		$c->registrar_cuartel_productor($_POST['prod'],$_POST['ano'],$_POST['nom'],$_POST['sup'],$_POST['nplan'],$_POST['z'],$_POST['d'],$_POST['nenc'],$_POST['fenc'],$_POST['eenc'],$_POST['geo'],$_POST['dth'],$_POST['deh'],$_POST['pm'],$_POST['o']);
	}
	$ar=$c->lista_cuarteles_productor($_POST['prod']);
	$c->desconexion();
	echo "Lista de Cuarteles<br>";
	$a='0';
	foreach($ar as $p)
	{
		echo "<div class='edi_cuar' id='".$p[0]."' style='mouse:pointer;background:blue;color:white;'>".$p[1]."</div>";
	}
?>
</body>
</html>