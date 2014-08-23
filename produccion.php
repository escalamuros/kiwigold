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
	$('#prod_um').hide();
	$('#prod_prod').hide();
	$('#opex').bind('change',function(e) {	
		sessionStorage['exportadora']=this.value;
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findprod:this.value},
			success:function(re){		
				$('#fprod').html(re);
				$('#prod_um').hide();
				$('#prod_prod').hide();
				}
			});
		$('#expo_prod').show(100);
    });
    $('#fprod').bind('change',function(e) {
		sessionStorage['productor']=this.value;
		$('#flab').html('');
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findlab:this.value},
			success:function(re){
				$('#flab').html(re);
				$('#prod_um').hide();
				$('#prod_prod').show();
				}
			});
		$('#expo_um').show();
    });
    $('#flab').bind('change',function(e) {
		sessionStorage['um']=this.value;
		$('#prod_um').show();
		$('#prod_prod').hide();	
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
		<div id="titulo_lab">Registro de Producciones Por Productor o UM</div>
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
        	<div id="expo_um" class="expo"><div class="etex">Unidad de Medición :</div> <select name="labexpo" id="flab"></select></div>
		</div>
		<div style="float:left;width:350px;height:120px;overflow:auto;"></div>
		<div id="prod_prod" style="clear:both;">
			Producción del Productor<br>
			Fecha:<input type="date" id="f_p_p"><br>
			Toneladas: <input type="number" id="t_p_p"><br>
			Calibre: <input type="numbre" id="c_p_p"><br>
			<div class="btn_colo2">Guardar</div>
		</div>
      <div id="prod_um" style="clear:both;">
			Producción de la Unidad de Medición<br>
			Fecha:<input type="date" id="f_p_u"><br>
			Toneladas: <input type="number" id="t_p_u"><br>
			Calibre: <input type="numbre" id="c_p_u"><br>
			<div class="btn_colo2">Guardar</div>
		</div>
   </div>
  <?php
  }
else{echo "<a href='index.php' style='color:black'>Session cerrada, Reingrese</a>";}
?> 
</body>
</html>