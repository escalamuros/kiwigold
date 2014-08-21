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
		$('#flab').html('');
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findlab:this.value},
			success:function(re){
				$('#flab').html(re);
				$('#h_fito').hide();
				$('#n_fito').hide();
				}
			});
		$('#expo_um').show(100);
    });
    $('#flab').bind('change',function(e) {
		sessionStorage['um']=this.value;
		$.ajax({
			url:'lista10_fitosanitario.php',
			type:'POST',
			data:'&um='+$('select#flab').val(),
			success:function(op){$('#h_fito').html(op);}
		});
		$('#h_fito').show(100);
		$('#n_fito').show(100);	
    });
    $('#btn_guardar').bind('click',function(){
    	$.ajax({
    		url:'ingreso_fitosanitario.php',
    		type:'post',
    		data:{um:$('select#flab').val(),fecha:$('#fechaf').val(),prog:$('#progf').val(),metodo:$('#metodof').val()},
    		success:function(a){$('#h_fito').html(a);}
    	});
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
		<div id="titulo_lab">Registro de Eventos Fitosanitarios</div>
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
        	<div id="expo_um" class="expo"><div class="etex">Unidad de Maduración :</div> <select name="labexpo" id="flab"></select></div>
		</div>
      <div id="h_fito" style='float:left;width:404px;height:250px;'>
      </div>
   	<div style="clear:both;"></div>
   	<div id="n_fito" style="width:950px;height:150px;">
   	Registrar nuevo evento Fitosanitario<br>
   	<table>
   	<tr><td>Fecha</td><td><input type="date" id="fechaf" style="width:700px;"></td></tr>
		<tr><td>Programa</td><td><input type="text" id="progf" style="width:700px;"></td></tr>
		<tr><td>Metodo de Aplicación<br>y Obervaciones</td><td><textarea id="metodof" style="width:700px;height:55px"></textarea></td></tr>
		<tr><td></td><td><div id="btn_guardar">Guardar evento Fitosanitario</div></td></tr>	
		</table>
		</div>
	<?php
  }
else{echo "<a href='index.php' style='color:black'>Session cerrada, Reingrese</a>";}
?> 
</body>
</html>