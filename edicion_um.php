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
	if(isset($_POST['um_elegida'])){
		$c->conexion();
		$ar=$c->datos_um($_POST['um_elegida']);
		echo "<input type='hidden' id='um_modificar' value='".$ar[0]."'>";
		$c->desconexion();
		echo "<table>";
		echo "<tr><td colspan='2'>Datos y Edición de Unidad de Maduración</td></tr>";
		echo "<tr><td>Nombre</td><td><input type='text' value='".$ar[1]."'></td></tr>";
		echo "<tr><td>Campo</td><td><input type='text' value='".$ar[2]."'></td></tr>";
		echo "<tr><td>Cuartel</td><td><input type='text' value='".$ar[3]."'></td></tr>";
		echo "<tr><td>Superficie</td><td><input type='text' value='".$ar[4]."'></td></tr>";
		echo "<tr><td>Año</td><td><input type='text' value='".$ar[5]."'></td></tr>";
		echo "<tr><td>Geolocalización</td><td><input type='text' value='".$ar[6]."'></td></tr>";
		echo "<tr><td>Estado</td><td>";
		if($ar[7]==1){echo "Activa";}else{echo "Inactiva";}
		echo "</td></tr>";
		echo "</table>";
	}
?>
</body>
</html>