<?php
	require('clasekiwi.php');
	$c=new basededatos();
	if(isset($_POST['elegido']))
	{
		$c->conexion();
		$lum=$c->lista_archivos($_POST['elegido']);
		$c->desconexion();
		if(is_array($lum))
		{
			foreach($lum as $v)
			{
				echo "<div style='margin-top:2px;width:310px;'><a href='bajar.php?arch=".$v[1],"' >". basename($v[1])."</a>";
				echo "<div style='border-radius:5px;cursor:pointer;float:right;margin-left:5px;padding-left:10px;color:red;background-color:#345;width:23px;' class='elim_arch' id='x".$v[0]."'>x</div></div>";
			}
		}
	}
	if(isset($_POST['elim_arch']))
	{
		$c->conexion();
		$dt=$c->recupera_datos_archivo($_POST['elim_arch']);
		$c->elimina_archivo($_POST['elim_arch']);
		unlink($dt[1]);
		$lum=$c->lista_archivos($dt[2]);
		$c->desconexion();
		if(is_array($lum))
		{
			foreach($lum as $v)
			{
				echo "<div style='margin-top:2px;width:310px;'><a href='bajar.php?arch=".$v[1],"' >". basename($v[1])."</a>";
				echo "<div style='border-radius:5px;cursor:pointer;float:right;margin-left:5px;padding-left:10px;color:red;background-color:#345;width:23px;' class='elim_arch' id='x".$v[0]."'>x</div></div>";
			}
		}
	}
?>
<script>
$('.elim_arch').bind('click',function(){
	$.ajax({
		url:'lista_archivos.php',
		type:'POST',
		data:{elim_arch:$(this).attr('id').substring(1)},
		success:function(oi){$('#m_arch').html(oi);}
	});
});
</script>