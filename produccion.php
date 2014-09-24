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
	$('#prod_prod').hide();
	$('#hist_prod').hide();
	$('#expo_prod').hide();
	$('#expo_cuar').hide();
	$('#opex').bind('change',function(e) {	
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findprod:$('select#opex').val()},
			success:function(re){		
				$('#fprod').html(re);
				$('#prod_prod').hide();
				$('#hist_prod').hide();
				$('#expo_cuar').hide();
				}
			});
		$('#expo_prod').show();
    });
    $('#fprod').bind('change',function(e) {
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findcuar:$('select#fprod').val()},
			success:function(dev){
				$('#fcuar').html(dev);
				$('#expo_cuar').show();
				$('#prod_prod').hide();
				$('#hist_prod').hide();	
			}
		});
    });
    $('#fcuar').bind('change',function(e) {
		$.ajax({
			url:'ingreso_produccion.php',
			type:'POST',
			data:{cuar:$('select#fcuar').val()},
			success:function(re){
				$('#hist_prod').html(re);
				$('#prod_prod').show();
				$('#hist_prod').show();
				}
			});
    });
    $('#guar_prod').bind('click',function(){
    	$.ajax({
    		url:'ingreso_produccion.php',
    		type:'POST',
    		data:{cuar:$('select#fcuar').val(),fech:$('#f_p_p').val(),com:$('#com_p_p').val(),ton:$('#t_p_p').val(),cal:$('#c_p_p').val()},
    		success:function(wa){$('#hist_prod').html(wa);},
    	});
    	$('#f_p_p').val('');
    	$('#com_p_p').val('');
    	$('#t_p_p').val('');
    	$('#c_p_p').val('');
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
		<div id="titulo_lab">Registro de Producciones Por Productor</div>
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
        	<div id="expo_prod" class="expo"><div class="etex">Productor :</div> <select id="fprod"></select></div>
        	<div id="expo_cuar" class="expo"><div class="etex">Cuartel :</div> <select id="fcuar"></select></div>
		</div>
		<div id='hist_prod' style="float:left;width:370px;height:220px;overflow:auto;"></div>
		<div id="prod_prod" style="clear:both;">
			<table>
			<tr><td colspan="2">Producción del Productor</td></tr>
			<tr><td>Fecha:</td>            <td><input type="date" id="f_p_p"></td></tr>
			<tr><td>Comercializadora:</td> <td><input type="text" id="com_p_p"></td></tr>
			<tr><td>Toneladas:</td>        <td><input type="text" id="t_p_p"></td></tr>
			<tr><td>Calibre:</td>          <td><input type="text" id="c_p_p"></td></tr>
			<tr><td colspan="2"><div class="btn_color" id='guar_prod'>Guardar</div></td></tr>
			</table>
		</div>
   </div>
  <?php
  }
else{echo "<a href='index.php' style='color:black'>Session cerrada, Reingrese</a>";}
?> 
</body>
</html>