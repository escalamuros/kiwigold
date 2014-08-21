<?php
	require('clasekiwi.php');
	$c=new basededatos();
?>
<html>
<head>
<script>
$('.mod').hide();
$(document).ready(function(){
	$('#btn_cam_est').bind('click',function(){
		$('.mod').hide();
		$.ajax({url:'recibeajax.php',type:'POST',data:{cam_est_usu:$('#idd').val(),estado:$('#est').html()},success:function(eq){$('#est').html(eq)}});
	});
	$('#btn_cam_pass').bind('click',function(){
		$('.mod').hide();
		$('#cam_pass').show();
	});
	$('#guar_pass').bind('click',function(){
		$('.mod').hide();
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{cam_pass_usu:$('#idd').val(),estado:$('#n_pass').val()},
			success:function(a){$('#ppp').html(a);$('#n_pass').val('')}
		});
	});
	$('#btn_cam_nom').bind('click',function(){
		$('.mod').hide();
		$('#cam_nom').show();
	});
	$('#guar_nom').bind('click',function(){
		$('.mod').hide();
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{cam_nom_usu:$('#idd').val(),estado:$('#n_nom').val()},
			success:function(a){$('#nnn').html(a);$('#n_nom').val('')}
		});
	});
	$('#btn_cam_usr').bind('click',function(){
		$('.mod').hide();
		$('#cam_usr').show();
	});
	$('#guar_usr').bind('click',function(){
		$('.mod').hide();
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{cam_usr_usu:$('#idd').val(),estado:$('#n_usr').val()},
			success:function(a){$('#uuu').html(a);$('#n_usr').val('')}
		});
	});
	
});
</script>
</head>
<body>
<?php
	if(isset($_POST['elegido']))
	{
		$c->conexion();
		$lis=$c->recuperar_usuario($_POST['elegido']);
		$lll=$c->rec_nivel($lis[4]);
		echo "<input type='hidden' id='idd' value='".$lis[0]."' >";
		echo "<div id='a' style='float:left;width:400px;'>";
		echo "Datos Del Usuario<br>";
		echo "<table>";
		echo "<tr><td>Nombre</td><td id='nnn'>".$lis[1]."</td><td class='btn_color' id='btn_cam_nom'>Cambiar</td></tr>";
		echo "<tr><td>Usuario</td><td id='uuu'>".$lis[2]."</td><td class='btn_color' id='btn_cam_usr'>Cambiar</td></tr>";
		echo "<tr><td>Password</td><td id='ppp'>".$lis[3]."</td><td class='btn_color' id='btn_cam_pass'>Cambiar</td></tr>";
		echo "<tr><td>Nivel</td><td>".$lll[0]."</td><td>".$lll[1]."</td></tr>";
		if($lis[5]!=0) 
		{
		echo "<tr><td>Empresa</td><td colpan='2'>".$c->rec_empresa($lis[5])."</td></tr>";
		}
		switch($lis[6]){case 0: $l='Activo';break;case 1: $l='Inactivo';break;}
		echo "<tr><td>Estado</td><td id='est'>".$l."</td><td class='btn_color' id='btn_cam_est' >Cambiar</td></tr>";
		echo "</table>";
		echo "</div>";
		echo "<div class='mod' id='cam_nom' >";
		echo "Nuevo Nombre: <input type='text' id='n_nom'><div class='btn_color' id='guar_nom' >Guardar</div>";
		echo "</div>";
		echo "<div class='mod' id='cam_usr' >";
		echo "Nuevo Usuario: <input type='text' id='n_usr'><div class='btn_color' id='guar_usr' >Guardar</div>";
		echo "</div>";
		echo "<div class='mod' id='cam_pass' >";
		echo "Nueva Password: <input type='text' id='n_pass'><div class='btn_color' id='guar_pass' >Guardar</div>";
		echo "</div>";
		echo "<div class='mod' id='cam_emp' ></div>";
		$c->desconexion();
	}
?>
</body></html>