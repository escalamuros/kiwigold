<?php session_start();include_once ("clasekiwi.php");$d=new basededatos();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script>
$(document).ready(function(){
	$('#txt_exp').hide();
	$('#expo_prod').hide();
	$('#opex').bind('change',function(e) {	
		sessionStorage['exportadora']=this.value;
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findprod:this.value},
			success:function(re){ $('#fprod').html(re);$('#h_fito').hide();	$('#n_fito').hide();	}
		});
		$('#expo_prod').show(100);
    });
    $('#fprod').bind('change',function(e) {
    	sessionStorage['productor']=this.value;
		$('#emp').val($('select#fprod').val());		
    });
	$('#niv').bind('change',function(){
		if($('select#niv').val()==4){$('#txt_exp').show();}
		else{$('#txt_exp').hide();$('#expo_prod').hide();$('#emp').val('0');}
	});
	$('#ingresa_usuario').bind('click',function(){
		var e=$('#emp').val();
		$.ajax({
			url:'ingreso_usuario.php',
			type:'POST',
			data:{nom:$('#nom').val(),usu:$('#usr').val(),pass:$('#pass').val(),niv:$('#niv').val(),emp:$('#emp').val()},
			success:function(a){$('#list_usu').html(a);}});
	});
	$('.c_usu').bind('click',function()
	{
		$.ajax({url:'usuario_esp.php',
			type:'POST',
			data:{elegido:$(this).attr('id')},
			success:function(uk){$('#conten_usuario').html(uk);}
		})
	});
});
</script>
</head>
<body>
<?php
if(isset($_SESSION['id']))
{
	if($_SESSION['nivel']=='1')
	{?>
	<div id="conten_usuario">
		<div id='list_usu' style="float:left;width:450px;scroll:auto;height:470px;">
			<?php 
			$d->conexion();
			$arr=$d->lista_usuarios();
			echo "<div class='lista_usu'>Edición de Usuarios</div><br>";
			$a='0';
			foreach($arr as $p)
			{
				if($p[3]=='0'){
					if($a!=$p[2]){echo "<div class='btn_color' >".$p[2]."</div>";$a=$p[2];}
					echo "<div class='c_usu' id='".$p[0]."'>".$p[1]."</div>";}
				else
				{
					if($a!=$p[3]){$a=$p[3];echo "<div class='btn_color'>Observador ".$a."</div>";}
					echo "<div class='c_usu' id='".$p[0]."'>".$p[1]."</div>";
				}
			}
			?>
		</div>
		<div style="float:left;width:450px;height:470px;margin-left:40px;">
			Ingreso Nuevo Usuario<br>
			<table>
			<tr><td>Nombre:</td><td><input type="text" id="nom"></td></tr>
			<tr><td>Usuario:</td><td><input type="text" id="usr"></td></tr>
			<tr><td>Password:</td><td><input type="text" id="pass"></td></tr>
			<tr><td>Nivel:</td><td><select id="niv">
			<option value="1">Administrador</option>
			<option value="2">Supervisor</option>
			<option value="3">Digitador</option>
			<option value="4">Observador</option>
			<option value="5">Directorio</option>
			</select></td></tr>
			</table>
			<input type="hidden" id="emp" value="0">
				<div id="txt_exp">Exportadora :
					<select name="opexpo" id="opex">
						<option>Seleccione</option>
						<?php
							
							$ar=$d->lista_exportadores();
							foreach($ar as $v)
							{echo "<option value='".$v[0]."'>".$v[1]."</option>";}
							$d->desconexion();
						?>
					</select>
				</div>
	        	<div id="expo_prod" class="expo"><div class="etex">Productor :</div> <select name="prodexpo" id="fprod"></select></div>
			<div class='btn_color' id="ingresa_usuario">Ingresar Nuevo Usuario</div>
		</div>
	</div>
	<?php
	}
	else
	{?>
No tiene premiso para Mantenedor de Usuarios<br>
	<?php
	}
}
else{echo "<a href='index.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
?>
</body>
</html>