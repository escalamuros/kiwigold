<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
if(isset($_SESSION['id']))
{
	if($_SESSION['nivel']=='4')
	{
		if($_SESSION['empresa']==0){echo "No es productor, o no tiene asignada una productora";}
		else
		{
			include_once('clasekiwi.php');
			$c=new basededatos();
			//$c->conexion();
			//$resp=$c->recuperar_cuartel($_POST['um']);
			//$c->desconexion();
			echo "<div style='float:left;width:350px;'>";
			echo "lista de Laboratorios";
			echo "</div>";
			echo "<div id='resumen' style='float:left;margin-left:8px;width:500px;'>";
			echo "</div>";	
		}
	}
}
else
{echo "<a href='login.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
?>
<script>
$('.bot_lab').bind('click',function(){
		$.ajax({
			url:'recibeajax.php',
			type:'ṔOST',
			data:,
			success:function(){}
		});
	});
</script>
</body>
</html>
