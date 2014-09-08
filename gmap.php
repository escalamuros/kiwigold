<?php session_start();?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="utf-8">
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBz8EVgNdIUevyxRjpoF3jPm5jtlValf3o&sensor=false"></script>
<script src="js/jquery.js"></script>
<script>
function initialize()
{
var mapProp = {
  center:new google.maps.LatLng(-34.580938889,-70.932877778),
  zoom:11,
  mapTypeId: google.maps.MapTypeId.HYBRID,
  zoomControl:true,
    zoomControlOptions: {
      style:google.maps.ZoomControlStyle.SMALL
    }
  };
var marker=new google.maps.Marker({
  position:new google.maps.LatLng(-34.580938889,-70.932877778),
  icon:'img/k_g_m.png'
  });
var map=new google.maps.Map(document.getElementById("googleMap")
  ,mapProp);
var infowindow = new google.maps.InfoWindow({
  content:"Hello World!"
  });
marker.setMap(map);
google.maps.event.addListener(marker, 'click', function() {
	map.setZoom(14);
  infowindow.open(map,marker);
  });
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>

<body>
-34 34 51.38,-70 55 58.36<br>
-34 39 22.0,-70 58 50.9<br>
<div id="googleMap" style="width:700px;height:450px;"></div>

</body>
</html>