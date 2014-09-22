<?php
	require_once 'clasekiwi.php';
	$c=new basededatos();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script>
$('.prod').bind('click',function()
{
	$.ajax({url:'productora_esp.php',
		type:'POST',
		data:{elegido:$(this).attr('id')},
		success:function(uk){$('#cont_productores').html(uk);}
	})
});
</script>
</head>
<body>
<?php 
	if(isset($_POST['expo']))
	{
		$c->conexion();
		$c->registrar_productora($_POST['expo'],$_POST['rs'],$_POST['nombre'],$_POST['rut'],$_POST['giro'],$_POST['fono'],$_POST['dir'],$_POST['mail'],$_POST['rl'],$_POST['rutr'],$_POST['fonor'],$_POST['mailr'],$_POST['agro'],$_POST['amail']);
		$lis=$c->lista_prod_y_exp();
		$c->desconexion();
		$a='0';
		echo $_POST['expo']."<br>";
		foreach($lis as $p)
		{
			if($p[0]!=$a){$a=$p[0];echo "<div class='tit_expo'>Exportadora ".$p[0]."</div>";}
			echo "<div class='prod' id='".$p[1]."'>".$p[2]."</div>";
		}
	}
?>
</body>
</html>