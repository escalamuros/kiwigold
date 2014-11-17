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
	if((isset($_POST['prod']))&&(isset($_POST['ano'])))
	{
		$c->agregar_cuartel_productor($_POST['prod'],$_POST['ano'],$_POST['nom'],$_POST['sup'],$_POST['nplan'],$_POST['z'],$_POST['d'],$_POST['nenc'],$_POST['fenc'],$_POST['eenc'],$_POST['geo'],$_POST['dth'],$_POST['deh'],$_POST['pm'],$_POST['t'],$_POST['c'],$_POST['o']);
	}
	$ar=$c->lista_cuarteles_productor($_POST['prod']);
	$c->desconexion();
	echo "Lista de Cuarteles asociado a la productora:<br>";
	echo "<table>";
		if(is_array($ar))
		{
			foreach($ar as $v)
			{
				echo "<tr><td>";
				echo "<div class='bit_cuartel btn_color' style='width:230px;' id='".$v[0]."'>".$v[1]."</div>";
				echo "</td><td>";
				echo "<div style='width:20px;' class='elim_cuar btn_color' id='e".$v[0]."'>X</div>";
				echo "</td></tr>";
			}
		}
		echo "</table>";
?>
<script>
$('.bit_cuartel').bind('click',function(){
		$.ajax({
			url:'editar_cuartel.php',
			type:'POST',
			data:{cuartel:$(this).attr('id')},
			success:function(asd){$('#form_edi_cuar').html(asd);}
		});
		$('#form_edi_cuar').show();
		$('#form_nu_cuar').hide();
	});
$('.elim_cuar').bind('click',function(){
	var e_c=$(this).attr('id').substring(1);
	if(confirm('Eliminar Cuartel, conlleva a eliminación de Unidades de Maduración Asociados, ademas de Labores, Fitosanitario y Laboratorio.\nEsta seguro?'))
	{
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{eliminar_cuar:e_c},
			success:function(){alert('Cuartel Eliminado');}
		});
		$.ajax({
			url:'ingreso_cuartel.php',
			type:'POST',
			data:{prod:$('#prod_id').val()},
			success:function(oi){$('#lis_cuarteles').html(oi);$('#form_edi_cuar').hide();$('#form_nu_cuar').hide();},
		});
	};
});
</script>
</body>
</html>