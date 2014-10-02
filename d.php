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
		$dat_anal=$c->recupera_datos_analisis2($_SESSION['lab']);
		echo "<html xmlns='http://www.w3.org/1999/xhtml'><head>";
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		echo "</head><body>";
		echo "<div style='width:600px;height:800px;'>";
		echo "<table>";
		echo "<tr><td>Productor </td><td>".$dt_inf[0]." : </td></tr>";
		echo "<tr><td>Cuartel</td><td>".$dt_inf[6]."</td></tr>";
		echo "<tr><td>Análisis numero</td><td>".$dt_f_analisis[0]."</td></tr>";
		echo "<tr><td>Fecha de la muestra</td><td>". substr($dt_f_analisis[3],8,2)."-".substr($dt_f_analisis[3],5,2)."-".substr($dt_f_analisis[3],0,4)."</td></tr>";
		echo "<tr><td>Fecha del análisis</td><td>". substr($dt_f_analisis[2],8,2)."-".substr($dt_f_analisis[2],5,2)."-".substr($dt_f_analisis[2],0,4)."</td></tr>";
		echo "<tr><td>Observación</td><td>".$dt_f_analisis[5]."</td></tr>";
		echo "<tr><td></td><td>Peso</td><td>Presión 1</td><td>Presión 2</td><td>Promedio Presión</td><td>Ss</td><td>Color 1</td><td>Color 2</td><td>Promedio Color</td><td>Peso Neto Inicial</td><td>Peso Neto Final</td><td>Materia Seca</td><td>Seleccionados</td></tr>";
		foreach ($dat_anal as $a)
		{
			echo "<tr><td></td><td>".number_format($a[0],2,',','.')."</td><td>".number_format($a[1],2,',','.')."</td><td>".number_format($a[2],2,',','.')."</td><td>".number_format((($a[1]+$a[2])/2),2,',','.')."</td><td>".number_format($a[3],2,',','.')."</td><td>".number_format($a[4],2,',','.')."</td><td>".number_format($a[5],2,',','.')."</td><td>".number_format((($a[4]+$a[5])/2),2,',','.')."</td><td>".number_format($a[6],2,',','.')."</td><td>".number_format($a[7],2,',','.')."</td><td>".number_format(($a[7]*100/$a[6]),2,',','.')."</td><td>";
			if($a[8]==1){echo "si";}else{echo "no";}
			echo "</td></tr>";
		}
		echo "<tr><td>Elementos de la muestra</td><td>".$an_dt[0]."</td></tr>";
		echo "<tr><td>Dato Minimo      </td><td>".number_format($an_dt[1],2,',','.') ."</td><td></td><td></td><td>".number_format($an_dt[3],2,',','.'). "</td><td>".number_format($an_dt[5],2,',','.'). "</td><td></td><td></td><td>".number_format($an_dt[7],2,',','.'). "</td><td></td><td></td><td>".number_format($an_dt[9],2,',','.'). "</td></tr>";
		echo "<tr><td>Dato Máximo      </td><td>".number_format($an_dt[2],2,',','.') ."</td><td></td><td></td><td>".number_format($an_dt[4],2,',','.'). "</td><td>".number_format($an_dt[6],2,',','.'). "</td><td></td><td></td><td>".number_format($an_dt[8],2,',','.'). "</td><td></td><td></td><td>".number_format($an_dt[10],2,',','.')."</td></tr>";
		echo "<tr><td>Promedio Muestral</td><td>".number_format($an_dt[11],2,',','.')."</td><td></td><td></td><td>".number_format($an_dt[12],2,',','.')."</td><td>".number_format($an_dt[13],2,',','.')."</td><td></td><td></td><td>".number_format($an_dt[14],2,',','.')."</td><td></td><td></td><td>".number_format($an_dt[15],2,',','.')."</td></tr>";
		echo "<tr><td>Minimo Aritmético</td><td>".number_format($an_dt[16],2,',','.')."</td><td></td><td></td><td>".number_format($an_dt[18],2,',','.')."</td><td>".number_format($an_dt[20],2,',','.')."</td><td></td><td></td><td>".number_format($an_dt[22],2,',','.')."</td><td></td><td></td><td>".number_format($an_dt[24],2,',','.')."</td></tr>";
		echo "<tr><td>Máximo Aritmético</td><td>".number_format($an_dt[17],2,',','.')."</td><td></td><td></td><td>".number_format($an_dt[19],2,',','.')."</td><td>".number_format($an_dt[21],2,',','.')."</td><td></td><td></td><td>".number_format($an_dt[23],2,',','.')."</td><td></td><td></td><td>".number_format($an_dt[25],2,',','.')."</td></tr>";
		echo "</table>";
		echo "</div>";
		echo "</body></html>";
	}
}
else{echo "<a href='login.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
$c->desconexion();
$_SESSION['lab']=0;
?>