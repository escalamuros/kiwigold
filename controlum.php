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
	$('#lista_um').hide();
	$('#editar_um').hide();
	$('#opex').bind('change',function(e) {	
		sessionStorage['exportadora']=this.value;
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findprod:this.value},
			success:function(re){		
				$('#fprod').html(re);
				$('#lista_um').hide();
				$('#editar_um').hide();
				}
			});
		$('#expo_prod').show();
    });
    $('#fprod').bind('change',function(e) {
		sessionStorage['productor']=this.value;
		$('#lista_um').show();
		$('#editar_um').show();
    });
    $('#guar_prod').bind('click',function(){
    	$.ajax({
    		url:'cambiar.php',
    		type:'POST',
    		data:{prod:$('select#fprod').val(),com:$('#com_p_p').val(),$fech:$('#f_p_p').val(),ton:$('#t_p_p').val(),cal:$('#c_p_p').val()},
    		success:function(wa){$('#his_prod').html(wa);},
    	});
    	alert('exito');
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
		<div id="titulo_lab">Control de UM por Productor</div>
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
		</div>
		<div style="clear:both;"></div>
		<div id='lista_um' style="float:left;width:400px;height:320px;overflow:auto;">
		lista
		</div>
		<div id="editar_um" style="width:400px;height:320px;float:left;">
			<table>
			<tr><td colspan="2">Producción del Productor</td></tr>
			<tr><td>Fecha:</td>     <td><input type="date" id="f_p_p"></td></tr>
			<tr><td>Comercializadora:</td>     <td><input type="text" id="com_p_p"></td></tr>
			<tr><td>Toneladas:</td> <td><input type="number" id="t_p_p"></td></tr>
			<tr><td>Calibre:</td>   <td><input type="numbre" id="c_p_p"></td></tr>
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