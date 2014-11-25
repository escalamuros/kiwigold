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
	width: 900px;
	margin: 0 auto 0 auto;
}
#cabecera{
	width: 900px;
	height: 100px;
}
#subcab{
	width:900px;
	height:262px;
	background-color:  #d5d9d0;
	padding-top: 8px;
}
#marco{width: 698px ;height: 248px ;border:1px solid black;margin-left: 100px;overflow:hidden; }
#cuerpo{background-color: #000000;}
.col{
	padding: 10px 0 10px 10px;
	width: 280px;
	height: 250px;
	float:left;
	overflow-y: auto;
}
.sep{background-color: #d5d9d0;width: 10px;padding: 0 0 0 0;}
a{ font-size: 12px;float:right;text-decoration: none;}
#footer{background-image:url('./img/footer.png');width:900px;height:60px; }
</style>
<script type="text/javascript" src="/js/jquery.js"></script>
<script src="js/jquery.cycle.all.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(e) {   
	  $('#marco').cycle({ timeout: 4000, delay: -1000});	
});
</script>
</head>
<body>
	<div id="contenedor">
		<div id="cabecera">
		<img src="./img/kiwi_logo.png" alt="logo kiwigold chile" style="height:70%">
		<a href="login.php">Area Reservada</a>
		</div>
		<div id="subcab">
			<div id="marco">
				<div><img src="./img/dos.jpg" alt=""></div>
				<div><img src="./img/uno.jpg" alt=""></div>
				<div><img src="./img/tre.jpg" alt=""></div>
			</div>			
		</div>
		<div id="cuerpo">
			<div class="col">
			
			</div>
			<div class="col sep"></div>
			<div class="col">
				Sitio en Construcción.
			</div>
			<div class="col sep"></div>
			<div class="col">
			
			</div>
		</div>
		<div style="clear:both;"></div>
		<div id="footer">
		<div style="padding: 13px  0 0 45px;">
		Sitio generado por EMEGECE Ltda. La difusión y emisión parsial o total de la pagina debe ser consultado a Kiwigold Chile SpA.
		</div> 
	   </div>	
   </div>
</body>
</html>