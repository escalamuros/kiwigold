<?php
	session_start();
	include("clasekiwi.php");
	$d=new basededatos();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script>
$(document).ready(function(){
	$('#h_fito').hide();
	$('#n_fito').hide();
	$('#opex').bind('change',function(e) {
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findprod:$('select#opex').val()},
			success:function(re){ $('#fprod').html(re);$('#h_fito').hide();	$('#n_fito').hide();	}
		});
		$('#expo_prod').show(100);
    });
    $('#fprod').bind('change',function(e) {
		$('#flab').html('');
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findcuar:$('select#fprod').val()},
			success:function(re){
				$('#flab').html(re);
				$('#h_fito').hide();
				$('#n_fito').hide();
				}
			});
		$('#expo_um').show(100);
    });
    $('#flab').bind('change',function(e) {
		$.ajax({
			url:'ingreso_labores.php',
			type:'POST',
			data:{cuar:$('select#flab').val()},
			success:function(op){$('#h_fito').html(op);}
		});
		$('#h_fito').show(100);
		$('#n_fito').show(100);	
    });
    $('#btn_guardar').bind('click',function(){
    	$.ajax({
    		url:'ingreso_labores.php',
    		type:'post',
    		data:{cuar:$('select#flab').val(),fecha:$('#fechaf').val(),prog:$('#progf').val(),metodo:$('#metodof').val(),ef:$('select#fen').val()},
    		success:function(a){$('#h_fito').html(a);$('#fechaf').val('');$('#progf').val('');$('#metodof').val('');}
    	});
    });
    $('#fen').bind('change',function(){
    	var a=$('select#fen').val();
    	$('#foto_fen').attr('src','img/if'+a+'.png');
    });
});   
</script>
</head>
<body>
<?php if(isset($_SESSION['id']))
{
?>
<div id="contenedor" style="color:#567;">
		<?php echo "<div class='id_prod' id='".$_SESSION['id']."'></div>" ?>
		<div id="titulo_lab">Registro de Labores No Quimicas</div>
		<div class="men_i">
			<div id="expo_lab" class="expo">
				<div class="etex">Exportadora :</div>
				<select name="opexpo" id="opex">
					<option>Seleccione</option>
					<?php
						$d->conexion();
						$ar=$d->lista_exportadores();
						foreach($ar as $v)
						{echo "<option value='".$v[0]."'>".$v[1]."</option>";}
						$d->desconexion();
					?>
				</select>
			</div>
        	<div id="expo_prod" class="expo"><div class="etex">Productor :</div> <select name="prodexpo" id="fprod"></select></div>
        	<div id="expo_um" class="expo"><div class="etex">Cuartel :</div> <select name="labexpo" id="flab"></select></div>
		</div>
      <div id="h_fito" style='float:left;width:300px;height:230px;overflow:auto;'>
      </div>
   	<div style="clear:both;"></div>
   	<div id="n_fito" style="width:950px;height:150px;overflow:auto;">
   	Registrar nueva Labor No Quimica<br>
   	<table>
   	<tr><td>Fecha</td><td><input type="date" id="fechaf" style="width:700px;"></td></tr>
   	<tr><td>Estado Fenologico</td><td>
   	<select id="fen">
   	<option value='0'>Seleccione</option>
   	<?php
   	$d->conexion();
   	$ar=$d->lista_estados_fenologicos();
		foreach($ar as $v)
		{echo "<option value='".$v[0]."'>".$v[1]."</option>";}
		$d->desconexion();
		?>
   	</select>
   	<img id='foto_fen' src='img/if0.png' width="50px"></td></tr>
		<tr><td>Programa</td><td><input type="text" id="progf" style="width:700px;"></td></tr>
		<tr><td>Metodo de Aplicación<br>y Obervaciones</td><td><textarea id="metodof" style="width:700px;height:55px"></textarea></td></tr>
		<tr><td></td><td><div id="btn_guardar">Guardar Labor No Quimica</div></td></tr>	
		</table>
		</div>
	<?php
  }
else{echo "<a href='index.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
?> 
</body>
</html>