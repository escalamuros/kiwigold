<?php session_start();
include_once 'clasekiwi.php';
$c=new basededatos();
if((isset($_GET['cuartel']))&&($_SESSION['nivel']))
{
	$c->conexion();
	$arr=$c->recuperar_cuartel($_GET['cuartel']);
	$arch=$c->recuperar_arch_gpx($_GET['cuartel']);
	$c->desconexion();	
	$nom=$arr[3];
	$dir=$arr[7];
}
if (file_exists($arch)) {
    $xml = simplexml_load_file($arch);
    $lis = $xml->trk->trkseg;
    foreach($lis->trkpt as $elem)
    { $l[]=$elem['lat'].",".$elem['lon'];}
    $ruta=true;
} else {
    $ruta=false;
    $geo=$arr[11];
    $pos1=substr($geo,0,strpos($geo,','));
    $d1=substr($pos1,0,strpos($pos1,' '));
    $pos1=substr($pos1,strpos($pos1,' ')+1);
    $m1=substr($pos1,0,strpos($pos1,' '));
    $s1=substr($pos1,strpos($pos1,' ')+1);
    if($d1>0){$pos1=$d1+((($m1*60)+$s1)/3600);}
    else{$pos1=$d1-((($m1*60)+$s1)/3600);}
    $pos2=substr($geo,strpos($geo,',')+1);
    $d2=substr($pos2,0,strpos($pos2,' '));
    $pos2=substr($pos2,strpos($pos2,' ')+1);
    $m2=substr($pos2,0,strpos($pos2,' '));
    $s2=substr($pos2,strpos($pos2,' ')+1);
    if($d2>0){$pos2=$d2+((($m2*60)+$s2)/3600);}
    else{$pos2=$d2-((($m2*60)+$s2)/3600);}
    $l[0]=$pos1.",".$pos2;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Cuartel <?php echo $nom;?></title>
<link rel="icon" href="img/favicon.ico">
<script>
function inicialize() {
	var c="<div style='width:300px'><img src='img/kiwi_logo.png' width='30px'><?php echo 'Cuartel '.$nom;?></div>";
	<?php if ($ruta) {?>
	var poligono =[<?php foreach($l as $e){echo "new google.maps.LatLng(".$e."),";}?>];
	cuartel = new google.maps.Polygon({
  		paths: poligono,
  		strokeColor: "#0000FF",
  		strokeOpacity: 0.8,
  		strokeWeight: 1,
  		fillColor: "#0000FF",
  		fillOpacity: 0.35
	});
	<?php	
	}
	?>
	var mapProp = {
		center:new google.maps.LatLng(<?php echo $l[0];?>),
		zoom:11,
		mapTypeId: google.maps.MapTypeId.HYBRID,
		zoomControl:true,
		zoomControlOptions: {style:google.maps.ZoomControlStyle.SMALL}
	};
	var marker=new google.maps.Marker({position:new google.maps.LatLng(<?php echo $l[0];?>)});
	var map=new google.maps.Map(document.getElementById('googleMap'),mapProp);
	var infowindow = new google.maps.InfoWindow({ content:c});
	marker.setMap(map);
	<?php if($ruta){?>
	cuartel.setMap(map);
	<?php}?>
	google.maps.event.addListener(marker, 'click', function() 
	{
		map.setZoom(14);
		infowindow.open(map,marker);
	});
}
function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'http://maps.googleapis.com/maps/api/js?key=AIzaSyBz8EVgNdIUevyxRjpoF3jPm5jtlValf3o&sensor=false&' +
      'callback=inicialize';
  document.body.appendChild(script);
}
window.onload = loadScript;
</script>
</head>
<body>
<div style="margin:auto auto auto auto;background-color: rgba(255, 255, 255, 0.7);width:700px;height:520px;border:solid 20px whitesmoke;border-radius:15px;">
<div style="width:700px;height:50px;padding: 10px;">
<img src="img/kiwi_logo.png" height="50px" style="margin-rigth:20px;float:left;">
<div style="float:left;margin-left:5px;margin-top:8px;">
	<?php echo "Cuartel: ".$nom."<br>Dirección: ".$dir."<br>Geolocalización: ".$l[0]; ?>
</div>
</div>
<div id="googleMap" style="width:700px;height:450px;"></div>
</div>
</body>
</html>