<?php
class basededatos
{
	//declarar atributos necesarios para la conexion
	private $servidor;
	private $login;
	private $clave;
	private $base;
	private $id_con;
	private $id_bd;
	
	//declarar constructor
	function basededatos()
	{	
		
		$this->servidor="localhost";
		$this->login="root";
		$this->clave="1537291534862123";
		$this->base="kiwibd";
		/*
		$this->servidor="kiwibd.db.11164618.hostedresource.com";
		$this->login="kiwibd";
		$this->clave="Kiwibd123!";
		$this->base="kiwibd";
		*/
	}
	function conexion()
	{
		$this->id_con=mysql_connect($this->servidor,$this->login,$this->clave) or die("Error, en la conexion al servidor de BD");
		$this->id_bd=mysql_select_db($this->base,$this->id_con) or die("Error, BD no encontrada en el servidor");
		mysql_query("SET NAMES 'utf8'");
	}
	function desconexion()
	{
		mysql_close($this->id_con); 
	}
	function validar($usuario,$pass)
	{
		$cons="select id,nombre,nivel,empresa,estado from usuarios where user='".$usuario."' and pass='".$pass."';";
		$ejec=mysql_query($cons,$this->id_con);
		$a=array(0,0,0,0);
		while($rs=mysql_fetch_array($ejec,$this->id_bd))
		{
			if($rs['estado']==0) {$a=array($rs['id'],$rs['nivel'],$rs['nombre'],$rs['empresa']);}	
			else{$a=array(-1,0,0,0);}
		}
		return $a;
	}
		
	function lista_exportadores()
	{
		$cons="select id,nombre from exportadoras;";
		$ejec=mysql_query($cons,$this->id_con);	
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){ $lista[]=array($rs['id'],$rs['nombre']); }
		return $lista;
	}
		
	function lista_productores($po)
	{	
		$cons="select id,empresa from campos where exportadora=$po order by id;";
		$ejec=mysql_query($cons,$this->id_con);		
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arreglo[]=array($rs['id'],$rs['empresa']);
		}
		return $arreglo;
	}
	function lista_um_activas($po)
	{	
		$cons="select id,um from um where campo='$po' and estado='1';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arreglo[]=array($rs['id'],$rs['um']);
		}
		return $arreglo;
	}
	
	function guardar_archivo($prod,$archivo)
	{
		$cons="insert into archivos values (NULL,'$archivo','$prod');";
		mysql_query($cons,$this->id_con);
	}
	function lista_archivos($prod)
	{
		$cons="select id,archivo from archivos where productor='$prod';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd))
		{
			$arreglo[]=array($rs['id'],basename($rs['archivo']));
		}
		return $arreglo;
	}
	// hasta aqui revisado	
	function ingresolab($numm,$peso,$pre1,$pre2,$ss,$col1,$col2,$pei,$pef,$obs,$ing){
		$cons="update analisis set peso='$peso',presion1='$pre1',presion2='$pre2',ss='$ss',color1='$col1',color2='$col2',pesoi='$pei',pesof='$pef',obs='$obs' where f_analisis='$ing' and numm='$numm';";
		mysql_query($cons,$this->id_con);
		if ($numm==48){
		echo $numm;}
		
		}
		function llenartabla(){
			for($a=1;$a<=48;$a++){
				echo'<tr><td><div id="nummer'.$a.'">'.$a.'</div></td><td><input type="text" id="l_peso'.$a.'" size="3" class="cuadrito" /></td><td><input type="text" id="l_pre1'.$a.'" class="cuadrito" size="3"/></td><td><input type="text" id="l_pre2'.$a.'" class="cuadrito" size="3"/></td><td><div id="p_pres'.$a.'" class="es_1"></div></td><td><input type="text" id="l_solu'.$a.'" class="cuadrito" size="3"/></td><td><input type="text" id="l_col1'.$a.'" class="cuadrito" size="3"/></td><td><input type="text" id="l_col2'.$a.'" class="cuadrito" size="3"/></td><td><div id="p_colo'.$a.'" class="es_1"></div></td><td><input type="text" id="l_pesi'.$a.'" class="cuadrito" size="3"/></td><td><input type="text" id="l_pesf'.$a.'" class="cuadrito" size="3"/></td><td><div id="m_seca'.$a.'" class="es_1"></div></td><td><input type="text" id="l_obse'.$a.'" class="cuadrito" size="8"/></td></tr>';	
				}	
			}
		function buscaAnalisis($um,$fecha){
			$cons="select id from f_analisis where um='$um' and fecha='$fecha';";
			
			$ejec=mysql_query($cons,$this->id_con);
			if($rs=mysql_fetch_array($ejec,$this->id_bd)){
				$id=$rs['id'];
				echo $id;
				}
			}
		function crearAnalisis($lab,$fecha){
			$cons="insert into f_analisis values(NULL,'$lab','$fecha','$fecha',0);";
			mysql_query($cons,$this->id_con);
			$po=mysql_insert_id();
			for($aa=1;$aa<=48;$aa++){
				$cons="insert into analisis values (NULL,$po,$aa,'','','','','','','','','');";
				mysql_query($cons,$this->id_con);
				}
			echo $po;
			}
			function traerDatos($re){
				$con=1;
				$cons="select * from analisis where f_analisis=$re order by numm";
				$ejec=mysql_query($cons,$this->id_con);
				while($rs=mysql_fetch_array($ejec,$this->id_bd)){
					$arreglo[$con][]=$rs['numm'];
					$arreglo[$con][]=$rs['peso'];
					$arreglo[$con][]=$rs['presion1'];
					$arreglo[$con][]=$rs['presion2'];
					$arreglo[$con][]=$rs['ss'];
					$arreglo[$con][]=$rs['color1'];
					$arreglo[$con][]=$rs['color2'];
					$arreglo[$con][]=$rs['pesoi'];
					$arreglo[$con][]=$rs['pesof'];
					$arreglo[$con][]=$rs['obs'];
					$con++;
					
					}
				print_r(json_encode($arreglo));
				}
			function nuevafecha($pom,$pe){
				$cons="update f_analisis set fecha_m='$pom' where id='$pe';";
				mysql_query($cons,$this->id_con);
				}
		function updata($cas){
			$cons="update f_analisis set estado='1' where id='$cas';";
			mysql_query($cons,$this->id_con);
			}
		function findum($re){
			$cons="select id,um,campo from um where um like '$re%';";
			$ejec=mysql_query($cons,$this->id_con);
				while($rs=mysql_fetch_array($ejec,$this->id_bd)){
					echo "<div class='resul_ind'>".$rs['um']."</div>";
					}
			}
	//nueva funciones para productor de un campo
	function datos_legales_productor($prod)
	{
		$cons="select * from datos_prod where campo=$prod;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arr=array($rs['rs'],$rs['rut'],$rs['giro'],$rs['dir'],$rs['fono'],$rs['mail'],$rs['rl'],$rs['rutrl'],$rs['fonorl'],$rs['mailrl'],$rs['encargado'],$rs['rute'],$rs['fonoe'],$rs['maile']);
		}
		return $arr;
	}
	//listado, ingreso y recuperacion de cuarteles
	function lista_cuarteles_productor($prod)
	{
		$cons="select id,nombre from cuarteles where campo='$prod';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd))
		{
			$arreglo[]=array($rs['id'],$rs['nombre']);
		}
		if(count($arreglo)==0){$arreglo=array(array('0','No hay Cuarteles'));}
		return $arreglo;
	}
	function agregar_cuartel_productor($prod,$ano,$nom,$sup,$nplan,$z,$d,$nenc,$fenc,$eenc,$geo,$dth,$deh,$pm,$o)
	{
		$cons="insert into cuarteles values(NULL,'$prod','$ano','$nom','$sup','$nplan','$z','$d','$nenc','$fenc','$eenc','$geo','$dth','$deh','$pm','$o');";
		mysql_query($cons,$this->id_con);
	}
	function recuperar_cuartel($cuar)
	{
		$cons="select * from cuarteles where id='$cuar';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arr=array($rs['id'],$rs['campo'],$rs['año'],$rs['nombre'],$rs['superficie'],$rs['nplantas'],$rs['zona'],$rs['direccion'],$rs['nenc'],$rs['fenc'],$rs['eenc'],$rs['geo'],$rs['dentreh'],$rs['denh'],$rs['pmacho'],$rs['obs']);
		}
		return $arr;
	}
	function editar_cuartel($cuar,$nombre,$ano,$sup,$nplan,$zona,$d,$enc,$fenc,$eenc,$geo,$dth,$deh,$pm,$o)
	{
		$cons="update cuarteles set nombre='$nombre',año='$ano',superficie='$sup',nplantas='$nplan',zona='$zona',direccion='$d',nenc='$enc',fenc='$fenc',eenc='$eenc',geo='$geo',dentreh='$dth',denh='$deh',pmachos='$pm',obs='$o' where id='$cuar' ; ";
		mysql_query($cons,$this->id_con);
	}
	function eliminar_cuartel($cuar)
	{
		$cons="delete from cuarteles where id='$cuar' ; ";
		mysql_query($cons,$this->id_con);
	}
	function lista_plantas($cuar){
		$cons="select tipo,cantidad,año from plantas where cuartel=$cuar;";

		$ejec=mysql_query($cons,$this->id_con);
		$totalp='No hay registro';
		while($rs=mysql_fetch_array($ejec,$this->idb)){
			
			$tipo=$rs['tipo'];
			$cantidad=$rs['cantidad'];
			$año=$rs['año'];

			$plantas[]=array($tipo,$cantidad,$año);
			
			$totalp=array($plantas);


		}

		 return $plantas;
	}
	function add_plantas($cuar,$tipo,$cantidad,$año){
		$cons="insert into plantas values(NULL,'$cuar','$tipo','$cantidad','$año');";
		echo $cons;
		mysql_query($cons,$this->id_con);

	}
	function lista_um_productor($prod)
	{
		$cons="select id,um from um where campo='$prod' and estado='1';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arreglo[]=array($rs['id'],$rs['um']);
		}
		return $arreglo;
	}
	function lista_todas_um_productor($prod)
	{
		$cons="select id,um,estado from um where campo='$prod' ;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arreglo[]=array($rs['id'],$rs['um'],$rs['estado']);
		}
		return $arreglo;
	}
	function datos_um($um)
	{
		$cons="select * from um where id='$um';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arr=array($rs['id'],$rs['um'],$rs['campo'],$rs['cuartel'],$rs['superficie'],$rs['año'],$rs['geo'],$rs['estado']);
		}
		return $arr;
	}
	function registrar_um($um,$prod,$cuar,$sup,$ao,$geo)
	{
		$cons="insert into um values (NULL,'$um','$prod','$cuar','$sup','$ao','$geo','1');";
		mysql_query($cons,$this->id_con);
	}
	function cambia_estado_um($id)
	{
		$cons="select estado from um where id='$id';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd))
		{$e=$rs['estado'];}
		if($e==1){$e=0;}else{$e=1;}
		$cons="update um set estado='$e' where id='$id';";
		mysql_query($cons,$this->id_con);
		switch($e){case 1:$ho="Activa";break;case 0:$ho="Inactiva";break;};
		return $ho;
	}
	function editar_um($um,$nom,$cuar,$sup,$ano,$geo)
	{
		$cons="update um set um='$nom',cuartel='$cuar',superficie='$sup',año='$ano',geo='$geo' where id='$um';";
		mysql_query($cons,$this->id_con);
	}
	/*
	function datos_ult_prod_um($um)
	{
		$cons="select * from prod_um where um=$um order by fecha asc limit 1;";
		$ejec=mysql_query($cons,$this->id_con);
		$arr=array('0','No hay registro','','');
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arr=array($rs['fecha'],$rs['tonha'],$rs['comercializadora'],$rs['calibre']);
		}
		return $arr;
	}
	
	function lista_fenologico_actual_um($um,$anno)
	{
		$cons="select fenologicos.fecha,est_fen.nombre from fenologicos,est_fen where um=$um and fenologicos.estado_f=est_fen.id and fecha between '$anno-05-01' and '".$anno+1."-06-30' order by fecha asc ;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arr[]=array($rs['fecha'],$rs['nombre']);
		}
		if(count($arr)==0){ $arr=array(array('0','No hay registro')); }
		return $arr;
	}
	*/
	function lista_estados_fenologicos()
	{
		$cons="select id,nombre from est_fen order by id asc ;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arr[]=array($rs['id'],$rs['nombre']);
		}
		return $arr;
	}
	function registrar_labores($um,$fecha,$prog,$met,$feno)
	{
		//$f=substr($fecha,6,4)."-". substr($fecha,3,2)."-". substr($fecha,0,2);
		$cons="insert into labores values ('$um','$fecha','$prog','$met','$feno');";
		mysql_query($cons,$this->id_con);
	}
	function lista_ultimos10_labores($um)
	{
		//modificar para nueva bd
		$cons="select labores.fecha,labores.programa,est_fen.nombre from labores,est_fen where labores.estado_f=est_fen.id and labores.um='$um' order by labores.fecha asc limit 10;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd))
		{
			$f=substr($rs['fecha'],8,2). substr($rs['fecha'],4,3)."-". substr($rs['fecha'],0,4);
			$arr[]=array($f,$rs['programa'],$rs['nombre']);
		}
		if(count($arr)==0){ $arr=array(array('0','No hay registro',' ')); }
		return $arr;
	}
	function registrar_fitosanitario($um,$fecha,$ncom,$iac,$cad,$obs,$feno)
	{
		//modificar para nueva bd
		$cons="insert into fitosanitarios values ('$um','$fecha','$ncom','$iac','$cad','$obs','$feno');";
		mysql_query($cons,$this->id_con);
	}
	function lista_ultimos10_fito($um)
	{
		$cons="select fitosanitarios.fecha,fitosanitarios.n_comercial,est_fen.nombre from fitosanitarios,est_fen where fitosanitarios.estado_f=est_fen.id and fitosanitarios.um='$um' order by fitosanitarios.fecha asc limit 10;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd))
		{
			$f=substr($rs['fecha'],8,2). substr($rs['fecha'],4,3)."-". substr($rs['fecha'],0,4);
			$arr[]=array($f,$rs['n_comercial'],$rs['nombre']);
		}
		if(count($arr)==0){ $arr=array(array('0','No hay registro',' ')); }
		return $arr;
	}	
	//funciones para produccion
	function ingresa_produccion($prod,$fecha,$com,$ton,$cal){
		$cons="insert into produccion values (NULL,'$prod','$fecha','$ton','$com','$cal');";
		mysql_query($cons,$this->id_con);
	}
	function lista_ultimos10_prod($prod)
	{
		$cons="select id,fecha,ton,calibre from produccion where productor='$prod' order by fecha desc limit 10;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)) 
		{$arr[]=array($rs['id'],$rs['fecha'],$rs['ton'],$rs['calibre']);}
		if(count($arr)==0){$arr[]=array('0','','No Hay registro','');}
		return $arr;
	}
	function rescatar_produccion($esa)
	{
		$cons="select * from produccion where id='$esa';";
		while($rs=mysql_fetch_array($ejec,$this->id_bd)) 
		{$arr[]=array($rs['id'],$rs['productor'],$rs['fecha'],$rs['ton'],$rs['comercializadora'],$rs['calibre']);}
		return $arr;
	}
	function editar_prod($id,$fech,$ton,$com,$cal)
	{
		$cons="update produccion set fecha='$fech',ton='$ton',comercializadora='$com',calibre='$cal' where id='$id';";
		mysql_query($cons,$this->id_con);
	}
	//funciones para usuarios, generar y editar, cambiar estado etc...
	function registrar_usuario($nom,$usu,$pass,$niv,$emp)
	{
		$cons="insert into usuarios values(NULL,'$nom','$usu','$pass','$niv','$emp','0');";
		$ejec=mysql_query($cons,$this->id_con);
	}
	function lista_usuarios()
	{
		$cons="select usuarios.id,usuarios.nombre,nivel.nivel,usuarios.empresa,usuarios.estado from usuarios,nivel where usuarios.nivel<'4' and nivel.id=usuarios.nivel order by usuarios.nivel asc ;";		
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arr[]=array($rs['id'],$rs['nombre'],$rs['nivel'],$rs['empresa'],$rs['estado']);
		};
		$cons="select usuarios.id,usuarios.nombre,nivel.nivel,campos.empresa,usuarios.estado from usuarios,nivel,campos where usuarios.nivel='4' and nivel.id=usuarios.nivel and campos.id=usuarios.empresa  order by usuarios.nivel asc ;";
		$ejec=mysql_query($cons,$this->id_con);		
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arr[]=array($rs['id'],$rs['nombre'],$rs['nivel'],$rs['empresa'],$rs['estado']);
		};
		return $arr;
	}
	function recuperar_usuario($id)
	{
		$cons="select * from usuarios where id='$id';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$re=array($id,$rs['nombre'],$rs['user'],$rs['pass'],$rs['nivel'],$rs['empresa'],$rs['estado']);
		}
		return $re;
	}
	function editar_usuario($id,$campo,$valor)
	{
		$cons="update usuarios set $campo='$valor' where id='$id' ;";
		$ejec=mysql_query($cons,$this->id_con);
	}
	function rec_empresa($emp)
	{
		$cons="select empresa from campos where id='$emp';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$re=$rs['empresa'];
		}
		return $re;
	}
	function rec_nivel($emp)
	{
		$cons="select nivel,descripcion from nivel where id='$emp';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$re = array($rs['nivel'],$rs['descripcion']);
		}
		return $re;
	}
	//funciones para productores, edicion, ingreso y lista
	function lista_prod_y_exp()
	{
		$cons="select exportadoras.nombre,campos.id,campos.empresa from exportadoras,campos where campos.exportadora=exportadoras.id order by exportadoras.id asc ;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$ar[] = array($rs['nombre'],$rs['id'],$rs['empresa']);
		}
		return $ar;
	}
	function registrar_productora($expo,$rs,$empresa,$rut,$giro,$dir,$fono,$mail,$rl,$rutrl,$fonorl,$mailrl)
	{
		$cons="insert into campos values(NULL,'$expo','0','$empresa');";
		$ejec=mysql_query($cons,$this->id_con);
		if(mysql_errno($this->id_con)==0)
		{
			$p=mysql_insert_id($this->id_con);
			$cons="insert into datos_prod values('$p','$rs','$rut','$giro','$dir','$fono','$mail','$rl','$rutrl','$fonorl','$mailrl');";
			$ejec=mysql_query($cons,$this->id_con);
		}
	}
	function recuperar_productora($id)
	{
		$cons="select exportadora,codprod,empresa from campos where id='$id';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$re[0]=$id;
		$re[1]=$rs['exportadora'];
		$re[2]=$rs['empresa'];
		}
		$cons="select * from datos_prod where campo='$id';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$re[3]=$rs['rs'];
		$re[4]=$rs['rut'];
		$re[5]=$rs['giro'];
		$re[6]=$rs['dir'];
		$re[7]=$rs['fono'];
		$re[8]=$rs['mail'];
		$re[9]=$rs['rl'];
		$re[10]=$rs['rutrl'];
		$re[11]=$rs['fonorl'];
		$re[12]=$rs['mailrl'];
		}
		while(count($re) < 17){$re[]='';}
		return $re;
	}
	function modif_productora($id,$empresa,$rs,$rut,$giro,$dir,$fono,$mail,$rl,$rutrl,$fonorl,$mailrl)
	{
		$cons="update campos set empresa='$empresa' where id='$id';";
		$ejec=mysql_query($cons,$this->id_con);
		$cons="select rs from datos_prod where campo='$id';";
		$ejec=mysql_query($cons, $this->id_con);
		if(mysql_num_rows($ejec)==1)
		{
			$cons="update datos_prod set rs='$rs',rut='$rut',giro='$giro',dir='$dir',fono='$fono',mail='$mail',rl='$rl',rutrl='$rutrl',fonorl='$fonorl',mailrl='$mailrl' where campo='$id';";
			$ejec=mysql_query($cons,$this->id_con);
		}
		else
		{
			$cons="insert into datos_prod values ('$id','$rs','$rut','$giro','$dir','$fono','$mail','$rl','$rutrl','$fonorl','$mailrl');";
			$ejec=mysql_query($cons,$this->id_con);
		}
	}
}
?>