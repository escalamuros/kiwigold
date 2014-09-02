<?php
	require('clasekiwi.php');
	$c=new basededatos();
	//retorna option con id y nombre de productores segun la exportadora
	if(isset($_POST['findprod'])){
		$c->conexion();
		echo "<option selected='selected'>Seleccione</option>";
		$arreglo=$c->lista_productores($_POST['findprod']);
		foreach($arreglo as $a){echo "<option value='".$a[0]."'>".$a[1]."</option>";}
		$c->desconexion();
		}
	//retorna unidad de madurez activas segun el productor
	if(isset($_POST['findlab'])){
		$c->conexion();
		echo "<option selected='selected'>Seleccione</option>";
		$arreglo=$c->lista_um_activas($_POST['findlab']);
		foreach($arreglo as $a){echo "<option value='".$a[0]."'>".$a[1]."</option>";}
		$c->desconexion();
		} 
		if(is_array($arreglo)){ foreach($arreglo as $arr){echo $arr;}}
		
	if(isset($_POST['peso'])){
		$c->conexion();
		$c->ingresolab($_POST['numm'],$_POST['peso'],$_POST['presion1'],$_POST['presion2'],$_POST['ss'],$_POST['color1'],$_POST['color2'],$_POST['pesoi'],$_POST['pesof'],$_POST['obs'],$_POST['ingbd']);
		$c->desconexion();
		}
	if(isset($_POST['um'])){
		$um=$_POST['um'];
		$fecha=$_POST['fecha'];
		$c->conexion();
		$c->buscaAnalisis($um,$fecha);
		$c->desconexion();
		}
	if(isset($_POST['lab'])){
		$um=$_POST['lab'];
		$fecha=$_POST['fecha'];
		$c->conexion();
		$c->crearAnalisis($um,$fecha);
		$c->desconexion();
		}
	if(isset($_POST['ning'])){
		$c->conexion();
		$c->traerDatos($_POST['ning']);
		$c->desconexion();
		}

	if(isset($_POST['nuevafecha'])){
		$c->conexion();
		$c->nuevafecha($_POST['nuevafecha'],$_POST['fin']);
		$c->desconexion();
		}
	if(isset($_POST['subir_data'])){
		$c->conexion();
		$c->updata($_POST['subir_data']);
		$c->desconexion();
		}
	if(isset($_POST['findum'])){
		$c->conexion();
		$c->findum($_POST['findum']);
		$c->desconexion();
		}
	// cambiar el estado de un usuario de activo a inactivo y vice versa
	if(isset($_POST['cam_est_usu'])){
		$c->conexion();
		if($_POST['estado']=='Activo'){$c->editar_usuario($_POST['cam_est_usu'],'estado','1');echo "Inactivo";}
		else{$c->editar_usuario($_POST['cam_est_usu'],'estado','0');echo "Activo";}
		$c->desconexion();
	}
	// cambiar el password de un usuario
	if(isset($_POST['cam_pass_usu'])){
		$c->conexion();
		$c->editar_usuario($_POST['cam_est_usu'],'pass',$_POST['estado']);echo $_POST['estado'];
		$c->desconexion();
	}
	// cambiar el nombre de un usuario 
	if(isset($_POST['cam_nom_usu'])){
		$c->conexion();
		$c->editar_usuario($_POST['cam_nom_usu'],'nombre',$_POST['estado']);echo $_POST['estado'];
		$c->desconexion();
	}
	// cambiar el usuario de un usuario
	if(isset($_POST['cam_usr_usu'])){
		$c->conexion();
		$c->editar_usuario($_POST['cam_usr_usu'],'usuario',$_POST['estado']);echo $_POST['estado'];
		$c->desconexion();
	}
?>