<?php
session_start();
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=resumen_total_productores.xls");
header("Pragma: no-cache");
header("Expires: 0");
include("./e.php");
?>