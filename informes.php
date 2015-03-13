<?php session_start();include_once "clasekiwi.php";
$d=new basededatos();
$d->conexion();
$ar=$d->lista_exportadores();
$lis=$d->lista_prod_y_exp();
$d->desconexion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/formato.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
	$('.prod').bind('click',function(){
		$.ajax({url:'informe_productora.php',
			type:'POST',
			data:{elegido:$(this).attr('id')},
			success:function(uk){$('#cont_productores').html(uk);}
		});
	});
});
</script>
</head>
<body>
<div id="titulo_lab"><img class='imgmenu' src='img/informes.png' />Lista de Productores, para Informes</div>
<?php
if(isset($_SESSION['id']))
{
	if(($_SESSION['nivel']=='1')||($_SESSION['nivel']=='5'))
	{
		?>
		<div id="cont_productores">
		<div id='list_prod' style='width:500px;'>
		<?php
		$a='0';
		foreach($lis as $p)
		{
			if($p[0]!=$a){$a=$p[0];echo "<div class='tit_expo'>Concesionaria ".$p[0]."</div>";}
			echo "<div class='prod' id='".$p[1]."'>".$p[2]."</div>";
		}
		?>
		</div>
		<div style="margin-left:5px;"><a href="informe_todo_excel.php"><img src='./img/excel_logo.png' width="30px">Archivo Exel General</a></div>
		<?php
	}
	else
	{
		 echo "	No tiene nivel de acceso a Informes<br>";
	}
}
else
{
	echo "<a href='index.php' style='color:black'>Sesión cerrada, Reingrese</a>";
}
?>
</body>
</html>