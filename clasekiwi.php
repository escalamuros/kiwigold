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
		/*
		$this->servidor="localhost";
		$this->login="root";
		$this->clave="1537291534862123";
		$this->base="kiwibd";
		
		$this->servidor="kiwibd.db.11164618.hostedresource.com";
		$this->login="kiwibd";
		$this->clave="Kiwibd123!";
		$this->base="kiwibd";
		*/
		$this->servidor="localhost";
		$this->login="kiwigold_user";
		$this->clave="user_kiwigold123!";
		$this->base="kiwigold_uno";
		
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
	//almacena en la bd un archivo, segun el productor
	function guardar_archivo($prod,$archivo)
	{
		$cons="insert into archivos values (NULL,'$archivo','$prod');";
		mysql_query($cons,$this->id_con);
	}
	//lista los archivos de un productor
	function lista_archivos($prod)
	{
		$arreglo= array();
		$cons="select id,archivo from archivos where productor='$prod';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd))
		{
			$arreglo[]=array($rs['id'],$rs['archivo']);
		}
		return $arreglo;
	}
	function guardar_arch_gpx($cuar,$arch)
	{
		$cons="insert into archiv_gpx values (NULL,'$cuar','$arch');";
		mysql_query($cons,$this->id_con);
	}
	function lista_arch_gpx($cuar)
	{
		$cons="select archivo_gpx from archivos where cuartel='$cuar';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd))
		{
			$arch=$rs['archivo'];
		}
		return $arch;
	}
	//recupera los datos del archivo
	function recupera_datos_archivo($id)
	{
		$cons="select * from archivos where id='$id';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd))
		{
			$arreglo=array($rs['id'],$rs['archivo'],$rs['productor']);
		}
		return $arreglo;
	}
	//elimina un archivo por su id
	function elimina_archivo($id)
	{
		$cons="delete from archivos where id='$id';";
		mysql_query($cons,$this->id_con);
	}
	//lista los 10 ultimos analisis, por cuartel
	function lista_ultimos10_fan($cuar)
	{
		$cons="select f_analisis.fecha,f_analisis.fecha_m,f_analisis.obs from f_analisis,um where f_analisis.estado='2' and um.cuartel='$cuar' and f_analisis.um=um.id order by f_analisis.fecha_m desc limit 10;";
		$ejec=mysql_query($cons,$this->id_con);
		$arr=array();
		while($rs=mysql_fetch_array($ejec,$this->id_bd)) 
		{$arr[]=array($rs['fecha_m'],$rs['fecha'],$rs['obs']);}
		if(count($arr)==0){$arr[]=array('','','No Hay registro');}
		return $arr;
	} 
	// crea una nueva f_analisis
	function crearAnalisis($lab,$fecha,$fmue){
		$cons="insert into f_analisis values(NULL,'$lab','$fecha','$fmue',0,'');";
		mysql_query($cons,$this->id_con);
		$po=mysql_insert_id();
		return $po;
	}
	// actualiza los datos en analisis, por linea
	function actualiza_analisis($numm,$peso,$pre1,$pre2,$ss,$col1,$col2,$pei,$pef,$obs,$ing){
		$cons="update analisis set peso='$peso',presion1='$pre1',presion2='$pre2',ss='$ss',color1='$col1',color2='$col2',pesoi='$pei',pesof='$pef',obs='$obs' where f_analisis='$ing' and numm='$numm';";
		mysql_query($cons,$this->id_con);
	}
	//inserta nuevos datos de un analisis, segun la f_analisis
	function llena_analisis($id_anal,$arr){
		$ar=explode('/',$arr);
		$cons="insert into analisis values (NULL,'$id_anal','".$ar[0]."','".$ar[1]."','".$ar[2]."','".$ar[3]."','".$ar[4]."','".$ar[5]."','".$ar[6]."','".$ar[7]."','".$ar[8]."','".$ar[9]."','1');";
		mysql_query($cons,$this->id_con);
	}
	//cambia estado de f_analisis, segun es est que se envie
	function cambia_estado_lab($lab,$est)
	{
		$cons="update f_analisis set estado='$est' where id='$lab';";
		mysql_query($cons,$this->id_con);
	}
	function actualiza_fechas_f_analisis($lab,$f,$ff){
		$cons="update f_analisis set fecha='$f',fecha_m='$ff' where id='$lab';";
		mysql_query($cons,$this->id_con);
	}
	function recupera_f_analisis($id)
	{
		$cons="select * from f_analisis where id='$id';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
			$resp=array($rs['id'],$rs['um'],$rs['fecha'],$rs['fecha_m'],$rs['estado'],$rs['obs']);
		}
		return $resp;
	}
	function analisis_datos_fanalisis($a)
	{
		$cons="select * from analisis where f_analisis='$a' and estado='1' order by numm asc ;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
			if(($rs['presion1'])&&($rs['presion2'])){$presion_p=($rs['presion1']+$rs['presion2'])/2;}else{$presion_p=0;}
			if(($rs['color1'])&&($rs['color2'])){$color_p=($rs['color1']+$rs['color2'])/2;}else{$color_p=0;}
			if(($rs['pesof'])&&($rs['pesoi'])){$pesp_p=($rs['pesof']/$rs['pesoi'])*100;}else{$pesp_p=0;}
			$arreglo[]=array($rs['peso'],$presion_p,$rs['ss'],$color_p,$pesp_p);
		}
		$pesoM=0;$pesom=99999;$presionM=0;$presionm=99999;$ssM=0;$ssm=99999;$colorM=0;$colorm=99999;$secaM=0;$secam=99999;
		$c=0;$sumap=0;$sumapre=0;$sumass=0;$sumacolor=0;$sumaseca=0;
		foreach($arreglo as $a)
		{
			if($pesoM<=$a[0]){$pesoM=$a[0];}
			if($pesom>=$a[0]){$pesom=$a[0];}
			$sumap+=$a[0];
			if($presionM<=$a[1]){$presionM=$a[1];}
			if($presionm>=$a[1]){$presionm=$a[1];}
			$sumapre+=$a[1];
			if($ssM<=$a[2]){$ssM=$a[2];}
			if($ssm>=$a[2]){$ssm=$a[2];}
			$sumass+=$a[2];
			if($colorM<=$a[3]){$colorM=$a[3];}
			if($colorm>=$a[3]){$colorm=$a[3];}
			$sumacolor+=$a[3];
			if($secaM<=$a[4]){$secaM=$a[4];}
			if($secam>=$a[4]){$secam=$a[4];}
			$sumaseca+=$a[4];
			$c++;
		}
		$difpeso=0;$difpresion=0;$difss=0;$difcolor=0;$difseca=0;
		if($c>0)
		{
			$promp=$sumap/$c;
			$prompre=$sumapre/$c;
			$promss=$sumass/$c;
			$promcolor=$sumacolor/$c;
			$promseca=$sumaseca/$c;
			foreach($arreglo as $b)
			{
				$difpeso+=pow(($b[0]-$promp),2);
				$difpresion+=pow(($b[1]-$prompre),2);
				$difss+=pow(($b[2]-$promss),2);
				$difcolor+=pow(($b[3]-$promcolor),2);
				$difseca+=pow(($b[4]-$promseca),2);
			}
			$desvp=sqrt($difpeso/$c);
			$desvpre=sqrt($difpresion/$c);
			$desvss=sqrt($difss/$c);
			$desvcolor=sqrt($difcolor/$c);
			$desvseca=sqrt($difseca/$c);
		}
		$lis[0]=$c;
		$lis[1]=$pesom;
		$lis[2]=$pesoM;
		$lis[3]=$presionm;
		$lis[4]=$presionM;
		$lis[5]=$ssm;
		$lis[6]=$ssM;
		$lis[7]=$colorm;
		$lis[8]=$colorM;
		$lis[9]=number_format($secam,1);
		$lis[10]=number_format($secaM,1);
		$lis[11]=number_format($promp,1);
		$lis[12]=number_format($prompre,1);
		$lis[13]=number_format($promss,1);
		$lis[14]=number_format($promcolor,1);
		$lis[15]=number_format($promseca,1);
		$lis[16]=number_format($promp-(3.35*$desvp),1);
		$lis[17]=number_format($promp+(3.35*$desvp),1);
		$lis[18]=number_format($prompre-(3.35*$desvpre),1);
		$lis[19]=number_format($prompre+(3.35*$desvpre),1);
		$lis[20]=number_format($promss-(3.35*$desvss),1);
		$lis[21]=number_format($promss+(3.35*$desvss),1);
		$lis[22]=number_format($promcolor-(3.35*$desvcolor),1);
		$lis[23]=number_format($promcolor+(3.35*$desvcolor),1);
		$lis[24]=number_format($promseca-(3.35*$desvseca),1);
		$lis[25]=number_format($promseca+(3.35*$desvseca),1);
		return $lis;
	}
	function recupera_datos_analisis($id_f_analisis){
		$cons="select * from analisis where f_analisis='$id_f_analisis' order by numm asc ;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
			$arreglo[]=array($rs['numm'],$rs['peso'],$rs['presion1'],$rs['presion2'],$rs['ss'],$rs['color1'],$rs['color2'],$rs['pesoi'],$rs['pesof'],$rs['obs'],$rs['estado']);
		}
		print_r(json_encode($arreglo));
	}
	function recupera_datos_analisis2($id_f_analisis){
		$cons="select * from analisis where f_analisis='$id_f_analisis' order by numm asc ;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
			$arreglo[]=array($rs['peso'],$rs['presion1'],$rs['presion2'],$rs['ss'],$rs['color1'],$rs['color2'],$rs['pesoi'],$rs['pesof'],$rs['estado']);
		}
		return $arreglo;
	}
	//recupera datos del productor, para generacion de informe en base a "um" hacia cuartel y productora
	function recupera_dt_para_inf($um)
	{
		$cons="select datos_prod.rs,datos_prod.mail,datos_prod.rl,datos_prod.mailrl,datos_prod.agronomo,datos_prod.amail,cuarteles.nombre,cuarteles.direccion,cuarteles.nenc,cuarteles.eenc from um,datos_prod,cuarteles where um.id='$um' and um.cuartel=cuarteles.id and um.campo=datos_prod.campo";
		$ejec=mysql_query($cons,$this->id_con);
		$arreglo="";
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
			$arreglo=array($rs['rs'],$rs['mail'],$rs['rl'],$rs['mailrl'],$rs['agronomo'],$rs['amail'],$rs['nombre'],$rs['direccion'],$rs['nenc'],$rs['eenc']);
		}
		while(count($arreglo) < 10){$arreglo[]='';}
		return $arreglo;
	}
	function recupera_f_f_analisis($re){
		$cons="select fecha,fecha_m from f_analisis where id='$re' ; ";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
			$arreglo=array($rs['fecha'],$rs['fecha_m']);
		}
		print_r(json_encode($arreglo));
	}
	//actualiza la observacion de f_analisis, segun lab
	function actualiza_obs_f_a($obs,$lab)
	{
		$cons="update f_analisis set obs='$obs' where id='$lab' ; ";
		mysql_query($cons,$this->id_con);
	}
	//genera nueva fecha en fechas de analisis, creo que ya no se usa... revisar			
	function nuevafecha($pom,$pe){
		$cons="update f_analisis set fecha_m='$pom' where id='$pe';";
		mysql_query($cons,$this->id_con);
	}
	// cambia el estado de un dato, de un analisis... para sacarlo o contarlo en los datos estadisticos
	function cambia_estado_dato_analisis($dato,$f_analisis){
		$cons="select estado from analisis where numm='$dato' and f_analisis='$f_analisis';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){ $est=$rs['estado']; }
		if($est==1){$est=0;}else{$est=1;}
		$cons="update analisis set estado='$est' where numm='$dato' and f_analisis='$f_analisis';";
		echo $cons;
		mysql_query($cons,$this->id_con);
	}
	//para laboratorio, solo muestra los laboratorios, sin autorizar
	function lista_lab_sin_autorizar($um){
		$ec=array();
		$cons="select id,fecha,fecha_m from f_analisis where um='$um' and estado='0' ;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){ $ec[]=array($rs['id'],$rs['fecha'],$rs['fecha_m']); }
		if(count($ec)<1){$ec[]=array('0','No hay Registro','');}
		return $ec;	
	}
	//lista los laboratorios (f_analisis) y desde que cuartel y UM vienen
	function lista_todo_laboratorio(){
		$cons="select f_analisis.id,um.um,cuarteles.nombre as n_c,campos.empresa as n_prod,f_analisis.fecha,f_analisis.fecha_m,f_analisis.estado from f_analisis,um,cuarteles,campos where f_analisis.estado<2 and f_analisis.um=um.id and um.cuartel=cuarteles.id and um.campo=campos.id order by f_analisis.fecha asc limit 20 ;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){ $ec[]=array($rs['id'],$rs['um'],$rs['n_c'],$rs['n_prod'],$rs['fecha'],$rs['fecha_m'],$rs['estado']);	}
		return $ec;
	}
	//lista los laboratorios ya analizados
	function lista_laboratorios_f(){
		$cons="select f_analisis.id,um.um,cuarteles.nombre as n_c,campos.empresa as n_prod,f_analisis.fecha,f_analisis.fecha_m,f_analisis.estado from f_analisis,um,cuarteles,campos where f_analisis.estado=2 and f_analisis.um=um.id and um.cuartel=cuarteles.id and um.campo=campos.id order by f_analisis.fecha asc limit 30;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){ $ec[]=array($rs['id'],$rs['um'],$rs['n_c'],$rs['n_prod'],$rs['fecha'],$rs['fecha_m'],$rs['estado']);	}
		return $ec;
	}
	//nueva funciones para productor de un campo (revisar donde se usa)
	function datos_legales_productor($prod)
	{
		$cons="select * from datos_prod where campo='$prod';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arr=array($rs['rs'],$rs['rut'],$rs['giro'],$rs['dir'],$rs['fono'],$rs['mail'],$rs['rl'],$rs['rutrl'],$rs['fonorl'],$rs['mailrl'],$rs['agronomo'],$rs['amail']);
		}
		return $arr;
	}
	//listado, ingreso y recuperacion de cuarteles
	function lista_cuarteles_productor($prod)
	{
		$arreglo = array();
		$cons="select id,nombre from cuarteles where campo='$prod';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd))
		{
			$arreglo[]=array($rs['id'],$rs['nombre']);
		}
		if(count($arreglo)==0){$arreglo=array(array('0','No hay Cuarteles'));}
		return $arreglo;
	}
	function agregar_cuartel_productor($prod,$ano,$nom,$sup,$nplan,$z,$d,$nenc,$fenc,$eenc,$geo,$dth,$deh,$pm,$t,$c,$o)
	{
		$cons="insert into cuarteles values(NULL,'$prod','$ano','$nom','$sup','$nplan','$z','$d','$nenc','$fenc','$eenc','$geo','$dth','$deh','$pm','$t','$c','$o');";
		mysql_query($cons,$this->id_con);
	}
	function recuperar_cuartel($cuar)
	{
		$cons="select * from cuarteles where id='$cuar';";
		$arr=array();
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arr=array($rs['id'],$rs['campo'],$rs['año'],$rs['nombre'],$rs['superficie'],$rs['nplantas'],$rs['zona'],$rs['direccion'],$rs['nenc'],$rs['fenc'],$rs['eenc'],$rs['geo'],$rs['dentreh'],$rs['denh'],$rs['pmachos'],$rs['tipo'],$rs['contrato'],$rs['obs']);
		}
		return $arr;
	}
	
	function editar_cuartel($cuar,$nombre,$ano,$sup,$nplan,$zona,$d,$enc,$fenc,$eenc,$geo,$dth,$deh,$pm,$t,$c,$o)
	{
		$cons="update cuarteles set nombre='$nombre',año='$ano',superficie='$sup',nplantas='$nplan',zona='$zona',direccion='$d',nenc='$enc',fenc='$fenc',eenc='$eenc',geo='$geo',dentreh='$dth',denh='$deh',pmachos='$pm',tipo='$t',contrato='$c',obs='$o' where id='$cuar' ; ";
		mysql_query($cons,$this->id_con);
	}
	function eliminar_cuartel($cuar)
	{
		$cons="delete from cuarteles where id='$cuar' ; ";
		mysql_query($cons,$this->id_con);
	}
	function lista_tipo_plantas()
	{
		$cons="select id,nombre from tipo_plantas order by id asc ;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd))
		{
			$l_p[]=array($rs['id'],$rs['nombre']);
		}
		return $l_p;
	}
	//retorna de lista de plantas
	function lista_plantas($cuar){
		$cons="select tipo_plantas.nombre,plantas.cantidad,plantas.año,plantas.id from plantas,tipo_plantas where tipo_plantas.id=plantas.tipo and plantas.cuartel='$cuar';";
		$ejec=mysql_query($cons,$this->id_con);
		$plantas=array();
		while($rs=mysql_fetch_array($ejec,$this->id_bd))
		{
			$plantas[]=array($rs['nombre'],$rs['cantidad'],$rs['año'],$rs['id']);
		}
		if(count($plantas) < 1){$plantas[]=array('0','No Hay Registro','-','-');}
		return $plantas;
	}
	function add_plantas($cuar,$tipo,$cantidad,$ann){
		$cons="insert into plantas values(NULL,'$cuar','$tipo','$cantidad','$ann');";
		mysql_query($cons,$this->id_con);
		$cons="select sum(cantidad) as cant from plantas where cuartel='$cuar';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){$cant_t=$rs['cant']; }
		$cons="select sum(cantidad) as cant from plantas where cuartel='$cuar' and tipo='1';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){$canti_h=$rs['cant']; }
		$p_m=(($cant_t-$canti_h)*100)/$cant_t;
		$cons="update cuarteles set nplantas='$cant_t',pmachos='$p_m' where id='$cuar'; ";
		mysql_query($cons,$this->id_con);
	}
	function elimina_plantas($elim){
		$cons="select cuartel from plantas where id='".$elim."';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){ $cuart=$rs['cuartel'];}
		$cons="delete from plantas where id='$elim';";
		mysql_query($cons,$this->id_con);
		$cons="select sum(cantidad) as a from plantas where cuartel='$cuart';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){$cant_t=$rs['a']; }
		$cons="select sum(cantidad) as a from plantas where cuartel='$cuart' and tipo='1';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){$canti_h=$rs['a']; }
		$p_m=(($cant_t-$canti_h)*100)/$cant_t;
		$cons="update cuarteles set nplantas='$cant_t',pmachos='$p_m' where id='$cuart'; ";
		mysql_query($cons,$this->id_con);
	}
	function editar_plantas($id,$tipo,$ano,$cant){
		$cons="update plantas set tipo='".$tipo."',año='".$ano."',cantidad='".$cant."' where id='".$id."';";
		mysql_query($cons,$this->id_con);
		$cons="select cuartel from plantas where id='".$id."';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){ $cuartel_contar=$rs['cuartel'];}
		$cons="select sum(cantidad) as a from plantas where cuartel='$cuartel_contar';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){$cant_t=$rs['a']; }
		$cons="select sum(cantidad) as a from plantas where cuartel='$cuartel_contar' and tipo='1';";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){$canti_h=$rs['a']; }
		$p_m=(($cant_t-$canti_h)*100)/$cant_t;
		$cons="update cuarteles set nplantas='$cant_t',pmachos='$p_m' where id='$cuartel_contar'; ";
		mysql_query($cons,$this->id_con);
	}

	function traer_edi($ed){
		$cons="select plantas.cantidad,plantas.año,tipo_plantas.nombre from plantas,tipo_plantas where plantas.id='$ed' and plantas.tipo=tipo_plantas.id";
		$ejec=mysql_query($cons,$this->id_con);
		if($rs=mysql_fetch_array($ejec,$this->id_bd)){
			$ret=array('id'=>$ed,'tipo'=>$rs['nombre'],'cantidad'=>$rs['cantidad'],'año'=>$rs['año']);
		}
		echo json_encode($ret);
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
	function lista_estados_fenologicos()
	{
		$cons="select id,nombre from est_fen order by id asc ;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
		$arr[]=array($rs['id'],$rs['nombre']);
		}
		return $arr;
	}
	function registrar_labores($cuar,$fecha,$prog,$met,$feno)
	{
		$cons="insert into labores values ('$cuar','$fecha','$prog','$met','$feno');";
		mysql_query($cons,$this->id_con);
	}
	function lista_ultimos10_labores($cuar)
	{
		$arr=array();
		$cons="select labores.fecha,labores.programa,est_fen.nombre from labores,est_fen where labores.estado_f=est_fen.id and labores.cuartel='$cuar' order by labores.fecha asc limit 10;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd))
		{
			$f=substr($rs['fecha'],8,2). substr($rs['fecha'],4,3)."-". substr($rs['fecha'],0,4);
			$arr[]=array($f,$rs['programa'],$rs['nombre']);
		}
		if(count($arr)==0){ $arr=array(array('0','No hay registro',' ')); }
		return $arr;
	}
	function registrar_fitosanitario($cuar,$fecha,$ncom,$iac,$cad,$obs,$feno)
	{
		$cons="insert into fitosanitarios values ('$cuar','$fecha','$ncom','$iac','$cad','$obs','$feno');";
		mysql_query($cons,$this->id_con);
	}
	function lista_ultimos10_fito($cuar)
	{
		$arr=array();
		$cons="select fitosanitarios.fecha,fitosanitarios.n_comercial,est_fen.nombre from fitosanitarios,est_fen where fitosanitarios.estado_f=est_fen.id and fitosanitarios.cuartel='$cuar' order by fitosanitarios.fecha asc limit 10;";
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
	function lista_ultimos10_prod($cuar)
	{
		$cons="select id,fecha,ton,calibre from produccion where cuartel='$cuar' order by fecha desc limit 10;";
		$ejec=mysql_query($cons,$this->id_con);
		$arr=array();
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
	function elim_prod($id)
	{
		$cons="delete from produccion where id='$id';";
		mysql_query($cons,$this->id_con);
	}
	//funciones para proyecciones
	function ingresa_proyeccion($prod,$fecha,$ton,$cal){
		$cons="insert into proyeccion values (NULL,'$prod','$fecha','$ton','$cal');";
		mysql_query($cons,$this->id_con);
	}
	function lista_ultimos10_proy($cuar)
	{
		$cons="select id,fecha,ton,calibre from proyeccion where cuartel='$cuar' order by fecha desc limit 10;";
		$ejec=mysql_query($cons,$this->id_con);
		$arr=array();
		while($rs=mysql_fetch_array($ejec,$this->id_bd)) 
		{$arr[]=array($rs['id'],$rs['fecha'],$rs['ton'],$rs['calibre']);}
		if(count($arr)==0){$arr[]=array('0','','No Hay registro','');}
		return $arr;
	}
	function rescatar_proyeccion($esa)
	{
		$cons="select * from proyeccion where id='$esa';";
		while($rs=mysql_fetch_array($ejec,$this->id_bd)) 
		{$arr[]=array($rs['id'],$rs['productor'],$rs['fecha'],$rs['ton'],$rs['comercializadora'],$rs['calibre']);}
		return $arr;
	}
	function editar_proy($id,$fech,$ton,$com,$cal)
	{
		$cons="update proyeccion set fecha='$fech',ton='$ton',calibre='$cal' where id='$id';";
		mysql_query($cons,$this->id_con);
	}
	function elim_proy($id)
	{
		$cons="delete from proyeccion where id='$id';";
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
		$cons="select usuarios.id,usuarios.nombre,nivel.nivel,usuarios.empresa,usuarios.estado from usuarios,nivel where usuarios.nivel='5' and nivel.id=usuarios.nivel order by usuarios.nivel asc ;";		
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
		$cons="update usuarios set ".$campo."='$valor' where id='$id' ;";
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
	function registrar_productora($expo,$rs,$empresa,$rut,$giro,$dir,$fono,$mail,$rl,$rutrl,$fonorl,$mailrl,$agronomo,$amail)
	{
		$cons="insert into campos values(NULL,'$expo','0','$empresa');";
		$ejec=mysql_query($cons,$this->id_con);
		if(mysql_errno($this->id_con)==0)
		{
			$p=mysql_insert_id($this->id_con);
			$cons="insert into datos_prod values('$p','$rs','$rut','$giro','$dir','$fono','$mail','$rl','$rutrl','$fonorl','$mailrl','$agronomo','$amail');";
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
		$re[13]=$rs['agronomo'];
		$re[14]=$rs['amail'];
		}
		while(count($re) < 17){$re[]='';}
		return $re;
	}
	function modif_productora($id,$empresa,$rs,$rut,$giro,$dir,$fono,$mail,$rl,$rutrl,$fonorl,$mailrl,$agronomo,$amail)
	{
		$cons="update campos set empresa='$empresa' where id='$id';";
		$ejec=mysql_query($cons,$this->id_con);
		$cons="select rs from datos_prod where campo='$id';";
		$ejec=mysql_query($cons, $this->id_con);
		if(mysql_num_rows($ejec)==1)
		{
			$cons="update datos_prod set rs='$rs',rut='$rut',giro='$giro',dir='$dir',fono='$fono',mail='$mail',rl='$rl',rutrl='$rutrl',fonorl='$fonorl',mailrl='$mailrl',agronomo='$agronomo',amail='$amail' where campo='$id';";
			$ejec=mysql_query($cons,$this->id_con);
		}
		else
		{
			$cons="insert into datos_prod values ('$id','$rs','$rut','$giro','$dir','$fono','$mail','$rl','$rutrl','$fonorl','$mailrl','$agronomo','$amail');";
			$ejec=mysql_query($cons,$this->id_con);
		}
	}
	function resumen_registro_cuartel($anio,$cuartel){
		$aniomas=intval($anio)+1;$res_prod=array();$res_proy=array();$res_lab=array();$res_f=array();
		$cons="select cuarteles.nombre,proyeccion.fecha,proyeccion.ton,proyeccion.calibre from cuarteles,proyeccion where proyeccion.cuartel='$cuartel' and proyeccion.cuartel=cuarteles.id and proyeccion.fecha BETWEEN '$anio-05-01' AND '$aniomas-05-01' order by proyeccion.fecha  ;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
			$res_proy[]=array($rs['nombre'],$rs['fecha'],$rs['ton'],$rs['calibre']);
		}
		$cons="select cuarteles.nombre,produccion.fecha,produccion.comercializadora,produccion.ton,produccion.calibre from cuarteles,produccion where produccion.cuartel='$cuartel' and produccion.cuartel=cuarteles.id and produccion.fecha BETWEEN '$anio-05-01' AND '$aniomas-05-01' order by produccion.fecha  ;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
			$res_prod[]=array($rs['nombre'],$rs['fecha'],$rs['comercializadora'],$rs['ton'],$rs['calibre']);
		}
		$cons="select cuarteles.nombre,labores.fecha,labores.programa,labores.aplicacion,est_fen.nombre as feno from cuarteles,labores,est_fen where labores.cuartel='$cuartel' and labores.cuartel=cuarteles.id AND labores.estado_f = est_fen.id and labores.fecha BETWEEN '$anio-05-01' AND '$aniomas-05-01' order by labores.fecha;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
			$res_lab[]=array($rs['nombre'],$rs['fecha'],$rs['programa'],$rs['aplicacion'],$rs['feno']);
		}
		$cons="select cuarteles.nombre,fitosanitarios.fecha,fitosanitarios.n_comercial,fitosanitarios.i_activo,fitosanitarios.cadencia,fitosanitarios.obs,est_fen.nombre as feno from cuarteles,fitosanitarios,est_fen where fitosanitarios.cuartel='$cuartel' and fitosanitarios.cuartel=cuarteles.id AND fitosanitarios.estado_f = est_fen.id and fitosanitarios.fecha BETWEEN '$anio-05-01' AND '$aniomas-05-01' order by fitosanitarios.fecha;";
		$ejec=mysql_query($cons,$this->id_con);
		while($rs=mysql_fetch_array($ejec,$this->id_bd)){
			$res_f[]=array($rs['nombre'],$rs['fecha'],$rs['n_comercial'],$rs['i_activo'],$rs['cadencia'],$rs['obs'],$rs['feno']);
		}
		$respon = array($res_f,$res_lab,$res_proy,$res_prod);
		return $respon;
	}
}
?>