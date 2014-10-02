<?php
//session_start();
include_once "clasekiwi.php";
$c=new basededatos();
$c->conexion();
if(isset($_SESSION['id']))
{
	if(isset($_SESSION['lab']))
	{
		$dt_f_analisis=$c->recupera_f_analisis($_SESSION['lab']);
		$dt_inf=$c->recupera_dt_para_inf($_SESSION['lab']);
		$an_dt=$c->analisis_datos_fanalisis($_SESSION['lab']);
		echo "<html xmlns='http://www.w3.org/1999/xhtml'><head>";
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		echo "<style>table {border-collapse:collapse;} table td{ border: 1px solid black;}</style>";
		echo "</head><body>";
		echo "<div style='width:600px;height:800px;margin:0 auto 0 auto;'>";
		echo "<img src='./img/kiwi_logo.png' alt='logo kiwigold chile' style='width:200px;'>ANÁLISIS DE LABORATORIO<br>";
		echo "<div style='margin: 15px 0 0 25px;width:570px;height:350px;font-size:14px;'>";
		echo "Estimado Productor ".$dt_inf[0]." : <br>";
		echo "<br>";
		echo "Envio resultado de análisis de madurez:<br>";
		echo "<br>"; 
		echo "Análisis numero ".$dt_f_analisis[0].".<br>";
		echo "Fecha de la muestra: ".substr($dt_f_analisis[3],8,2)."-".substr($dt_f_analisis[3],5,2)."-".substr($dt_f_analisis[3],0,4).".<br>";
		echo "Fecha del análisis: ". substr($dt_f_analisis[2],8,2)."-".substr($dt_f_analisis[2],5,2)."-".substr($dt_f_analisis[2],0,4).".<br>";
		echo "Nombre del cuarte: ".$dt_inf[6]." ( ".$dt_inf[7]." ).<br>";
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
		echo "<div style='margin-left:250px;width:350px;height:200px;text-align:center;'>";
		echo "<img src='./img/firma_carolina_soto.jpg' alt='firma' style='width:80%'><br>";
		echo "Carolina Soto Asenjo<br>Cordinadora Técnica<br>Kiwigold Chile SpA";
		
		echo "</div>";
		echo "</div>";
		echo "</body></html>";
	}
}
else{echo "<a href='login.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
$c->desconexion();
$_SESSION['lab']=0;
?>