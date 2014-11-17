<?php
	session_start();
	include("clasekiwi.php");
	$d=new basededatos();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- <script src="js/jquery.js"></script> -->
<script>
$(document).ready(function(){
	$('#ventana').hide();
	$('#prod_proy').hide();
	$('#hist_proy').hide();
	$('#expo_proy').hide();
	$('#expo_cuar').hide();
	$('#op_exportadora').bind('change',function(e) {	
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findprod:$('select#op_exportadora').val()},
			beforeSend:function(){
				$('#ventana').show();
				$('#ventana').html('Enviando consulta al Servidor');
			},
			success:function(re){	
				$('#ventana').hide();	
				$('#op_productora').html(re);
				$('#prod_proy').hide();
				$('#hist_proy').hide();
				$('#expo_cuar').hide();
				}
			});
		$('#expo_proy').show();
    });
    $('#op_productora').bind('change',function(e) {
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findcuar:$('select#op_productora').val()},
			beforeSend:function(){
				$('#ventana').show();
				$('#ventana').html('Enviando consulta al Servidor');
			},
			success:function(dev){
				$('#ventana').hide();
				$('#op_cuartel').html(dev);
				$('#expo_cuar').show();
				$('#prod_prod').hide();
				$('#hist_proy').hide();	
			}
		});
    });
    $('#op_cuartel').bind('change',function(e) {
		$.ajax({
			url:'ingreso_proyeccion.php',
			type:'POST',
			data:{cuar:$('select#op_cuartel').val()},
			beforeSend:function(){
				$('#ventana').show();
				$('#ventana').html('Enviando consulta al Servidor');
			},
			success:function(re){
				$('#ventana').hide();
				$('#hist_proy').html(re);
				$('#prod_proy').show();
				$('#hist_proy').show();
				}
			});
    });
    $('#guar_proy').bind('click',function(){
    	if(($('#f_p_p').val()!='')&&($('#t_p_p').val()!='')&&($('#c_p_p').val()!=''))
    	{
	    	$.ajax({
	    		url:'ingreso_proyeccion.php',
	    		type:'POST',
	    		data:{cuar:$('select#op_cuartel').val(),fech:$('#f_p_p').val(),ton:$('#t_p_p').val(),cal:$('#c_p_p').val()},
	    		beforeSend:function(){
					$('#ventana').show();
					$('#ventana').html('Enviando datos al Servidor');
				},
	    		success:function(wa){
	    			$('#ventana').hide();
	    			$('#hist_proy').html(wa);
	    			$('#f_p_p').val('');
	    			$('#t_p_p').val('');
	    			$('#c_p_p').val('');
	    		}
	    	});
    	}
    	else {alert('Faltan Datos, Llene todo los campos');}
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
		<div id="titulo_lab">Registro de Proyecciones Por Productor</div>
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
        	<div id="expo_proy" class="expo"><div class="etex">Productor :</div> <select id="op_productora"></select></div>
        	<div id="expo_cuar" class="expo"><div class="etex">Cuartel :</div> <select id="op_cuartel"></select></div>
		</div>
		<div id='hist_proy' style="float:left;width:370px;height:220px;overflow:auto;"></div>
		<div id="prod_proy" style="clear:both;">
			<table>
			<tr><td colspan="2">Proyección del Productor</td></tr>
			<tr><td>Fecha:</td>            <td><input type="date" id="f_p_p"></td></tr>
			<tr><td>Toneladas:</td>        <td><input type="text" id="t_p_p"></td></tr>
			<tr><td>Calibre:</td>          <td><input type="text" id="c_p_p"></td></tr>
			<tr><td colspan="2"><div class="btn_color" id='guar_proy'>Guardar</div></td></tr>
			</table>
		</div>
   </div>
  <?php
  }
else{echo "<a href='index.php' style='color:black'>Session cerrada, Reingrese</a>";}
?> 
</body>
</html>