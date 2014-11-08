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
	if((isset($_POST['cuar']))&&(isset($_POST['fech'])))
	{
		$c->ingresa_proyeccion($_POST['cuar'],$_POST['fech'],$_POST['ton'],$_POST['cal']);
	}
	if(isset($_POST['elim_proy']))
	{
		$c->elim_proy($_POST['elim_proy']);
	}
	$ar=$c->lista_ultimos10_proy($_POST['cuar']);
	$c->desconexion();
	echo "Últimas Proyecciones Registradas";
	echo "<table>";
	echo "<tr><td>Fecha</td><td>Toneladas</td><td>Calibre</td><td>Eliminar</td></tr>";
	foreach($ar as $p)
	{
		echo "<tr><td>".$p[1]."</td><td>".$p[2]."</td><td>".$p[3]."</td><td><img class='elim' id='".$p[0]."-".$_POST['cuar']."' src='./img/cruz.png'></td></tr>";
	}
	echo "</table>";
?>
<script>
$('.elim').bind('click',function(){
	var pos=$(this).attr('id').indexOf('-');
	var id=$(this).attr('id').substr(0,pos);
	var cuart=$(this).attr('id').substr(pos+1);
	$.ajax({
			url:'ingreso_proyeccion.php',
			type:'POST',
			data:{elim_proy:id,cuar:cuart},
			success:function(wa){$('#hist_prod').html(wa);}
		});
});
</script>
</body>
</html>