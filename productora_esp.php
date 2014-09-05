<?php
	require('clasekiwi.php');
	$c=new basededatos();
?>
<html>
<head>
<script>
$(document).ready(function(){
	$('.mod').hide();
	$('#form_nu_cuar').hide();
	$('#form_edi_cuar').hide();
	$('#Editar').bind('click',function(){
		$('.mod').hide();
		$('#editar_prod').show();
	});
	$('#MostrarCuarteles').bind('click',function(){
		$('.mod').hide();
		$('#form_nu_cuar').hide();
		$('#form_edi_cuar').hide();
		$('#mantenedor_cuarteles').show();
	});
	$('#ArchadjEditar').bind('click',function(){
		$('.mod').hide();
		$('#form_nu_cuar').hide();
		$('#form_edi_cuar').hide();
		$('#mantenedor_arch').show();
	});
	$('#guar_datos').bind('click',function(){
		$.ajax({
			url:'modif_productora.php',
			type:'POST',
			async:false,
			data:{id:$('#ide').val(),nf:$('#nf').val(),rs:$('#rs').val(),rut:$('#rut').val(),giro:$('#giro').val(),dir:$('#dir').val(),fono:$('#fono').val(),mail:$('#mail').val(),rl:$('#rl').val(),rutr:$('#rutr').val(),fonor:$('#fonor').val(),mailr:$('#mailr').val()},
			success:function(a){alert('Cambios Aceptados');}
		});
		$.ajax({
			url:'productora_esp.php',
			type:'POST',
			data:{elegido:$('#ide').val()},
			success:function(uk){$('#cont_productores').html(uk);}
		});
	});
	$('.bit_cuartel').bind('click',function(){
		$.ajax({
			url:'editar_cuartel.php',
			type:'POST',
			data:{cuartel:$(this).attr('id')},
			success:function(asd){$('#form_edi_cuar').html(asd);}
		});
		$('#form_edi_cuar').show();
		$('#form_nu_cuar').hide();
	});
	$('#agregar_cuartel').bind('click',function(){
		$('#form_nu_cuar').show();
	});
	$('#btn_guar_nu_cuar').bind('click',function(){
		$.ajax({
			url:'ingreso_cuartel.php',
			type:'POST',
			data:{prod:$('#p').val(),ano:$('#ano').val(),nom:$('#nom').val(),sup:$('#sup').val(),nplan:$('#nplan').val(),z:$('#z').val(),d:$('#d').val(),nenc:$('#nenc').val(),fenc:$('#fenc').val(),eenc:$('#eenc').val(),geo:$('#geo').val(),dth:$('#dth').val(),deh:$('#deh').val(),pm:$('#pm').val(),o:$('#o').val()},
			success:function(a){$('#lis_cuarteles').html(a);}
		});
	});
	$('#btn_guar_nu_arch').bind('click',function(){
		var inputFile = document.getElementById('archivo');
		var file = inputFile.files[0];
		var datos = new FormData();
		datos.append('archivo',file);
		datos.append('prod',$('#prod_id').val());
		$.ajax({
			url:'subir.php',
			type:'POST',
			contentType:false,
			data:datos,
			processData:false,
			cache:false,
			success:function(ii){alert(ii);},
		});
		$.ajax({
			url:'lista_archivos.php',
			type:'POST',
			data:{prod:$('#prod_id').val()},
			success:function(oi){$('#m_arch').html(oi);},
		});
	});
});
</script>
</head>
<body>
<?php
	if(isset($_POST['elegido']))
	{
		$c->conexion();
		$lis=$c->recuperar_productora($_POST['elegido']);

		echo "<input type='hidden' id='ide' value='".$lis[0]."' >";
		echo "<div id='a' style='float:left;width:400px;'>";
		echo "Datos De la Productora<br>";
		echo "<table>";
		//echo "<tr><td>Codigo Exportadora</td><td>".$lis[1]."</td> <td></td></tr>";
		echo "<tr><td>Nombre</td><td>".$lis[2]."</td>            </tr>";
		echo "<tr><td>Razón Social</td><td>".$lis[3]."</td>      </tr>";
		echo "<tr><td>Rut</td><td>".$lis[4]."</td>                </tr>";
		echo "<tr><td>Giro</td><td>".$lis[5]."</td>               </tr>";
		echo "<tr><td>Dirección</td><td>".$lis[6]."</td>          </tr>";
		echo "<tr><td>Fono</td><td>".$lis[7]."</td>          </tr>";
		echo "<tr><td>EMail</td><td>".$lis[8]."</td>             </tr>";
		echo "<tr><td>Representante Legal</td><td>".$lis[9]."</td></tr>";
		echo "<tr><td>Rut Rep.</td><td>".$lis[10]."</td>         </tr>";
		echo "<tr><td>Telefono Rep.</td><td>".$lis[11]."</td>     </tr>";
		echo "<tr><td>EMail Rep.</td><td>".$lis[12]."</td>      </tr>";
		echo "</table>";
		echo "<div class='btn_color' id='Editar' style='width:240px;'>Editar Productora</div><br>";
		echo "<div class='btn_color' id='MostrarCuarteles' style='width:240px;'>Listar Cuarteles</div><br>";
		echo "<div class='btn_color' id='ArchadjEditar' style='width:240px;'>Archivos Adjuntos Productora</div>";
		echo "</div>";
		echo "<div class='mod' id='editar_prod' >";
		echo "<table>";
		echo "<tr><td>Nombre de Fantasia</td><td>           <input type='text' id='nf' value='".$lis[2]."'></td></tr>";
		echo "<tr><td>Razón Social</td><td>                  <input type='text' id='rs' value='".$lis[3]."'></td></tr>";
		echo "<tr><td>Rut</td><td>                          <input type='text' id='rut' value='".$lis[4]."'></td></tr>";
		echo "<tr><td>Giro</td><td>                        <input type='text' id='giro' value='".$lis[5]."'></td></tr>";
		echo "<tr><td>Dirección </td><td>                   <input type='text' id='dir' value='".$lis[6]."'></td></tr>";
		echo "<tr><td>Fono</td><td>                        <input type='text' id='fono' value='".$lis[7]."'></td></tr>";
		echo "<tr><td>Mail</td><td>                        <input type='text' id='mail' value='".$lis[8]."'></td></tr>";
		echo "<tr><td>Representante Legal</td><td>           <input type='text' id='rl' value='".$lis[9]."'></td></tr>";
		echo "<tr><td>Rut Representante Legal</td><td>    <input type='text' id='rutr' value='".$lis[10]."'></td></tr>";
		echo "<tr><td>Fono Representante Legal</td><td>  <input type='text' id='fonor' value='".$lis[11]."'></td></tr>";
		echo "<tr><td>EMail Representante Legal</td><td>  <input type='text' id='mailr' value='".$lis[12]."'></td></tr>";
		echo "</table>";
		echo "<div class='btn_color' id='guar_datos' style='width:240px;'>Guardar</div>";
		echo "</div>";
		echo "<div class='mod' id='mantenedor_cuarteles' >";
		echo "<div id='lis_cuarteles'>";
		echo "Lista de Cuarteles asociado a la productora:<br>";
		$lum=$c->lista_cuarteles_productor($_POST['elegido']);
		foreach($lum as $v)	{echo "<div class='bit_cuartel btn_color' style='width:220px;margin-top:3px;' id='".$v[0]."'>".$v[1]."</div>";}
		echo "</div>";
		echo "<div class='btn_color' id='agregar_cuartel' style='width:300px;margin-top:10px;'>Agregar nuevo Cuartel</div>";
		echo "<div id='form_nu_cuar' style='margin-top:10px;'>";
		echo "Nuevo Cuartel<br>";
		echo "<input type='hidden' id='p' value='".$lis[0]."' >";
		echo "<table>";
		echo "<tr><td>Nombre:</td><td>                  <input type='text' id='nom'></td></tr>";
		echo "<tr><td>Año:</td><td>                     <input type='text' id='ano'></td></tr>";
		echo "<tr><td>Superficie:</td><td>              <input type='text' id='sup'></td></tr>";
		echo "<tr><td>Numero de Plantas:</td><td>       <input type='text' id='nplan'></td></tr>";
		echo "<tr><td>Zona:</td><td>                    <input type='text' id='z'></td></tr>";
		echo "<tr><td>Dirección:</td><td>               <input type='text' id='d'></td></tr>";
		echo "<tr><td>Nombre Encargado:</td><td>        <input type='text' id='nenc'></td></tr>";
		echo "<tr><td>Fono Encargado:</td><td>          <input type='text' id='fenc'></td></tr>";
		echo "<tr><td>EMail Encargado:</td><td>        <input type='text' id='eenc'></td></tr>";
		echo "<tr><td>Geolocalización:</td><td>         <input type='text' id='geo'></td></tr>";
		echo "<tr><td>Distancia entre hileras:</td><td> <input type='text' id='dth'></td></tr>";
		echo "<tr><td>Distancia en hileras:</td><td>    <input type='text' id='deh'></td></tr>";
		echo "<tr><td>% Machos:</td><td>                <input type='text' id='pm'></td></tr>";
		echo "<tr><td>Observación:</td><td>             <input type='text' id='o'></td></tr>";
		echo "<tr><td colspan='2'><div class='btn_color' id='btn_guar_nu_cuar'>Guardar</div></td></tr>";
		echo "</table>";
		echo "</div>";
		echo "<div id='form_edi_cuar' style='margin-top:10px;'>Editar Cuartel</div>";
		echo "</div>";
		echo "<div class='mod' id='mantenedor_arch' >";
		echo "Lista de Archivos Adjuntos Productora:<br>";
		echo "<div id='m_arch'>";
		$lum=$c->lista_archivos($_POST['elegido']);
		foreach($lum as $v)	{echo "<div class='btn_color2' style='width:250px;margin-top:3px;' id='".$v[0]."'>".$v[1]."</div>";}
		echo "</div>";		
		echo "<br>";
		echo "Agregar nuevo Archivo:<br>";
		echo "<input type='hidden' id='prod_id' value='".$_POST['elegido']."'>";
		echo "<input type='file' id='archivo'>";
		echo "<div class='btn_color' id='btn_guar_nu_arch'>Guardar</div>";
		echo "</div>";
		$c->desconexion();
	}
?>
</body></html>