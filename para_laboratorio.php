<?php
	require_once 'clasekiwi.php';
	$c=new basededatos();
	//retorna lista de fechas de analisis de una um, sin autorizar
	if(isset($_POST['lista_f_anal'])){
		$c->conexion();
		$arr=$c->lista_lab_sin_autorizar($_POST['lista_f_anal']);
		echo "<div class='btn_color' id='n_anal' style='width:200px'>Nuevo Analisis</div>";
		echo "<table>";
		echo "<tr><td colpsan='3'>Lista de Laboratorios </td></tr>";
		echo "<tr><td>Fecha</td><td>F Muestreo</td><td>Editar</td></tr>";
		foreach($arr as $a){
			if($a[0]!=0) {
			echo "<tr><td>".$a[1]."</td><td>".$a[2]."</td><td class='btn_edi_lab' id='an_".$a[0]."'><div class='btn_color'>Editar</div></td></tr>";
			}else {
			echo "<tr><td>".$a[1]."</td><td>".$a[2]."</td><td>-</td></tr>";			
			}
		}
		echo "</table>";
		$c->desconexion();
	}
	//retorna lista de todas las fechas de analisis de una um
	if(isset($_POST['t_lista_f_anal'])){
		$c->conexion();
		$arr=$c->lista_laboratorio($_POST['t_lista_f_anal']);
		echo "<table>";
		echo "<tr><td>id</td><td>Fecha</td><td>F Muestreo</td><td>Estado</td></tr>";
		foreach($arr as $a){echo "<tr><td>".$a[0]."</td><td>".$a[1]."</td><td>".$a[2]."</td><td>".$a[3]."</td></tr>";}
		echo "</table>";
		$c->desconexion();
	}
?>
<script>
$('.btn_edi_lab').bind('click',function(){
	$('#add_data').show();
});
$('#n_anal').bind('click',function(){
	$('#add_data').show();
});
</script>