<?php 
require('clasekiwi.php');
$return ="Archivo subido con exito.";
$nombre_archivo = $_FILES['archivo']['name'];
$tipo_archivo = $_FILES['archivo']['type'];
$tamano_archivo = $_FILES['archivo']['size'];
$tmp_archivo = $_FILES['archivo']['tmp_name'];
$ruta='./documentos/'.$_POST['prod'].'/';
if(mkdir ($ruta ,0777)){chmod($ruta,0777);}
$archivador = $ruta . $nombre_archivo;
if (!move_uploaded_file($tmp_archivo, $archivador))
{
	$return = "Ocurrio un error al subir el archivo. No pudo guardarse.";
}
else
{
	$c=new basededatos();
	$c->conexion();
	$c->guardar_archivo($_POST['prod'],$archivador);
	$c->desconexion();
}
echo $return;
?>