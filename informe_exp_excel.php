<?php
session_start();
$_SESSION['temporada']=$_GET['temporada'];
$_SESSION['cuartel']=$_GET['cuartel'];
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=resumen_cuartel_".$_GET['cuartel']."_".$_GET['temporada']."_Excel.xls");
header("Pragma: no-cache");
header("Expires: 0");
include("./d.php");
?>