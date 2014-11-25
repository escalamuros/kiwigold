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
		$l_c=$c->lista_cuarteles_productor($ar[2]);
		echo "<input type='hidden' id='um_modificar' value='".$ar[0]."'>";
		$c->desconexion();
		echo "<table>";
		echo "<tr><td colspan='2'>Datos y Edición de Unidad de Maduración</td></tr>";
		echo "<tr><td>Nombre</td><td><input id='nom_um' type='text' value='".$ar[1]."'></td></tr>";
		echo "<tr><td>Cuartel</td><td>";
		echo "<select id='cuartel_um'>";
		foreach($l_c as $cu){
			if($ar[3]==$cu[0]){echo "<option value='".$cu[0]."' selected='selected'>".$cu[1]."</option>";}
			else{echo "<option value='".$cu[0]."' >".$cu[1]."</option>";}
		}
		echo "</select></td></tr>";
		echo "<tr><td>Superficie</td><td><input type='text' id='sup_um' value='".$ar[4]."'></td></tr>";
		echo "<tr><td>Año</td><td><input type='text' id='ano_um' value='".$ar[5]."'></td></tr>";
		echo "<tr><td>Geolocalización</td><td><input type='text' id='geo_um' value='".$ar[6]."'></td></tr>";
		echo "<tr><td>Estado</td><td><div class='btn_color' id='c_estado_um'>";
		if($ar[7]==1){echo "Activa";}else{echo "Inactiva";}
		echo "</div></td></tr>";
		echo "<tr><td colspan='2'><div class='btn_color' id='guar_edi_um'>Guardar Cambios</div></td></tr>";
		echo "</table>";
	}
?>
<script>
$('#guar_edi_um').bind('click',function(){
	$.ajax({
		url:'recibeajax.php',
		type:'POST',
		data:{editar_um:$('#um_modificar').val(),nombre:$('#nom_um').val(),cuartel:$('#cuartel_um').val(),sup:$('#sup_um').val(),ano:$('#ano_um').val(),geo:$('#geo_um').val()},
		success:function(){alert('Cambios Aceptados');}
	});
	$('#editar_um').hide();
});
$('#c_estado_um').bind('click',function(){
	$.ajax({
		url:'recibeajax.php',
		async:false,
		type:'POST',
		data:{cambia_estado_um:$('#um_modificar').val()},
		success:function(f){$('#c_estado_um').html(f);}
	});
	$.ajax({
		url:'ingreso_um.php',
		async:false,
		type:'POST',
		data:{prod:$('select#fprod').val()},
		success:function(a){$('#lista_um').html(a);}
	});
});
</script>
</body>
</html>