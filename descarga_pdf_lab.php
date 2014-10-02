<?php
session_start();
ob_start();
$_SESSION['lab']=$_GET['lab'];
include("./b.php");
$html=ob_get_contents(); //creo un fichero .html
ob_end_clean();
$html=utf8_decode($html);
require_once("./dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html($html);
//ini_set("memory_limit","32M");
$dompdf->render();
$dompdf->stream("resumen_laboratorio_".$_GET['lab'].".pdf");
?>