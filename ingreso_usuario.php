<?php
	require_once 'clasekiwi.php';
	$c=new basededatos();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script>
$('.c_usu').bind('click',function()
{
	$.ajax({url:'usuario_esp.php',
		type:'POST',
		data:{elegido:$(this).attr('id')},
		success:function(uk){$('#conten_usuario').html(uk);}
	})
});
</script>
</head>
<body>
<?php 
	if(isset($_POST['nom']))
	{
		$c->conexion();
		$c->registrar_usuario($_POST['nom'],$_POST['usu'],$_POST['pass'],$_POST['niv'],$_POST['emp']);
		$ar=$c->lista_usuarios();
		$c->desconexion();
		echo "Lista de Usuarios(para Editar)<br>";
		$a='0';
		foreach($ar as $p)
		{
			if($p[3]=='0'){
				if($a!=$p[2]){echo "<div style='background:blue;color:white;'>".$p[2]."</div>";$a=$p[2];}
				echo "<div class='c_usu' id='".$p[0]."'>".$p[1]."</div>";}
			else
			{
				if($a!=$p[3]){$a=$p[3];echo "<div style='background:blue;color:white;'>Observador ".$a."</div>";}
				echo "<div class='c_usu' id='".$p[0]."'>".$p[1]."</div>";
			}
		}
	}
?>
</body>
</html>