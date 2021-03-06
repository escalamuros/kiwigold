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
	if(isset($_POST['findcuar'])){
		$c->conexion();
		echo "<option selected='selected'>Seleccione</option>";
		$arreglo=$c->lista_cuarteles_productor($_POST['findcuar']);
		foreach($arreglo as $a){echo "<option value='".$a[0]."'>".$a[1]."</option>";}
		$c->desconexion();
		}
	if(isset($_POST['findlab'])){
		$c->conexion();
		echo "<option selected='selected'>Seleccione</option>";
		$arreglo=$c->lista_um_activas($_POST['findlab']);
		foreach($arreglo as $a){echo "<option value='".$a[0]."'>".$a[1]."</option>";}
		$c->desconexion();
		}
	//retorna id y nombre de cuarteles segun el productor seleccionado
	if(isset($_POST['prod_elegido'])){
		$c->conexion();
		echo "<option selected='selected'>Seleccione</option>";
		$arreglo=$c->lista_cuarteles_productor($_POST['prod_elegido']);
		foreach($arreglo as $a){echo "<option value='".$a[0]."'>".$a[1]."</option>";}
		$c->desconexion();
	}
	//cambia estado de laboratorio y guarda la observacion.
	if( (isset($_POST['lab_aut']))&&(isset($_POST['obs_datos']))){
		$c->conexion();
		$c->actualiza_obs_f_a($_POST['obs_datos'],$_POST['lab_aut']);
		$c->cambia_estado_lab($_POST['lab_aut'],2);
		$c->desconexion();
	}
	//llena de datos, un analisis seleccionado para editar
	if(isset($_POST['lab_seleccionado'])){
		$c->conexion();
		$c->recupera_datos_analisis($_POST['lab_seleccionado']);
		$c->desconexion();
		}
	if(isset($_POST['f_lab_selec'])){
		$c->conexion();
		$c->recupera_f_f_analisis($_POST['f_lab_selec']);
		$c->desconexion();
		}
	//genera una nueva fecha en f_analisis (laboratorio.php)
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
		$c->editar_usuario($_POST['cam_pass_usu'],'pass',$_POST['estado']);echo $_POST['estado'];
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
		$c->editar_usuario($_POST['cam_usr_usu'],'user',$_POST['estado']);echo $_POST['estado'];
		$c->desconexion();
	}
	//actualiza los datos de un cuartel
	if(isset($_POST['editar_cuar'])){
		$c->conexion();
		$c->editar_cuartel($_POST['editar_cuar'],$_POST['nombre'],$_POST['ano'],$_POST['sup'],$_POST['nplan'],$_POST['zona'],$_POST['d'],$_POST['enc'],$_POST['fenc'],$_POST['eenc'],$_POST['geo'],$_POST['dth'],$_POST['deh'],$_POST['pm'],$_POST['t'],$_POST['c'],$_POST['o']);
		$c->desconexion();
	}
	//eliminar los datos de un cuartel
	if(isset($_POST['eliminar_cuar'])){
		$c->conexion();
		$c->eliminar_cuartel($_POST['eliminar_cuar']);
		$c->desconexion();
	}
	//actualiza los datos de un UM
	if(isset($_POST['editar_um'])){
		$c->conexion();
		$c->editar_um($_POST['editar_um'],$_POST['nombre'],$_POST['cuartel'],$_POST['sup'],$_POST['ano'],$_POST['geo']);
		$c->desconexion();
	}
	// cambia el estado de un UM, de activo a inactivo y viceversa
	if(isset($_POST['cambia_estado_um'])){
		$c->conexion();
		echo $c->cambia_estado_um($_POST['cambia_estado_um']);
		$c->desconexion();
	}
	//agrega plantas a un cuartel
	if(isset($_POST['agrega_plantas'])){
		$c->conexion();
		$c->add_plantas($_POST['cuartel'],$_POST['tipo'],$_POST['cantidad'],$_POST['año']);
		$c->desconexion();
	}
	if(isset($_POST['to_del'])){
		$c->conexion();
		$c->elimina_plantas($_POST['to_del']);
		$c->desconexion();
	}
	if(isset($_POST['traer_datos'])){
		$c->conexion();
		$c->traer_edi($_POST['traer_datos']);
		$c->desconexion();
	}
	if(isset($_POST['ed_id'])){
		$c->conexion();
		$c->editar_plantas($_POST['ed_id'],$_POST['ed_tipo'],$_POST['ed_año'],$_POST['ed_cant']);
		$c->desconexion();
	}
	//cambia el estado de un dato, de un analisis.. 
	if(isset($_POST['cam_est_dato']))
	{
		$c->conexion();
		$c->cambia_estado_dato_analisis($_POST['cam_est_dato'],$_POST['analisis']);
		$c->desconexion();
	}
?>