<?php
	require_once 'clasekiwi.php';
	$c=new basededatos();
	$c->conexion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php 
	if(isset($_POST['cuartel']))
	{
		$ar=$c->recuperar_cuartel($_POST['cuartel']);
		$or=$c->lista_plantas($_POST['cuartel']);
	}
	$c->desconexion();
	echo "Editar Cuartel:<br>";
	echo "<input type='hidden' id='p' value='".$ar[0]."' >";
	echo "<table>";
	echo "<tr><td>Nombre:</td><td>                  <input type='text' id='enom' value='".$ar[3]."'></td></tr>";
	echo "<tr><td>Año:</td><td>                     <input type='text' id='eano' value='".$ar[2]."'></td></tr>";
	echo "<tr><td>Superficie:</td><td>              <input type='text' id='esup' value='".$ar[4]."'></td></tr>";
	echo "<tr><td>Numero de Plantas:</td><td>       <input type='text' id='enplan' value='".$ar[5]."'></td></tr>";
	echo "<tr><td>Zona:</td><td>                    <input type='text' id='ez' value='".$ar[6]."'></td></tr>";
	echo "<tr><td>Dirección:</td><td>               <input type='text' id='ed' value='".$ar[7]."'></td></tr>";
	echo "<tr><td>Nombre Encargado:</td><td>        <input type='text' id='enenc' value='".$ar[8]."'></td></tr>";
	echo "<tr><td>Fono Encargado:</td><td>          <input type='text' id='efenc' value='".$ar[9]."'></td></tr>";
	echo "<tr><td>EMail Encargado:</td><td>         <input type='text' id='eeenc' value='".$ar[10]."'></td></tr>";
	echo "<tr><td>Geolocalización:</td><td>         <input type='text' id='egeo' value='".$ar[11]."'></td></tr>";
	echo "<tr><td>Distancia entre hileras:</td><td> <input type='text' id='edth' value='".$ar[12]."'></td></tr>";
	echo "<tr><td>Distancia en hileras:</td><td>    <input type='text' id='edeh' value='".$ar[13]."'></td></tr>";
	echo "<tr><td>% Machos:</td><td>                <input type='text' id='epm' value='".$ar[14]."'></td></tr>";
	echo "<tr><td>Observación:</td><td>             <input type='text' id='eo' value='".$ar[15]."'></td></tr>";
	echo "<tr><td colspan='2'><div id='btn_guar_edi_cuar' class='btn_color'>Guardar Cambio</td></tr></div>";
	echo "</table>";
	
	echo "Lista de Plantas:<br>";
	foreach($or as $ee){echo "<div>".$ee[1]."</div>";}
?>
<script>
$('#btn_guar_edi_cuar').bind('click',function(){
		alert('aaa');
	});
</script>
</body>
</html>