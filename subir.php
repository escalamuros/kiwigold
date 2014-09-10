<?php 
require('clasekiwi.php');
$nombre_archivo =basename($_FILES['archivo']['name']) ;
$tmp_archivo = $_FILES['archivo']['tmp_name'];
$ruta='./documentos/'.$_POST['prod'].'/';
if(mkdir ($ruta ,0777)){chmod($ruta,0777);}
$i=1;
do{
	$temp=$ruta."/".$i."_".$nombre_archivo;
	$i++;
}
while(file_exists($temp));
$archivador = $temp;
if (!move_uploaded_file($tmp_archivo, $archivador))
{
	$return = "Ocurrio un error al subir el archivo\n".$nombre_archivo."\n. No pudo guardarse.";
}
else
{
	$return ="Archivo subido con exito.";
	$c=new basededatos();
	$c->conexion();
	$c->guardar_archivo($_POST['prod'],$archivador);
	$c->desconexion();
}
echo $return;
?>