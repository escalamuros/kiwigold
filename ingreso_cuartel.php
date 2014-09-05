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
	if(isset($_POST['prod']))
	{
		$c->agregar_cuartel_productor($_POST['prod'],$_POST['ano'],$_POST['nom'],$_POST['sup'],$_POST['nplan'],$_POST['z'],$_POST['d'],$_POST['nenc'],$_POST['fenc'],$_POST['eenc'],$_POST['geo'],$_POST['dth'],$_POST['deh'],$_POST['pm'],$_POST['o']);
	}
	$ar=$c->lista_cuarteles_productor($_POST['prod']);
	$c->desconexion();
	echo "Lista de Cuarteles asociado a la productora:<br>";
	foreach($ar as $v)	{echo "<div class='bit_cuartel btn_color' style='width:220px;margin-top:3px;' id='".$v[0]."'>".$v[1]."</div>";}
?>
<script>
$('.bit_cuartel').bind('click',function(){
		$.ajax({
			url:'recuperar_cuartel.php',
			type:'POST',
			data:{cuartel:$(this).attr('id')},
			success:function(asd){$('#form_edi_cuar').html(asd);}
		});
		$('#form_edi_cuar').show();
		$('#form_nu_cuar').hide();
	});
</script>
</body>
</html>