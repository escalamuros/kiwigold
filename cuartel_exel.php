<?php
session_start();
$_SESSION['lab']=$_GET['lab'];
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=Laboratorio_".$_GET['lab']."_Excel.xls");
header("Pragma: no-cache");
header("Expires: 0");
include("./d.php");
?>