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
	if((isset($_POST['um']))&&(isset($_POST['prod'])))
	{
		$c->registrar_um($_POST['um'],$_POST['prod'],$_POST['cuartel'],$_POST['sup'],$_POST['ano'],$_POST['geo']);
	}
	$ar=$c->lista_todas_um_productor($_POST['prod']);
	$c->desconexion();
	if(is_array($ar))
	{
		echo "Lista de Unidades de Maduración:<br>";
		foreach($ar as $v)
		{
			echo "<div class='bit_um btn_color' style='width:220px;margin-top:3px;' id='".$v[0]."'>".$v[1];
			if($v[2]==1){echo "(Activa)";}else {echo "(Inactiva)";}
			echo "</div>";
		}
	}
?>
<script>
$('.bit_um').bind('click',function(){
	$.ajax({
		url:'editar_um.php',
		type:'POST',
		data:{um_elegida:$(this).attr('id')},
		success:function(o){$('#editar_um').html(o);}
	});
	$('#editar_um').show();
	$('#nuevo_um').hide();
});
</script>
</body>
</html>