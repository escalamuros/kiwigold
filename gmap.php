<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script>
var map;
function initialize() {
  var mapOptions = {
    zoom: 8,
    center: new google.maps.LatLng(-34.397, 150.644)
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);
}
$(document).ready(initialize());
google.maps.event.addDomListener(window, 'load', initialize);

</script>
</head>
<body>

<?php
//if(isset($_SESSION['id']))
//{
//	if($_SESSION['nivel']=='1')
//	{
//		echo "Lab_autorisa<br>";
//		echo "<div id='map-canvas'></div>";
//	}
//	else
//	{
//		echo "No tiene nivel de acceso<br>";
//	}
//}
//else
//{
//	echo "<a href='index.php' style='color:black'>Session cerrada, Reingrese</a>";
//}
?>
</body>
</html>