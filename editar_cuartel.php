<?php
	require_once 'clasekiwi.php';
	$c=new basededatos();
	$c->conexion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php 
	if(isset($_POST['cuartel']))
	{
		
		$ar=$c->recuperar_cuartel($_POST['cuartel']);
		$or=$c->lista_plantas($_POST['cuartel']);
		$lu=$c->lista_tipo_plantas();
		$conteo=$c->contar_machos($_POST['cuartel']);
	}
	$c->desconexion();
	echo "Editar Cuartel:<br>";
	echo "<input type='hidden' id='ppp' value='".$ar[0]."' >";
	echo "<table>";
	echo "<tr><td>Nombre:</td><td>                  <input type='text' id='enom' value='".$ar[3]."'></td></tr>";
	echo "<tr><td>Año:</td><td>                     <input type='text' id='eano' value='".$ar[2]."'></td></tr>";
	echo "<tr><td>Superficie:</td><td>              <input type='text' id='esup' value='".$ar[4]."'></td></tr>";
	echo "<tr><td>Numero de Plantas:</td><td>       <input type='text' id='enplan' value='".$ar[5]."'></td></tr>";
	echo "<tr><td>Zona:</td><td>                    <input type='text' id='ez' value='".$ar[6]."'></td></tr>";
	echo "<tr><td>Dirección:</td><td>               <input type='text' id='ed' value='".$ar[7]."'></td></tr>";
	echo "<tr><td>Nombre Encargado:</td><td>        <input type='text' id='enenc' value='".$ar[8]."'></td></tr>";
	echo "<tr><td>Fono Encargado:</td><td>          <input type='text' id='efenc' value='".$ar[9]."'></td></tr>";
	echo "<tr><td>EMail Encargado:</td><td>         <input type='text' id='eeenc' value='".$ar[10]."'></td></tr>";
	echo "<tr><td>Geolocalización:</td><td>         <input type='text' id='egeo' value='".$ar[11]."'></td></tr>";
	echo "<tr><td>Distancia entre hileras:</td><td> <input type='text' id='edth' value='".$ar[12]."'></td></tr>";
	echo "<tr><td>Distancia en hileras:</td><td>    <input type='text' id='edeh' value='".$ar[13]."'></td></tr>";
	echo "<tr><td>% Machos:</td><td>                <input type='text' id='epm' value='".$conteo."'></td></tr>";
	echo "<tr><td>Observación:</td><td>             <input type='text' id='eo' value='".$ar[15]."'></td></tr>";
	echo "<tr><td colspan='2'><div id='btn_guar_edi_cuar' class='btn_color'>Guardar Cambio</td></tr></div>";
	echo "</table>";
	
	echo "Lista de Plantas:<br>";
	echo "<table border='1' ><tr><td>Tipo</td><td>Cantidad</td><td>Año</td><td>Editar</td><td>Eliminar</td>";
	foreach($or as $ee){echo "<tr><td>".$ee[0]."</td><td>".$ee[1]."</td><td> ".$ee[2]."</td><td class='btn_ed' id='ed".$ee[3]."'>Editar</td><td class='btn_el' id='el".$ee[3]."'>Eliminar</tr>";}
	echo "</table>";
	echo "<div id='add_tira_planta'>+ Agregar Plantas</div>";
	echo "<div id='add_plantas1'><input type='hidden' value='".$_POST['cuartel']."' id='ap_cuartel'>";
	echo "<table>";
	echo "<tr><td>Tipo: </td>";
	echo "<td><select id='ap_tipo'>";
	foreach($lu as $ey){echo "<option value='".$ey[0]."'>".$ey[1]."</option>";}
	echo "</select></td></tr>";
	echo "<tr><td>Cantidad: </td><td><input type='text' id='ap_cant'></td></tr>";
	echo "<tr><td>Año:</td><td><input type='text' id='ap_año'></td></tr>";
	echo "<tr><td colspan='2'><input type='button' value='Agregar' class='btn_color' id='btn_add_planta'></td></tr>";
	echo "</table></div>";
	echo "<div id='editar_plantas'><table>";
	echo "<tr><td>Tipo: </td>";
	echo "<td><select id='ed_tipo'>";
	foreach($lu as $ey){echo "<option value='".$ey[0]."'>".$ey[1]."</option>";}
	echo "</select></td></tr>";
	echo "<tr><td>Cantidad: </td><td><input type='text' id='ed_cant' size='5'></td></tr>";
	echo "<tr><td>Año:</td><td><input type='text' id='ed_año' size='5'></td></tr>";
	echo "<tr><td><input type='bottom' id='btn_cancel'value='Cancelar' size='5'></td><td><input type='bottom' id='btn_editar'value='Guardar' size='5'></td></tr></table>";

	echo "</div>";
?>
<script>


$('.btn_el').bind('click',function(){

	var elim=this.id.substr(2);
	conf_elim=confirm('Esta seguro de eliminar esta entrada?');
	if(conf_elim){
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{to_del:elim},
			success:function(){alert ('Datos eliminados con exito')}

		});
	}
});
$('.btn_ed').bind('click',function(){
	$('#editar_plantas').show();
	var edi=this.id.substr(2);

	$('#add_tira_planta').hide();
	$.ajax({
		url:'recibeajax.php',
		type:'POST',
		dataType:'json',
		data:{traer_datos:edi},
		success:function(e){
			sessionStorage['ed_id']=e['id'];
			$('#ed_cant').val(e['cantidad']);
			$('#ed_año').val(e['año']);
		}
	})
});
$('#btn_editar').bind('click',function(){
	
	$.ajax({
		url:'recibeajax.php',
		type:'POST',
		data:{ed_id:sessionStorage['ed_id'],ed_año:$('#ed_año').val(),ed_tipo:$('#ed_tipo').val(),ed_cant:$('#ed_cant').val()},
		success:function(){$('#editar_plantas').hide(); alert ('Datos editados con exito');location.reload();	}

	});

});

$('#btn_cancel').bind('click',function(){
	$('#editar_plantas').hide();
});
$('#add_tira_planta').bind('click',function(){
	$('#add_plantas1').show();

});
$('#btn_add_planta').bind('click',function(){
	$.ajax({
		url:'recibeajax.php',
		type:'POST',
		data:{agrega_plantas:1,cuartel:$('#ap_cuartel').val(),tipo:$('select#ap_tipo').val(),cantidad:$('#ap_cant').val(),año:$('#ap_año').val()},
		success:function(){alert ('Datos guardados con exito');$('#add_plantas1').hide()}
	});
});

$('#btn_guar_edi_cuar').bind('click',function(){
	$.ajax({
		url:'recibeajax.php',
		type:'POST',
		data:{editar_cuar:$('#ppp').val(),nombre:$('#enom').val(),ano:$('#eano').val(),sup:$('#esup').val(),nplan:$('#enplan').val(),zona:$('#ez').val(),d:$('#ed').val(),enc:$('#enenc').val(),fenc:$('#efenc').val(),eenc:$('#eeenc').val(),geo:$('#egeo').val(),dth:$('#edth').val(),deh:$('#edeh').val(),pm:$('#epm').val(),o:$('#eo').val()},
		success:function(){alert('Datos Aceptados y Actualizados');}
	});
	$('#form_edi_cuar').hide();
	});

</script>
</body>
</html>