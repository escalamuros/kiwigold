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
	$('#lat').hide();
	$('#opex').bind('change',function(e) {	
		sessionStorage['exportadora']=this.value;
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findprod:this.value},
			success:function(re){		
				$('#fprod').html(re);
				$('#edo_fen').hide();
				$('#lat').hide();
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
				$('#edo_fen').hide();
				$('#lat').hide();
				}
			});
		$('#expo_um').show();
    });
    $('#flab').bind('change',function(e) {
		sessionStorage['um']=this.value;
		$.ajax({
			url:'lista10_fenologicos.php',
			type:'POST',
			data:'&um='+$('select#flab').val(),
			success:function(op){$('#lat').html(op);}
		});
		$('#edo_fen').show();
		$('#lat').show();	
    });
    $('.boxfen').bind('click',function(e){
    	if($('#fe').val()==''){alert('Debe Indicar una Fecha, para poder registrar el Evento Fenológico');}
    	else
    	{
    		$.ajax({
    			url:'ingreso_fenologico.php',
    			type:'POST',
    			data:{um:$('select#flab').val(),estado:$(this).attr('id'),fecha:$('#fe').val()},
    			success:function(re){$('#lat').html(re);}
    		});
    	}
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
		<div id="titulo_lab">Registro Estados Fenológicos Jintao</div>
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
		<div id='lat' style="float:left;width:350px;height:120px;overflow:auto;">
		</div>
      <div id="edo_fen">
      	Fecha :<input id="fe" type="date">
      	<div class="boxfen" id="fen1"><img src="img/if1.png"   class="img_f" /><div class="tfe">Yema Hinchada</div> <div class="itfe"></div></div>
       	<div class="boxfen" id="fen2"><img src="img/if2.png"   class="img_f" /><div class="tfe">Yema Algodonosa</div><div class="itfe"></div></div>
       	<div class="boxfen" id="fen3"><img src="img/if3.png"   class="img_f" /><div class="tfe">Puntas Verdes</div><div class="itfe"></div></div>
       	<div class="boxfen" id="fen4"><img src="img/if4.png"   class="img_f" /><div class="tfe">Hojas Visibles</div><div class="itfe"></div></div>
       	<div class="boxfen" id="fen5"><img src="img/if5.png"   class="img_f" /><div class="tfe">Botones Separados</div><div class="itfe"></div></div>
       	<div class="boxfen" id="fen6"><img src="img/if6.png"   class="img_f" /><div class="tfe">Boton Floral</div><div class="itfe"></div></div>
       	<div class="boxfen" id="fen7"><img src="img/if7.png"   class="img_f" /><div class="tfe">Flor de Inicio</div><div class="itfe"></div></div>
       	<div class="boxfen" id="fen8"><img src="img/if8.png"   class="img_f" /><div class="tfe">Plena Floración</div><div class="itfe"></div></div>
       	<div class="boxfen" id="fen9"><img src="img/if9.png"   class="img_f" /><div class="tfe">Fruto Cuajado</div><div class="itfe"></div></div>
       	<div class="boxfen" id="fen10"><img src="img/if10.png" class="img_f" /><div class="tfe">Liberación</div><div class="itfe"></div></div>
       	<div class="boxfen" id="fen11"><img src="img/if11.png" class="img_f" /><div class="tfe">Cosecha</div><div class="itfe"></div></div>
		</div>
   </div>
  <?php
  }
else{echo "<a href='index.php' style='color:black'>Session cerrada, Reingrese</a>";}
?> 
</body>
</html>