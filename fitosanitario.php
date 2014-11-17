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
	$('#h_fito').hide();
	$('#n_fito').hide();
	$('#op_exportadora').bind('change',function(e) {	
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findprod:$('select#op_exportadora').val()},
			success:function(re){ $('#op_prod').html(re);$('#h_fito').hide();	$('#n_fito').hide();	}
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
				$('#h_fito').hide();
				$('#n_fito').hide();
				}
			});
		$('#expo_um').show();
    });
    $('#op_cuar').bind('change',function(e) {
		sessionStorage['um']=this.value;
		$.ajax({
			url:'ingreso_fitosanitario.php',
			type:'POST',
			data:{cuar:$('select#op_cuar').val()},
			success:function(op){$('#h_fito').html(op);}
		});
		$('#h_fito').show();
		$('#n_fito').show();	
    });
    $('#btn_guardar').bind('click',function(){
    	if(($('#fecha').val()!='')&&($('select#fen').val()!=0))
    	{
    		$.ajax({
	    		url:'ingreso_fitosanitario.php',
	    		type:'post',
	    		data:{cuar:$('select#op_cuar').val(),fecha:$('#fecha').val(),ncom:$('#ncom').val(),iac:$('#iac').val(),cad:$('#cad').val(),obs:$('#obs').val(),est_f:$('select#fen').val()},
	    		beforeSend:function(){
					$('#ventana').show();
					$('#ventana').html('Enviando datos al Servidor');
				},
	    		success:function(a){
	    			$('#ventana').hide();
	    			$('#h_fito').html(a);
	    			$('#fecha').val('');
	    			$('#ncom').val('');
	    			$('#iac').val('');
	    			$('#cad').val('');
	    			$('#obs').val('');
	    			$('#fen').val('0');
	    		}
	    	});
    	}
    	else
    	{alert('Debe Ingresar Fecha y Estado Fenológico, para generar un evento Fitosanitario');}
	    	
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
		<div id="titulo_lab">Registro de Eventos Fitosanitarios</div>
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
        	<div id="expo_um" class="expo"><div class="etex">Cuartel :</div> <select id="op_cuar"></select></div>
		</div>
      <div id="h_fito" style='float:left;width:300px;height:140px;overflow:auto;'>
      </div>
   	<div style="clear:both;"></div>
   	<div id="n_fito" style="width:950px;height:290px;overflow:auto;">
   	Registrar nuevo evento Fitosanitario<br>
   	<table>
   	<tr><td>Fecha</td><td><input type="date" id="fecha" style="width:100px;"></td>
   	<td>Estado Fenológico</td><td>
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
		<tr><td>Nombre Comercial</td><td colspan="3"><input type="text" id="ncom" style="width:700px;"></td></tr>
		<tr><td>Ingrediente Activo</td><td colspan="3"><input type="text" id="iac" style="width:700px;"></td></tr>
		<tr><td>Carencia</td><td colspan="3"><input type="text" id="cad" style="width:700px;"></td></tr>
		<tr><td>Metodo de Aplicación<br>y Obervaciones</td><td colspan="3"><textarea id="obs" style="width:700px;height:55px"></textarea></td></tr>
		<tr><td></td><td colspan="3"><div id="btn_guardar">Guardar evento Fitosanitario</div></td></tr>	
		</table>
		</div>
	<?php
  }
else{echo "<a href='index.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
?> 
</body>
</html>