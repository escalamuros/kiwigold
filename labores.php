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
	$('#ventana').hide();
	$('#h_labores').hide();
	$('#n_labores').hide();
	$('#expo_cuart').hide();
	$('#op_exportadora').bind('change',function(e) {
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findprod:$('select#op_exportadora').val()},
			success:function(re){ $('#op_prod').html(re);$('#h_labores').hide();	$('#n_labores').hide();	}
		});
		$('#expo_prod').show();
    });
    $('#op_prod').bind('change',function(e) {
		$('#op_cuar').html('');
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findcuar:$('select#op_prod').val()},
			success:function(re){
				$('#op_cuar').html(re);
				$('#h_labores').hide();
				$('#n_labores').hide();
				}
			});
		$('#expo_cuart').show();
    });
    $('#op_cuar').bind('change',function(e) {
		$.ajax({
			url:'ingreso_labores.php',
			type:'POST',
			data:{cuar:$('select#op_cuar').val()},
			success:function(op){$('#h_labores').html(op);}
		});
		$('#h_labores').show();
		$('#n_labores').show();	
    });
    $('#btn_guardar').bind('click',function(){
    	if(($('#fechal').val()!='')&&($('select#fen').val()!='0'))
    	{
	    	$.ajax({
	    		url:'ingreso_labores.php',
	    		type:'post',
	    		data:{cuar:$('select#op_cuar').val(),fecha:$('#fechal').val(),prog:$('#progl').val(),metodo:$('#metodol').val(),ef:$('select#fen').val()},
	    		beforeSend:function(){
					$('#ventana').show();
					$('#ventana').html('Enviando datos al Servidor');
				},
	    		success:function(a){
	    			$('#ventana').hide();
	    			$('#h_labores').html(a);
	    			$('#fechal').val('');
	    			$('#progl').val('');
	    			$('#metodol').val('');
	    			$('#fen').val('0');
	    		}
	    	});
	   }
	   else
	   {
	   	alert('Debe Ingresar Fecha y Estado Fenológico, para generar nueva Labor no quimica');
	   }
    });
    $('#fen').bind('change',function(){
    	var a=$('select#fen').val();
    	$('#foto_fen').attr('src','img/if'+a+'.png');
    });
});   
</script>
</head>
<body>
<div id="ventana" style="position:absolute;z-index:100;margin 0 auto 0 auto;background-color:white;"></div>
<?php if(isset($_SESSION['id']))
{
?>
<div id="contenedor" style="color:#567;">
		<?php echo "<div class='id_prod' id='".$_SESSION['id']."'></div>" ?>
		<div id="titulo_lab">Registro de Labores No Quimicas</div>
		<div class="men_i">
			<div id="expo_lab" class="expo">
				<div class="etex">Concesionaria :</div>
				<select id="op_exportadora">
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
        	<div id="expo_prod" class="expo"><div class="etex">Productor :</div> <select id="op_prod"></select></div>
        	<div id="expo_cuart" class="expo"><div class="etex">Cuartel :</div> <select id="op_cuar"></select></div>
		</div>
      <div id="h_labores" style='float:left;width:300px;height:140px;overflow:auto;'>
      </div>
   	<div style="clear:both;"></div>
   	<div id="n_labores" style="width:950px;height:290px;overflow:auto;">
   	Registrar nueva Labor No Quimica<br>
   	<table>
   	<tr><td>Fecha</td><td><input type="date" id="fechal" style="width:700px;"></td></tr>
   	<tr><td>Estado Fenológico</td><td>
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
		<tr><td>Programa</td><td><input type="text" id="progl" style="width:700px;"></td></tr>
		<tr><td>Metodo de Aplicación<br>y Obervaciones</td><td><textarea id="metodol" style="width:700px;height:55px"></textarea></td></tr>
		<tr><td></td><td><div id="btn_guardar">Guardar Labor No Quimica</div></td></tr>	
		</table>
		</div>
	<?php
  }
else{echo "<a href='index.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
?> 
</body>
</html>