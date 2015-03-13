<?php
	session_start();
	include("clasekiwi.php");
	$d=new basededatos();
	$d->conexion();
	$ar=$d->lista_exportadores();
	$d->desconexion();
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
	$('#n_um').hide();
	$('#nuevo_um').hide();
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
				$('#n_um').hide();
				$('#nuevo_um').hide();
				}
			});
		$('#expo_prod').show();
    });
    $('#fprod').bind('change',function(e) {
		sessionStorage['productor']=this.value;
		$.ajax({
			url:'ingreso_um.php',
			type:'POST',
			data:{prod:$('select#fprod').val()},
			success:function(a){$('#lista_um').html(a);}
		});
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{prod_elegido:$('select#fprod').val()},
			success:function(t){$('#ncuar').html(t);}
		});
		$('#lista_um').show();
		$('#editar_um').hide();
		$('#nuevo_um').hide();
		$('#n_um').show();
    });
    $('#n_um').bind('click',function(){
    	$('#nuevo_um').show();
    	$('#editar_um').hide();
    });
    $('#guar_n_um').bind('click',function(){
    	if(($('select#ncuar').val()=='0') || ($('select#ncuar').val()=='Seleccione'))
    	{
    		alert('No hay Cuarteles, o no ha seleccionado cuartel');
    	}
    	else
    	{
	    	$.ajax({
	    		url:'ingreso_um.php',
	    		type:'POST',
	    		data:{prod:$('select#fprod').val(),um:$('#num').val(),cuartel:$('select#ncuar').val(),sup:$('#nsup').val(),ano:$('#nano').val(),geo:$('#ngeo').val()},
	    		success:function(wa){$('#lista_um').html(wa);},
	    	});
	    	$('#nuevo_um').hide();
	    	alert('Unidad de Maduración Ingresada');
    	};
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
		<div id="titulo_lab"><img class='imgmenu' src='img/controlum.png' />Control de UM por Productor</div>
		<div class="men_i">
			<div id="expo_lab" class="expo">
				<div class="etex">Concesionaria :</div>
				<select name="opexpo" id="opex">
					<option>Seleccione</option>
					<?php
						foreach($ar as $v)
						{echo "<option value='".$v[0]."'>".$v[1]."</option>";}				
					?>
				</select>
			</div>
        	<div id="expo_prod" class="expo"><div class="etex">Productor :</div> <select name="prodexpo" id="fprod"></select></div>
        	<div id="n_um" class="btn_color" style="width:180px;margin-left:130px;">Generar Nueva UM</div>
		</div>
		<div style="clear:both;"></div>
		<div id='lista_um' style="float:left;width:400px;height:320px;overflow:auto;">
		lista
		</div>
		<div id="editar_um" style="width:400px;height:320px;float:left;">
		editar
		</div>
		<div id='nuevo_um' style="float:left;width:400px;height:320px;overflow:auto;">
		<table>
			<tr><td colspan="2">Nueva Unidad de Maduración</td></tr>
			<tr><td>Nombre:</td>            <td><input type="text" id="num"></td></tr>
			<tr><td>Cuartel:</td>           <td><select id="ncuar"></select></td></tr>
			<tr><td>Superficie:</td>        <td><input type="text" id="nsup"></td></tr>
			<tr><td>Año:</td>               <td><input type="text" id="nano"></td></tr>
			<tr><td>Geolocalización:</td>   <td><input type="text" id="ngeo"></td></tr>
			<tr><td colspan="2"><div class="btn_color" id='guar_n_um'>Guardar</div></td></tr>
			</table>
		</div>
   </div>
  <?php
  }
else{echo "<a href='index.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
?> 
</body>
</html>