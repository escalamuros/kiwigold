<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
if(isset($_SESSION['id']))
{
	if(($_SESSION['nivel']=='1')||($_SESSION['nivel']=='2'))
	{?>
	lab_autorisa<br>
	<?php 
	}
}
else{echo "<a href='index.php' style='color:black'>Sesión cerrada, Reingrese</a>";}
?>
</body>
</html>