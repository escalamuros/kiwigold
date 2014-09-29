<?php
	session_start();
	session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="js/jquery.js"></script>
<title>Kiwi Gold - Inicio</title>
<link rel="icon" href="img/favicon.ico">
<style type="text/css">
#contenedor{
	width: 990px;
	margin: 0 auto 0 auto;
}
#cabecera{
	width: 990px;
	height: 150px;
}
.col{
	padding: 10px;
	width: 310px;
	height: 350px;
	float:left;
}
a{ font-size: 12px;float:right;text-decoration: none;}
</style>
</head>
<body>
	<div id="contenedor">
		<div id="cabecera">
		<img src="./img/kiwi_logo.png" alt="logo kiwigold chile" style="height:70%">
		<a href="login.php">Area Reservada</a>
		</div>
		<div id="cuerpo">
		<div class="col"></div>
		<div class="col">
		<img src="./img/constr.jpg" style="width:100%" alt="sitio en construccion">
		</div>
		<div class="col"></div>
		</div>
		<div id="footer">
	   <img src="img/footer.png" width="100%" height="50"  />
	   </div>	
   </div>
</body>
</html>