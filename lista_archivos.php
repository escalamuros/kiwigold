<?php
	require('clasekiwi.php');
	$c=new basededatos();
	if(isset($_POST['um']))
	{
		$c->conexion();
		$ar=$c->lista_archivos($_POST['prod']);
		$c->desconexion();
		$lum=$c->lista_archivos($_POST['elegido']);
		foreach($lum as $v)	{echo "<div class='btn_color2' style='width:250px;margin-top:3px;' id='".$v[0]."'>".$v[1]."</div>";}
	}
?>