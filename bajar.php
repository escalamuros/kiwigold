<?php
$enlace =$_GET['arch'];
Header("Content-type: application/force-download");
Header("Content-Length: ".filesize($enlace));
Header("Content-Disposition: attachment; filename=".basename($enlace));
readfile($enlace);
?>