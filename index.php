<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/formato.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.js"></script>
<script src="js/js_login.js"></script>
<title>Kiwi Gold - Login</title>
</head>

<body>
	<div id="contenedor">	
    	<div id="login">
    		<div id="logo"><img src="img/kiwi_logo.png"  /></div>
            <div class="linea"><input id="user" type="text" class="ibox" placeholder="Usuario" /></div>
            <div class="linea"><input id="pass" type="password" class="ibox" placeholder="Contraseña" /></div>
           	<div id="btningresar" class="btnstdr">INGRESAR</div>
           	<div id="algo">
           	<?php
           			if($_GET['op']=='1'){ echo "<span style='color:#345;'>Error de Usuario o Contraseña</span>";}
           			if($_GET['op']=='2'){ echo "<span style='color:#345;'>Sesión cerrada por inactividad</span>";}
           			if($_GET['op']=='3'){ echo "<span style='color:#345;'>Sesión cerrada </span>";}
           			if($_GET['op']=='4'){ echo "<span style='color:#345;'>Usuario inactivo, comuniquese con administrador del sistema</span>";}
            ?>
           	</div>
    	</div>
    </div>
    <div class="footer"><img src="img/footer.png" width="100%" height="50"  /></div>
</body>
</html>