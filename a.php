<?php
session_start();
include_once "clasekiwi.php";
$c=new basededatos();
$c->conexion();
if(isset($_SESSION['id']))
{
	if(isset($_POST['lab']))
	{
		$dt_f_analisis=$c->recupera_f_analisis($_POST['lab']);
		$dt_inf=$c->recupera_dt_para_inf($_POST['lab']);
		$an_dt=$c->analisis_datos_fanalisis($_POST['lab']);
		echo "<div style='width:600px;height:800px;float:left;'>";
		echo "<img src='img/kiwi_logo.png' style='width:200px;'>ANÁLISIS DE LABORATORIO<br>";
		echo "<div style='margin: 15px 0 0 25px;width:570px;font-size:14px;'>";
		echo "Estimado Productor ".$dt_inf[0]." : <br>";
		echo "<br>";
		echo "Envio resultado de análisis de madurez:<br>";
		echo "<br>"; 
		echo "Análisis numero ".$dt_f_analisis[0].".<br>";
		echo "Fecha de la muestra: ".substr($dt_f_analisis[3],8,2)."-".substr($dt_f_analisis[3],5,2)."-".substr($dt_f_analisis[3],0,4).".<br>";
		echo "Fecha del análisis: ". substr($dt_f_analisis[2],8,2)."-".substr($dt_f_analisis[2],5,2)."-".substr($dt_f_analisis[2],0,4).".<br>";
		echo "Nombre del cuartel: ".$dt_inf[6]." ( ".$dt_inf[7]." ).<br>";
		echo "<br>";
		echo "Observación :".$dt_f_analisis[5]."<br>";
		echo "<br>";
		echo "<table style='width:580px; margin:5px auto 0 auto;'>";
		echo "<tr><td colspan='6'>Cantidad de elementos de la muestra: ".$an_dt[0]."</td></tr>";
		echo "<tr><td></td><td>Peso</td><td>Presión</td><td>Ss</td><td>Color</td><td>Materia Seca</td></tr>";
		//echo "<tr><td>Dato Minimo      </td><td>".$an_dt[1] ."</td><td>".$an_dt[3]. "</td><td>".$an_dt[5]. "</td><td>".$an_dt[7]. "</td><td>".$an_dt[9]. "</td></tr>";
		//echo "<tr><td>Dato Máximo      </td><td>".$an_dt[2] ."</td><td>".$an_dt[4]. "</td><td>".$an_dt[6]. "</td><td>".$an_dt[8]. "</td><td>".$an_dt[10]."</td></tr>";
		echo "<tr><td>Promedio Muestral</td><td>".$an_dt[11]."</td><td>".$an_dt[12]."</td><td>".$an_dt[13]."</td><td>".$an_dt[14]."</td><td>".$an_dt[15]."</td></tr>";
		echo "<tr><td>Minimo Aritmético</td><td>".$an_dt[16]."</td><td>".$an_dt[18]."</td><td>".$an_dt[20]."</td><td>".$an_dt[22]."</td><td>".$an_dt[24]."</td></tr>";
		echo "<tr><td>Máximo Aritmético</td><td>".$an_dt[17]."</td><td>".$an_dt[19]."</td><td>".$an_dt[21]."</td><td>".$an_dt[23]."</td><td>".$an_dt[25]."</td></tr>";
		echo "</table>";
		echo "</div>";
		echo "<div style='float:right;width:350px;height:200px;text-align:center;'>";
		echo "<img src='img/firma_carolina_soto.jpg' ><br>";
		echo "Carolina Soto Asenjo<br>Cordinadora Técnica<br>Kiwigold Chile SpA";
		echo "</div>";
		echo "</div>";
		echo "<div style='width:350px;height:250px;float:left;overflow:auto;font-size:14px;margin-top:30px; margin-left:7px;'>";
		echo "<div style='font-size:16px;text-align:center;'>Cuerpo del Correo</div>";
		echo "<div style='border:1px solid grey;'>";
		echo "<p>Correo Para: ".$dt_inf[1].", ".$dt_inf[3].", ".$dt_inf[5].", ".$dt_inf[9]."</p>";
		echo "<p>Estimado Productor ".$dt_inf[0].":</p>";
		echo "<p>Adjunto archivo PDF resumen del análisis numero ".$_POST['lab']." dirigidos a : ".$dt_inf[2].", ".$dt_inf[4].", ".$dt_inf[8].".</p>";
		echo "</div>";
		echo "<a href='descarga_pdf_lab.php?lab=".$_POST['lab']."'> <img src='img/pdf_logo.png' style='width:35px;'>Descarga de archivo(pdf)</a><br>";
		echo "<a href='datos_lab_exel.php?lab=".$_POST['lab']."'>  <img src='img/excel_logo.png' style='width:35px;'>Descarga de datos(xls)</a>";
		echo "</div>";
	}
}
else{echo "<a href='login.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
$c->desconexion();
?>