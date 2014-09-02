<?php
	require('clasekiwi.php');
	session_start();
	$c=new basededatos();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="css/formato.css" rel="stylesheet" type="text/css" />
<!-- <script src="js/jquery.js"></script> -->
<script>
$(document).ready(function(){
    $('#opex').bind('change',function(e) {	
		sessionStorage['exportadora']=this.value;
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findprod:this.value},
			success:function(re){		
				$('#fprod').html(re);
				$('#datos_2').hide();
				$('#add_data').hide();
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
				$('#datos_2').hide();
				$('#add_data').hide();
				}
			});
		$('#expo_um').show(100);
    });
    $('#flab').bind('change',function(e) {
		sessionStorage['um']=this.value;
		$('#datos_2').show(100);
		$('#add_data').show(100);
		//$('#add_data').show(200);	
    });
});
</script>
</head>
<body>
<?php if(isset($_SESSION['id']))
{
?>
	<div id="contenedor" style="color:#567;">
    	<div id="titulo_lab">Registro Análisis de Control de Madurez Jintao</div>
        <div class="men_i">
        	<div id="expo_lab" class="expo"><div class="etex">Exportadora :</div> <select name="opexpo" id="opex"><option>Seleccione</option>
        	<?php
						$c->conexion();
						$ar=$c->lista_exportadores();
						foreach($ar as $v)
						{echo "<option value='".$v[0]."'>".$v[1]."</option>";}
						$c->desconexion();
			?></select></div>
        	<div id="expo_prod" class="expo"><div class="etex">Productor :</div> <select name="prodexpo"id="fprod"></select></div>
        	<div id="expo_um" class="expo"><div class="etex">Unidad de Maduracion :</div> <select name="labexpo"id="flab"></select></div>
       </div>
       <div class="men_i" id="datos_2">
       		
            <div id="expo_fecha" class="expo"><div class="etex">Fecha Analisis: </div><input type="date" id="fanalisis" /></div>
            <div id="expo_num" class="expo"><div class="etex">Fecha Muestreo :</div> <input type="date" id="fmuestra" /></div>
            <!--<div id="expo_semana" class="expo"><div class="etex">Semana :</div><input id="fsemana" type="week" class="week"  /></div>-->
       </div>
       
       <div id="add_data">
       		<table border="0">
            	<tr><td >Nº</td><td >Peso(g)</td><td >Presion 1(lbs)</td><td >Presion 2(lbs)</td><td >Promedio Presion 1-2</td><td>SS (ºbrix)</td><td>Color 1(ºH)</td><td>Color 2(ºH)</td><td>Promedio Color 1-2</td><td>Peso Neto inicial(g)</td><td>Peso Neto final(g)</td><td>Mat Seca</td><td>Observaciones</td></tr>
                <?php
					$c->conexion();
					$c->llenartabla();
					$c->desconexion()
				?>
             	
           	</table>
            
            <div id="masdatos" class="adder">Guardar Datos</div>
       </div>
       <div id="resultados">
       <table border="0">
            	<tr><td></td><td>Peso(g)</td><td>Promedio Presion 1-2</td><td>SS (ºbrix)</td><td>Promedio Color 1-2</td><td>Mat Seca</td></tr>
                <tr><td>Datos Válidos</td><td><div id="resvalidos" class="resul"></div></td><td><div id="resvalidosp" class="resul"></td><td><div id="resvalidoss" class="resul"></td><td><div id="resvalidosc" class="resul"></td><td><div id="resvalidosm" class="resul"></td></tr>
                <tr><td>Promedio Aritmetico</td><td><div id="resprom" class="resul"></div></td><td><div id="respromp" class="resul"></td><td><div id="resproms" class="resul"></td><td><div id="respromc" class="resul"></td><td><div id="respromm" class="resul"></td></tr>
                <tr><td>Min</td><td><div id="resmin" class="resul"></div></td><td><div id="resminp" class="resul"></td><td><div id="resmins" class="resul"></td><td><div id="resminc" class="resul"></td><td><div id="resminm" class="resul"></td></tr>
                <tr><td>Max</td><td><div id="resmax" class="resul"></div></td><td><div id="resmaxp" class="resul"></td><td><div id="resmaxs" class="resul"></td><td><div id="resmaxc" class="resul"></td><td><div id="resmaxm" class="resul"></td></tr>
                <tr><td>Desv.Estandar</td><td><div id="resdesv" class="resul"></div></td><td><div id="resdesvp" class="resul"></td><td><div id="resdesvs" class="resul"></td><td><div id="resdesvc" class="resul"></td><td><div id="resdesvm" class="resul"></td></tr>
                
       </table>  
       <br />
       <table border='0'>
       	
        <tr><td colspan="6" align="left">Rango de normalidad de la muestra</td></tr>
        <tr><td></td><td>Peso(g)</td><td>Promedio Presion 1-2</td><td>SS (ºbrix)</td><td>Promedio Color 1-2</td><td>Mat Seca</td></tr>
        <tr><td>Min</td><td><div id="minpeso" class="resul"></div></td><td><div id="minpre" class="resul"></div></td><td><div id="minss" class="resul"></div></td><td><div id="mincol" class="resul"></div></td><td><div id="minseca" class="resul"></div></td></tr>
        <tr><td>Max</td><td><div id="maxpeso" class="resul"></div></td><td><div id="maxpre" class="resul"></div></td><td><div id="maxss" class="resul"></div></td><td><div id="maxcol" class="resul"></div></td><td><div id="maxseca" class="resul"></div></td></tr>
        <!--<tr><td>Datos anormales</td><td><div id="datopeso" class="resul"></div></td><td><div id="datopre" class="resul"></div></td><td><div id="datoss" class="resul"></div></td><td><div id="datocol" class="resul"></div></td><td><div id="datoseca" class="resul"></div></td></tr>-->
       </table> 
            <br />
       <table border='0'>
       <tr><td></td><td>Peso(g)</td><td>Promedio Presion 1-2</td><td>SS (ºbrix)</td><td>Promedio Color 1-2</td><td>Mat Seca</td></tr>
       <tr><td>Promedio Depurado</td><td><div id="deppeso" class="resul"></div></td><td><div id="deppre" class="resul"></div></td><td><div id="depss" class="resul"></div></td><td><div id="depcol" class="resul"></div></td><td><div id="depseca" class="resul"></div></td></tr>
       </table>         
          <?php if($_SESSION['nivel']==3 or $_SESSION['nivel']==1){ ?>
		   <div class="addersd" id="btn_subir" style="float:left;width:550px;">Subir Información</div>
		  <?php  }; ?>      
       
       </div>
       
    </div>
    <?php
  }
else{echo "<a href='index.php' style='color:black'>Session cerrada, Reingrese</a>";}
?> 
</body>
</html>