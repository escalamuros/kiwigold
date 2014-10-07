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
			$c->conexion();
			$l_cuar=$c->lista_cuarteles_productor($_SESSION['empresa']);
			echo "<div style='float:left;width:350px;'>";
			echo "lista de Laboratorios, por cuarteles";
			echo "<table>";
			foreach($l_cuar as $a)
			{
				echo "<tr><td colspan='3'>Cuartel: ".$a[1]."</td></tr>";
				echo "<tr><td>Fecha Muestreo</td><td>Fecha Analisis</td><td>observación</td></tr>";
				$l_f=$c->lista_ultimos10_fan($a[0]);
				foreach($l_f as $b)
				{
					echo "<tr><td>".$b[0]."</td><td>".$b[1]."</td><td>".$b[2]."</td></tr>";
				}
			}
			$c->desconexion();
			echo "</table>";
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
//$('.bot_lab').bind('click',function(){
//		$.ajax({
//			url:'recibeajax.php',
//			type:'ṔOST',
//			data:,
//			success:function(){}
//		});
//	});
</script>
</body>
</html>
